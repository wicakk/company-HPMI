@extends('layouts.admin')
@section('title','Detail Pengurus')
@section('content')
<div class="max-w-sm space-y-5">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.org.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Detail Pengurus</h2>
        <a href="{{ route('admin.org.edit', $structure) }}" class="px-3 py-1.5 text-xs font-semibold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-lg hover:bg-primary-100 transition">Edit</a>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 text-center">
        @if($structure->photo)<img src="{{ $structure->photo }}" class="w-24 h-24 rounded-2xl object-cover mx-auto mb-4">
        @else<div class="w-24 h-24 bg-gradient-to-br from-pink-400 to-rose-500 rounded-2xl flex items-center justify-center text-white font-black text-4xl mx-auto mb-4">{{ substr($structure->name,0,1) }}</div>@endif
        <h3 class="font-black text-slate-900 dark:text-white text-lg">{{ $structure->name }}</h3>
        <p class="text-sm text-primary-600 dark:text-primary-400 font-semibold mt-1">{{ $structure->position }}</p>
        <p class="text-xs text-slate-400 mt-1">Periode: {{ $structure->period }}</p>
        @if($structure->bio)<p class="text-sm text-slate-600 dark:text-slate-400 mt-4 leading-relaxed">{{ $structure->bio }}</p>@endif
    </div>
</div>
@endsection
