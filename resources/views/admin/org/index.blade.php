@extends('layouts.admin')
@section('title', 'Struktur Organisasi')
@section('content')

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-blue-500 dark:text-blue-400 mb-1">Kepengurusan</p>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Struktur Organisasi</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola kepengurusan HPMI</p>
    </div>
    <a href="{{ route('admin.org.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-500/25 transition-all active:scale-95">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Tambah Pengurus
    </a>
  </div>

  {{-- Flash --}}
  @if(session('success'))
  <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
  </div>
  @endif

  {{-- Cards Grid --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
    @forelse($structures as $org)
    @php
      $gradients = ['from-blue-500 to-blue-600','from-violet-500 to-purple-600','from-emerald-500 to-teal-600','from-amber-500 to-orange-500','from-pink-500 to-rose-600','from-sky-500 to-cyan-600'];
      $grad = $gradients[$loop->index % count($gradients)];
    @endphp
    <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:shadow-slate-200/60 dark:hover:shadow-slate-900/60 hover:-translate-y-1 transition-all duration-250 {{ !$org->is_active ? 'opacity-60' : '' }}">

      {{-- Gradient accent bar --}}
      <div class="h-1.5 bg-gradient-to-r {{ $grad }} {{ !$org->is_active ? 'opacity-40' : '' }}"></div>

      <div class="p-5 text-center">
        {{-- Avatar --}}
        <div class="relative inline-block mb-4">
          @if($org->photo)
          <img src="{{ Storage::url($org->photo) }}" alt="{{ $org->name }}"
            class="w-20 h-20 rounded-2xl object-cover ring-4 ring-slate-100 dark:ring-slate-700 {{ !$org->is_active ? 'grayscale' : '' }}">
          @else
          <div class="w-20 h-20 rounded-2xl bg-gradient-to-br {{ $grad }} {{ !$org->is_active ? 'opacity-50' : '' }} flex items-center justify-center text-white font-black text-2xl ring-4 ring-slate-100 dark:ring-slate-700">
            {{ strtoupper(substr($org->name, 0, 1)) }}
          </div>
          @endif
          @if($org->is_active)
          <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-2 border-white dark:border-slate-800 flex items-center justify-center">
            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
          </span>
          @else
          <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-slate-300 dark:bg-slate-600 rounded-full border-2 border-white dark:border-slate-800"></span>
          @endif
        </div>

        <h3 class="font-bold text-slate-900 dark:text-white text-sm leading-tight">{{ $org->name }}</h3>
        <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 mt-1">{{ $org->position }}</p>

        @if($org->period)
        <span class="inline-flex items-center gap-1 mt-2 px-2.5 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-[10px] font-medium rounded-full">
          <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          {{ $org->period }}
        </span>
        @endif

        @if(!$org->is_active)
        <div class="mt-2">
          <span class="inline-block text-[10px] font-bold bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Nonaktif</span>
        </div>
        @endif

        @if($org->bio)
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-2.5 line-clamp-2 leading-relaxed">{{ $org->bio }}</p>
        @endif

        {{-- Actions --}}
        <div class="mt-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
          <a href="{{ route('admin.org.edit', $org) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-all">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
          </a>
          <form method="POST" action="{{ route('admin.org.destroy', $org) }}" onsubmit="return confirm('Hapus pengurus ini?')" class="flex-1">
            @csrf @method('DELETE')
            <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 py-2 text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-500 dark:hover:text-red-400 rounded-xl transition-all">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              Hapus
            </button>
          </form>
        </div>
      </div>
    </div>
    @empty
    <div class="col-span-full bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 py-20 text-center">
      <div class="w-14 h-14 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-3">
        <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
      </div>
      <p class="text-sm font-bold text-slate-800 dark:text-white">Belum ada pengurus</p>
      <p class="text-xs text-slate-400 mt-1 mb-5">Tambahkan pengurus organisasi</p>
      <a href="{{ route('admin.org.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition shadow-sm shadow-blue-500/25">+ Tambah Pengurus</a>
    </div>
    @endforelse
  </div>

  @if($structures->hasPages())
  <div class="flex justify-center">{{ $structures->links() }}</div>
  @endif

</div>
@endsection
