@extends('layouts.admin')
@section('title', 'Pengumuman')
@section('content')

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-amber-500 dark:text-amber-400 mb-1">Broadcast</p>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Pengumuman</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola pengumuman untuk anggota dan publik</p>
    </div>
    <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl shadow-sm shadow-amber-500/25 transition-all active:scale-95">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Buat Pengumuman
    </a>
  </div>

  {{-- List --}}
  <div class="space-y-3">
    @forelse($announcements as $ann)
    <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 flex items-start gap-4 hover:shadow-md dark:hover:shadow-slate-900/50 hover:-translate-y-0.5 transition-all duration-200">
      @if($ann->is_pinned)
      <div class="flex-shrink-0 w-10 h-10 bg-amber-50 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5 text-amber-500 dark:text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M16.5 3C14.76 3 13.09 3.81 12 5.08 10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3z"/></svg>
      </div>
      @else
      <div class="flex-shrink-0 w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
      </div>
      @endif

      <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2 flex-wrap">
          <h3 class="font-bold text-slate-900 dark:text-white text-sm">{{ $ann->title }}</h3>
          @if($ann->is_pinned)
          <span class="inline-flex px-2 py-0.5 text-[11px] font-semibold bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-full border border-amber-200 dark:border-amber-800/50">Disematkan</span>
          @endif
          @if($ann->is_member_only)
          <span class="inline-flex px-2 py-0.5 text-[11px] font-semibold bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-full border border-blue-200 dark:border-blue-800/50">Member Only</span>
          @endif
        </div>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1.5 line-clamp-2 leading-relaxed">{{ Str::limit(strip_tags($ann->content), 140) }}</p>
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-2 flex items-center gap-1.5">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          {{ $ann->created_at->format('d M Y') }}
        </p>
      </div>

      <div class="flex items-center gap-1.5 flex-shrink-0">
        <a href="{{ route('admin.announcements.edit', $ann) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-amber-50 dark:hover:bg-amber-900/30 hover:text-amber-600 dark:hover:text-amber-400 transition-all" title="Edit">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </a>
        <form method="POST" action="{{ route('admin.announcements.destroy', $ann) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
          @csrf @method('DELETE')
          <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-500 dark:hover:text-red-400 transition-all" title="Hapus">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
          </button>
        </form>
      </div>
    </div>
    @empty
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 py-20 text-center">
      <div class="w-14 h-14 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-3">
        <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
      </div>
      <p class="text-sm font-bold text-slate-800 dark:text-white">Belum ada pengumuman</p>
      <p class="text-xs text-slate-400 mt-1 mb-5">Buat pengumuman pertama untuk anggota</p>
      <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 text-white rounded-xl text-xs font-semibold hover:bg-amber-600 transition shadow-sm shadow-amber-500/25">+ Buat Pengumuman</a>
    </div>
    @endforelse
  </div>

  @if($announcements->hasPages())
  <div class="flex justify-center">{{ $announcements->links() }}</div>
  @endif

</div>
@endsection
