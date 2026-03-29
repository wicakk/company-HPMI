<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class PaymentController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $member  = $user->member;
        $pending = $member?->payments()->whereIn('status', ['pending', 'waiting'])->latest()->first();

        $banks = collect(range(1, 5))->map(fn($i) => [
            'bank_name'      => SiteSetting::get("bank_{$i}_name"),
            'account_number' => SiteSetting::get("bank_{$i}_number"),
            'account_name'   => SiteSetting::get("bank_{$i}_owner"),
            'active'         => SiteSetting::get("bank_{$i}_active") === '1',
        ])->filter(fn($b) => $b['active'] && $b['bank_name'])->values();

        $settings = SiteSetting::all_map();

        return view('member.payment.index', compact('user', 'member', 'pending', 'banks', 'settings'));
    }

    /** Ajukan upgrade — langsung upload bukti sekaligus */
    public function pay(Request $request)
    {
        $user   = auth()->user();
        $member = $user->member;

        if (!$member)           return back()->with('error', 'Data member tidak ditemukan.');
        if ($user->isPremium()) return back()->with('info', 'Anda sudah menjadi anggota Premium.');

        $existing = $member->payments()->whereIn('status', ['pending', 'waiting'])->first();
        if ($existing) return back()->with('info', 'Pengajuan upgrade Premium Anda sedang diproses.');

        $request->validate([
            'target_bank'    => 'required|string|max:150',
            'sender_name'    => 'required|string|max:100',
            'payment_method' => 'required|string|max:100',
            'transfer_date'  => 'required|date|before_or_equal:today',
            'proof'          => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'target_bank.required'    => 'Pilih rekening tujuan transfer.',
            'sender_name.required'    => 'Nama pengirim wajib diisi.',
            'payment_method.required' => 'Bank/e-wallet pengirim wajib diisi.',
            'transfer_date.required'  => 'Tanggal transfer wajib diisi.',
            'proof.required'          => 'Bukti transfer wajib diupload.',
            'proof.image'             => 'File harus berupa gambar (JPG/PNG).',
            'proof.max'               => 'Ukuran file maksimal 2 MB.',
        ]);

        $proofPath = $request->file('proof')->store('proofs', 'public');
        $amount    = (int) SiteSetting::get('billing_registration_fee', 300000);

        $member->payments()->create([
            'amount'         => $amount,
            'type'           => 'registration',
            'status'         => 'waiting',
            'payment_method' => $request->payment_method,
            'sender_name'    => $request->sender_name,
            'transfer_date'  => $request->transfer_date,
            'proof_path'     => $proofPath,
            'notes'          => 'Transfer ke: ' . $request->target_bank,
            'expired_at'     => now()->addDays(3),
        ]);

        $member->update(['status' => 'premium_pending']);

        return redirect()->route('member.payment')
            ->with('success', 'Pengajuan berhasil dikirim! Bukti transfer Anda sedang divalidasi admin dalam 1×24 jam.');
    }

    /** Konfirmasi untuk payment yang sudah ada (state 3) — opsional, bisa dihapus */
    public function confirm(Request $request, int $id)
    {
        return redirect()->route('member.payment');
    }

    public function history()
    {
        $payments = auth()->user()->member?->payments()->latest()->paginate(10);
        return view('member.payment.history', compact('payments'));
    }
}