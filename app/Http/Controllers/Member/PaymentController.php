<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $member  = $user->member;
        $pending = $member?->payments()->where('status', 'pending')->latest()->first();
        return view('member.payment.index', compact('member', 'pending', 'user'));
    }

    /** Ajukan upgrade premium - buat tagihan VA */
    public function pay(Request $request)
    {
        $user   = auth()->user();
        $member = $user->member;
        if (!$member) return back()->with('error', 'Data member tidak ditemukan.');

        // Sudah premium
        if ($user->isPremium()) {
            return back()->with('info', 'Anda sudah menjadi anggota Premium.');
        }

        // Sudah ada pengajuan pending
        $existing = $member->payments()->where('status', 'pending')->first();
        if ($existing) {
            return back()->with('info', 'Pengajuan upgrade Premium Anda sedang diproses.');
        }

        $member->payments()->create([
            'amount'     => 300000,
            'type'       => 'registration',
            'status'     => 'pending',
            'va_number'  => '88808' . rand(1000000, 9999999),
            'expired_at' => now()->addDay(),
        ]);

        // Tandai member sedang menunggu validasi admin
        $member->update(['status' => 'premium_pending']);

        return redirect()->route('member.payment')
            ->with('success', 'Tagihan berhasil dibuat! Selesaikan pembayaran lalu konfirmasi di bawah.');
    }

    /** Member konfirmasi sudah transfer → menunggu validasi admin */
    public function simulateConfirm(Request $request, int $id)
    {
        $member  = auth()->user()->member;
        $payment = Payment::where('id', $id)
            ->where('member_id', $member->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $request->validate([
            'payment_method' => 'required|in:bca,bni,mandiri,bri,dana,gopay,ovo',
        ]);

        // Simpan metode bayar, tapi status tetap pending (menunggu validasi admin)
        $payment->update([
            'payment_method' => strtoupper($request->payment_method),
            'notes'          => 'Member mengkonfirmasi sudah transfer. Menunggu validasi admin.',
        ]);

        return redirect()->route('member.payment')
            ->with('success', '✅ Konfirmasi diterima! Akun Premium Anda sedang divalidasi oleh admin (1x24 jam).');
    }

    public function history()
    {
        $payments = auth()->user()->member?->payments()->latest()->paginate(10);
        return view('member.payment.history', compact('payments'));
    }
}
