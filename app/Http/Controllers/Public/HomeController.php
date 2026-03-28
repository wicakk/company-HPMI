<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Article, Event, Announcement, Member, SiteSetting, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        // ── Settings ──
        $settings = SiteSetting::all()->keyBy('key');

        // ── Banner Slides ──
        $bannerSlides = collect(range(1, 5))->map(function ($i) use ($settings) {
            $active = ($settings['banner_slide_'.$i.'_active']?->value ?? '1') === '1';
            if (!$active) return null;

            $path     = $settings['banner_slide_'.$i.'_image']?->value ?? '';
            $imageUrl = null;

            if ($path) {
                if (str_starts_with($path, 'http')) {
                    $imageUrl = $path;
                } elseif (Storage::disk('public')->exists($path)) {
                    $imageUrl = Storage::url($path);
                }
            }

            return [
                'image'    => $imageUrl,
                'title'    => $settings['banner_slide_'.$i.'_title']?->value ?? '',
                'subtitle' => $settings['banner_slide_'.$i.'_subtitle']?->value ?? '',
                'link'     => $settings['banner_slide_'.$i.'_link']?->value ?? '#',
                'color'    => $settings['banner_slide_'.$i.'_color']?->value ?? '#1a4e8a',
            ];
        })->filter()->values();

        // ── Stats ──
        $stats = [
            'members'  => Member::count(),
            // 'events'   => Event::where('status', 'completed')->count(),
            'events'   => Event::all()->count(),
            'articles' => Article::where('status', 'published')->count(),
        ];

        // ── Articles (Homepage) ──
        $articles = Article::with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->limit(3)
            ->get();

        // ── Events (Homepage) ──
        $events = Event::where('status', 'open')
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->limit(4)
            ->get();

        // ── Announcements ──
        $announcements = Announcement::orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // ── Default search state (PENTING biar Blade aman) ──
        $keyword  = '';
        $category = 'semua';
        $members  = collect();

        return view('public.home', compact(
            'settings',
            'bannerSlides',
            'stats',
            'articles',
            'events',
            'announcements',
            'keyword',
            'category',
            'members'
        ));
    }

    public function researchSearch(Request $request)
    {
        $keyword  = trim($request->input('q', ''));
        $category = $request->input('category', 'semua');

        $articles = collect();
        $events   = collect();
        $members  = collect();

        if ($keyword !== '') {

            // ── Articles ──
            if (in_array($category, ['semua', 'Penelitian'])) {
                $articles = Article::with('category')
                    ->where('status', 'published')
                    ->where(function ($q) use ($keyword) {
                        $q->where('title', 'like', "%{$keyword}%")
                          ->orWhere('excerpt', 'like', "%{$keyword}%")
                          ->orWhere('content', 'like', "%{$keyword}%");
                    })
                    ->latest('published_at')
                    ->limit(6)
                    ->get();
            }

            // ── Events ──
            if (in_array($category, ['semua', 'Event'])) {
                $events = Event::where(function ($q) use ($keyword) {
                        $q->where('title', 'like', "%{$keyword}%")
                          ->orWhere('description', 'like', "%{$keyword}%")
                          ->orWhere('location', 'like', "%{$keyword}%");
                    })
                    ->latest('start_date')
                    ->limit(6)
                    ->get();
            }

            // ── Members ──
            if (in_array($category, ['semua', 'Anggota'])) {
                $members = User::where('name', 'like', "%{$keyword}%")
                    ->limit(6)
                    ->get();
            }
        }

        // ── Shared data (WAJIB biar Blade tidak error) ──
        $settings = SiteSetting::all()->keyBy('key');

        $stats = [
            'members'  => Member::count(),
            'events'   => Event::where('status', 'completed')->count(),
            'articles' => Article::where('status', 'published')->count(),
        ];

        // ❗ penting: tetap kirim walaupun kosong
        $announcements = collect();
        $bannerSlides  = collect();

        return view('public.home', compact(
            'keyword',
            'category',
            'articles',
            'events',
            'members',
            'settings',
            'stats',
            'announcements',
            'bannerSlides'
        ));
    }
}