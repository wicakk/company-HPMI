@extends('layouts.app')
@section('title', $article->title)
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            @if($article->thumbnail)<img src="{{ $article->thumbnail }}" class="w-full h-64 object-cover rounded-2xl mb-6" alt="{{ $article->title }}">@endif
            @if($article->category)<a href="{{ route('articles.index', ['category'=>$article->category->slug]) }}" class="inline-block text-xs font-bold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 px-3 py-1 rounded-xl mb-4">{{ $article->category->name }}</a>@endif
            <h1 class="text-3xl font-black text-slate-900 dark:text-white leading-tight mb-4">{{ $article->title }}</h1>
            <div class="flex items-center gap-3 text-sm text-slate-500 dark:text-slate-400 mb-8 pb-6 border-b border-slate-100 dark:border-slate-800">
                <div class="w-8 h-8 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">{{ substr($article->user->name??'A',0,1) }}</div>
                <div>
                    <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $article->user->name ?? 'Admin' }}</span>
                    <span class="mx-2">·</span>
                    <span>{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d F Y') : '' }}</span>
                </div>
                <span class="ml-auto flex items-center gap-1 text-xs"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>{{ number_format($article->views) }}</span>
            </div>
            <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 leading-relaxed">
                {!! nl2br(e($article->content)) !!}
            </div>
        </div>
        <div class="space-y-6">
            @if($related->isNotEmpty())
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5">
                <h3 class="font-black text-slate-900 dark:text-white text-sm mb-4">Artikel Terkait</h3>
                <div class="space-y-4">
                    @foreach($related as $rel)
                    <a href="{{ route('articles.show', $rel->slug) }}" class="flex gap-3 group">
                        <div class="w-16 h-14 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100 dark:bg-slate-800">
                            @if($rel->thumbnail)<img src="{{ $rel->thumbnail }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform" alt="{{ $rel->title }}">@else<div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/30 dark:to-primary-800/30 flex items-center justify-center"><svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7"/></svg></div>@endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition">{{ $rel->title }}</h4>
                            <p class="text-xs text-slate-400 mt-1">{{ $rel->published_at ? \Carbon\Carbon::parse($rel->published_at)->format('d M Y') : '' }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
            <a href="{{ route('articles.index') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold rounded-2xl hover:bg-slate-200 dark:hover:bg-slate-700 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Artikel
            </a>
        </div>
    </div>
</div>
@endsection
