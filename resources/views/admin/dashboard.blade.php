@extends('layouts.admin')
@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-6">

  {{-- ── HEADER ── --}}
  <div class="flex items-start justify-between">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-blue-500 dark:text-blue-400 mb-1">Overview</p>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Dashboard</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Selamat datang, <span class="font-semibold text-slate-700 dark:text-slate-300">{{ auth()->user()->name }}</span></p>
    </div>
    <div class="flex items-center gap-2.5">
      <a href="{{ route('admin.members.export') }}" class="inline-flex items-center gap-1.5 h-9 px-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Export
      </a>
      <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-1.5 h-9 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-sm font-semibold text-white transition-all shadow-sm shadow-blue-500/30">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Konten
      </a>
    </div>
  </div>

  {{-- ── STAT CARDS ROW 1 ── --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

    {{-- Total Anggota --}}
    <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:shadow-slate-900/60 hover:-translate-y-0.5 transition-all duration-200">
      <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 flex-shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">{{ number_format($stats['totalMembers']) }}</div>
          <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Total Anggota</div>
          <div class="flex items-center gap-1 mt-2 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            {{ $stats['activeMembers'] }} aktif saat ini
          </div>
        </div>
      </div>
    </div>

    {{-- Anggota Aktif --}}
    <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:shadow-slate-900/60 hover:-translate-y-0.5 transition-all duration-200">
      <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 flex-shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div class="flex-1 min-w-0">
          @php $pct = $stats['totalMembers'] > 0 ? round($stats['activeMembers']/$stats['totalMembers']*100, 1) : 0; @endphp
          <div class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">{{ number_format($stats['activeMembers']) }}</div>
          <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Anggota Aktif</div>
          <div class="flex items-center gap-1 mt-2 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            {{ $pct }}% dari total
          </div>
        </div>
      </div>
    </div>

    {{-- Iuran Bulan Ini --}}
    <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:shadow-slate-900/60 hover:-translate-y-0.5 transition-all duration-200">
      <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 flex-shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
        </div>
        <div class="flex-1 min-w-0">
          @php
            $iuran = $stats['iuranBulanIni'];
            $iuranFmt = $iuran >= 1000000 ? 'Rp '.number_format($iuran/1000000,1).'jt' : 'Rp '.number_format($iuran,0,',','.');
          @endphp
          <div class="text-xl font-black text-slate-900 dark:text-white leading-none tracking-tight">{{ $iuranFmt }}</div>
          <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Iuran Bulan Ini</div>
          <div class="flex items-center gap-1 mt-2 text-[11px] font-semibold {{ $stats['pendingPayments'] > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400' }}">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="{{ $stats['pendingPayments'] > 0 ? '18 9 12 15 6 9' : '18 15 12 9 6 15' }}"/></svg>
            {{ $stats['pendingPayments'] > 0 ? $stats['pendingPayments'].' belum dikonfirmasi' : 'Semua terkonfirmasi' }}
          </div>
        </div>
      </div>
    </div>

    {{-- Kegiatan Aktif --}}
    <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:shadow-slate-900/60 hover:-translate-y-0.5 transition-all duration-200">
      <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center text-violet-600 dark:text-violet-400 flex-shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">{{ number_format($stats['activeEvents']) }}</div>
          <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Kegiatan Aktif</div>
          <div class="flex items-center gap-1 mt-2 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            {{ $stats['newEventsMonth'] }} kegiatan baru
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- ── STAT CARDS ROW 2 ── --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

    <a href="{{ route('admin.members.index') }}?status=pending" class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:shadow-slate-900/60 hover:-translate-y-0.5 transition-all duration-200 block">
      <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-red-50 dark:bg-red-900/30 flex items-center justify-center text-red-500 dark:text-red-400 flex-shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">{{ number_format($stats['pendingMembers']) }}</div>
          <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Pending Aktivasi</div>
          <div class="flex items-center gap-1 mt-2 text-[11px] font-semibold text-red-500 dark:text-red-400">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 9 12 15 6 9"/></svg>
            {{ $stats['pendingPayments'] }} belum dibayar
          </div>
        </div>
      </div>
    </a>

    <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:shadow-slate-900/60 hover:-translate-y-0.5 transition-all duration-200">
      <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-sky-50 dark:bg-sky-900/30 flex items-center justify-center text-sky-600 dark:text-sky-400 flex-shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">{{ number_format($stats['totalArticles']) }}</div>
          <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Total Artikel</div>
          <div class="flex items-center gap-1 mt-2 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            {{ $stats['newArticles'] }} artikel baru
          </div>
        </div>
      </div>
    </div>

    <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:shadow-slate-900/60 hover:-translate-y-0.5 transition-all duration-200">
      <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 flex-shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">{{ number_format($stats['totalMaterials']) }}</div>
          <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Materi Edukasi</div>
          <div class="flex items-center gap-1 mt-2 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            {{ $stats['newMaterials'] }} materi baru
          </div>
        </div>
      </div>
    </div>

    <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:shadow-slate-900/60 hover:-translate-y-0.5 transition-all duration-200">
      <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-pink-50 dark:bg-pink-900/30 flex items-center justify-center text-pink-600 dark:text-pink-400 flex-shrink-0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">{{ number_format($stats['pengunjung']) }}</div>
          <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Pengunjung Bulan Ini</div>
          <div class="flex items-center gap-1 mt-2 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            22% dari bulan lalu
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- ── CHART ROW ── --}}
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-5">

    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
      <div class="flex items-start justify-between mb-5">
        <div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Pertumbuhan Anggota</h3>
          <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">6 bulan terakhir</p>
        </div>
        <div class="flex items-center gap-4 text-xs text-slate-500 dark:text-slate-400">
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500 inline-block"></span>Daftar</span>
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>Aktif</span>
        </div>
      </div>
      <div class="relative h-[200px]">
        <canvas id="barChart"></canvas>
      </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
      <div class="mb-4">
        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Status Keanggotaan</h3>
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Distribusi saat ini</p>
      </div>
      <div class="flex items-center gap-5">
        <div class="relative flex-shrink-0">
          @php
            $r = 38; $cx = 50; $cy = 50;
            $circ = 2 * M_PI * $r;
            $aDash = $circ * $donutActive / 100;
            $pOff  = -$aDash;
            $pDash = $circ * $donutPending / 100;
            $eOff  = -$aDash - $pDash;
            $eDash = $circ * $donutExpired / 100;
          @endphp
          <svg width="100" height="100" viewBox="0 0 100 100">
            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#f1f5f9" class="dark:[stroke:#1e293b]" stroke-width="13"/>
            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#3b82f6" stroke-width="13"
              stroke-dasharray="{{ $aDash }} {{ $circ }}" stroke-dashoffset="{{ $circ/4 }}" stroke-linecap="butt"/>
            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#10b981" stroke-width="13"
              stroke-dasharray="{{ $pDash }} {{ $circ }}" stroke-dashoffset="{{ $circ/4 + $pOff }}" stroke-linecap="butt"/>
            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#ef4444" stroke-width="13"
              stroke-dasharray="{{ $eDash }} {{ $circ }}" stroke-dashoffset="{{ $circ/4 + $eOff }}" stroke-linecap="butt"/>
          </svg>
          <div class="absolute inset-0 flex flex-col items-center justify-center">
            <span class="text-lg font-black text-slate-900 dark:text-white">{{ $donutActive }}%</span>
            <span class="text-[10px] text-slate-500">aktif</span>
          </div>
        </div>
        <div class="flex-1 space-y-3">
          <div>
            <div class="flex items-center justify-between mb-1">
              <span class="flex items-center gap-1.5 text-xs text-slate-600 dark:text-slate-400"><span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span>Aktif</span>
              <span class="text-xs font-bold text-slate-900 dark:text-white">{{ number_format($activeMembers) }}</span>
            </div>
            <div class="h-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden"><div class="h-full bg-blue-500 rounded-full" style="width:{{ $donutActive }}%"></div></div>
          </div>
          <div>
            <div class="flex items-center justify-between mb-1">
              <span class="flex items-center gap-1.5 text-xs text-slate-600 dark:text-slate-400"><span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>Pending</span>
              <span class="text-xs font-bold text-slate-900 dark:text-white">{{ number_format($pendingMembers) }}</span>
            </div>
            <div class="h-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden"><div class="h-full bg-emerald-500 rounded-full" style="width:{{ $donutPending }}%"></div></div>
          </div>
          <div>
            <div class="flex items-center justify-between mb-1">
              <span class="flex items-center gap-1.5 text-xs text-slate-600 dark:text-slate-400"><span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span>Kadaluarsa</span>
              <span class="text-xs font-bold text-slate-900 dark:text-white">{{ number_format($expiredMembers) }}</span>
            </div>
            <div class="h-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden"><div class="h-full bg-red-500 rounded-full" style="width:{{ $donutExpired }}%"></div></div>
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- ── BOTTOM ROW ── --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
      <div class="px-5 pt-5 pb-3.5 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
        <div>
          <div class="text-sm font-bold text-slate-900 dark:text-white">Anggota Terbaru</div>
          <div class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Pendaftar 7 hari terakhir</div>
        </div>
        <a href="{{ route('admin.members.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">Lihat semua →</a>
      </div>
      @forelse($recentMembers as $member)
      @php
        $initials = collect(explode(' ', $member->user->name ?? 'User'))->take(2)->map(fn($w)=>strtoupper(substr($w,0,1)))->join('');
        $colors = [['bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'],['bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400'],['bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400'],['bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400'],['bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400']];
        $avatarColor = $colors[$loop->index % count($colors)][0];
      @endphp
      <a href="{{ route('admin.members.show', $member->id) }}" class="flex items-center gap-3 px-4 py-3 {{ !$loop->last ? 'border-b border-slate-50 dark:border-slate-700/50' : '' }} hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
        <div class="w-9 h-9 rounded-xl {{ $avatarColor }} flex items-center justify-center font-bold text-xs flex-shrink-0">{{ $initials }}</div>
        <div class="flex-1 min-w-0">
          <div class="text-sm font-semibold text-slate-800 dark:text-white truncate">{{ $member->user->name ?? 'Unknown' }}</div>
          <div class="text-xs text-slate-400 dark:text-slate-500">{{ $member->institution ?? $member->member_code }}</div>
        </div>
        @if($member->status === 'active')
        <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">Aktif</span>
        @elseif($member->status === 'pending')
        <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400">Pending</span>
        @else
        <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">{{ ucfirst($member->status) }}</span>
        @endif
      </a>
      @empty
      <div class="px-4 py-10 text-center text-sm text-slate-400">Belum ada anggota terdaftar</div>
      @endforelse
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
      <div class="px-5 pt-5 pb-3.5 border-b border-slate-100 dark:border-slate-700">
        <div class="text-sm font-bold text-slate-900 dark:text-white">Aktivitas Terbaru</div>
        <div class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Log aktivitas sistem</div>
      </div>
      <div class="p-5 flex flex-col gap-3.5">
        @forelse($activities as $act)
        <div class="flex items-start gap-3">
          <div class="w-8 h-8 rounded-xl {{ $act['color'] }} flex items-center justify-center flex-shrink-0">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $act['icon'] !!}</svg>
          </div>
          <div class="flex-1 min-w-0 text-xs text-slate-600 dark:text-slate-300 leading-relaxed">{!! $act['text'] !!}</div>
          <div class="text-[10px] text-slate-400 dark:text-slate-500 font-mono flex-shrink-0 pt-0.5">
            {{ $act['time'] ? \Carbon\Carbon::parse($act['time'])->diffForHumans(null, true) : '-' }}
          </div>
        </div>
        @empty
        <div class="py-8 text-center text-sm text-slate-400">Belum ada aktivitas</div>
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
const labelColor = isDark ? '#475569' : '#94a3b8';
const ctx = document.getElementById('barChart').getContext('2d');
const gradBlue = ctx.createLinearGradient(0,0,0,200);
gradBlue.addColorStop(0,'rgba(59,130,246,.9)');gradBlue.addColorStop(1,'rgba(59,130,246,.3)');
const gradGreen = ctx.createLinearGradient(0,0,0,200);
gradGreen.addColorStop(0,'rgba(16,185,129,.9)');gradGreen.addColorStop(1,'rgba(16,185,129,.3)');
new Chart(ctx, {
  type:'bar',
  data:{ labels:@json($chartLabels), datasets:[
    {label:'Daftar',data:@json($chartDaftar),backgroundColor:gradBlue,borderRadius:6,borderSkipped:false,barPercentage:.55,categoryPercentage:.7},
    {label:'Aktif',data:@json($chartAktif),backgroundColor:gradGreen,borderRadius:6,borderSkipped:false,barPercentage:.55,categoryPercentage:.7},
  ]},
  options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{backgroundColor:isDark?'#0f172a':'#1e293b',titleColor:'#64748b',bodyColor:'#f1f5f9',borderColor:isDark?'#1e293b':'#334155',borderWidth:1,padding:10,cornerRadius:8,callbacks:{label:c=>' '+c.dataset.label+': '+c.parsed.y+' orang'}}},scales:{x:{grid:{display:false},border:{display:false},ticks:{color:labelColor,font:{size:11}}},y:{beginAtZero:true,grid:{color:gridColor},border:{display:false,dash:[4,4]},ticks:{color:labelColor,font:{size:11},stepSize:30}}}},
});
</script>
@endpush
