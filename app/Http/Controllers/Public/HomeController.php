<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Article, Event, Announcement, Member, SiteSetting };

class HomeController extends Controller
{
    public function index()
    {
        $articles      = Article::with('category')->published()->latest('published_at')->take(6)->get();
        $events        = Event::open()->orderBy('start_date')->take(4)->get();
        $announcements = Announcement::active()->orderByDesc('is_pinned')->latest('published_at')->take(5)->get();
        $stats = [
            'members' => Member::where('status','premium')->count(),
            'events'  => Event::where('status','completed')->count(),
            'articles'=> Article::published()->count(),
        ];
        return view('public.home', compact('articles','events','announcements','stats'));
    }
    // public function index()
    // {
    //     $stats = [
    //         'members'  => Member::where('status', 'premium')->count(),
    //         'events'  => Event::where('status','completed')->count(),
    //         'articles'=> Article::published()->count(),
    //     ];
 
    //     $articles      = Article::with('category')
    //                         ->where('status', 'published')
    //                         ->latest('published_at')
    //                         ->take(3)
    //                         ->get();
 
    //     $events        = Event::where('status', 'published')
    //                         ->where('start_date', '>=', now())
    //                         ->orderBy('start_date')
    //                         ->take(4)
    //                         ->get();
 
    //     // $announcements = Announcement::where('is_active', true)
    //     //                     ->orderByDesc('is_pinned')
    //     //                     ->orderByDesc('created_at')
    //     //                     ->take(5)
    //     //                     ->get();
    //     $announcements = Announcement::active()->orderByDesc('is_pinned')->latest('published_at')->take(3)->get();
 
    //     // Load all settings as key => value map untuk dipakai di view
    //     $settings = SiteSetting::all()->keyBy('key');
 
    //     return view('public.home', compact('stats', 'articles', 'events', 'announcements', 'settings'));
    // }
}
