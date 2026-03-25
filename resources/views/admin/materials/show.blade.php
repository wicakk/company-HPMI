@extends('layouts.admin')
@section('title','Detail Materi')
@section('content')
<div class="max-w-2xl space-y-5">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.materials.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">{{ $materi->title }}</h2>
        <a href="{{ route('admin.materials.edit', $materi) }}" class="px-3 py-1.5 text-xs font-semibold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-lg hover:bg-primary-100 transition">Edit</a>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-3 text-sm">
        @foreach([['Tipe', strtoupper($materi->type)],['Kategori', $materi->category->name??'—'],['Downloads', number_format($materi->downloads).' kali'],['Views', number_format($materi->views).' kali'],['Akses', $materi->is_member_only?'Hanya Member':'Publik']] as [$l,$v])
        <div class="flex gap-4 py-2 border-b border-slate-50 dark:border-slate-800 last:border-0"><span class="text-slate-400 w-28 flex-shrink-0 text-xs uppercase tracking-wide font-semibold">{{ $l }}</span><span class="font-semibold text-slate-900 dark:text-white">{{ $v }}</span></div>
        @endforeach
        @if($materi->file_url)<div class="pt-2"><a href="{{ $materi->file_url }}" target="_blank" class="text-primary-600 dark:text-primary-400 text-sm font-semibold hover:underline flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>Buka File</a></div>@endif
    </div>
</div>
@endsection
