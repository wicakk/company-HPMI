@extends('layouts.admin')
@section('title', 'Detail Artikel')
@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.articles.index') }}"
               class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Detail Artikel</h2>
                <p class="text-xs text-slate-400 mt-0.5">Dibuat {{ $artikel->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
        <a href="{{ route('admin.articles.edit', $artikel) }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-500/25 transition-all duration-150 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Artikel
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Konten Utama ── --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Thumbnail --}}
            @if($artikel->thumbnail)
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
                <img src="{{ Storage::url($artikel->thumbnail) }}" alt="{{ $artikel->title }}"
                     class="w-full h-64 object-cover">
            </div>
            @endif

            {{-- Judul & Meta --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex-1">
                        @php
                        $statusConfig = [
                            'published' => ['bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50', 'Diterbitkan'],
                            'draft'     => ['bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-600', 'Draft'],
                            'archived'  => ['bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-800/50', 'Diarsip'],
                        ];
                        [$sc, $sl] = $statusConfig[$artikel->status] ?? ['bg-slate-100 text-slate-600 border-slate-200', $artikel->status];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $sc }} mb-3">
                            <span class="w-1.5 h-1.5 rounded-full {{ $artikel->status === 'published' ? 'bg-emerald-500' : ($artikel->status === 'draft' ? 'bg-slate-400' : 'bg-amber-500') }}"></span>
                            {{ $sl }}
                        </span>
                        <h1 class="text-xl font-bold text-slate-900 dark:text-white leading-snug">{{ $artikel->title }}</h1>
                    </div>
                </div>

                @if($artikel->excerpt)
                <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-l-4 border-blue-500 mb-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 italic leading-relaxed">{{ $artikel->excerpt }}</p>
                </div>
                @endif

                <div class="prose prose-sm dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-wrap">{{ $artikel->content }}</div>
            </div>

        </div>

        {{-- ── Sidebar Info ── --}}
        <div class="space-y-5">

            {{-- Meta --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Informasi Artikel</h4>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-violet-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                            {{ strtoupper(substr($artikel->user->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $artikel->user->name ?? '—' }}</p>
                            <p class="text-xs text-slate-400">Penulis</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 dark:border-slate-700 pt-3 space-y-2.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400">Kategori</span>
                            @if($artikel->category)
                            <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 rounded-lg font-medium border border-blue-100 dark:border-blue-800/50">{{ $artikel->category->name }}</span>
                            @else
                            <span class="text-slate-400">—</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400">Views</span>
                            <span class="font-semibold text-slate-900 dark:text-white tabular-nums">{{ number_format($artikel->views) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400">Dibuat</span>
                            <span class="font-medium text-slate-700 dark:text-slate-300">{{ $artikel->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400">Diterbitkan</span>
                            <span class="font-medium text-slate-700 dark:text-slate-300">{{ $artikel->published_at ? $artikel->published_at->format('d M Y') : '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400">Slug</span>
                            <span class="font-mono text-slate-500 dark:text-slate-400 truncate max-w-[140px]">{{ $artikel->slug }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 space-y-3">
                <h4 class="font-semibold text-slate-900 dark:text-white text-sm mb-4">Aksi</h4>
                <a href="{{ route('admin.articles.edit', $artikel) }}"
                   class="flex items-center gap-3 px-4 py-3 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-xl text-sm font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Artikel
                </a>
                @if($artikel->status === 'published')
                <a href="{{ route('articles.show', $artikel->slug) }}" target="_blank"
                   class="flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat di Website
                </a>
                @endif
                <form method="POST" action="{{ route('admin.articles.destroy', $artikel) }}"
                      onsubmit="return confirm('Hapus artikel ini secara permanen?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus Artikel
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection