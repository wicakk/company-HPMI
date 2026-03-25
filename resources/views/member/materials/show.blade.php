@extends('layouts.app')
@section('title', $material->title)
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('member.materials') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h1 class="text-xl font-black text-slate-900 dark:text-white truncate">{{ $material->title }}</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                @if($material->video_url)
                <div class="aspect-video bg-slate-900">
                    <iframe src="{{ str_replace(['watch?v=','youtu.be/'],['embed/','youtube.com/embed/'],$material->video_url) }}" class="w-full h-full" allowfullscreen></iframe>
                </div>
                @elseif($material->thumbnail)
                <img src="{{ $material->thumbnail }}" class="w-full h-52 object-cover" alt="{{ $material->title }}">
                @endif
                <div class="p-6">
                    @php $tc=['pdf'=>'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400','video'=>'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400','article'=>'bg-blue-100 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400','module'=>'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400']; @endphp
                    <div class="flex gap-2 mb-4">
                        <span class="text-xs font-bold px-3 py-1 rounded-lg {{ $tc[$material->type]??'bg-slate-100 text-slate-600' }}">{{ strtoupper($material->type) }}</span>
                        @if($material->category)<span class="text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-3 py-1 rounded-lg">{{ $material->category->name }}</span>@endif
                    </div>
                    <h2 class="text-xl font-black text-slate-900 dark:text-white mb-3">{{ $material->title }}</h2>
                    @if($material->description)<p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm">{{ $material->description }}</p>@endif
                </div>
            </div>
        </div>
        <div class="space-y-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Detail</h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between"><dt class="text-slate-400">Tipe</dt><dd class="font-bold text-slate-900 dark:text-white">{{ strtoupper($material->type) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-400">Unduhan</dt><dd class="font-bold text-slate-900 dark:text-white">{{ number_format($material->downloads) }}×</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-400">Ditambah</dt><dd class="font-bold text-slate-900 dark:text-white">{{ $material->created_at->format('d M Y') }}</dd></div>
                </dl>
            </div>
            @if($material->file_url)
            <a href="{{ route('member.materials.download', $material->id) }}" class="flex items-center justify-center gap-2 w-full py-3.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold rounded-2xl shadow-lg shadow-emerald-500/30 transition text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh Materi
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
