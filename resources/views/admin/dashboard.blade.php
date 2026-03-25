@extends('layouts.admin')
@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-[20px]">

  {{-- ── HEADER ── --}}
  <div class="flex items-start justify-between">
    <div>
      <h2 class="text-[22px] font-extrabold text-slate-800">Dashboard Overview</h2>
      <p class="text-[13px] text-slate-500 mt-0.5">Selamat datang kembali, {{ auth()->user()->name }}. Ini ringkasan hari ini.</p>
    </div>
    <div class="flex items-center gap-2">
      <a href="{{ route('admin.members.export') }}" class="h-9 px-4 rounded-[9px] border border-slate-200 bg-white text-[13px] font-semibold text-slate-700 hover:bg-slate-50 transition-colors flex items-center gap-2 shadow-[0_1px_3px_rgba(0,0,0,.04)]">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Export
      </a>
      <a href="{{ route('admin.articles.create') }}" class="h-9 px-4 rounded-[9px] bg-[#1e5aff] text-[13px] font-semibold text-white hover:bg-blue-700 transition-colors flex items-center gap-2 shadow-[0_2px_8px_rgba(30,90,255,.3)]">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Konten
      </a>
    </div>
  </div>

  {{-- ── STAT CARDS ROW 1 ── --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-[14px]">

    {{-- Total Anggota --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.05)] p-5 relative overflow-hidden group hover:-translate-y-0.5 hover:shadow-md transition-all">
      <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-[rgba(30,90,255,.06)] -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
      <div class="flex items-start gap-3 relative z-10">
        <div class="w-11 h-11 rounded-[11px] bg-[rgba(30,90,255,.1)] flex items-center justify-center text-[#1e5aff] flex-shrink-0">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div>
          <div class="text-[28px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['totalMembers']) }}</div>
          <div class="text-[12px] text-slate-500 mt-1 font-medium">Total Anggota</div>
          <div class="text-[11px] font-semibold text-[#10b981] mt-2 flex items-center gap-1">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            {{ $stats['activeMembers'] }} aktif saat ini
          </div>
        </div>
      </div>
    </div>

    {{-- Anggota Aktif --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.05)] p-5 relative overflow-hidden group hover:-translate-y-0.5 hover:shadow-md transition-all">
      <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-[rgba(16,185,129,.06)] -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
      <div class="flex items-start gap-3 relative z-10">
        <div class="w-11 h-11 rounded-[11px] bg-[rgba(16,185,129,.1)] flex items-center justify-center text-[#10b981] flex-shrink-0">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div>
          <div class="text-[28px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['activeMembers']) }}</div>
          <div class="text-[12px] text-slate-500 mt-1 font-medium">Anggota Aktif</div>
          @php $pct = $stats['totalMembers'] > 0 ? round($stats['activeMembers']/$stats['totalMembers']*100, 1) : 0; @endphp
          <div class="text-[11px] font-semibold text-[#10b981] mt-2 flex items-center gap-1">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            {{ $pct }}% dari total
          </div>
        </div>
      </div>
    </div>

    {{-- Iuran Bulan Ini --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.05)] p-5 relative overflow-hidden group hover:-translate-y-0.5 hover:shadow-md transition-all">
      <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-[rgba(245,158,11,.06)] -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
      <div class="flex items-start gap-3 relative z-10">
        <div class="w-11 h-11 rounded-[11px] bg-[rgba(245,158,11,.1)] flex items-center justify-center text-[#f59e0b] flex-shrink-0">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
        </div>
        <div>
          @php
            $iuran = $stats['iuranBulanIni'];
            $iuranFmt = $iuran >= 1000000 ? 'Rp '.number_format($iuran/1000000,1).'jt' : 'Rp '.number_format($iuran,0,',','.');
          @endphp
          <div class="text-[28px] font-extrabold text-slate-800 leading-none tracking-tight">{{ $iuranFmt }}</div>
          <div class="text-[12px] text-slate-500 mt-1 font-medium">Iuran Bulan Ini</div>
          <div class="text-[11px] font-semibold text-[#10b981] mt-2 flex items-center gap-1">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            {{ $stats['pendingPayments'] > 0 ? $stats['pendingPayments'].' belum dikonfirmasi' : 'Semua terkonfirmasi' }}
          </div>
        </div>
      </div>
    </div>

    {{-- Kegiatan Aktif --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.05)] p-5 relative overflow-hidden group hover:-translate-y-0.5 hover:shadow-md transition-all">
      <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-[rgba(139,92,246,.06)] -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
      <div class="flex items-start gap-3 relative z-10">
        <div class="w-11 h-11 rounded-[11px] bg-[rgba(139,92,246,.1)] flex items-center justify-center text-[#8b5cf6] flex-shrink-0">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
          <div class="text-[28px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['activeEvents']) }}</div>
          <div class="text-[12px] text-slate-500 mt-1 font-medium">Kegiatan Aktif</div>
          <div class="text-[11px] font-semibold text-[#10b981] mt-2 flex items-center gap-1">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            {{ $stats['newEventsMonth'] }} kegiatan baru
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- ── STAT CARDS ROW 2 ── --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-[14px]">

    {{-- Pending Aktivasi --}}
    <a href="{{ route('admin.members.index') }}?status=pending" class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.05)] p-5 relative overflow-hidden group hover:-translate-y-0.5 hover:shadow-md transition-all block">
      <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-[rgba(239,68,68,.05)] -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
      <div class="flex items-start gap-3 relative z-10">
        <div class="w-11 h-11 rounded-[11px] bg-[rgba(239,68,68,.1)] flex items-center justify-center text-[#ef4444] flex-shrink-0">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
          <div class="text-[28px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['pendingMembers']) }}</div>
          <div class="text-[12px] text-slate-500 mt-1 font-medium">Pending Aktivasi</div>
          <div class="text-[11px] font-semibold text-[#ef4444] mt-2 flex items-center gap-1">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 9 12 15 6 9"/></svg>
            {{ $stats['pendingPayments'] }} belum dibayar
          </div>
        </div>
      </div>
    </a>

    {{-- Total Artikel --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.05)] p-5 relative overflow-hidden group hover:-translate-y-0.5 hover:shadow-md transition-all">
      <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-[rgba(14,165,233,.06)] -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
      <div class="flex items-start gap-3 relative z-10">
        <div class="w-11 h-11 rounded-[11px] bg-[rgba(14,165,233,.1)] flex items-center justify-center text-[#0ea5e9] flex-shrink-0">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <div>
          <div class="text-[28px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['totalArticles']) }}</div>
          <div class="text-[12px] text-slate-500 mt-1 font-medium">Total Artikel</div>
          <div class="text-[11px] font-semibold text-[#10b981] mt-2 flex items-center gap-1">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            {{ $stats['newArticles'] }} artikel baru
          </div>
        </div>
      </div>
    </div>

    {{-- Materi Edukasi --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.05)] p-5 relative overflow-hidden group hover:-translate-y-0.5 hover:shadow-md transition-all">
      <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-[rgba(16,185,129,.06)] -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
      <div class="flex items-start gap-3 relative z-10">
        <div class="w-11 h-11 rounded-[11px] bg-[rgba(16,185,129,.1)] flex items-center justify-center text-[#10b981] flex-shrink-0">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
        </div>
        <div>
          <div class="text-[28px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['totalMaterials']) }}</div>
          <div class="text-[12px] text-slate-500 mt-1 font-medium">Materi Edukasi</div>
          <div class="text-[11px] font-semibold text-[#10b981] mt-2 flex items-center gap-1">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            {{ $stats['newMaterials'] }} materi baru
          </div>
        </div>
      </div>
    </div>

    {{-- Pengunjung --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.05)] p-5 relative overflow-hidden group hover:-translate-y-0.5 hover:shadow-md transition-all">
      <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-[rgba(236,72,153,.06)] -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
      <div class="flex items-start gap-3 relative z-10">
        <div class="w-11 h-11 rounded-[11px] bg-[rgba(236,72,153,.1)] flex items-center justify-center text-[#ec4899] flex-shrink-0">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
        <div>
          <div class="text-[28px] font-extrabold text-slate-800 leading-none tracking-tight">{{ number_format($stats['pengunjung']) }}</div>
          <div class="text-[12px] text-slate-500 mt-1 font-medium">Pengunjung Bulan Ini</div>
          <div class="text-[11px] font-semibold text-[#10b981] mt-2 flex items-center gap-1">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            22% dari bulan lalu
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- ── CHART ROW ── --}}
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-[18px]">

    {{-- Bar Chart: Pertumbuhan Anggota --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] p-6">
      <div class="flex items-start justify-between mb-5">
        <div>
          <h3 class="text-[14px] font-bold text-slate-800">Pertumbuhan Anggota</h3>
          <p class="text-[12px] text-slate-500 mt-0.5">6 bulan terakhir</p>
        </div>
        <div class="flex items-center gap-4 text-[12px]">
          <span class="flex items-center gap-1.5 text-slate-500"><span class="w-3 h-3 rounded-full bg-[#1e5aff] inline-block"></span>Daftar</span>
          <span class="flex items-center gap-1.5 text-slate-500"><span class="w-3 h-3 rounded-full bg-[#10b981] inline-block"></span>Aktif</span>
        </div>
      </div>
      <div class="relative h-[200px]" id="barChartWrap">
        <canvas id="barChart"></canvas>
      </div>
    </div>

    {{-- Donut: Status Keanggotaan --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] p-6">
      <div class="mb-4">
        <h3 class="text-[14px] font-bold text-slate-800">Status Keanggotaan</h3>
        <p class="text-[12px] text-slate-500 mt-0.5">Distribusi saat ini</p>
      </div>
      <div class="flex items-center gap-5">
        {{-- Donut SVG --}}
        <div class="relative flex-shrink-0">
          <svg width="100" height="100" viewBox="0 0 100 100">
            @php
              $r = 38; $cx = 50; $cy = 50;
              $circ = 2 * M_PI * $r;
              // Aktif
              $aOff  = 0;
              $aDash = $circ * $donutActive / 100;
              // Pending
              $pOff  = -$aDash;
              $pDash = $circ * $donutPending / 100;
              // Expired
              $eOff  = -$aDash - $pDash;
              $eDash = $circ * $donutExpired / 100;
            @endphp
            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#f1f5f9" stroke-width="14"/>
            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#1e5aff" stroke-width="14"
              stroke-dasharray="{{ $aDash }} {{ $circ }}" stroke-dashoffset="{{ $circ/4 }}" stroke-linecap="butt"/>
            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#10b981" stroke-width="14"
              stroke-dasharray="{{ $pDash }} {{ $circ }}" stroke-dashoffset="{{ $circ/4 + $pOff }}" stroke-linecap="butt"/>
            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#ef4444" stroke-width="14"
              stroke-dasharray="{{ $eDash }} {{ $circ }}" stroke-dashoffset="{{ $circ/4 + $eOff }}" stroke-linecap="butt"/>
          </svg>
          <div class="absolute inset-0 flex flex-col items-center justify-center">
            <span class="text-[18px] font-extrabold text-slate-800">{{ $donutActive }}%</span>
            <span class="text-[10px] text-slate-500">aktif</span>
          </div>
        </div>
        {{-- Legend --}}
        <div class="flex-1 space-y-3">
          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2 text-[12.5px] text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-[#1e5aff]"></span>Aktif</span>
            <span class="text-[13px] font-bold text-slate-800">{{ number_format($activeMembers) }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2 text-[12.5px] text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-[#10b981]"></span>Pending</span>
            <span class="text-[13px] font-bold text-slate-800">{{ number_format($pendingMembers) }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="flex items-center gap-2 text-[12.5px] text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-[#ef4444]"></span>Kadaluarsa</span>
            <span class="text-[13px] font-bold text-slate-800">{{ number_format($expiredMembers) }}</span>
          </div>
          <div class="border-t border-slate-100 pt-3 space-y-2">
            <div class="flex items-center gap-2">
              <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-[#1e5aff] rounded-full" style="width:{{ $donutActive }}%"></div>
              </div>
              <span class="text-[11px] text-slate-500 w-7 text-right">{{ $donutActive }}%</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-[#10b981] rounded-full" style="width:{{ $donutPending }}%"></div>
              </div>
              <span class="text-[11px] text-slate-500 w-7 text-right">{{ $donutPending }}%</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-[#ef4444] rounded-full" style="width:{{ $donutExpired }}%"></div>
              </div>
              <span class="text-[11px] text-[#ef4444] w-7 text-right">{{ $donutExpired }}%</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── BOTTOM ROW ── --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-[18px]">

    {{-- Anggota Terbaru --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] overflow-hidden">
      <div class="px-5 pt-5 pb-3.5 border-b border-slate-200 flex items-center justify-between">
        <div>
          <div class="text-[14px] font-bold text-slate-800">Anggota Terbaru</div>
          <div class="text-[12px] text-slate-500 mt-0.5">Pendaftar 7 hari terakhir</div>
        </div>
        <a href="{{ route('admin.members.index') }}" class="px-3 py-1.5 rounded-[8px] border border-slate-200 bg-white text-slate-600 text-[12px] font-semibold hover:bg-slate-50 transition-colors">Lihat semua</a>
      </div>
      <div>
        @forelse($recentMembers as $member)
        @php
          $initials = collect(explode(' ', $member->user->name ?? 'User'))->take(2)->map(fn($w)=>strtoupper(substr($w,0,1)))->join('');
          $avatarColors = ['bg-[rgba(30,90,255,.12)] text-[#1e5aff]','bg-[rgba(16,185,129,.12)] text-[#10b981]','bg-[rgba(245,158,11,.12)] text-[#f59e0b]','bg-[rgba(139,92,246,.12)] text-[#8b5cf6]','bg-[rgba(14,165,233,.12)] text-[#0ea5e9]'];
          $avatarColor = $avatarColors[$loop->index % count($avatarColors)];
        @endphp
        <a href="{{ route('admin.members.show', $member->id) }}" class="flex items-center gap-3 px-4 py-3 {{ !$loop->last ? 'border-b border-slate-100' : '' }} hover:bg-slate-50 transition-colors">
          <div class="w-[38px] h-[38px] rounded-[10px] {{ $avatarColor }} flex items-center justify-center font-bold text-[13px] flex-shrink-0">{{ $initials }}</div>
          <div class="flex-1 min-w-0">
            <div class="text-[13px] font-semibold text-slate-800 truncate">{{ $member->user->name ?? 'Unknown' }}</div>
            <div class="text-[11px] text-slate-500">{{ $member->institution ?? $member->member_code }}</div>
          </div>
          @if($member->status === 'active')
          <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[rgba(16,185,129,.12)] text-[#059669]">Aktif</span>
          @elseif($member->status === 'pending')
          <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[rgba(245,158,11,.12)] text-[#d97706]">Pending</span>
          @else
          <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500">{{ ucfirst($member->status) }}</span>
          @endif
        </a>
        @empty
        <div class="px-4 py-8 text-center text-[13px] text-slate-400">Belum ada anggota terdaftar</div>
        @endforelse
      </div>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] overflow-hidden">
      <div class="px-5 pt-5 pb-3.5 border-b border-slate-200">
        <div class="text-[14px] font-bold text-slate-800">Aktivitas Terbaru</div>
        <div class="text-[12px] text-slate-500 mt-0.5">Log aktivitas sistem</div>
      </div>
      <div class="p-5 flex flex-col gap-3.5">
        @forelse($activities as $act)
        <div class="flex items-start gap-3">
          <div class="w-8 h-8 rounded-[9px] {{ $act['color'] }} flex items-center justify-center flex-shrink-0">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $act['icon'] !!}</svg>
          </div>
          <div class="flex-1 min-w-0 text-[12.5px] text-slate-600 leading-relaxed">{!! $act['text'] !!}</div>
          <div class="text-[10.5px] text-slate-400 font-mono flex-shrink-0">
            {{ $act['time'] ? \Carbon\Carbon::parse($act['time'])->diffForHumans(null, true) : '-' }}
          </div>
        </div>
        @empty
        <div class="py-6 text-center text-[13px] text-slate-400">Belum ada aktivitas</div>
        @endforelse
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const isDark = document.documentElement.classList.contains('dark');
const gridColor = isDark ? 'rgba(255,255,255,.06)' : 'rgba(0,0,0,.05)';
const labelColor = isDark ? '#64748b' : '#94a3b8';

const ctx = document.getElementById('barChart').getContext('2d');

// Gradients
const gradBlue = ctx.createLinearGradient(0, 0, 0, 200);
gradBlue.addColorStop(0, 'rgba(30,90,255,.85)');
gradBlue.addColorStop(1, 'rgba(30,90,255,.35)');

const gradGreen = ctx.createLinearGradient(0, 0, 0, 200);
gradGreen.addColorStop(0, 'rgba(16,185,129,.85)');
gradGreen.addColorStop(1, 'rgba(16,185,129,.35)');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: @json($chartLabels),
    datasets: [
      {
        label: 'Daftar',
        data: @json($chartDaftar),
        backgroundColor: gradBlue,
        borderRadius: 6,
        borderSkipped: false,
        barPercentage: 0.55,
        categoryPercentage: 0.7,
      },
      {
        label: 'Aktif',
        data: @json($chartAktif),
        backgroundColor: gradGreen,
        borderRadius: 6,
        borderSkipped: false,
        barPercentage: 0.55,
        categoryPercentage: 0.7,
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: '#0f1b2d',
        titleColor: '#94a3b8',
        bodyColor: '#f1f5f9',
        borderColor: '#1e2d42',
        borderWidth: 1,
        padding: 10,
        cornerRadius: 8,
        callbacks: {
          label: ctx => ' ' + ctx.dataset.label + ': ' + ctx.parsed.y + ' orang',
        }
      },
    },
    scales: {
      x: {
        grid: { display: false },
        border: { display: false },
        ticks: { color: labelColor, font: { size: 11, family: 'Plus Jakarta Sans' } },
      },
      y: {
        beginAtZero: true,
        grid: { color: gridColor },
        border: { display: false, dash: [4,4] },
        ticks: {
          color: labelColor,
          font: { size: 11, family: 'Plus Jakarta Sans' },
          stepSize: 30,
          callback: v => v === 0 ? '0' : v,
        },
      },
    },
  },
});
</script>
@endpush
