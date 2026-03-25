@extends('layouts.admin')
@section('title', 'Konfirmasi Pembayaran')
@section('content')
<div class="space-y-[18px]">

  {{-- Header --}}
  <div class="flex items-center justify-between">
    <div>
      <h2 class="text-[20px] font-extrabold text-slate-800">Konfirmasi Pembayaran</h2>
      <p class="text-[13px] text-slate-500 mt-0.5">Verifikasi dan aktivasi keanggotaan anggota</p>
    </div>
    <div class="flex items-center gap-2">
      <form method="GET" class="flex items-center gap-2">
        <select name="status" onchange="this.form.submit()" class="h-9 px-3 rounded-[9px] border border-slate-200 bg-white text-[13px] text-slate-700 focus:outline-none focus:border-[#1e5aff]">
          <option value="">Semua Status</option>
          <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>
          <option value="paid" {{ request('status')==='paid'?'selected':'' }}>Lunas</option>
          <option value="expired" {{ request('status')==='expired'?'selected':'' }}>Kadaluarsa</option>
        </select>
      </form>
    </div>
  </div>

  {{-- Stats --}}
  @php
    $allPayments = \App\Models\Payment::all();
    $totalPending = $allPayments->where('status','pending')->count();
    $totalPaid    = $allPayments->where('status','paid')->count();
    $totalAmount  = $allPayments->where('status','paid')->sum('amount');
  @endphp
  <div class="grid grid-cols-3 gap-[16px]">
    <div class="bg-white rounded-[14px] p-5 border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] flex items-center gap-4">
      <div class="w-11 h-11 rounded-[11px] bg-[rgba(245,158,11,.1)] flex items-center justify-center text-[#f59e0b] flex-shrink-0">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div>
        <div class="text-[24px] font-extrabold text-slate-800">{{ $totalPending }}</div>
        <div class="text-[12px] text-slate-500">Menunggu Konfirmasi</div>
      </div>
    </div>
    <div class="bg-white rounded-[14px] p-5 border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] flex items-center gap-4">
      <div class="w-11 h-11 rounded-[11px] bg-[rgba(16,185,129,.1)] flex items-center justify-center text-[#10b981] flex-shrink-0">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      </div>
      <div>
        <div class="text-[24px] font-extrabold text-slate-800">{{ $totalPaid }}</div>
        <div class="text-[12px] text-slate-500">Pembayaran Lunas</div>
      </div>
    </div>
    <div class="bg-white rounded-[14px] p-5 border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] flex items-center gap-4">
      <div class="w-11 h-11 rounded-[11px] bg-[rgba(30,90,255,.1)] flex items-center justify-center text-[#1e5aff] flex-shrink-0">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
      </div>
      <div>
        <div class="text-[22px] font-extrabold text-slate-800">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
        <div class="text-[12px] text-slate-500">Total Diterima</div>
      </div>
    </div>
  </div>

  {{-- Table --}}
  <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b border-slate-200">
            <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Anggota</th>
            <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Invoice</th>
            <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nominal</th>
            <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tipe</th>
            <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">VA Number</th>
            <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
            <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Batas</th>
            <th class="text-left px-5 py-3.5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($payments as $payment)
          <tr class="hover:bg-slate-50 transition-colors">
            <td class="px-5 py-4">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-[9px] bg-[rgba(30,90,255,.1)] text-[#1e5aff] flex items-center justify-center font-bold text-[12px] flex-shrink-0">
                  {{ strtoupper(substr($payment->member->user->name ?? 'U', 0, 2)) }}
                </div>
                <div>
                  <p class="text-[13px] font-semibold text-slate-800">{{ $payment->member->user->name ?? '-' }}</p>
                  <p class="text-[11px] text-slate-500 font-mono">{{ $payment->member->member_code ?? '-' }}</p>
                </div>
              </div>
            </td>
            <td class="px-5 py-4">
              <code class="text-[11px] bg-slate-100 px-2 py-1 rounded-[5px] text-slate-700 font-mono">{{ $payment->invoice_no }}</code>
            </td>
            <td class="px-5 py-4 font-bold text-[13px] text-slate-800">
              Rp {{ number_format($payment->amount, 0, ',', '.') }}
            </td>
            <td class="px-5 py-4">
              <span class="text-[12px] text-slate-600 capitalize">{{ str_replace('_', ' ', $payment->type) }}</span>
            </td>
            <td class="px-5 py-4">
              <span class="text-[12px] font-mono text-slate-700">{{ $payment->va_number ?? '-' }}</span>
            </td>
            <td class="px-5 py-4">
              @if($payment->status === 'paid')
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[rgba(16,185,129,.12)] text-[#059669]">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>Lunas
                </span>
              @elseif($payment->status === 'pending')
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[rgba(245,158,11,.12)] text-[#d97706]">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Pending
                </span>
              @elseif($payment->status === 'expired')
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500">Kadaluarsa</span>
              @else
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[rgba(239,68,68,.1)] text-[#dc2626]">Gagal</span>
              @endif
            </td>
            <td class="px-5 py-4 text-[12px] text-slate-500">
              {{ $payment->expired_at ? $payment->expired_at->format('d M Y') : '-' }}
            </td>
            <td class="px-5 py-4">
              @if($payment->status === 'pending')
              <div class="flex items-center gap-2">
                {{-- Tombol Konfirmasi --}}
                <form method="POST" action="{{ route('admin.payments.confirm', $payment->id) }}" onsubmit="return confirm('Konfirmasi pembayaran ini dan aktifkan keanggotaan {{ addslashes($payment->member->user->name ?? '') }}?')">
                  @csrf @method('PUT')
                  <button type="submit" class="h-8 px-3 rounded-[8px] bg-[#1e5aff] text-white text-[12px] font-semibold hover:bg-blue-700 transition-colors flex items-center gap-1.5">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Konfirmasi
                  </button>
                </form>
                {{-- Tombol Tolak --}}
                <form method="POST" action="{{ route('admin.payments.reject', $payment->id) }}" onsubmit="return confirm('Tolak pembayaran ini?')">
                  @csrf @method('PUT')
                  <button type="submit" class="h-8 px-3 rounded-[8px] border border-slate-200 text-[12px] font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                    Tolak
                  </button>
                </form>
              </div>
              @elseif($payment->status === 'paid')
                <div class="flex items-center gap-1.5 text-[12px] text-[#059669] font-semibold">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                  Dikonfirmasi
                </div>
              @else
                <span class="text-[12px] text-slate-400">—</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="px-5 py-12 text-center">
              <svg class="mx-auto mb-3 text-slate-300" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
              <p class="text-[13px] text-slate-400">Belum ada data pembayaran</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($payments->hasPages())
    <div class="px-5 py-4 border-t border-slate-200">{{ $payments->links() }}</div>
    @endif
  </div>

</div>
@endsection
