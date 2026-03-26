@extends('layouts.app')
@section('title','Artikel')
@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <p class="text-xs font-bold text-primary-600 dark:text-primary-400 uppercase tracking-widest mb-2">Pengetahuan & Informasi</p>
        <h1 class="text-4xl font-black text-slate-900 dark:text-white">Artikel HPMI</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-3 max-w-lg mx-auto">Kumpulan artikel, jurnal, dan informasi terkini seputar keperawatan manajemen</p>
    </div>
    {{-- Filter --}}
    <div class="flex flex-wrap items-center gap-3 mb-10">
        <a href="{{ route('articles.index') }}" class="px-4 py-2 text-sm font-semibold rounded-xl {{ !request('category') ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/30' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50' }} transition">Semua</a>
        @foreach($categories as $cat)
        <a href="{{ route('articles.index', ['category' => $cat->slug]) }}" class="px-4 py-2 text-sm font-semibold rounded-xl {{ request('category') === $cat->slug ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/30' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50' }} transition">{{ $cat->name }}</a>
        @endforeach
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-down">
        @forelse($articles as $article)
        <a href="{{ route('articles.show', $article->slug) }}" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all group">
            <div class="h-48 overflow-hidden bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30" >
                @if($article->thumbnail)<img src="{{ $article->thumbnail }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $article->title }}">@else<div class="w-full h-full flex items-center justify-center"><svg class="w-12 h-12 text-blue-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg></div>@endif
            </div>
            <div class="p-5">
                @if($article->category)<span class="text-xs font-bold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 px-2.5 py-0.5 rounded-lg">{{ $article->category->name }}</span>@endif
                <h2 class="font-black text-slate-900 dark:text-white mt-2 mb-2 line-clamp-2">{{ $article->title }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">{{ $article->excerpt ?? Str::limit(strip_tags($article->content), 100) }}</p>
                <div class="flex items-center gap-2 mt-4 pt-4 border-t border-slate-50 dark:border-slate-800 text-xs text-slate-400">
                    <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $article->user->name ?? 'Admin' }}</span>
                    <span>·</span>
                    <span>{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d M Y') : '' }}</span>
                    <span class="ml-auto flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>{{ number_format($article->views) }}</span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-3 py-20 text-center text-slate-400">
            <svg class="w-14 h-14 mx-auto mb-3 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            <p>Belum ada artikel</p>
        </div>
        @endforelse
    </div>
    @if($articles->hasPages())<div class="mt-10">{{ $articles->withQueryString()->links() }}</div>@endif
</div>
@endsection
