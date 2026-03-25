@extends('layouts.app')
@section('title','HPMI — Himpunan Perawat Manajer Indonesia')
@section('content')

{{-- SLIDESHOW BANNER --}}
<div class="relative overflow-hidden white py-36 px-4" 
     x-data="{ current: 0, total: {{ count($announcements ?? []) ?: 3 }}, paused: false }"
     x-init="setInterval(() => { if (!paused) current = (current + 1) % total }, 5000)">

    {{-- Slides wrapper --}}
    <div class="flex transition-transform duration-500 ease-in-out"
         :style="'transform: translateX(-' + (current * 100) + '%)'">

        @forelse($announcements ?? [] as $item)
        <div class="min-w-full flex items-center justify-between gap-4 px-6 py-3">
            <div class="flex items-center gap-3 text-dark min-w-0">
                {{-- Badge --}}
                @php
                    $badgeMap = ['event'=>['bg-emerald-500','Kegiatan'],'article'=>['bg-violet-500','Artikel'],'info'=>['bg-amber-500','Info']];
                    [$bg, $label] = $badgeMap[$item->type ?? 'info'] ?? ['bg-primary-500','Info'];
                @endphp
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 {{ $bg }} rounded-full text-xs font-bold shrink-0">
                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                    {{ $label }}
                </span>
                {{-- Text --}}
                <a href="{{ $item->url ?? '#' }}" 
                   class="text-sm font-medium text-dark/90 hover:text-dark truncate transition">
                    {{ $item->title }}
                </a>
            </div>
            <a href="{{ $item->url ?? '#' }}"
               class="shrink-0 text-xs font-semibold text-dark/60 hover:text-dark flex items-center gap-1 transition">
                Selengkapnya
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        @empty
        {{-- Fallback statis jika tidak ada data --}}
        <div class="min-w-full flex items-center justify-center gap-3 px-6 py-3 text-dark">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-500 rounded-full text-xs font-bold">
                <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                Info
            </span>
            <span class="text-sm font-medium text-dark/90">
                Selamat datang di HPMI — Himpunan Perawat Manajer Indonesia
            </span>
        </div>
        <div class="min-w-full flex items-center justify-center gap-3 px-6 py-3 text-dark">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-violet-500 rounded-full text-xs font-bold">
                <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                Kegiatan
            </span>
            <a href="{{ route('events.index') }}" class="text-sm font-medium text-dark/90 hover:text-dark transition">
                Cek kegiatan mendatang HPMI di seluruh Indonesia
            </a>
        </div>
        <div class="min-w-full flex items-center justify-center gap-3 px-6 py-3 text-dark">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-500 rounded-full text-xs font-bold">
                <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                Daftar
            </span>
            <a href="{{ route('register') }}" class="text-sm font-medium text-dark/90 hover:text-dark transition">
                Bergabung sebagai anggota HPMI — Pendaftaran terbuka!
            </a>
        </div>
        @endforelse
    </div>

    {{-- Prev / Next buttons --}}
    <button @click="current = (current - 1 + total) % total; paused = true"
            class="absolute left-2 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-white/10 hover:bg-white/25 text-dark flex items-center justify-center transition">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
    <button @click="current = (current + 1) % total; paused = true"
            class="absolute right-2 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-white/10 hover:bg-white/25 text-dark flex items-center justify-center transition">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-1 left-1/2 -translate-x-1/2 flex gap-1.5">
        <template x-for="i in total" :key="i">
            <button @click="current = i - 1"
                    :class="current === i - 1 ? 'bg-white' : 'bg-white/35'"
                    class="w-1.5 h-1.5 rounded-full transition-all">
            </button>
        </template>
    </div>
</div>
{{-- END SLIDESHOW BANNER --}}

