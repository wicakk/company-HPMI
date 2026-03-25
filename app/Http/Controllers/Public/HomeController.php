<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Article, Event, Announcement, Member};

class HomeController extends Controller
{
    public function index()
    {
        $articles      = Article::with('category')->published()->latest('published_at')->take(6)->get();
        $events        = Event::open()->orderBy('start_date')->take(4)->get();
        $announcements = Announcement::active()->orderByDesc('is_pinned')->latest('published_at')->take(3)->get();
        $stats = [
            'members' => Member::where('status','active')->count(),
            'events'  => Event::where('status','completed')->count(),
            'articles'=> Article::published()->count(),
        ];
        return view('public.home', compact('articles','events','announcements','stats'));
    }
}
