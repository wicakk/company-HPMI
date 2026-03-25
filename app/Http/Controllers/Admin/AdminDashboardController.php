<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Member, Event, Article, Payment, ContactMessage};

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_members'   => Member::count(),
            'active_members'  => Member::where('status','active')->count(),
            'pending_members' => Member::where('status','pending')->count(),
            'total_events'    => Event::count(),
            'total_articles'  => Article::count(),
            'pending_payments'=> Payment::where('status','pending')->count(),
            'unread_messages' => ContactMessage::where('is_read',false)->count(),
        ];
        $recent_members  = Member::with('user')->latest()->take(5)->get();
        $recent_payments = Payment::with('member.user')->latest()->take(5)->get();
        return view('admin.dashboard', compact('stats','recent_members','recent_payments'));
    }
}
