<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Journal;
use App\Models\SiteSetting;
use App\Models\Ebook;

class DashboardController extends Controller
{
    public function index(){
    // {
    //     $user          = auth()->user();
    //     $member        = $user->member;
    //     $announcements = Announcement::active()->where(fn($q) => $q->where('is_member_only',false)->orWhere('is_member_only',true))
    //         ->orderByDesc('is_pinned')->latest('published_at')->take(5)->get();
    //     $registrations = $user->eventRegistrations()->with('event')->latest()->take(5)->get();
    //     return view('member.dashboard.index', compact('user','member','announcements','registrations'));
    // }

    $user          = auth()->user();
    $setting             = SiteSetting::all_map();
    $member        = $user->member;
    $registrations = $member?->eventRegistrations ?? collect();
    $announcements = Announcement::active()->where(fn($q) => $q->where('is_member_only',false)->orWhere('is_member_only',true))
        ->orderByDesc('is_pinned')->latest('published_at')->take(5)->get();

    // Ambil 4 jurnal terbaru yang published
    $journals = Journal::where('is_published', true)
                       ->latest()->take(4)->get();

    // Ambil 4 ebook terbaru yang published
    $ebooks = Ebook::where('is_published', true)
                   ->latest()->take(4)->get();

    return view('member.dashboard.index', compact(
        'user','setting', 'member', 'registrations', 'announcements', 'journals', 'ebooks'
    ));
}   
}

    

