@extends('layouts.app')
@section('title','Struktur Organisasi')
@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <p class="text-xs font-bold text-primary-600 dark:text-primary-400 uppercase tracking-widest mb-2">Periode 2022–2026</p>
        <h1 class="text-4xl font-black text-slate-900 dark:text-white">Struktur Organisasi</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-3">Pengurus Himpunan Perawat Manajer Indonesia</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
        @forelse($structures as $struktur)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 text-center hover:shadow-lg hover:-translate-y-1 transition-all group">
            @if($struktur->photo)
            <img src="{{ $struktur->photo }}" class="w-20 h-20 rounded-2xl object-cover mx-auto mb-4 ring-4 ring-slate-100 dark:ring-slate-800 group-hover:ring-primary-200 dark:group-hover:ring-primary-900 transition" alt="{{ $struktur->name }}">
            @else
            <div class="w-20 h-20 bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto mb-4 shadow-lg shadow-primary-500/30">{{ substr($struktur->name,0,1) }}</div>
            @endif
            <h3 class="font-bold text-slate-900 dark:text-white text-sm leading-tight">{{ $struktur->name }}</h3>
            <p class="text-xs text-primary-600 dark:text-primary-400 font-semibold mt-1.5">{{ $struktur->position }}</p>
            @if($struktur->bio)<p class="text-xs text-slate-400 mt-2 line-clamp-2">{{ $struktur->bio }}</p>@endif
        </div>
        @empty
        <div class="col-span-5 py-20 text-center text-slate-400 text-sm">Data pengurus belum tersedia</div>
        @endforelse
    </div>
    <div class="text-center mt-10">
        <a href="{{ route('about') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold rounded-xl hover:bg-slate-200 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Tentang HPMI
        </a>
    </div>
</div>
@endsection
