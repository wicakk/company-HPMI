<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AnalyticsController extends Controller
{
    public function __construct(protected AnalyticsService $analytics) {}

    /**
     * Halaman utama dashboard analitik.
     */
    public function index(Request $request)
    {
        $days = (int) $request->query('period', 30);
        $days = in_array($days, [7, 30, 90]) ? $days : 30;

        $summary      = $this->analytics->getSummary($days);
        $dailyData    = $this->analytics->getDailyVisitors($days);
        $popularPages = $this->analytics->getPopularPages($days);
        $deviceStats  = $this->analytics->getDeviceStats($days);
        $sources      = $this->analytics->getTrafficSources($days);
        $contentStats = $this->analytics->getContentStats($days);
        $activeUsers  = $this->analytics->getActiveUsers();
        $hourly       = $this->analytics->getHourlyToday();

        return view('admin.analytics.index', compact(
            'summary', 'dailyData', 'popularPages',
            'deviceStats', 'sources', 'contentStats',
            'activeUsers', 'hourly', 'days'
        ));
    }

    /**
     * API endpoint untuk polling realtime (dipanggil tiap 10 detik via JS).
     */
    public function realtime(): JsonResponse
    {
        return response()->json([
            'active_users' => $this->analytics->getActiveUsers(),
            'today_visits' => \App\Models\PageVisit::today()->count(),
            'hourly'       => $this->analytics->getHourlyToday(),
            'timestamp'    => now()->format('H:i:s'),
        ]);
    }

    /**
     * API endpoint untuk refresh statistik per periode.
     */
    public function stats(Request $request): JsonResponse
    {
        $days = (int) $request->query('period', 30);
        $days = in_array($days, [7, 30, 90]) ? $days : 30;

        // Bersihkan cache agar data fresh
        $this->analytics->clearCache();

        return response()->json([
            'summary'       => $this->analytics->getSummary($days),
            'daily'         => $this->analytics->getDailyVisitors($days),
            'popular_pages' => $this->analytics->getPopularPages($days),
            'devices'       => $this->analytics->getDeviceStats($days),
            'sources'       => $this->analytics->getTrafficSources($days),
            'period'        => $days,
        ]);
    }

    /**
     * Update durasi kunjungan (dipanggil via beacon saat user meninggalkan halaman).
     */
    public function updateDuration(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
            'duration'   => 'required|integer|min:0|max:86400',
        ]);

        \App\Models\PageVisit::where('session_id', $validated['session_id'])
            ->where('ip_address', $request->ip())
            ->latest()
            ->first()
            ?->update(['duration_seconds' => $validated['duration']]);

        return response()->json(['ok' => true]);
    }
}
