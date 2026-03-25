@extends('layouts.admin')
@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-[20px]">

  {{-- ── STAT CARDS ── --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-[16px]">

    {{-- Total Anggota --}}
    <div class="stat-card bg-white rounded-[14px] p-[20px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] flex items-start gap-3.5">
      <div class="w-11 h-11 rounded-[11px] bg-[rgba(30,90,255,.1)] flex items-center justify-center text-[#1e5aff] flex-shrink-0">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
      </div>
      <div>
        <div class="text-[26px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['total_members']) }}</div>
        <div class="text-[12px] text-slate-500 mt-1 font-medium">Total Anggota</div>
        <div class="text-[11px] font-semibold text-[#1e5aff] mt-2 flex items-center gap-1">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
          Terdaftar
        </div>
      </div>
    </div>

    {{-- Anggota Aktif --}}
    <div class="stat-card bg-white rounded-[14px] p-[20px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] flex items-start gap-3.5">
      <div class="w-11 h-11 rounded-[11px] bg-[rgba(16,185,129,.1)] flex items-center justify-center text-[#10b981] flex-shrink-0">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      </div>
      <div>
        <div class="text-[26px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['active_members']) }}</div>
        <div class="text-[12px] text-slate-500 mt-1 font-medium">Anggota Aktif</div>
        @php $activePct = $stats['total_members'] > 0 ? round($stats['active_members']/$stats['total_members']*100) : 0; @endphp
        <div class="text-[11px] font-semibold text-[#10b981] mt-2">{{ $activePct }}% dari total</div>
      </div>
    </div>

    {{-- Menunggu Verifikasi --}}
    <div class="stat-card bg-white rounded-[14px] p-[20px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] flex items-start gap-3.5">
      <div class="w-11 h-11 rounded-[11px] bg-[rgba(245,158,11,.1)] flex items-center justify-center text-[#f59e0b] flex-shrink-0">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div>
        <div class="text-[26px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['pending_members']) }}</div>
        <div class="text-[12px] text-slate-500 mt-1 font-medium">Menunggu Aktivasi</div>
        @if($stats['pending_members'] > 0)
        <a href="{{ route('admin.members.index') }}?status=pending" class="text-[11px] font-semibold text-[#f59e0b] mt-2 flex items-center gap-1 hover:underline">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
          Tinjau sekarang
        </a>
        @else
        <div class="text-[11px] font-semibold text-slate-400 mt-2">Semua terverifikasi</div>
        @endif
      </div>
    </div>

    {{-- Pembayaran Tertunda --}}
    <div class="stat-card bg-white rounded-[14px] p-[20px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] flex items-start gap-3.5">
      <div class="w-11 h-11 rounded-[11px] bg-[rgba(239,68,68,.1)] flex items-center justify-center text-[#ef4444] flex-shrink-0">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
      </div>
      <div>
        <div class="text-[26px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['pending_payments']) }}</div>
        <div class="text-[12px] text-slate-500 mt-1 font-medium">Bayar Tertunda</div>
        @if($stats['pending_payments'] > 0)
        <a href="{{ route('admin.payments.index') }}?status=pending" class="text-[11px] font-semibold text-[#ef4444] mt-2 flex items-center gap-1 hover:underline">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
          Konfirmasi
        </a>
        @else
        <div class="text-[11px] font-semibold text-slate-400 mt-2">Tidak ada pending</div>
        @endif
      </div>
    </div>

    {{-- Total Kegiatan --}}
    <div class="stat-card bg-white rounded-[14px] p-[20px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] flex items-start gap-3.5">
      <div class="w-11 h-11 rounded-[11px] bg-[rgba(139,92,246,.1)] flex items-center justify-center text-[#8b5cf6] flex-shrink-0">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      </div>
      <div>
        <div class="text-[26px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['total_events']) }}</div>
        <div class="text-[12px] text-slate-500 mt-1 font-medium">Total Kegiatan</div>
        <div class="text-[11px] font-semibold text-[#8b5cf6] mt-2">Seminar & Webinar</div>
      </div>
    </div>

    {{-- Total Artikel --}}
    <div class="stat-card bg-white rounded-[14px] p-[20px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] flex items-start gap-3.5">
      <div class="w-11 h-11 rounded-[11px] bg-[rgba(14,165,233,.1)] flex items-center justify-center text-[#0ea5e9] flex-shrink-0">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      </div>
      <div>
        <div class="text-[26px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['total_articles']) }}</div>
        <div class="text-[12px] text-slate-500 mt-1 font-medium">Total Artikel</div>
        <div class="text-[11px] font-semibold text-[#0ea5e9] mt-2">Artikel & Berita</div>
      </div>
    </div>

    {{-- Pesan Belum Dibaca --}}
    <div class="stat-card bg-white rounded-[14px] p-[20px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] flex items-start gap-3.5">
      <div class="w-11 h-11 rounded-[11px] bg-[rgba(236,72,153,.1)] flex items-center justify-center text-[#ec4899] flex-shrink-0">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      </div>
      <div>
        <div class="text-[26px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['unread_messages']) }}</div>
        <div class="text-[12px] text-slate-500 mt-1 font-medium">Pesan Belum Dibaca</div>
        @if($stats['unread_messages'] > 0)
        <a href="{{ route('admin.contact.index') }}" class="text-[11px] font-semibold text-[#ec4899] mt-2 flex items-center gap-1 hover:underline">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
          Buka Pesan
        </a>
        @else
        <div class="text-[11px] font-semibold text-slate-400 mt-2">Semua sudah dibaca</div>
        @endif
      </div>
    </div>

    {{-- Aksi Cepat --}}
    <div class="bg-[#0f1b2d] rounded-[14px] p-[20px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)]">
      <div class="text-[12px] font-bold text-white/50 uppercase tracking-widest mb-3">Aksi Cepat</div>
      <div class="flex flex-col gap-2">
        <a href="{{ route('admin.members.index') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-[8px] bg-white/[.05] hover:bg-white/[.1] text-white/80 text-[12px] font-medium transition-colors">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
          Tambah Anggota
        </a>
        <a href="{{ route('admin.articles.create') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-[8px] bg-white/[.05] hover:bg-white/[.1] text-white/80 text-[12px] font-medium transition-colors">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Tulis Artikel
        </a>
        <a href="{{ route('admin.events.create') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-[8px] bg-white/[.05] hover:bg-white/[.1] text-white/80 text-[12px] font-medium transition-colors">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Buat Kegiatan
        </a>
      </div>
    </div>

  </div>{{-- /stat grid --}}

  {{-- ── BOTTOM TABLES ── --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-[18px]">

    {{-- Anggota Terbaru --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] overflow-hidden">
      <div class="px-5 pt-[18px] pb-3.5 border-b border-slate-200 flex items-center justify-between">
        <div>
          <div class="text-[14px] font-bold text-slate-800">Anggota Terbaru</div>
          <div class="text-[12px] text-slate-500 mt-0.5">Pendaftar terakhir masuk</div>
        </div>
        <a href="{{ route('admin.members.index') }}" class="px-3 py-1.5 rounded-[8px] border border-slate-200 bg-white text-slate-600 text-[12px] font-semibold hover:bg-slate-50 transition-colors">Lihat semua</a>
      </div>
      <div>
        @forelse($recent_members as $member)
        @php
          $initials = collect(explode(' ', $member->user->name ?? 'User'))->take(2)->map(fn($w)=>strtoupper(substr($w,0,1)))->join('');
          $colors = ['bg-[rgba(30,90,255,.12)] text-[#1e5aff]','bg-[rgba(16,185,129,.12)] text-[#10b981]','bg-[rgba(245,158,11,.12)] text-[#f59e0b]','bg-[rgba(139,92,246,.12)] text-[#8b5cf6]','bg-[rgba(14,165,233,.12)] text-[#0ea5e9]'];
          $color = $colors[$loop->index % count($colors)];
        @endphp
        <div class="flex items-center gap-3 px-4 py-3 {{ !$loop->last ? 'border-b border-slate-100' : '' }} hover:bg-slate-50 transition-colors cursor-pointer">
          <div class="w-[38px] h-[38px] rounded-[10px] {{ $color }} flex items-center justify-center font-bold text-[13px] flex-shrink-0">{{ $initials }}</div>
          <div class="flex-1 min-w-0">
            <div class="text-[13px] font-semibold text-slate-800 truncate">{{ $member->user->name ?? 'Unknown' }}</div>
            <div class="text-[11px] text-slate-500">{{ $member->member_code }}</div>
          </div>
          @if($member->status === 'active')
          <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[rgba(16,185,129,.12)] text-[#059669]">Aktif</span>
          @elseif($member->status === 'pending')
          <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[rgba(245,158,11,.12)] text-[#d97706]">Pending</span>
          @else
          <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[rgba(239,68,68,.1)] text-[#dc2626]">{{ ucfirst($member->status) }}</span>
          @endif
        </div>
        @empty
        <div class="px-4 py-8 text-center text-[13px] text-slate-400">
          <svg class="mx-auto mb-2 text-slate-300" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
          Belum ada anggota terdaftar
        </div>
        @endforelse
      </div>
    </div>

    {{-- Pembayaran Terbaru --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] overflow-hidden">
      <div class="px-5 pt-[18px] pb-3.5 border-b border-slate-200 flex items-center justify-between">
        <div>
          <div class="text-[14px] font-bold text-slate-800">Pembayaran Terbaru</div>
          <div class="text-[12px] text-slate-500 mt-0.5">Transaksi iuran anggota</div>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="px-3 py-1.5 rounded-[8px] border border-slate-200 bg-white text-slate-600 text-[12px] font-semibold hover:bg-slate-50 transition-colors">Lihat semua</a>
      </div>
      <div>
        @forelse($recent_payments as $payment)
        <div class="flex items-center gap-3 px-4 py-3 {{ !$loop->last ? 'border-b border-slate-100' : '' }} hover:bg-slate-50 transition-colors cursor-pointer">
          <div class="w-[38px] h-[38px] rounded-[10px] bg-[rgba(30,90,255,.08)] flex items-center justify-center text-[#1e5aff] flex-shrink-0">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          </div>
          <div class="flex-1 min-w-0">
            <div class="text-[13px] font-semibold text-slate-800 truncate">{{ $payment->member->user->name ?? 'Unknown' }}</div>
            <div class="text-[11px] text-slate-500 font-mono">{{ $payment->invoice_no }}</div>
          </div>
          <div class="text-right flex-shrink-0">
            <div class="text-[13px] font-bold text-slate-800">Rp {{ number_format($payment->amount) }}</div>
            @if($payment->status === 'paid')
            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#059669]">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>Lunas
            </span>
            @else
            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#d97706]">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Pending
            </span>
            @endif
          </div>
        </div>
        @empty
        <div class="px-4 py-8 text-center text-[13px] text-slate-400">
          <svg class="mx-auto mb-2 text-slate-300" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          Belum ada transaksi pembayaran
        </div>
        @endforelse
      </div>
    </div>

  </div>{{-- /bottom row --}}

</div>
@endsection
