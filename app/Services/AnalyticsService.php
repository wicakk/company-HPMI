<?php

namespace App\Services;

use App\Models\PageVisit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AnalyticsService
{
    /**
     * Ringkasan statistik utama.
     */
    public function getSummary(int $days = 30): array
    {
        $cacheKey = "analytics_summary_{$days}";

        return Cache::remember($cacheKey, 60, function () use ($days) {
            $current  = $this->periodStats($days);
            $previous = $this->periodStats($days, $days); // periode sebelumnya

            $visitorsDiff   = $this->calcChange($current['visitors'],   $previous['visitors']);
            $pageviewsDiff  = $this->calcChange($current['pageviews'],  $previous['pageviews']);
            $bounceDiff     = $this->calcChange($current['bounce_rate'], $previous['bounce_rate']);
            $durationDiff   = $current['avg_duration'] - $previous['avg_duration'];

            return [
                'visitors'      => $current['visitors'],
                'pageviews'     => $current['pageviews'],
                'avg_duration'  => $current['avg_duration'],
                'bounce_rate'   => $current['bounce_rate'],
                'visitors_pct'  => $visitorsDiff,
                'pageviews_pct' => $pageviewsDiff,
                'bounce_pct'    => $bounceDiff,
                'duration_diff' => $durationDiff,
                'period_days'   => $days,
            ];
        });
    }

    private function periodStats(int $days, int $offsetDays = 0): array
    {
        $end   = $offsetDays ? now()->subDays($offsetDays) : now();
        $start = $end->copy()->subDays($days);

        $rows = PageVisit::whereBetween('created_at', [$start, $end])
            ->selectRaw('
                COUNT(*) as pageviews,
                COUNT(DISTINCT ip_address) as visitors,
                AVG(duration_seconds) as avg_duration,
                SUM(CASE WHEN is_bounce = 1 THEN 1 ELSE 0 END) / COUNT(*) * 100 as bounce_rate
            ')
            ->first();

        return [
            'visitors'    => (int) ($rows->visitors ?? 0),
            'pageviews'   => (int) ($rows->pageviews ?? 0),
            'avg_duration' => (float) ($rows->avg_duration ?? 0),
            'bounce_rate' => round((float) ($rows->bounce_rate ?? 0), 1),
        ];
    }

    private function calcChange(float $current, float $previous): float
    {
        if ($previous == 0) return $current > 0 ? 100 : 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * Data pengunjung harian untuk grafik.
     */
    public function getDailyVisitors(int $days = 30): array
    {
        return Cache::remember("analytics_daily_{$days}", 60, function () use ($days) {
            $rows = PageVisit::period($days)
                ->selectRaw('DATE(created_at) as date, COUNT(DISTINCT ip_address) as visitors, COUNT(*) as pageviews')
                ->groupByRaw('DATE(created_at)')
                ->orderBy('date')
                ->get();

            // Isi hari yang tidak ada datanya dengan 0
            $result = [];
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->toDateString();
                $row  = $rows->firstWhere('date', $date);
                $result[] = [
                    'date'      => $date,
                    'label'     => Carbon::parse($date)->translatedFormat('d M'),
                    'visitors'  => $row ? (int) $row->visitors : 0,
                    'pageviews' => $row ? (int) $row->pageviews : 0,
                ];
            }

            return $result;
        });
    }

    /**
     * Halaman terpopuler.
     */
    public function getPopularPages(int $days = 30, int $limit = 6): array
    {
        return Cache::remember("analytics_pages_{$days}_{$limit}", 60, function () use ($days, $limit) {
            return PageVisit::period($days)
                ->selectRaw('page_url, page_title, page_type, COUNT(*) as views, COUNT(DISTINCT ip_address) as unique_visitors')
                ->groupBy('page_url', 'page_title', 'page_type')
                ->orderByDesc('views')
                ->limit($limit)
                ->get()
                ->map(fn($r) => [
                    'url'             => $r->page_url,
                    'title'           => $r->page_title ?: basename(parse_url($r->page_url, PHP_URL_PATH)) ?: 'Beranda',
                    'type'            => $r->page_type,
                    'views'           => $r->views,
                    'unique_visitors' => $r->unique_visitors,
                ])
                ->toArray();
        });
    }

    /**
     * Distribusi perangkat.
     */
    public function getDeviceStats(int $days = 30): array
    {
        return Cache::remember("analytics_devices_{$days}", 60, function () use ($days) {
            $rows = PageVisit::period($days)
                ->selectRaw('device_type, COUNT(*) as count')
                ->groupBy('device_type')
                ->get();

            $total = $rows->sum('count') ?: 1;

            return $rows->map(fn($r) => [
                'device'  => ucfirst($r->device_type),
                'count'   => $r->count,
                'percent' => round($r->count / $total * 100, 1),
            ])->toArray();
        });
    }

    /**
     * Sumber trafik berdasarkan referrer / UTM.
     */
    public function getTrafficSources(int $days = 30): array
    {
        return Cache::remember("analytics_sources_{$days}", 60, function () use ($days) {
            $rows = PageVisit::period($days)
                ->selectRaw("
                    CASE
                        WHEN utm_source IS NOT NULL THEN utm_source
                        WHEN referrer IS NULL OR referrer = '' THEN 'Langsung'
                        WHEN referrer LIKE '%google%' THEN 'Google Search'
                        WHEN referrer LIKE '%facebook%' OR referrer LIKE '%instagram%' OR referrer LIKE '%twitter%' OR referrer LIKE '%tiktok%' THEN 'Media Sosial'
                        WHEN referrer LIKE '%bing%' OR referrer LIKE '%yahoo%' THEN 'Search Engine Lain'
                        ELSE 'Referral'
                    END as source,
                    COUNT(*) as count
                ")
                ->groupByRaw('source')
                ->orderByDesc('count')
                ->get();

            $total = $rows->sum('count') ?: 1;

            return $rows->map(fn($r) => [
                'source'  => $r->source,
                'count'   => $r->count,
                'percent' => round($r->count / $total * 100, 1),
            ])->toArray();
        });
    }

    /**
     * Statistik konten: artikel, event.
     */
    public function getContentStats(int $days = 30): array
    {
        return Cache::remember("analytics_content_{$days}", 60, function () use ($days) {
            // Top artikel
            $articles = DB::table('page_visits as pv')
                ->join('articles as a', 'pv.reference_id', '=', 'a.id')
                ->where('pv.page_type', 'article')
                ->where('pv.created_at', '>=', now()->subDays($days))
                ->selectRaw('a.id, a.title, COUNT(*) as views')
                ->groupBy('a.id', 'a.title')
                ->orderByDesc('views')
                ->limit(5)
                ->get();

            // Top event
            $events = DB::table('page_visits as pv')
                ->join('events as e', 'pv.reference_id', '=', 'e.id')
                ->where('pv.page_type', 'event')
                ->where('pv.created_at', '>=', now()->subDays($days))
                ->selectRaw('e.id, e.title, COUNT(*) as views')
                ->groupBy('e.id', 'e.title')
                ->orderByDesc('views')
                ->limit(5)
                ->get();

            // Total artikel & event di DB
            $totalArticles = DB::table('articles')->count();
            $totalEvents   = DB::table('events')->count();
            $totalUsers    = DB::table('users')->count();
            // $totalComments = DB::table('comments')->count();

            return [
                'top_articles'  => $articles,
                'top_events'    => $events,
                'total_articles' => $totalArticles,
                'total_events'  => $totalEvents,
                'total_users'   => $totalUsers,
                // 'total_comments' => $totalComments,
            ];
        });
    }

    /**
     * Pengguna aktif dalam 5 menit terakhir (realtime).
     */
    public function getActiveUsers(): array
    {
        $rows = PageVisit::where('created_at', '>=', now()->subMinutes(5))
            ->selectRaw('ip_address, page_url, page_title, device_type, MAX(created_at) as last_seen')
            ->groupBy('ip_address', 'page_url', 'page_title', 'device_type')
            ->orderByDesc('last_seen')
            ->limit(10)
            ->get();

        return [
            'count' => $rows->count(),
            'users' => $rows->map(fn($r) => [
                'page'        => $r->page_title ?: basename(parse_url($r->page_url, PHP_URL_PATH)) ?: 'Beranda',
                'device'      => $r->device_type,
                'last_seen'   => Carbon::parse($r->last_seen)->diffForHumans(),
                'ip_short'    => substr($r->ip_address, 0, strrpos($r->ip_address, '.')) . '.***',
            ])->toArray(),
        ];
    }

    /**
     * Statistik per jam hari ini.
     */
    public function getHourlyToday(): array
    {
        $rows = PageVisit::today()
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as visits')
            ->groupByRaw('HOUR(created_at)')
            ->get()
            ->keyBy('hour');

        return collect(range(0, 23))->map(fn($h) => [
            'hour'   => str_pad($h, 2, '0', STR_PAD_LEFT) . ':00',
            'visits' => $rows->has($h) ? (int) $rows[$h]->visits : 0,
        ])->toArray();
    }

    /**
     * Hapus cache analitik (dipanggil setelah update data).
     */
    public function clearCache(): void
    {
        foreach ([7, 30, 90] as $days) {
            Cache::forget("analytics_summary_{$days}");
            Cache::forget("analytics_daily_{$days}");
            Cache::forget("analytics_pages_{$days}_6");
            Cache::forget("analytics_devices_{$days}");
            Cache::forget("analytics_sources_{$days}");
            Cache::forget("analytics_content_{$days}");
        }
    }
}
