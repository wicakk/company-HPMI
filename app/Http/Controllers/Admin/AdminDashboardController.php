<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Member, Event, Article, Payment, ContactMessage, LearningMaterial};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── STAT CARDS ──────────────────────────────────────────────
        $totalMembers   = Member::count();
        $activeMembers  = Member::where('status', 'active')->count();
        $pendingMembers = Member::where('status', 'pending')->count();
        $expiredMembers = Member::where('status', 'expired')->count();

        $activeEvents   = Event::where('status', 'open')->count();
        $newEventsMonth = Event::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

        $totalArticles  = Article::count();
        $newArticles    = Article::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

        $totalMaterials = LearningMaterial::count();
        $newMaterials   = LearningMaterial::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

        // Iuran bulan ini
        $iuranBulanIni  = Payment::where('status', 'paid')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        // Pengunjung (placeholder — bisa disambung analytics)
        $pengunjung      = 48921;
        $pendingPayments = Payment::where('status', 'pending')->count();
        $unreadMessages  = ContactMessage::where('is_read', false)->count();

        $stats = compact(
            'totalMembers','activeMembers','pendingMembers','expiredMembers',
            'activeEvents','newEventsMonth',
            'totalArticles','newArticles',
            'totalMaterials','newMaterials',
            'iuranBulanIni','pengunjung',
            'pendingPayments','unreadMessages'
        );

        // ── GRAFIK PERTUMBUHAN ANGGOTA (6 bulan terakhir) ───────────
        $chartLabels = [];
        $chartDaftar = [];
        $chartAktif  = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('M');

            $chartDaftar[] = Member::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $chartAktif[] = Member::where('status', 'active')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // ── DONUT STATUS KEANGGOTAAN ─────────────────────────────────
        $donutTotal   = max($totalMembers, 1);
        $donutActive  = round($activeMembers / $donutTotal * 100);
        $donutPending = round($pendingMembers / $donutTotal * 100);
        $donutExpired = max(0, 100 - $donutActive - $donutPending);

        // ── ANGGOTA TERBARU ──────────────────────────────────────────
        $recentMembers = Member::with('user')->latest()->take(5)->get();

        // ── AKTIVITAS LOG (dari berbagai model, digabung) ────────────
        $activities = collect();

        // Pembayaran terkonfirmasi
        Payment::with('member.user')->where('status','paid')->latest('paid_at')->take(3)->get()
            ->each(fn($p) => $activities->push([
                'type'  => 'payment',
                'text'  => 'Pembayaran dikonfirmasi — ' . ($p->member->user->name ?? '-') . ', iuran Rp ' . number_format($p->amount, 0, ',', '.'),
                'time'  => $p->paid_at ?? $p->updated_at,
                'color' => 'bg-[rgba(16,185,129,.12)] text-[#10b981]',
                'icon'  => '<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
            ]));

        // Artikel terbaru
        Article::latest()->take(2)->get()
            ->each(fn($a) => $activities->push([
                'type'  => 'article',
                'text'  => 'Artikel diterbitkan: <strong>"' . $a->title . '"</strong>',
                'time'  => $a->created_at,
                'color' => 'bg-[rgba(30,90,255,.1)] text-[#1e5aff]',
                'icon'  => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/>',
            ]));

        // Anggota baru
        Member::with('user')->latest()->take(3)->get()
            ->each(fn($m) => $activities->push([
                'type'  => 'member',
                'text'  => 'Anggota baru mendaftar: <strong>' . ($m->user->name ?? '-') . '</strong>',
                'time'  => $m->created_at,
                'color' => 'bg-[rgba(245,158,11,.12)] text-[#f59e0b]',
                'icon'  => '<path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>',
            ]));

        $activities = $activities->sortByDesc('time')->take(6)->values();

        return view('admin.dashboard', compact(
            'stats',
            'chartLabels','chartDaftar','chartAktif',
            'donutActive','donutPending','donutExpired',
            'activeMembers','pendingMembers','expiredMembers','totalMembers',
            'recentMembers','activities'
        ));
    }
}
