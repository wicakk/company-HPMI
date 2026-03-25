<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Member, Payment};
use Illuminate\Http\Request;

class MemberAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('user');
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%'));
        }
        $members = $query->latest()->paginate(20);
        return view('admin.members.index', compact('members'));
    }

    public function show(int $id)
    {
        $member = Member::with(['user', 'payments'])->findOrFail($id);
        return view('admin.members.show', compact('member'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $member = Member::findOrFail($id);
        $data   = $request->validate(['status' => 'required|in:free,premium_pending,premium,expired,suspended']);

        if ($data['status'] === 'premium') {
            $data['joined_at']  = $data['joined_at'] ?? $member->joined_at ?? now();
            $data['expired_at'] = now()->addYear();
            $member->user->update(['role' => 'premium']);
        } elseif ($data['status'] === 'free') {
            $member->user->update(['role' => 'member']);
        }

        $member->update($data);
        return back()->with('success', 'Status anggota diperbarui.');
    }

    public function payments(Request $request)
    {
        $query = Payment::with('member.user');
        if ($request->filled('status')) $query->where('status', $request->status);
        $payments = $query->latest()->paginate(20);
        return view('admin.members.payments', compact('payments'));
    }

    public function confirmPayment(int $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'paid', 'paid_at' => now()]);

        // Aktifkan premium
        $payment->member->update([
            'status'     => 'premium',
            'joined_at'  => $payment->member->joined_at ?? now(),
            'expired_at' => now()->addYear(),
        ]);

        if ($payment->member->user) {
            $payment->member->user->update(['role' => 'premium']);
        }

        return back()->with('success', 'Pembayaran dikonfirmasi. Anggota diupgrade ke Premium.');
    }

    public function exportExcel()
    {
        $members = Member::with('user')->get();
        $csv = "Kode,Nama,Email,Telepon,Institusi,Status,Bergabung,Kadaluarsa\n";
        foreach ($members as $m) {
            $csv .= implode(',', [
                $m->member_code, $m->user->name ?? '-', $m->user->email ?? '-',
                $m->phone, $m->institution, $m->status, $m->joined_at, $m->expired_at,
            ]) . "\n";
        }
        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="anggota-hpmi-'.date('Y-m-d').'.csv"',
        ]);
    }
}
