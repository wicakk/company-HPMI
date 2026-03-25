@extends('layouts.admin')
@section('title','Detail Artikel')
@section('content')
<div class="max-w-3xl space-y-5">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.articles.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white flex-1 truncate">{{ $artikel->title }}</h2>
        <a href="{{ route('admin.articles.edit', $artikel) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-lg hover:bg-primary-100 transition">Edit</a>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
        <div class="flex flex-wrap gap-2 mb-4 pb-4 border-b border-slate-100 dark:border-slate-800 text-xs">
            @php $ss=['published'=>'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400','draft'=>'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400']; @endphp
            <span class="font-semibold px-2.5 py-1 rounded-lg {{ $ss[$artikel->status]??'bg-slate-100 text-slate-600' }}">{{ ucfirst($artikel->status) }}</span>
            @if($artikel->category)<span class="font-semibold px-2.5 py-1 rounded-lg bg-blue-100 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400">{{ $artikel->category->name }}</span>@endif
            <span class="text-slate-400 px-2.5 py-1">{{ $artikel->user->name ?? '-' }}</span>
            <span class="ml-auto font-semibold text-slate-700 dark:text-slate-300">{{ number_format($artikel->views) }} views</span>
        </div>
        @if($artikel->excerpt)<p class="text-sm text-slate-600 dark:text-slate-400 italic border-l-4 border-primary-400 pl-4 mb-5">{{ $artikel->excerpt }}</p>@endif
        <div class="prose prose-sm dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 leading-relaxed">{!! nl2br(e($artikel->content)) !!}</div>
    </div>
</div>
@endsection
