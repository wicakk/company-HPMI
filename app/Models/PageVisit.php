<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PageVisit extends Model
{
    protected $fillable = [
        'page_url', 'page_title', 'page_type', 'reference_id',
        'ip_address', 'user_agent', 'device_type', 'browser', 'os',
        'referrer', 'utm_source', 'utm_medium', 'utm_campaign',
        'user_id', 'session_id', 'duration_seconds', 'is_bounce',
        'country', 'city',
    ];

    protected $casts = [
        'is_bounce' => 'boolean',
        'duration_seconds' => 'integer',
    ];

    // ── Scopes ──────────────────────────────────────────────

    public function scopePeriod(Builder $query, int $days): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    // ── Static helpers ───────────────────────────────────────

    /**
     * Rekam kunjungan halaman dari request.
     */
    public static function record(array $data = []): self
    {
        $request = request();
        $ua = $request->userAgent() ?? '';

        return self::create(array_merge([
            'page_url'       => $request->fullUrl(),
            'page_title'     => $data['title'] ?? null,
            'page_type'      => $data['type'] ?? 'general',
            'reference_id'   => $data['reference_id'] ?? null,
            'ip_address'     => $request->ip(),
            'user_agent'     => $ua,
            'device_type'    => self::detectDevice($ua),
            'browser'        => self::detectBrowser($ua),
            'os'             => self::detectOS($ua),
            'referrer'       => $request->header('referer'),
            'utm_source'     => $request->query('utm_source'),
            'utm_medium'     => $request->query('utm_medium'),
            'utm_campaign'   => $request->query('utm_campaign'),
            'user_id'        => auth()->id(),
            'session_id'     => session()->getId(),
        ], $data));
    }

    public static function detectDevice(string $ua): string
    {
        $ua = strtolower($ua);
        if (preg_match('/tablet|ipad|playbook|silk/i', $ua)) return 'tablet';
        if (preg_match('/mobile|android|iphone|ipod|blackberry|opera mini|iemobile/i', $ua)) return 'mobile';
        return 'desktop';
    }

    public static function detectBrowser(string $ua): string
    {
        if (str_contains($ua, 'Chrome') && !str_contains($ua, 'Chromium') && !str_contains($ua, 'Edg')) return 'Chrome';
        if (str_contains($ua, 'Firefox')) return 'Firefox';
        if (str_contains($ua, 'Safari') && !str_contains($ua, 'Chrome')) return 'Safari';
        if (str_contains($ua, 'Edg')) return 'Edge';
        if (str_contains($ua, 'OPR') || str_contains($ua, 'Opera')) return 'Opera';
        return 'Other';
    }

    public static function detectOS(string $ua): string
    {
        if (str_contains($ua, 'Windows')) return 'Windows';
        if (str_contains($ua, 'Mac OS')) return 'macOS';
        if (str_contains($ua, 'Android')) return 'Android';
        if (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) return 'iOS';
        if (str_contains($ua, 'Linux')) return 'Linux';
        return 'Other';
    }
}
