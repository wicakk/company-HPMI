<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageVisit
{
    /**
     * URL pattern yang tidak perlu dicatat.
     */
    protected array $excludePatterns = [
        'admin/*',
        'api/*',
        '_debugbar/*',
        'livewire/*',
        '*.css',
        '*.js',
        '*.ico',
        '*.png',
        '*.jpg',
        '*.svg',
        '*.woff',
        '*.map',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya rekam GET request yang sukses (200)
        if ($request->isMethod('GET') && $response->getStatusCode() === 200 && !$this->shouldExclude($request)) {
            $this->record($request);
        }

        return $response;
    }

    protected function record(Request $request): void
    {
        try {
            $data = [
                'page_url'     => $request->fullUrl(),
                'page_title'   => null,
                'page_type'    => $this->detectPageType($request),
                'reference_id' => $this->detectReferenceId($request),
                'ip_address'   => $request->ip(),
                'user_agent'   => $request->userAgent(),
                'device_type'  => PageVisit::detectDevice($request->userAgent() ?? ''),
                'browser'      => PageVisit::detectBrowser($request->userAgent() ?? ''),
                'os'           => PageVisit::detectOS($request->userAgent() ?? ''),
                'referrer'     => $request->header('referer'),
                'utm_source'   => $request->query('utm_source'),
                'utm_medium'   => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
                'user_id'      => auth()->id(),
                'session_id'   => session()->getId(),
                'is_bounce'    => $this->detectBounce($request),
            ];

            PageVisit::create($data);
        } catch (\Exception $e) {
            // Jangan sampai analytics error mengganggu user experience
            logger()->error('Analytics tracking error: ' . $e->getMessage());
        }
    }

    protected function detectPageType(Request $request): string
    {
        $path = $request->path();
        if (str_starts_with($path, 'artikel') || str_starts_with($path, 'article')) return 'article';
        if (str_starts_with($path, 'kegiatan') || str_starts_with($path, 'event'))  return 'event';
        if (str_starts_with($path, 'kategori') || str_starts_with($path, 'category')) return 'category';
        if ($path === '/' || $path === 'beranda' || $path === 'home') return 'home';
        return 'general';
    }

    protected function detectReferenceId(Request $request): ?int
    {
        // Ambil ID dari route parameter jika ada
        $route = $request->route();
        if (!$route) return null;
        return $route->parameter('id') ?? $route->parameter('article') ?? $route->parameter('event') ?? null;
    }

    protected function detectBounce(Request $request): bool
    {
        // Dianggap bounce jika tidak ada referrer dari domain sendiri
        $referrer = $request->header('referer');
        if (!$referrer) return true;
        return !str_contains($referrer, $request->getHost());
    }

    protected function shouldExclude(Request $request): bool
    {
        $path = $request->path();
        foreach ($this->excludePatterns as $pattern) {
            if (fnmatch($pattern, $path)) return true;
        }
        return false;
    }
}
