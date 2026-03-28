@extends('layouts.admin')
@section('title', 'Detail Pengumuman')
@section('content')

<div class="space-y-5 max-w-2xl">
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <h2 class="text-lg font-black text-slate-900 dark:text-white">Detail Pengumuman</h2>
  </div>

  <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="h-1.5 bg-gradient-to-r from-amber-400 to-orange-500"></div>
    <div class="p-6 space-y-5">

      {{-- Badges --}}
      <div class="flex items-center gap-2 flex-wrap">
        @if($announcement->is_pinned)
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-full border border-amber-200 dark:border-amber-800/50">
          <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M16.5 3C14.76 3 13.09 3.81 12 5.08 10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3z"/></svg>
          Disematkan
        </span>
        @endif
        @if($announcement->is_member_only)
        <span class="inline-flex px-2.5 py-1 text-xs font-semibold bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-full border border-blue-200 dark:border-blue-800/50">Member Only</span>
        @endif
        @if($announcement->type)
        <span class="inline-flex px-2.5 py-1 text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-full">{{ ucfirst($announcement->type) }}</span>
        @endif
      </div>

      {{-- Judul --}}
      <div>
        <h3 class="text-xl font-black text-slate-900 dark:text-white leading-snug">{{ $announcement->title }}</h3>
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5 flex items-center gap-1.5">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          {{ $announcement->created_at->format('d M Y, H:i') }}
          @if($announcement->expired_at)
          · Kadaluarsa {{ \Carbon\Carbon::parse($announcement->expired_at)->format('d M Y') }}
          @endif
        </p>
      </div>

      {{-- Konten --}}
      <div class="bg-slate-50 dark:bg-slate-700/40 rounded-xl p-5">
        <div class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-wrap">{{ strip_tags($announcement->content) }}</div>
      </div>

    </div>

    {{-- Actions --}}
    <div class="px-6 pb-6 flex gap-3">
      <a href="{{ route('admin.announcements.edit', $announcement) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shadow-amber-500/25 active:scale-95">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        Edit
      </a>
      <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 hover:border-red-200 dark:hover:border-red-800 text-sm font-semibold rounded-xl transition-all">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
          Hapus
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
