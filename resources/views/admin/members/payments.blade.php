@extends('layouts.admin')
@section('title', 'Konfirmasi Pembayaran')
@section('content')

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-emerald-500 dark:text-emerald-400 mb-1">Keuangan</p>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Konfirmasi Pembayaran</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Verifikasi dan aktivasi keanggotaan anggota</p>
    </div>
    <form method="GET">
      <select name="status" onchange="this.form.submit()"
        class="h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition cursor-pointer">
        <option value="">Semua Status</option>
        {{-- ✅ FIX: Tambah opsi waiting --}}
        <option value="waiting"  {{ request('status')==='waiting'?'selected':'' }}>Menunggu Validasi</option>
        <option value="pending"  {{ request('status')==='pending'?'selected':'' }}>Pending</option>
        <option value="paid"     {{ request('status')==='paid'?'selected':'' }}>Lunas</option>
        <option value="rejected" {{ request('status')==='rejected'?'selected':'' }}>Ditolak</option>
        <option value="expired"  {{ request('status')==='expired'?'selected':'' }}>Kadaluarsa</option>
      </select>
    </form>
  </div>

  {{-- Stats --}}
  @php
    $allPayments  = \App\Models\Payment::all();
    // {{-- ✅ FIX: Hitung waiting + pending sebagai "Menunggu Konfirmasi" --}}
    $totalPending = $allPayments->whereIn('status', ['pending', 'waiting'])->count();
    $totalPaid    = $allPayments->where('status', 'paid')->count();
    $totalAmount  = $allPayments->where('status', 'paid')->sum('amount');
  @endphp
  <div class="grid grid-cols-3 gap-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 flex items-center gap-4 hover:shadow-md dark:hover:shadow-slate-900/50 transition-all">
      <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-500 dark:text-amber-400 flex-shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div>
        <p class="text-2xl font-black text-slate-900 dark:text-white leading-none">{{ $totalPending }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Menunggu Konfirmasi</p>
      </div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 flex items-center gap-4 hover:shadow-md dark:hover:shadow-slate-900/50 transition-all">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-500 dark:text-emerald-400 flex-shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <div>
        <p class="text-2xl font-black text-slate-900 dark:text-white leading-none">{{ $totalPaid }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Pembayaran Lunas</p>
      </div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 flex items-center gap-4 hover:shadow-md dark:hover:shadow-slate-900/50 transition-all">
      <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 flex-shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
      </div>
      <div>
        <p class="text-xl font-black text-slate-900 dark:text-white leading-none">Rp {{ number_format($totalAmount,0,',','.') }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Total Diterima</p>
      </div>
    </div>
  </div>

  {{-- Table --}}
  <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-slate-100 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-700/30">
            <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Anggota</th>
            <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Invoice</th>
            <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nominal</th>
            <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">Tipe</th>
            <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">VA Number</th>
            <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
            <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">Batas</th>
            <th class="text-left px-5 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
          @forelse($payments as $payment)
          <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/20 transition-colors">

            {{-- Anggota --}}
            <td class="px-5 py-4">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-xs flex-shrink-0">
                  {{ strtoupper(substr($payment->member->user->name ?? 'U', 0, 2)) }}
                </div>
                <div>
                  <p class="text-sm font-semibold text-slate-800 dark:text-white">{{ $payment->member->user->name ?? '-' }}</p>
                  <p class="text-xs text-slate-400 dark:text-slate-500 font-mono">{{ $payment->member->member_code ?? '-' }}</p>
                </div>
              </div>
            </td>

            {{-- Invoice --}}
            <td class="px-5 py-4">
              <code class="text-xs bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 px-2 py-1 rounded-lg font-mono">{{ $payment->invoice_no }}</code>
            </td>

            {{-- Nominal --}}
            <td class="px-5 py-4 font-bold text-sm text-slate-800 dark:text-white">
              Rp {{ number_format($payment->amount, 0, ',', '.') }}
            </td>

            {{-- Tipe --}}
            <td class="px-5 py-4 hidden md:table-cell">
              <span class="text-xs text-slate-500 dark:text-slate-400 capitalize">{{ str_replace('_', ' ', $payment->type) }}</span>
            </td>

            {{-- VA Number --}}
            <td class="px-5 py-4 hidden lg:table-cell">
              <span class="text-xs font-mono text-slate-600 dark:text-slate-300">{{ $payment->va_number ?? '-' }}</span>
            </td>

            {{-- ✅ FIX: Status badge — tambah case 'waiting' & 'rejected' --}}
            <td class="px-5 py-4">
              @if($payment->status === 'paid')
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline stroke-width="2.5" points="20 6 9 17 4 12"/></svg>
                  Lunas
                </span>

              @elseif($payment->status === 'waiting')
                {{-- ✅ Status yang dikirim member (upload bukti) --}}
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                  <svg class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                  </svg>
                  Menunggu Validasi
                </span>

              @elseif($payment->status === 'pending')
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline stroke-width="2" points="12 6 12 12 16 14"/></svg>
                  Pending
                </span>

              @elseif($payment->status === 'rejected')
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                  Ditolak
                </span>

              @elseif($payment->status === 'expired')
                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">
                  Kadaluarsa
                </span>

              @else
                {{-- Fallback: status lain yang tidak dikenal --}}
                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400">
                  {{ ucfirst($payment->status) }}
                </span>
              @endif
            </td>

            {{-- Batas --}}
            <td class="px-5 py-4 hidden lg:table-cell">
              <span class="text-xs text-slate-500 dark:text-slate-400">
                {{ $payment->expired_at ? $payment->expired_at->format('d M Y') : '-' }}
              </span>
            </td>

            {{-- ✅ FIX: Tombol Aksi — tambah 'waiting' agar tombol konfirmasi/tolak muncul --}}
            <td class="px-5 py-4">
              @if(in_array($payment->status, ['pending', 'waiting']))
                <div class="flex items-center gap-2">
                  {{-- Tombol Konfirmasi --}}
                  <form method="POST" action="{{ route('admin.payments.confirm', $payment->id) }}"
                        onsubmit="return confirm('Konfirmasi pembayaran ini dan aktifkan Premium?')">
                    @csrf @method('PUT')
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 h-8 px-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-all shadow-sm shadow-blue-500/25">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline stroke-width="2.5" points="20 6 9 17 4 12"/></svg>
                      Konfirmasi
                    </button>
                  </form>

                  {{-- Tombol Tolak --}}
                  <form method="POST" action="{{ route('admin.payments.reject', $payment->id) }}"
                        onsubmit="return confirm('Tolak pembayaran ini? Member akan dikembalikan ke status Free.')">
                    @csrf @method('PUT')
                    <button type="submit"
                            class="inline-flex items-center h-8 px-3 rounded-lg border border-slate-200 dark:border-slate-600 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                      Tolak
                    </button>
                  </form>
                </div>

              @elseif($payment->status === 'paid')
                <div class="flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline stroke-width="2.5" points="20 6 9 17 4 12"/></svg>
                  Dikonfirmasi
                </div>

              @elseif($payment->status === 'rejected')
                <span class="text-xs text-red-400 font-semibold">Ditolak</span>

              @else
                <span class="text-xs text-slate-400">—</span>
              @endif
            </td>

          </tr>
          @empty
          <tr>
            <td colspan="8" class="px-5 py-16 text-center">
              <svg class="w-9 h-9 mx-auto mb-3 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
              <p class="text-sm text-slate-400 dark:text-slate-500">Belum ada data pembayaran</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($payments->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-700">{{ $payments->links() }}</div>
    @endif
  </div>

</div>
@endsection