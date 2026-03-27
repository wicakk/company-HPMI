@extends('layouts.app')
@section('title', 'Beranda - ' . ($settings['org_name']?->value ?? 'HPMI'))

@php
    $s = fn(string $key, string $default = '') => $settings[$key]?->value ?? $default;
@endphp

@section('content')

{{-- =============================================
     SLIDESHOW BANNER — style gambar 2
     (full-width, center slide besar, nav panah, dots)
     ============================================= --}}
<div class="relative w-full overflow-hidden bg-white dark:bg-gray-950 py-8 select-none" id="heroBannerWrap"
     style="background-image: linear-gradient(rgba(0,0,0,0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.06) 1px, transparent 1px); background-size: 40px 40px; background-color: #f8fafc;">
    {{-- dark mode grid override via inline style won't work for dark, handled with pseudo via overlay --}}
    <div class="absolute inset-0 pointer-events-none dark:opacity-100 opacity-0"
         style="background-image: linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 40px 40px; background-color: #030712; z-index:0;"></div>

    {{-- Slides track --}}
    <div class="relative flex items-center justify-center" id="bannerTrack" style="min-height:320px;">

        {{-- === SLIDE ITEMS ===
             Tambahkan / ubah konten slide di sini.
             Tiap slide: <div class="banner-slide" data-index="N"> ... </div>
             Gunakan gambar nyata atau gradient sebagai background.
        --}}

        <div class="banner-slide absolute rounded-3xl overflow-hidden shadow-2xl transition-all duration-500"
             data-index="0"
             style="background:linear-gradient(135deg,#1a4e8a,#0d2d57); width:68%; max-width:860px;">
            <div class="flex items-center h-56 md:h-72 px-10 gap-8">
                <div class="flex-1 text-white">
                    <p class="text-xs font-semibold uppercase tracking-widest text-blue-300 mb-2">Program Unggulan</p>
                    <h2 class="text-2xl md:text-3xl font-bold leading-snug mb-3">Pelatihan Manajerial<br>Keperawatan 2025</h2>
                    <p class="text-sm text-blue-100 mb-5 max-w-xs">Tingkatkan kompetensi manajerial Anda bersama praktisi terbaik.</p>
                    <a href="#" class="inline-flex items-center gap-2 bg-white text-blue-800 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-blue-50 transition">
                        Daftar Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="hidden md:flex flex-shrink-0 w-40 h-40 items-center justify-center">
                    <svg class="w-36 h-36 text-blue-300/40" fill="currentColor" viewBox="0 0 64 64"><circle cx="32" cy="32" r="30"/><path fill="#fff" d="M20 44V22l24 11-24 11z" opacity=".7"/></svg>
                </div>
            </div>
        </div>

        <div class="banner-slide absolute rounded-3xl overflow-hidden shadow-2xl transition-all duration-500"
             data-index="1"
             style="background:linear-gradient(135deg,#0f5e3a,#07381f); width:68%; max-width:860px;">
            <div class="flex items-center h-56 md:h-72 px-10 gap-8">
                <div class="flex-1 text-white">
                    <p class="text-xs font-semibold uppercase tracking-widest text-green-300 mb-2">Kesehatan</p>
                    <h2 class="text-2xl md:text-3xl font-bold leading-snug mb-3">Seminar Nasional<br>Keperawatan 2025</h2>
                    <p class="text-sm text-green-100 mb-5 max-w-xs">Forum pertemuan dan diskusi perawat manajer se-Indonesia.</p>
                    <a href="#" class="inline-flex items-center gap-2 bg-white text-green-800 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-green-50 transition">
                        Info Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="hidden md:flex flex-shrink-0 w-40 h-40 items-center justify-center">
                    <svg class="w-36 h-36 text-green-300/30" fill="currentColor" viewBox="0 0 64 64"><circle cx="32" cy="32" r="30"/><path fill="#fff" d="M24 18h4v10h10v4H28v10h-4V32H14v-4h10V18z" opacity=".8"/></svg>
                </div>
            </div>
        </div>

        <div class="banner-slide absolute rounded-3xl overflow-hidden shadow-2xl transition-all duration-500"
             data-index="2"
             style="background:linear-gradient(135deg,#7c2d12,#4a1007); width:68%; max-width:860px;">
            <div class="flex items-center h-56 md:h-72 px-10 gap-8">
                <div class="flex-1 text-white">
                    <p class="text-xs font-semibold uppercase tracking-widest text-orange-300 mb-2">Donor</p>
                    <h2 class="text-2xl md:text-3xl font-bold leading-snug mb-3">Aksi Donor Darah<br>Bersama HPMI</h2>
                    <p class="text-sm text-orange-100 mb-5 max-w-xs">Satu tetes darah, satu nyawa terselamatkan.</p>
                    <a href="#" class="inline-flex items-center gap-2 bg-white text-red-800 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-red-50 transition">
                        Ikut Berpartisipasi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="hidden md:flex flex-shrink-0 w-40 h-40 items-center justify-center">
                    <svg class="w-36 h-36 text-red-300/30" fill="currentColor" viewBox="0 0 64 64"><path d="M32 8 C32 8 12 26 12 38 a20 20 0 0 0 40 0 C52 26 32 8 32 8z"/></svg>
                </div>
            </div>
        </div>

        <div class="banner-slide absolute rounded-3xl overflow-hidden shadow-2xl transition-all duration-500"
             data-index="3"
             style="background:linear-gradient(135deg,#4c1d95,#2e1065); width:68%; max-width:860px;">
            <div class="flex items-center h-56 md:h-72 px-10 gap-8">
                <div class="flex-1 text-white">
                    <p class="text-xs font-semibold uppercase tracking-widest text-purple-300 mb-2">Workshop</p>
                    <h2 class="text-2xl md:text-3xl font-bold leading-snug mb-3">Workshop Rumah Sakit<br>Akreditasi Nasional</h2>
                    <p class="text-sm text-purple-100 mb-5 max-w-xs">Persiapkan RS Anda menuju standar akreditasi internasional.</p>
                    <a href="#" class="inline-flex items-center gap-2 bg-white text-purple-800 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-purple-50 transition">
                        Daftar Workshop
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="hidden md:flex flex-shrink-0 w-40 h-40 items-center justify-center">
                    <svg class="w-36 h-36 text-purple-300/30" fill="none" stroke="currentColor" viewBox="0 0 64 64"><rect x="8" y="12" width="48" height="36" rx="4" stroke-width="3"/><path d="M8 22h48" stroke-width="3"/></svg>
                </div>
            </div>
        </div>

        <div class="banner-slide absolute rounded-3xl overflow-hidden shadow-2xl transition-all duration-500"
             data-index="4"
             style="background:linear-gradient(135deg,#0e7490,#083344); width:68%; max-width:860px;">
            <div class="flex items-center h-56 md:h-72 px-10 gap-8">
                <div class="flex-1 text-white">
                    <p class="text-xs font-semibold uppercase tracking-widest text-cyan-300 mb-2">Kunjungan</p>
                    <h2 class="text-2xl md:text-3xl font-bold leading-snug mb-3">Kunjungan RS Anggota<br>Wilayah Jawa Timur</h2>
                    <p class="text-sm text-cyan-100 mb-5 max-w-xs">Saling berbagi praktik terbaik manajemen keperawatan.</p>
                    <a href="#" class="inline-flex items-center gap-2 bg-white text-cyan-800 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-cyan-50 transition">
                        Lihat Jadwal
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="hidden md:flex flex-shrink-0 w-40 h-40 items-center justify-center">
                    <svg class="w-36 h-36 text-cyan-300/30" fill="none" stroke="currentColor" viewBox="0 0 64 64"><circle cx="32" cy="28" r="12" stroke-width="3"/><path d="M12 56c0-11 8.95-20 20-20s20 8.95 20 20" stroke-width="3"/></svg>
                </div>
            </div>
        </div>

    </div>

    {{-- Prev / Next arrows --}}
    <button id="bannerPrev"
            class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white dark:bg-gray-800 rounded-full shadow-lg flex items-center justify-center text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition z-20">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button id="bannerNext"
            class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white dark:bg-gray-800 rounded-full shadow-lg flex items-center justify-center text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition z-20">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>

    {{-- Dot indicators --}}
    <div class="flex justify-center gap-2 mt-6" id="bannerDots">
        {{-- dots generated by JS --}}
    </div>

</div>
{{-- END SLIDESHOW BANNER --}}


{{-- Hero --}}
<section class="relative bg-gradient-to-br from-primary-700 via-primary-600 to-primary-800 text-white py-24 overflow-hidden">
    {{-- Grid kotak-kotak overlay --}}
    <div class="absolute inset-0 pointer-events-none"
         style="background-image: linear-gradient(rgba(255,255,255,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 40px 40px; z-index:0;"></div>
    <div class="absolute inset-0 opacity-10" style="z-index:1;">
        <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-accent-400 rounded-full filter blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" style="z-index:2;">
        <span class="inline-block bg-white/20 backdrop-blur text-sm font-medium px-4 py-1.5 rounded-full mb-6">
            {{ $s('hero_badge_text', 'Organisasi Profesi Keperawatan Indonesia') }}
        </span>
        <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
            {{ $s('hero_title', 'Himpunan Perawat') }}<br>
            <span class="text-accent-400">{{ $s('hero_title_accent', 'Manajer Indonesia') }}</span>
        </h1>
        <p class="text-xl text-primary-100 mb-10 max-w-2xl mx-auto">
            {{ $s('hero_subtitle', 'Bersama membangun kompetensi dan profesionalisme perawat manajer di seluruh Indonesia.') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if($s('feature_registration', '1') === '1')
            <a href="{{ route('register') }}" class="px-8 py-3.5 bg-white text-primary-700 font-semibold rounded-xl hover:bg-primary-50 transition shadow-lg">
                {{ $s('hero_cta_primary', 'Gabung Sekarang') }}
            </a>
            @endif
            <a href="{{ route('about') }}" class="px-8 py-3.5 border-2 border-white/50 text-white font-semibold rounded-xl hover:bg-white/10 transition">
                {{ $s('hero_cta_secondary', 'Tentang HPMI') }}
            </a>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-12 bg-white dark:bg-gray-800 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 gap-6 text-center">
            <div data-aos="fade-down-right">
                <div class="text-4xl font-bold text-primary-600 dark:text-primary-400">{{ number_format($stats['members']) }}+</div>
                <div class="text-gray-500 dark:text-gray-400 mt-1">Anggota Aktif</div>
            </div>
            <div data-aos="fade-down-right">
                <div class="text-4xl font-bold text-primary-600 dark:text-primary-400">{{ number_format($stats['events']) }}+</div>
                <div class="text-gray-500 dark:text-gray-400 mt-1">Kegiatan Terlaksana</div>
            </div>
            <div data-aos="fade-down-right">
                <div class="text-4xl font-bold text-primary-600 dark:text-primary-400">{{ number_format($stats['articles']) }}+</div>
                <div class="text-gray-500 dark:text-gray-400 mt-1">Artikel Edukasi</div>
            </div>
        </div>
    </div>
</section>


{{-- =============================================
     ANNOUNCEMENTS — style gambar 1
     (icon + judul kiri, filter kategori + card carousel kanan)
     ============================================= --}}
@if($announcements->count())
<section class="py-12 bg-primary-50 dark:bg-primary-900/10 relative overflow-hidden">
    {{-- Grid kotak-kotak --}}
    <div class="absolute inset-0 pointer-events-none"
         style="background-image: linear-gradient(rgba(0,0,0,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.04) 1px, transparent 1px); background-size: 40px 40px;"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

        <div class="flex flex-col md:flex-row gap-8 items-start">

            {{-- ── LEFT: icon + title + CTA ── --}}
            <div class="flex-shrink-0 md:w-56">
                {{-- Green badge icon --}}
                <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-800 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white leading-snug mb-4">
                    Kuy, cek pengumuman<br>sebelum...
                </h2>
                <a href="#"
                   class="inline-block text-sm font-semibold text-primary-600 dark:text-primary-400 bg-primary-100 dark:bg-primary-800 px-5 py-2.5 rounded-xl hover:bg-primary-200 dark:hover:bg-primary-700 transition">
                    Lihat semua pengumuman
                </a>
            </div>

            {{-- ── RIGHT: filter tabs + announcement cards ── --}}
            <div class="flex-1 min-w-0">

                {{-- Filter tabs (like gambar 1: Semua, Pesawat, Hotel…) --}}
                <div class="flex gap-2 flex-wrap mb-5" id="annFilterTabs">
                    <button data-filter="semua"
                            class="ann-filter-btn px-4 py-1.5 rounded-full text-sm font-medium border transition
                                   bg-primary-600 text-white border-primary-600">
                        Semua
                    </button>
                    <button data-filter="pinned"
                            class="ann-filter-btn px-4 py-1.5 rounded-full text-sm font-medium border transition
                                   border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-400">
                        📌 Penting
                    </button>
                    <button data-filter="umum"
                            class="ann-filter-btn px-4 py-1.5 rounded-full text-sm font-medium border transition
                                   border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-400">
                        Umum
                    </button>
                    <button data-filter="kegiatan"
                            class="ann-filter-btn px-4 py-1.5 rounded-full text-sm font-medium border transition
                                   border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-400">
                        Kegiatan
                    </button>
                    <button data-filter="info"
                            class="ann-filter-btn px-4 py-1.5 rounded-full text-sm font-medium border transition
                                   border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-400">
                        Info
                    </button>
                </div>

                {{-- Cards container (horizontal scroll) --}}
                <div class="relative">
                    <div class="flex gap-4 overflow-x-auto pb-3 snap-x snap-mandatory scroll-smooth" id="annCarouselInner"
                         style="scrollbar-width:none; -ms-overflow-style:none;">

                        @foreach($announcements as $i => $ann)
                        <div class="ann-card snap-start flex-shrink-0 w-72 bg-white dark:bg-gray-800 rounded-2xl border border-primary-100 dark:border-gray-700 shadow-sm overflow-hidden"
                             data-category="{{ $ann->is_pinned ? 'pinned' : 'umum' }}">

                            {{-- Card colour strip --}}
                            <div class="h-2 {{ $ann->is_pinned ? 'bg-amber-400' : 'bg-primary-500' }}"></div>

                            <div class="p-5">
                                {{-- Pin badge --}}
                                @if($ann->is_pinned)
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-700 bg-amber-50 dark:bg-amber-900/30 dark:text-amber-300 px-2.5 py-0.5 rounded-full mb-3">
                                    📌 Penting
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-primary-600 bg-primary-50 dark:bg-primary-900/30 dark:text-primary-300 px-2.5 py-0.5 rounded-full mb-3">
                                    Info
                                </span>
                                @endif

                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm leading-snug mb-2 line-clamp-2">
                                    {{ $ann->title }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-3">
                                    {{ Str::limit($ann->content, 120) }}
                                </p>

                                <a href="#" class="inline-flex items-center gap-1 mt-4 text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">
                                    Baca selengkapnya
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                {{-- Pagination counter (like "9/10" in gambar 1) --}}
                <div class="flex items-center gap-3 mt-4">
                    <button id="annPrev"
                            class="w-9 h-9 bg-white dark:bg-gray-800 rounded-full border border-gray-200 dark:border-gray-700 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button id="annNext"
                            class="w-9 h-9 bg-white dark:bg-gray-800 rounded-full border border-gray-200 dark:border-gray-700 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden ml-2">
                        <div id="annProgressBar" class="h-full bg-gray-400 dark:bg-gray-500 rounded-full transition-all duration-300" style="width:0%"></div>
                    </div>
                    <span id="annCounter" class="text-xs text-gray-500 dark:text-gray-400 font-medium ml-1">1/{{ $announcements->count() }}</span>
                </div>

            </div>
        </div>
    </div>
</section>
@endif
{{-- END ANNOUNCEMENTS --}}


{{-- Latest Articles --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Artikel Terbaru</h2>
            <a href="{{ route('articles.index') }}" class="text-primary-600 dark:text-primary-400 text-sm hover:underline">Lihat semua →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-down">
            @foreach($articles as $article)
            <article class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition group">
                <div class="h-44 bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900 dark:to-primary-800 flex items-center justify-center">
                    <svg class="w-12 h-12 text-primary-300 dark:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2"/>
                    </svg>
                </div>
                <div class="p-5" data-aos="fade-right">
                    @if($article->category)
                    <span class="inline-block text-xs font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 px-2.5 py-0.5 rounded-full mb-3">{{ $article->category->name }}</span>
                    @endif
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition line-clamp-2">
                        <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">{{ $article->excerpt }}</p>
                    <div class="mt-4 flex items-center justify-between text-xs text-gray-400 dark:text-gray-500">
                        <span>{{ $article->published_at?->format('d M Y') }}</span>
                        <span>{{ number_format($article->views) }} views</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Upcoming Events --}}
@if($events->count())
<section class="py-16 bg-gray-50 dark:bg-gray-800/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Kegiatan Mendatang</h2>
            <a href="{{ route('events.index') }}" class="text-primary-600 dark:text-primary-400 text-sm hover:underline">Lihat semua →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-aos="zoom-in-down">
            @foreach($events as $event)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex gap-4 hover:shadow-md transition">
                <div class="flex-shrink-0 w-14 h-14 bg-primary-600 rounded-xl flex flex-col items-center justify-center text-white">
                    <span class="text-xs font-medium">{{ $event->start_date->format('M') }}</span>
                    <span class="text-xl font-bold leading-none">{{ $event->start_date->format('d') }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-900 dark:text-white truncate">{{ $event->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $event->location ?? 'Online' }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        @if($event->is_member_only)<span class="text-xs bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 px-2 py-0.5 rounded-full">Member Only</span>@endif
                        @if($event->is_free)<span class="text-xs bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 px-2 py-0.5 rounded-full">Gratis</span>@endif
                    </div>
                </div>
                <a href="{{ route('events.show', $event->slug) }}" class="flex-shrink-0 self-center text-primary-600 dark:text-primary-400 hover:underline text-sm">Detail →</a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20 mx-20 md:mx-5 rounded-3xl bg-primary-600 dark:bg-primary-800 text-white text-center relative overflow-hidden" data-aos="zoom-in-down">
    <div class="absolute inset-0 rounded-3xl pointer-events-none"
         style="background-image: linear-gradient(rgba(255,255,255,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 40px 40px;"></div>
    <div class="max-w-2xl mx-auto px-4 relative" style="z-index:1;">
        <h2 class="text-3xl font-bold mb-4">{{ $s('cta_title', 'Bergabunglah dengan HPMI') }}</h2>
        <p class="text-primary-100 mb-8 text-lg">{{ $s('cta_subtitle', 'Tingkatkan kompetensi Anda bersama ribuan perawat manajer profesional di seluruh Indonesia.') }}</p>
        @if($s('feature_registration', '1') === '1')
        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-primary-700 font-semibold rounded-xl hover:bg-primary-50 transition shadow-lg text-lg">
            {{ $s('cta_button_text', 'Daftar Sekarang') }}
        </a>
        @else
        <p class="text-white/70 text-base">Pendaftaran anggota sementara ditutup.</p>
        @endif
    </div>
</section>


{{-- =============================================
     JAVASCRIPT
     ============================================= --}}
<script>
(function () {
    /* ────────────────────────────────────────────
       BANNER CAROUSEL (style gambar 2)
    ──────────────────────────────────────────── */
    const track     = document.getElementById('bannerTrack');
    const slides    = Array.from(track.querySelectorAll('.banner-slide'));
    const prevBtn   = document.getElementById('bannerPrev');
    const nextBtn   = document.getElementById('bannerNext');
    const dotsWrap  = document.getElementById('bannerDots');
    const total     = slides.length;
    let current     = 0;
    let autoTimer;

    // Build dots
    slides.forEach((_, i) => {
        const d = document.createElement('button');
        d.className = 'w-2 h-2 rounded-full transition-all duration-300 ' +
            (i === 0 ? 'bg-primary-600 w-5' : 'bg-gray-300 dark:bg-gray-600');
        d.setAttribute('aria-label', 'Slide ' + (i + 1));
        d.addEventListener('click', () => goTo(i));
        dotsWrap.appendChild(d);
    });

    function updateDots() {
        Array.from(dotsWrap.children).forEach((d, i) => {
            if (i === current) {
                d.className = 'w-5 h-2 rounded-full transition-all duration-300 bg-primary-600';
            } else {
                d.className = 'w-2 h-2 rounded-full transition-all duration-300 bg-gray-300 dark:bg-gray-600';
            }
        });
    }

    function updateBanner() {
        const trackW = track.offsetWidth;

        slides.forEach((slide, i) => {
            const offset = i - current;
            const absOffset = Math.abs(offset);

            if (absOffset > 2) {
                slide.style.opacity = '0';
                slide.style.pointerEvents = 'none';
                slide.style.transform = `translateX(${offset > 0 ? 200 : -200}%) scale(0.5)`;
                return;
            }

            const isCurrent = offset === 0;
            const isAdjacent = absOffset === 1;

            // Position: centre slide fills centre, adjacent peek from sides
            const translateX = offset * 72; // % shift per step
            const scale = isCurrent ? 1 : isAdjacent ? 0.82 : 0.68;
            const opacity = isCurrent ? 1 : isAdjacent ? 0.55 : 0.3;
            const zIndex  = total - absOffset;

            slide.style.transform  = `translateX(${translateX}%) scale(${scale})`;
            slide.style.opacity    = opacity;
            slide.style.zIndex     = zIndex;
            slide.style.pointerEvents = isCurrent ? 'auto' : 'none';
        });

        updateDots();
    }

    function goTo(n) {
        current = (n + total) % total;
        updateBanner();
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    prevBtn.addEventListener('click', () => { clearInterval(autoTimer); prev(); startAuto(); });
    nextBtn.addEventListener('click', () => { clearInterval(autoTimer); next(); startAuto(); });

    function startAuto() {
        autoTimer = setInterval(next, 5000);
    }

    updateBanner();
    startAuto();


    /* ────────────────────────────────────────────
       ANNOUNCEMENT CAROUSEL (style gambar 1)
    ──────────────────────────────────────────── */
    const annInner  = document.getElementById('annCarouselInner');
    const annPrev   = document.getElementById('annPrev');
    const annNext   = document.getElementById('annNext');
    const annBar    = document.getElementById('annProgressBar');
    const annCount  = document.getElementById('annCounter');
    const filterBtns = document.querySelectorAll('.ann-filter-btn');
    const allCards  = Array.from(document.querySelectorAll('.ann-card'));

    if (!annInner) return;

    const cardW = () => {
        const c = annInner.querySelector('.ann-card');
        return c ? c.offsetWidth + 16 : 288; // card width + gap
    };

    function updateAnnUI() {
        const visible = Array.from(annInner.querySelectorAll('.ann-card:not([style*="display: none"])'));
        const total   = visible.length;
        if (!total) { annBar.style.width = '0%'; annCount.textContent = '0/0'; return; }

        const scrolled = annInner.scrollLeft;
        const max      = annInner.scrollWidth - annInner.clientWidth;
        const pct      = max > 0 ? (scrolled / max) * 100 : 0;
        annBar.style.width = pct + '%';

        // Estimate current index
        const idx = Math.round(scrolled / cardW()) + 1;
        annCount.textContent = Math.min(idx, total) + '/' + total;
    }

    annInner.addEventListener('scroll', updateAnnUI);

    annPrev.addEventListener('click', () => {
        annInner.scrollBy({ left: -cardW(), behavior: 'smooth' });
    });
    annNext.addEventListener('click', () => {
        annInner.scrollBy({ left: cardW(), behavior: 'smooth' });
    });

    // Filter tabs
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;

            // Update active tab style
            filterBtns.forEach(b => {
                b.classList.remove('bg-primary-600', 'text-white', 'border-primary-600');
                b.classList.add('border-gray-300', 'dark:border-gray-600', 'text-gray-700', 'dark:text-gray-300');
            });
            btn.classList.add('bg-primary-600', 'text-white', 'border-primary-600');
            btn.classList.remove('border-gray-300', 'dark:border-gray-600', 'text-gray-700', 'dark:text-gray-300');

            // Show/hide cards
            allCards.forEach(card => {
                const cat = card.dataset.category;
                const show = filter === 'semua' || cat === filter;
                card.style.display = show ? '' : 'none';
            });

            annInner.scrollLeft = 0;
            setTimeout(updateAnnUI, 50);
        });
    });

    updateAnnUI();
})();
</script>

@endsection