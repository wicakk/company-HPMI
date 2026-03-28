@extends('layouts.admin')
@section('title', 'Detail Pengurus')
@section('content')

<div class="space-y-5 max-w-lg">
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.org.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <h2 class="text-lg font-black text-slate-900 dark:text-white">Detail Pengurus</h2>
  </div>

  <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="h-1.5 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
    <div class="p-6 text-center">
      @if($structure->photo)
      <img src="{{ Storage::url($structure->photo) }}" alt="{{ $structure->name }}" class="w-24 h-24 rounded-2xl object-cover ring-4 ring-slate-100 dark:ring-slate-700 mx-auto mb-4">
      @else
      <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-black text-3xl mx-auto mb-4">
        {{ strtoupper(substr($structure->name, 0, 1)) }}
      </div>
      @endif

      <h3 class="text-lg font-black text-slate-900 dark:text-white">{{ $structure->name }}</h3>
      <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 mt-1">{{ $structure->position }}</p>

      @if($structure->period)
      <span class="inline-flex items-center gap-1 mt-2 px-2.5 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-xs font-medium rounded-full">
        {{ $structure->period }}
      </span>
      @endif

      <div class="mt-3">
        @if($structure->is_active)
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-full">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Aktif
        </span>
        @else
        <span class="inline-flex px-2.5 py-1 text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-full">Nonaktif</span>
        @endif
      </div>

      @if($structure->bio)
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-4 leading-relaxed">{{ $structure->bio }}</p>
      @endif
    </div>
    <div class="px-6 pb-6 flex gap-3">
      <a href="{{ route('admin.org.edit', $structure) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shadow-indigo-500/25 active:scale-95">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        Edit
      </a>
      <form method="POST" action="{{ route('admin.org.destroy', $structure) }}" onsubmit="return confirm('Hapus pengurus ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 hover:border-red-200 dark:hover:border-red-800 text-sm font-semibold rounded-xl transition-all">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
          Hapus
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
