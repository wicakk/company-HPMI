@extends('layouts.app')
@section('title','Riwayat Pembayaran')
@section('content')

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

  {{-- Header --}}
  <div class="flex items-center gap-3 mb-8">
    <a href="{{ route('member.payment') }}"
       class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
    </a>
    <div>
      <h1 class="text-2xl font-black text-slate-900 dark:text-white">Riwayat Pembayaran</h1>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Semua transaksi keanggotaan Anda</p>
    </div>
  </div>

  {{-- List --}}
  <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
    @forelse($payments ?? [] as $pay)
    @php
      // Warna icon & badge per status — termasuk waiting & rejected
      $statusConfig = [
        'paid'     => ['icon_bg' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400', 'text' => 'text-emerald-600 dark:text-emerald-400', 'label' => 'Lunas'],
        'waiting'  => ['icon_bg' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400',             'text' => 'text-blue-600 dark:text-blue-400',    'label' => 'Menunggu Validasi'],
        'pending'  => ['icon_bg' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400',         'text' => 'text-amber-600 dark:text-amber-400',  'label' => 'Pending'],
        'rejected' => ['icon_bg' => 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400',                 'text' => 'text-red-600 dark:text-red-400',      'label' => 'Ditolak'],
        'failed'   => ['icon_bg' => 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400',                 'text' => 'text-red-600 dark:text-red-400',      'label' => 'Gagal'],
        'expired'  => ['icon_bg' => 'bg-slate-100 dark:bg-slate-800 text-slate-400',                                'text' => 'text-slate-400',                      'label' => 'Kadaluarsa'],
      ];
      $cfg = $statusConfig[$pay->status] ?? ['icon_bg' => 'bg-slate-100 text-slate-400', 'text' => 'text-slate-400', 'label' => ucfirst($pay->status)];
    @endphp

    <div class="flex items-center gap-4 px-6 py-4 border-b border-slate-50 dark:border-slate-800 last:border-0 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">

      {{-- Icon --}}
      <div class="w-10 h-10 rounded-2xl {{ $cfg['icon_bg'] }} flex items-center justify-center flex-shrink-0">
        @if($pay->status === 'paid')
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        @elseif($pay->status === 'waiting')
          <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
          </svg>
        @elseif($pay->status === 'pending')
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        @else
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        @endif
      </div>

      {{-- Info --}}
      <div class="flex-1 min-w-0">
        <p class="font-bold text-slate-900 dark:text-white text-sm">
          {{ str_replace('_', ' ', ucfirst($pay->type)) }}
        </p>
        <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $pay->invoice_no }}</p>
        @if($pay->payment_method)
          <p class="text-xs text-slate-400 mt-0.5">Via: {{ $pay->payment_method }}</p>
        @endif
        @if($pay->sender_name)
          <p class="text-xs text-slate-400">a.n. {{ $pay->sender_name }}</p>
        @endif
      </div>

      {{-- Nominal & Status --}}
      <div class="text-right flex-shrink-0">
        <p class="font-black text-slate-900 dark:text-white">
          Rp {{ number_format($pay->amount, 0, ',', '.') }}
        </p>
        <p class="text-xs font-semibold {{ $cfg['text'] }} mt-0.5">
          {{ $cfg['label'] }}
        </p>
        <p class="text-xs text-slate-400 mt-0.5">
          {{ $pay->created_at->format('d M Y') }}
        </p>
      </div>

    </div>
    @empty
    <div class="py-20 text-center text-slate-400">
      <svg class="w-14 h-14 mx-auto mb-3 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
      </svg>
      <p class="text-sm font-semibold">Belum ada riwayat pembayaran</p>
    </div>
    @endforelse
  </div>

  {{-- Pagination --}}
  @if(isset($payments) && $payments && $payments->hasPages())
  <div class="mt-4">{{ $payments->links() }}</div>
  @endif

</div>

@endsection