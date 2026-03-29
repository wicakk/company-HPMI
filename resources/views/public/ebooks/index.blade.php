{{-- resources/views/member/ebooks/index.blade.php --}}
@extends('layouts.app')
@section('title','Ebook HPMI')
@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-rose-500 mb-1">Perpustakaan Digital</p>
      <h1 class="text-2xl font-black text-slate-900 dark:text-white">Koleksi Ebook HPMI</h1>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Referensi ilmiah dan panduan keperawatan manajerial</p>
    </div>
    {{-- @if(!auth()->user()->isPremium()) --}}
    <a href="{{ route('member.payment') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-bold rounded-xl shadow-sm flex-shrink-0">
      ⭐ Upgrade Premium — Akses Semua Ebook
    </a>
    {{-- @endif --}}
  </div>

  {{-- Flash error --}}
  @if(session('error'))
  <div class="flex items-center gap-3 px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 text-red-700 dark:text-red-400 rounded-xl text-sm">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('error') }}
  </div>
  @endif

  {{-- Filter --}}
  <form method="GET" class="flex flex-col sm:flex-row gap-3">
    <div class="relative flex-1">
      <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35"/></svg>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau penulis..."
        class="w-full pl-10 pr-4 h-10 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 transition">
    </div>
    @if($categories->count())
    <select name="category" class="h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-rose-500 cursor-pointer">
      <option value="">Semua Kategori</option>
      @foreach($categories as $cat)
      <option value="{{ $cat }}" {{ request('category')===$cat?'selected':'' }}>{{ $cat }}</option>
      @endforeach
    </select>
    @endif
    <select name="access" class="h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-rose-500 cursor-pointer">
      <option value="">Semua Akses</option>
      <option value="free"    {{ request('access')==='free'?'selected':'' }}>Gratis</option>
      <option value="premium" {{ request('access')==='premium'?'selected':'' }}>Premium</option>
    </select>
    <button type="submit" class="h-10 px-5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl transition active:scale-95">Cari</button>
    @if(request()->hasAny(['q','category','access']))
    <a href="{{ route('member.ebooks') }}" class="h-10 px-4 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-sm font-medium rounded-xl transition flex items-center hover:bg-slate-200">Reset</a>
    @endif
  </form>

  {{-- Grid Ebook --}}
  @if($ebooks->count())
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
    @foreach($ebooks as $ebook)
    @php $canDownload = $ebook->canDownload(auth()->user()); @endphp
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group flex flex-col">

      {{-- Cover --}}
      <div class="relative aspect-[3/4] bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800 overflow-hidden">
        @if($ebook->cover_path)
        <img src="{{ Storage::url($ebook->cover_path) }}" alt="{{ $ebook->title }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
        <div class="w-full h-full flex flex-col items-center justify-center gap-2 p-4 text-center">
          <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          <p class="text-xs font-semibold text-slate-400 line-clamp-2">{{ $ebook->title }}</p>
        </div>
        @endif

        {{-- Badge akses --}}
        <div class="absolute top-2 left-2">
          @if($ebook->isFree())
          <span class="px-2 py-0.5 bg-emerald-500 text-white text-[10px] font-black rounded-full">GRATIS</span>
          @else
          <span class="px-2 py-0.5 bg-amber-500 text-white text-[10px] font-black rounded-full">⭐ PREMIUM</span>
          @endif
        </div>

        {{-- Lock overlay untuk premium yg belum subscribe --}}
        @if($ebook->isPremium() && !$canDownload)
        <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px] flex flex-col items-center justify-center gap-2">
          <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          </div>
          <p class="text-white text-xs font-bold text-center px-3">Khusus Member Premium</p>
          <a href="{{ route('member.payment') }}"
             class="px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-black rounded-full transition">
            Upgrade
          </a>
        </div>
        @endif
      </div>

      {{-- Info --}}
      <div class="p-4 flex flex-col flex-1">
        <p class="font-bold text-slate-900 dark:text-white text-sm line-clamp-2 leading-snug">{{ $ebook->title }}</p>
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 flex items-center gap-1">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          {{ $ebook->author }}
        </p>
        <div class="flex items-center gap-2 mt-1 flex-wrap">
          @if($ebook->year)<span class="text-[10px] text-slate-300 dark:text-slate-600">{{ $ebook->year }}</span>@endif
          @if($ebook->pages)<span class="text-[10px] text-slate-300 dark:text-slate-600">· {{ $ebook->pages }} hal</span>@endif
          @if($ebook->file_size)<span class="text-[10px] text-slate-300 dark:text-slate-600">· {{ $ebook->file_size }}</span>@endif
        </div>
        @if($ebook->description)
        <p class="text-xs text-slate-400 mt-2 line-clamp-2 flex-1">{{ $ebook->description }}</p>
        @endif

        {{-- Tombol download --}}
        <div class="mt-3">
          @if($canDownload)
          <a href="{{ route('member.ebooks.download', $ebook) }}"
             class="w-full flex items-center justify-center gap-2 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition active:scale-95">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download PDF
          </a>
          @else
          <a href="{{ route('member.payment') }}"
             class="w-full flex items-center justify-center gap-2 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition">
            ⭐ Upgrade Premium
          </a>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Pagination --}}
  @if($ebooks->hasPages())
  <div class="flex justify-center">
    {{ $ebooks->links() }}
  </div>
  @endif

  @else
  <div class="py-20 text-center">
    <div class="w-20 h-20 bg-rose-50 dark:bg-rose-900/20 rounded-3xl flex items-center justify-center mx-auto mb-4">
      <svg class="w-10 h-10 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
    </div>
    <p class="text-slate-600 dark:text-slate-400 font-semibold">Belum ada ebook tersedia</p>
    <p class="text-sm text-slate-400 mt-1">Koleksi ebook akan segera ditambahkan</p>
  </div>
  @endif

</div>
@endsection