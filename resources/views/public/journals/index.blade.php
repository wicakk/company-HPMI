@extends('layouts.app')
@section('title', 'Jurnal Ilmiah HPMI')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-blue-500 dark:text-blue-400 mb-1">Perpustakaan</p>
      <h1 class="text-2xl font-black text-slate-900 dark:text-white">Jurnal Ilmiah HPMI</h1>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kumpulan publikasi dan penelitian keperawatan manajerial</p>
    </div>
    @auth
    <a href="{{ route('member.dashboard') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-50 transition flex-shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
      Dashboard
    </a>
    @else
    {{-- <a href="{{ route('login') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition flex-shrink-0">
      Login / Daftar
    </a> --}}
    @endauth
  </div>

  {{-- Flash error --}}
  @if(session('error'))
  <div class="flex items-center gap-3 px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl text-sm">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('error') }}
  </div>
  @endif

  {{-- Filter --}}
  <form method="GET" class="flex flex-col sm:flex-row gap-3">
    <div class="relative flex-1">
      <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35"/>
      </svg>
      <input type="text" name="q" value="{{ request('q') }}"
             placeholder="Cari judul, penulis, kategori..."
             class="w-full pl-10 pr-4 h-10 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>

    @if($categories->count())
    <select name="category"
      class="h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
      <option value="">Semua Kategori</option>
      @foreach($categories as $cat)
      <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
      @endforeach
    </select>
    @endif

    <button type="submit"
      class="h-10 px-5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition active:scale-95 flex items-center gap-2">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35"/></svg>
      Cari
    </button>

    @if(request()->hasAny(['q', 'category']))
    <a href="{{ route('journals.index') }}"
       class="h-10 px-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 text-sm font-medium rounded-xl transition flex items-center">
      Reset
    </a>
    @endif
  </form>

  {{-- List Jurnal --}}
  <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">

    @forelse($journals as $journal)
    @php
      // Tentukan apakah jurnal ini premium
      $isPremium = isset($journal->access) && $journal->access === 'premium';

      // Logika akses download:
      // - Gratis (free)  → siapa pun bisa download, termasuk tamu (belum login)
      // - Premium        → hanya user yang sudah login DAN isPremium()
      $canDownload = !$isPremium || (auth()->check() && auth()->user()->isPremium());

      $ext = strtoupper(
          $journal->file_type
          ?? pathinfo($journal->file_path ?? '', PATHINFO_EXTENSION)
          ?? 'PDF'
      );
    @endphp

    <div class="flex items-start gap-4 px-6 py-5 border-b border-slate-50 dark:border-slate-800 last:border-0 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition group">

      {{-- File type badge --}}
      <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center font-black text-xs
                  {{ $ext === 'PDF'
                    ? 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400'
                    : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' }}">
        {{ $ext ?: 'PDF' }}
      </div>

      {{-- Info --}}
      <div class="flex-1 min-w-0">
        <div class="flex items-start gap-2 flex-wrap">
          <h3 class="text-sm font-bold text-slate-900 dark:text-white flex-1 min-w-0">
            {{ $journal->title }}
          </h3>

          {{-- Badge akses --}}
          @if($isPremium)
            @if(auth()->check() && auth()->user()->isPremium())
              {{-- User premium yang login --}}
              <span class="flex-shrink-0 inline-flex items-center gap-1 px-2 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-[10px] font-black rounded-full">
                ⭐ Premium
              </span>
            @else
              {{-- Tamu atau member biasa --}}
              <span class="flex-shrink-0 inline-flex items-center gap-1 px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 text-[10px] font-bold rounded-full">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Terkunci
              </span>
            @endif
          @else
            {{-- Jurnal gratis --}}
            <span class="flex-shrink-0 px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold rounded-full">
              Gratis
            </span>
          @endif
        </div>

        {{-- Meta --}}
        <div class="flex items-center gap-2 mt-1.5 flex-wrap">
          @if($journal->author)
          <span class="flex items-center gap-1 text-xs text-slate-400 dark:text-slate-500">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            {{ $journal->author }}
          </span>
          @endif
          @if($journal->year)
          <span class="text-slate-300 dark:text-slate-600">·</span>
          <span class="text-xs text-slate-400 dark:text-slate-500">{{ $journal->year }}</span>
          @endif
          @if($journal->volume)
          <span class="text-slate-300 dark:text-slate-600">·</span>
          <span class="text-xs text-slate-400 dark:text-slate-500">Vol. {{ $journal->volume }}</span>
          @endif
          @if($journal->category)
          <span class="text-slate-300 dark:text-slate-600">·</span>
          <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[10px] font-semibold rounded-lg">
            {{ $journal->category }}
          </span>
          @endif
          @if($journal->file_size ?? false)
          <span class="text-slate-300 dark:text-slate-600">·</span>
          <span class="text-xs text-slate-400 dark:text-slate-500">{{ $journal->file_size }}</span>
          @endif
        </div>

        {{-- Abstrak --}}
        @if($journal->abstract ?? false)
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-2 line-clamp-2 leading-relaxed">
          {{ $journal->abstract }}
        </p>
        @endif

        {{-- Download count --}}
        <div class="flex items-center gap-1 mt-2">
          <svg class="w-3 h-3 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
          <span class="text-xs text-slate-300 dark:text-slate-600">{{ number_format($journal->download_count ?? 0) }} unduhan</span>
        </div>
      </div>

      {{-- Tombol aksi --}}
      <div class="flex-shrink-0 flex flex-col items-end gap-2">
        @if($canDownload)
          {{--
            Jurnal gratis: route publik (tidak butuh login)
            Jurnal premium + user premium: route member
          --}}
          @if(!$isPremium)
          <a href="{{ route('journals.download', $journal) }}"
             class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition active:scale-95 shadow-sm shadow-blue-500/20">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download
          </a>
          @else
          <a href="{{ route('member.journals.download', $journal) }}"
             class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition active:scale-95 shadow-sm shadow-blue-500/20">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download
          </a>
          @endif

        @else
          {{-- Premium tapi belum login atau bukan premium --}}
          @if(!auth()->check())
            {{-- Tamu: arahkan ke login dulu --}}
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white text-xs font-bold rounded-xl transition shadow-sm shadow-amber-500/20">
              🔐 Login untuk Upgrade
            </a>
            <p class="text-[10px] text-slate-400 dark:text-slate-500 text-right">Khusus member premium</p>
          @else
            {{-- Sudah login tapi belum premium --}}
            <a href="{{ route('member.payment') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white text-xs font-bold rounded-xl transition shadow-sm shadow-amber-500/20">
              ⭐ Upgrade Premium
            </a>
            <p class="text-[10px] text-slate-400 dark:text-slate-500 text-right">Khusus member premium</p>
          @endif
        @endif
      </div>

    </div>
    @empty

    {{-- Empty state --}}
    <div class="py-20 text-center">
      <div class="w-20 h-20 bg-blue-50 dark:bg-blue-900/20 rounded-3xl flex items-center justify-center mx-auto mb-4">
        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
      </div>
      <p class="text-slate-600 dark:text-slate-400 font-bold">
        {{ request()->hasAny(['q','category']) ? 'Tidak ada jurnal yang cocok' : 'Belum ada jurnal tersedia' }}
      </p>
      <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">
        {{ request()->hasAny(['q','category']) ? 'Coba ubah kata kunci pencarian' : 'Jurnal akan segera ditambahkan' }}
      </p>
      @if(request()->hasAny(['q','category']))
      <a href="{{ route('journals.index') }}"
         class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition">
        Reset Pencarian
      </a>
      @endif
    </div>

    @endforelse
  </div>

  {{-- Pagination --}}
  @if($journals->hasPages())
  <div class="flex items-center justify-between gap-4">
    <p class="text-xs text-slate-500 dark:text-slate-400">
      Menampilkan {{ $journals->firstItem() }}–{{ $journals->lastItem() }} dari {{ $journals->total() }} jurnal
    </p>
    {{ $journals->links() }}
  </div>
  @endif

  {{-- Banner upgrade — hanya tampil jika bukan premium (tamu atau member biasa) --}}
  @if(!auth()->check() || !auth()->user()->isPremium())
  <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-800/50 rounded-2xl p-5">
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
      <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-amber-500/30">
        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
      </div>
      <div class="flex-1">
        <p class="font-black text-amber-900 dark:text-amber-200 text-sm">Unlock Semua Jurnal Premium</p>
        <p class="text-amber-700 dark:text-amber-400 text-xs mt-1">
          @if(!auth()->check())
            Daftar dan upgrade ke Premium untuk mengakses semua jurnal eksklusif HPMI.
          @else
            Upgrade ke Premium untuk mengakses semua jurnal eksklusif HPMI.
          @endif
        </p>
      </div>
      @if(!auth()->check())
      <a href="{{ route('register') }}"
         class="flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-black text-sm rounded-xl shadow-lg shadow-amber-500/30 transition">
        Daftar Sekarang
      </a>
      @else
      <a href="{{ route('member.payment') }}"
         class="flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-black text-sm rounded-xl shadow-lg shadow-amber-500/30 transition">
        ⭐ Upgrade Sekarang
      </a>
      @endif
    </div>
  </div>
  @endif

</div>
@endsection