{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-to-br from-primary-900 via-primary-800 to-indigo-900 text-white py-24 px-4">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-20 -right-20 w-80 h-80 bg-primary-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-5xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-primary-200 text-sm font-semibold px-4 py-2 rounded-full border border-white/20 mb-8">
            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
            Organisasi Perawat Manajer Indonesia
        </div>
        <h1 class="text-4xl md:text-6xl font-black leading-tight mb-6">
            Himpunan Perawat<br><span class="bg-gradient-to-r from-primary-300 to-emerald-300 bg-clip-text text-transparent">Manajer Indonesia</span>
        </h1>
        <p class="text-lg text-primary-200 max-w-2xl mx-auto mb-10">Bersama membangun profesionalisme perawat manajer untuk pelayanan kesehatan yang lebih baik di seluruh Indonesia.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-emerald-400 to-emerald-500 hover:from-emerald-500 hover:to-emerald-600 text-white font-black rounded-2xl shadow-2xl shadow-emerald-500/40 transition text-base flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Bergabung Sekarang
            </a>
            <a href="{{ route('about') }}" class="px-8 py-4 bg-white/10 hover:bg-white/20 border border-white/30 backdrop-blur text-white font-bold rounded-2xl transition text-base">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="py-12 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-5xl mx-auto px-4 grid grid-cols-3 gap-8 text-center">
        @php $statsItems=[['value'=>number_format($stats['members']),'label'=>'Anggota Aktif','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','color'=>'blue'],['value'=>$stats['events'].'+','label'=>'Kegiatan Selesai','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','color'=>'violet'],['value'=>$stats['articles'].'+','label'=>'Artikel Terbit','icon'=>'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z','color'=>'emerald']]; @endphp
        @foreach($statsItems as $s)
        <div>
            <div class="w-12 h-12 bg-{{ $s['color'] }}-100 dark:bg-{{ $s['color'] }}-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-{{ $s['color'] }}-600 dark:text-{{ $s['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/></svg>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white">{{ $s['value'] }}</div>
            <div class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>
</section>

{{-- EVENTS --}}
@if($events->isNotEmpty())
<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-10">
            <div>
                <p class="text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider mb-1">Kegiatan Mendatang</p>
                <h2 class="text-3xl font-black text-slate-900 dark:text-white">Kegiatan HPMI</h2>
            </div>
            <a href="{{ route('events.index') }}" class="text-sm font-semibold text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($events as $event)
            <a href="{{ route('events.show', $event->slug) }}" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all group">
                <div class="h-36 overflow-hidden bg-gradient-to-br from-violet-100 to-indigo-100 dark:from-violet-900/30 dark:to-indigo-900/30">
                    @if($event->thumbnail)<img src="{{ $event->thumbnail }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $event->title }}">@else<div class="w-full h-full flex items-center justify-center"><svg class="w-10 h-10 text-violet-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>@endif
                </div>
                <div class="p-5">
                    <span class="text-xs font-bold text-violet-600 dark:text-violet-400">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                    <h3 class="font-bold text-slate-900 dark:text-white text-sm mt-1 line-clamp-2">{{ $event->title }}</h3>
                    @if($event->location)<p class="text-xs text-slate-400 mt-2 flex items-center gap-1 truncate"><svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>{{ Str::limit($event->location,30) }}</p>@endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ARTICLES --}}
@if($articles->isNotEmpty())
<section class="py-16 px-4 bg-slate-50 dark:bg-slate-900/50">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-10">
            <div>
                <p class="text-xs font-bold text-primary-600 dark:text-primary-400 uppercase tracking-wider mb-1">Pengetahuan & Informasi</p>
                <h2 class="text-3xl font-black text-slate-900 dark:text-white">Artikel Terbaru</h2>
            </div>
            <a href="{{ route('articles.index') }}" class="text-sm font-semibold text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($articles->take(6) as $article)
            <a href="{{ route('articles.show', $article->slug) }}" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all group">
                <div class="h-44 overflow-hidden bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30">
                    @if($article->thumbnail)<img src="{{ $article->thumbnail }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $article->title }}">@else<div class="w-full h-full flex items-center justify-center"><svg class="w-10 h-10 text-blue-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg></div>@endif
                </div>
                <div class="p-5">
                    @if($article->category)<span class="text-xs font-bold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 px-2.5 py-0.5 rounded-lg">{{ $article->category->name }}</span>@endif
                    <h3 class="font-bold text-slate-900 dark:text-white text-sm mt-2 line-clamp-2 leading-snug">{{ $article->title }}</h3>
                    <p class="text-xs text-slate-400 mt-2 line-clamp-2">{{ $article->excerpt ?? Str::limit(strip_tags($article->content),80) }}</p>
                    <div class="flex items-center gap-2 mt-3 text-xs text-slate-400">
                        <span>{{ $article->user->name ?? 'Admin' }}</span>
                        <span>·</span>
                        <span>{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d M Y') : '' }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20 px-4 bg-gradient-to-r from-primary-600 to-indigo-700 text-white text-center">
    <h2 class="text-3xl font-black mb-4">Siap Bergabung dengan HPMI?</h2>
    <p class="text-primary-200 max-w-lg mx-auto mb-8">Daftarkan diri Anda dan nikmati manfaat eksklusif keanggotaan HPMI.</p>
    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-primary-700 font-black rounded-2xl shadow-2xl hover:shadow-white/20 hover:bg-slate-50 transition text-base">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        Daftar Sekarang — Gratis
    </a>
</section>
@endsection
