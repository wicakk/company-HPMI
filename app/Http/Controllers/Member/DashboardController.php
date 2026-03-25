<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $user          = auth()->user();
        $member        = $user->member;
        $announcements = Announcement::active()->where(fn($q) => $q->where('is_member_only',false)->orWhere('is_member_only',true))
            ->orderByDesc('is_pinned')->latest('published_at')->take(5)->get();
        $registrations = $user->eventRegistrations()->with('event')->latest()->take(5)->get();
        return view('member.dashboard.index', compact('user','member','announcements','registrations'));
    }
}
