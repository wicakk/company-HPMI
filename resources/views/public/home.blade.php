{{-- resources/views/home.blade.php --}}
{{-- Menggabungkan: struktur dinamis (doc1) + UI style (doc2) --}}
{{-- Banner: card 3D peek dari $bannerSlides, fallback slide statis --}}
{{-- + Section Announcements dengan filter tab --}}
{{-- + Research Data search box --}}

@extends('layouts.app')

@php
    $s = fn(string $key, string $default = '') => $settings[$key]?->value ?? $default;

    $keyword  = $keyword  ?? '';
    $category = $category ?? 'semua';

    $articles = $articles ?? collect();
    $events   = $events   ?? collect();
    $members  = $members  ?? collect();

    // ✅ FIX DI SINI
    $totalResults = $articles->count() + $events->count() + $members->count();
@endphp

@section('title', $keyword 
    ? 'Hasil Pencarian: ' . $keyword . ' - ' . $s('org_name', 'HPMI')
    : 'Beranda - ' . $s('org_name', 'HPMI')
)

@section('content')

{{-- ════════════════════════════════════════════════
     HERO BANNER SLIDER — Style card 3D peek (doc2)
     Data dinamis dari $bannerSlides (controller)
     Fallback: slide statis jika $bannerSlides kosong
════════════════════════════════════════════════ --}}
<div class="relative w-full overflow-hidden select-none py-16"
     id="heroBannerWrap"
     style="background-image: linear-gradient(rgba(0,0,0,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.05) 1px, transparent 1px); background-size: 40px 40px; background-color: #f8fafc;">

    {{-- Dark mode grid overlay --}}
    <div class="absolute inset-0 pointer-events-none dark:opacity-100 opacity-0"
         style="background-image: linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 40px 40px; background-color: #030712; z-index:0;"></div>

    {{-- Slides track --}}
    <div class="relative flex items-center justify-center" id="bannerTrack" style="min-height:288px;">

        @php
            $hasSlides = isset($bannerSlides) && $bannerSlides->count() > 0;

            // Slide statis sebagai fallback jika tidak ada data dari controller
            $staticSlides = [
                [
                    'title'    => 'Pelatihan Manajerial Keperawatan 2025',
                    'subtitle' => 'Tingkatkan kompetensi manajerial Anda bersama praktisi terbaik.',
                    'badge'    => 'Program Unggulan',
                    'link'     => '#',
                    'link_text'=> 'Daftar Sekarang',
                    'color'    => '#1a4e8a',
                    'color2'   => '#0d2d57',
                    'accent'   => '#93c5fd',
                    'image'    => null,
                ],
                [
                    'title'    => 'Seminar Nasional Keperawatan 2025',
                    'subtitle' => 'Forum pertemuan dan diskusi perawat manajer se-Indonesia.',
                    'badge'    => 'Kesehatan',
                    'link'     => '#',
                    'link_text'=> 'Info Selengkapnya',
                    'color'    => '#0f5e3a',
                    'color2'   => '#07381f',
                    'accent'   => '#6ee7b7',
                    'image'    => null,
                ],
                [
                    'title'    => 'Aksi Donor Darah Bersama HPMI',
                    'subtitle' => 'Satu tetes darah, satu nyawa terselamatkan.',
                    'badge'    => 'Donor',
                    'link'     => '#',
                    'link_text'=> 'Ikut Berpartisipasi',
                    'color'    => '#7c2d12',
                    'color2'   => '#4a1007',
                    'accent'   => '#fca5a5',
                    'image'    => null,
                ],
                [
                    'title'    => 'Workshop RS Akreditasi Nasional',
                    'subtitle' => 'Persiapkan RS Anda menuju standar akreditasi internasional.',
                    'badge'    => 'Workshop',
                    'link'     => '#',
                    'link_text'=> 'Daftar Workshop',
                    'color'    => '#4c1d95',
                    'color2'   => '#2e1065',
                    'accent'   => '#c4b5fd',
                    'image'    => null,
                ],
                [
                    'title'    => 'Kunjungan RS Anggota Wilayah Jawa Timur',
                    'subtitle' => 'Saling berbagi praktik terbaik manajemen keperawatan.',
                    'badge'    => 'Kunjungan',
                    'link'     => '#',
                    'link_text'=> 'Lihat Jadwal',
                    'color'    => '#0e7490',
                    'color2'   => '#083344',
                    'accent'   => '#67e8f9',
                    'image'    => null,
                ],
            ];
        @endphp

        {{-- ── Render slide dinamis dari controller ── --}}
        @if($hasSlides)
            @foreach($bannerSlides as $idx => $slide)
            <div class="banner-slide absolute rounded-3xl overflow-hidden shadow-2xl"
                 data-index="{{ $idx }}"
                 style="background: linear-gradient(135deg, {{ $slide['color'] }}, {{ $slide['color'] }}99);
                        width: 68%; max-width: 860px;
                        transition: transform .5s cubic-bezier(.4,0,.2,1), opacity .5s ease;">

                {{-- Gambar jika ada --}}
                @if(!empty($slide['image']))
                <img src="{{ $slide['image'] }}"
                     alt="{{ $slide['title'] }}"
                     class="absolute inset-0 w-full h-full object-cover"
                     loading="{{ $idx === 0 ? 'eager' : 'lazy' }}">
                <div class="absolute inset-0"
                     style="background: linear-gradient(135deg, {{ $slide['color'] }}cc 0%, {{ $slide['color'] }}66 60%, transparent 100%);"></div>
                @endif

                <div class="relative flex items-center h-56 md:h-72 px-10 gap-8 z-10">
                    <div class="flex-1 text-white">
                        @if(!empty($slide['badge']) || !empty($slide['title']))
                        <p class="text-xs font-semibold uppercase tracking-widest mb-2"
                           style="color: {{ $slide['accent'] ?? '#93c5fd' }};">
                            {{ $slide['badge'] ?? '' }}
                        </p>
                        @endif
                        @if(!empty($slide['title']))
                        <h2 class="text-2xl md:text-3xl font-bold leading-snug mb-3">
                            {!! nl2br(e($slide['title'])) !!}
                        </h2>
                        @endif
                        @if(!empty($slide['subtitle']))
                        <p class="text-sm mb-5 max-w-xs opacity-80 leading-relaxed">
                            {{ $slide['subtitle'] }}
                        </p>
                        @endif
                        @if(!empty($slide['link']) && $slide['link'] !== '#')
                        <a href="{{ $slide['link'] }}"
                           class="inline-flex items-center gap-2 bg-white font-semibold text-sm px-5 py-2.5 rounded-xl transition hover:opacity-90"
                           style="color: {{ $slide['color'] }};">
                            Selengkapnya
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

        {{-- ── Fallback: slide statis ── --}}
        @else
            @foreach($staticSlides as $idx => $slide)
            <div class="banner-slide absolute rounded-3xl overflow-hidden shadow-2xl"
                 data-index="{{ $idx }}"
                 style="background: linear-gradient(135deg, {{ $slide['color'] }}, {{ $slide['color2'] }});
                        width: 68%; max-width: 860px;
                        transition: transform .5s cubic-bezier(.4,0,.2,1), opacity .5s ease;">
                <div class="flex items-center h-56 md:h-72 px-10 gap-8">
                    <div class="flex-1 text-white">
                        <p class="text-xs font-semibold uppercase tracking-widest mb-2"
                           style="color: {{ $slide['accent'] }};">
                            {{ $slide['badge'] }}
                        </p>
                        <h2 class="text-2xl md:text-3xl font-bold leading-snug mb-3">
                            {!! nl2br(e($slide['title'])) !!}
                        </h2>
                        <p class="text-sm mb-5 max-w-xs opacity-80 leading-relaxed">
                            {{ $slide['subtitle'] }}
                        </p>
                        <a href="{{ $slide['link'] }}"
                           class="inline-flex items-center gap-2 bg-white font-semibold text-sm px-5 py-2.5 rounded-xl transition hover:opacity-90"
                           style="color: {{ $slide['color'] }};">
                            {{ $slide['link_text'] }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        @endif

    </div>{{-- /bannerTrack --}}

    {{-- Prev / Next arrows --}}
    <button id="bannerPrev"
            class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white dark:bg-gray-800 rounded-full shadow-lg flex items-center justify-center text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition z-20">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
    <button id="bannerNext"
            class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white dark:bg-gray-800 rounded-full shadow-lg flex items-center justify-center text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition z-20">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- Dot indicators --}}
    <div class="flex justify-center gap-2 mt-4 relative z-10" id="bannerDots"></div>

</div>
{{-- ── Research Data Search Box (doc2) ── --}}
<div class="relative w-full overflow-hidden select-none "
     id="heroBannerWrap"
     style="background-image: linear-gradient(rgba(0,0,0,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.05) 1px, transparent 1px); background-size: 40px 40px; background-color: #f8fafc;">
    <div class="py-6 my-6 mx-12 rounded-2xl bg-gradient-to-br from-primary-700 to-primary-800 text-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">Research Data</h1>

            {{-- Search form (ulang dari home, agar bisa refinement) --}}
            <form method="GET" action="{{ route('research.search') }}" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="q" value="{{ $keyword }}"
                        placeholder="Masukkan data penelitian / ID / keyword..."
                        class="w-full rounded-2xl px-5 py-3 bg-white/15 backdrop-blur border border-white/20
                                text-white placeholder-white/60
                                focus:outline-none focus:ring-2 focus:ring-white/50 transition">
                </div>
                <div>
                    <select name="category"
                            class="rounded-2xl px-4 py-3 bg-white/15 backdrop-blur border border-white/20
                                text-white focus:outline-none focus:ring-2 focus:ring-white/50 transition">
                        <option value="semua"     {{ $category === 'semua'     ? 'selected' : '' }}>Semua Kategori</option>
                        <option value="Penelitian"{{ $category === 'Penelitian'? 'selected' : '' }}>Penelitian</option>
                        <option value="Event"     {{ $category === 'Event'     ? 'selected' : '' }}>Event</option>
                        <option value="Anggota"   {{ $category === 'Anggota'   ? 'selected' : '' }}>Anggota</option>
                    </select>
                </div>
                <span class="flex gap-4">
                    <button type="submit"
                            class="flex items-center gap-2 bg-white text-primary-700 font-semibold px-6 py-3 rounded-2xl hover:bg-primary-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                        Cari
                    </button>
                    @if(!empty($keyword))
                    <button type="button"
                            onclick="window.location='{{ route('home') }}'"
                            class="flex items-center gap-2 bg-white text-primary-700 font-semibold px-6 py-3 rounded-2xl hover:bg-primary-50 transition">
                        Reset
                    </button>
                    @endif
                </span>
            </form>
        </div>
    </div>

    {{-- ── Results Body ── --}}
    @if(!empty($keyword ) && $keyword )
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

            {{-- Jika belum ada keyword --}}
            @if($keyword === '')
            <div class="text-center py-20 text-gray-400 dark:text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <p class="text-lg font-medium">Masukkan keyword untuk mulai mencari</p>
            </div>

            {{-- Jika ada keyword tapi tidak ada hasil --}}
            @elseif($totalResults === 0)
            <div class="text-center py-20">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    Tidak ada hasil untuk <span class="text-primary-600 dark:text-primary-400">"{{ $keyword }}"</span>
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Coba gunakan kata kunci lain atau pilih kategori berbeda.</p>
            </div>

            @else

            {{-- Ringkasan hasil --}}
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Ditemukan <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $totalResults }} hasil</span>
                untuk <span class="font-semibold text-primary-600 dark:text-primary-400">"{{ $keyword }}"</span>
                @if($category !== 'semua') <span>· Kategori: {{ $category }}</span> @endif
            </p>

            {{-- ── Artikel / Penelitian ── --}}
            @if($articles->count())
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-primary-500 inline-block"></span>
                    Artikel &amp; Penelitian
                    <span class="ml-1 text-xs font-normal text-gray-400">({{ $articles->count() }})</span>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($articles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}"
                    class="flex gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-md hover:border-primary-200 dark:hover:border-primary-700 transition group">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            @if($article->category)
                            <span class="text-xs font-medium text-primary-500 dark:text-primary-400">{{ $article->category->name }}</span>
                            @endif
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition line-clamp-2 mt-0.5">
                                {{ $article->title }}
                            </h3>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                {{ $article->published_at?->format('d M Y') }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── Events ── --}}
            @if($events->count())
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-sky-500 inline-block"></span>
                    Kegiatan / Event
                    <span class="ml-1 text-xs font-normal text-gray-400">({{ $events->count() }})</span>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($events as $event)
                    <a href="{{ route('events.show', $event->slug) }}"
                    class="flex gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-md hover:border-sky-200 dark:hover:border-sky-800 transition group">
                        <div class="flex-shrink-0 w-12 h-12 bg-primary-600 rounded-xl flex flex-col items-center justify-center text-white">
                            <span class="text-xs font-medium leading-none">{{ $event->start_date->format('M') }}</span>
                            <span class="text-lg font-bold leading-none">{{ $event->start_date->format('d') }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition line-clamp-2">
                                {{ $event->title }}
                            </h3>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                {{ $event->location ?? 'Online' }}
                                @if($event->is_free)
                                · <span class="text-green-500">Gratis</span>
                                @endif
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── Anggota ── --}}
            @if($members->count())
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                    Anggota
                    <span class="ml-1 text-xs font-normal text-gray-400">({{ $members->count() }})</span>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($members as $member)
                    <div class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $member->name }}</p>
                            @if(!empty($member->profession))
                            <p class="text-xs text-gray-400 dark:text-gray-500 truncate">{{ $member->profession }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @endif {{-- end if totalResults --}}

        </div>
    @endif
</div>
{{-- END BANNER SLIDER --}}


{{-- ── Hero Text ── --}}
<section class="relative bg-gradient-to-br from-primary-700 via-primary-600 to-primary-800 text-white py-16 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none"
         style="background-image: linear-gradient(rgba(255,255,255,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 40px 40px; z-index:0;"></div>
    <div class="absolute inset-0 opacity-10" style="z-index:1;">
        <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-accent-400 rounded-full filter blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" style="z-index:2;">
        <span class="inline-block bg-white/20 backdrop-blur text-sm font-medium px-4 py-1.5 rounded-full mb-6">
            {{  $settings['hero_badge_text']['value'] }}
        </span>
        <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
            {{  $settings['hero_title']['value'] }}
            <span class="text-accent-400"><br>{{  $settings['hero_title_accent']['value'] }}</span>
        </h1>
        <p class="text-xl text-primary-100 mb-10 max-w-2xl mx-auto">
            {{  $settings['hero_subtitle']['value'] }}
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


{{-- ── Stats ── --}}
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


{{-- ════════════════════════════════════════════════
     ANNOUNCEMENTS — filter tab + card carousel (doc2)
════════════════════════════════════════════════ --}}
{{-- @if(isset($announcements) && $announcements->count())
<section class="py-12 bg-primary-50 dark:bg-primary-900/10 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none"
         style="background-image: linear-gradient(rgba(0,0,0,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.04) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex flex-col md:flex-row gap-8 items-start">
            <div class="flex-shrink-0 md:w-56">
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
            <div class="flex-1 min-w-0">
                <div class="flex gap-2 flex-wrap mb-5" id="annFilterTabs">
                    <button data-filter="semua"
                            class="ann-filter-btn px-4 py-1.5 rounded-full text-sm font-medium border transition bg-primary-600 text-white border-primary-600">
                        Semua
                    </button>
                    <button data-filter="pinned"
                            class="ann-filter-btn px-4 py-1.5 rounded-full text-sm font-medium border transition border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-400">
                        📌 Penting
                    </button>
                    <button data-filter="umum"
                            class="ann-filter-btn px-4 py-1.5 rounded-full text-sm font-medium border transition border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-400">
                        Umum
                    </button>
                    <button data-filter="kegiatan"
                            class="ann-filter-btn px-4 py-1.5 rounded-full text-sm font-medium border transition border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-400">
                        Kegiatan
                    </button>
                    <button data-filter="info"
                            class="ann-filter-btn px-4 py-1.5 rounded-full text-sm font-medium border transition border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-400">
                        Info
                    </button>
                </div>
                <div class="relative">
                    <div class="flex gap-4 overflow-x-auto pb-3 snap-x snap-mandatory scroll-smooth" id="annCarouselInner"
                         style="scrollbar-width:none; -ms-overflow-style:none;">

                        @foreach($announcements as $ann)
                        <div class="ann-card snap-start flex-shrink-0 w-72 bg-white dark:bg-gray-800 rounded-2xl border border-primary-100 dark:border-gray-700 shadow-sm overflow-hidden"
                             data-category="{{ $ann->is_pinned ? 'pinned' : 'umum' }}">

                            <div class="h-2 {{ $ann->is_pinned ? 'bg-amber-400' : 'bg-primary-500' }}"></div>

                            <div class="p-5">
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
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                <div class="flex items-center gap-3 mt-4">
                    <button id="annPrev"
                            class="w-9 h-9 bg-white dark:bg-gray-800 rounded-full border border-gray-200 dark:border-gray-700 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button id="annNext"
                            class="w-9 h-9 bg-white dark:bg-gray-800 rounded-full border border-gray-200 dark:border-gray-700 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden ml-2">
                        <div id="annProgressBar" class="h-full bg-primary-400 dark:bg-primary-500 rounded-full transition-all duration-300" style="width:0%"></div>
                    </div>
                    <span id="annCounter" class="text-xs text-gray-500 dark:text-gray-400 font-medium ml-1">
                        1/{{ $announcements->count() }}
                    </span>
                </div>

            </div>
        </div>
    </div>
</section>
@endif --}}
{{-- END ANNOUNCEMENTS --}}


{{-- Layanan --}}
{{-- Layanan --}}
@if(isset($layanans) && $layanans->count())
<section class="py-16 bg-gray-50 dark:bg-gray-800/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
 
        {{-- Section Header --}}
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Layanan Kami</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Layanan medis terpercaya untuk Anda dan keluarga.
                </p>
            </div>
            <a href="{{ route('layanan.index') }}"
               class="text-primary-600 dark:text-primary-400 text-sm hover:underline">
                Lihat semua →
            </a>
        </div>
 
        @if(isset($grouped) && !$grouped->isEmpty())
 
            @foreach($grouped as $kategori => $items)
            <div class="mb-12">
                {{-- Kategori label --}}
                <div class="flex items-center gap-3 mb-6">
                    <h3 class="text-base font-semibold text-gray-700 dark:text-gray-300">
                        {{ $kategori }}
                    </h3>
                    <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
                    <span class="text-xs text-gray-400">{{ $items->count() }} layanan</span>
                </div>
 
                {{-- Grid kartu --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" data-aos="fade-up">
                    @foreach($items as $layanan)
                    <a href="{{ route('layanan.show', $layanan->slug) }}"
                       class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700
                              p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
 
                        {{-- Ikon --}}
                        <div class="w-14 h-14 rounded-2xl bg-primary-50 dark:bg-primary-900/30
                                    flex items-center justify-center text-3xl mb-5
                                    group-hover:bg-primary-100 dark:group-hover:bg-primary-900/50 transition-colors">
                            {{ $layanan->ikon ?? '🏥' }}
                        </div>
 
                        {{-- Nama --}}
                        <h4 class="text-base font-bold text-gray-900 dark:text-white mb-2
                                   group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            {{ $layanan->nama }}
                        </h4>
 
                        {{-- Deskripsi --}}
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-5 line-clamp-3">
                            {{ $layanan->deskripsi_singkat }}
                        </p>
 
                        {{-- CTA --}}
                        <span class="inline-flex items-center gap-1
                                     text-primary-600 dark:text-primary-400 text-sm font-semibold">
                            Selengkapnya
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach
 
        @else
            <div class="text-center py-16 text-gray-400 dark:text-gray-500">
                <p class="text-base">Belum ada layanan yang tersedia saat ini.</p>
            </div>
        @endif
 
    </div>
</section>
@endif
{{-- end layanan --}}




{{-- ── Latest Articles ── --}}
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
                <div class="p-5">
                    @if($article->category)
                    <span class="inline-block text-xs font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 px-2.5 py-0.5 rounded-full mb-3">
                        {{ $article->category->name }}
                    </span>
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


{{-- ── Upcoming Events ── --}}
@if(isset($events) && $events->count())
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
                        @if($event->is_member_only)
                        <span class="text-xs bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 px-2 py-0.5 rounded-full">Member Only</span>
                        @endif
                        @if($event->is_free)
                        <span class="text-xs bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 px-2 py-0.5 rounded-full">Gratis</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('events.show', $event->slug) }}"
                   class="flex-shrink-0 self-center text-primary-600 dark:text-primary-400 hover:underline text-sm">
                    Detail →
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ── CTA ── --}}
<section class="py-20 mx-4 md:mx-20 rounded-3xl bg-primary-600 dark:bg-primary-800 text-white text-center relative overflow-hidden my-10" data-aos="zoom-in-down">
    <div class="absolute inset-0 rounded-3xl pointer-events-none"
         style="background-image: linear-gradient(rgba(255,255,255,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 40px 40px;"></div>
    <div class="max-w-2xl mx-auto px-4 relative" style="z-index:1;">
        <h2 class="text-3xl font-bold mb-4">{{ $s('cta_title', 'Bergabunglah dengan HPMI') }}</h2>
        <p class="text-primary-100 mb-8 text-lg">
            {{ $s('cta_subtitle', 'Tingkatkan kompetensi Anda bersama ribuan perawat manajer profesional di seluruh Indonesia.') }}
        </p>
        @if($s('feature_registration', '1') === '1')
        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-primary-700 font-semibold rounded-xl hover:bg-primary-50 transition shadow-lg text-lg">
            {{ $s('cta_button_text', 'Daftar Sekarang') }}
        </a>
        @else
        <p class="text-white/70 text-base">Pendaftaran anggota sementara ditutup.</p>
        @endif
    </div>
</section>


{{-- ════════════════════════════════════════════════
     JAVASCRIPT — Banner Carousel 3D Peek + Announcement Carousel
════════════════════════════════════════════════ --}}
<script>
(function () {

    /* ─────────────────────────────────────────────
       1. BANNER CAROUSEL — 3D peek style (doc2)
    ───────────────────────────────────────────── */
    const track    = document.getElementById('bannerTrack');
    const dotsWrap = document.getElementById('bannerDots');
    const prevBtn  = document.getElementById('bannerPrev');
    const nextBtn  = document.getElementById('bannerNext');

    if (!track) return;

    const slides = Array.from(track.querySelectorAll('.banner-slide'));
    const total  = slides.length;
    if (!total) return;

    let current   = 0;
    let autoTimer = null;

    // Build dots
    if (dotsWrap && total > 1) {
        slides.forEach((_, i) => {
            const d = document.createElement('button');
            d.setAttribute('aria-label', 'Slide ' + (i + 1));
            d.addEventListener('click', () => { stopAuto(); goTo(i); startAuto(); });
            dotsWrap.appendChild(d);
        });
    }

    function updateDots() {
        if (!dotsWrap) return;
        Array.from(dotsWrap.children).forEach((d, i) => {
            d.className = i === current
                ? 'w-5 h-2 rounded-full transition-all duration-300 bg-primary-600 dark:bg-primary-400'
                : 'w-2 h-2 rounded-full transition-all duration-300 bg-gray-300 dark:bg-gray-600';
        });
    }

    function updateBanner() {
        slides.forEach((slide, i) => {
            const offset    = i - current;
            const absOffset = Math.abs(offset);

            if (absOffset > 2) {
                slide.style.opacity       = '0';
                slide.style.pointerEvents = 'none';
                slide.style.transform     = `translateX(${offset > 0 ? 200 : -200}%) scale(0.5)`;
                slide.style.zIndex        = '0';
                return;
            }

            const scale   = offset === 0 ? 1 : absOffset === 1 ? 0.82 : 0.68;
            const opacity = offset === 0 ? 1 : absOffset === 1 ? 0.55 : 0.3;
            const transX  = offset * 72; // % shift

            slide.style.transform     = `translateX(${transX}%) scale(${scale})`;
            slide.style.opacity       = opacity;
            slide.style.zIndex        = String(total - absOffset);
            slide.style.pointerEvents = offset === 0 ? 'auto' : 'none';
        });

        updateDots();
    }

    function goTo(n) {
        current = ((n % total) + total) % total;
        updateBanner();
    }

    function stopAuto() { clearInterval(autoTimer); }
    function startAuto() {
        if (total <= 1) return;
        autoTimer = setInterval(() => goTo(current + 1), 5000);
    }

    if (prevBtn) prevBtn.addEventListener('click', () => { stopAuto(); goTo(current - 1); startAuto(); });
    if (nextBtn) nextBtn.addEventListener('click', () => { stopAuto(); goTo(current + 1); startAuto(); });

    // Touch swipe
    let touchStartX = 0;
    track.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; }, { passive: true });
    track.addEventListener('touchend', e => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) { stopAuto(); goTo(current + (diff > 0 ? 1 : -1)); startAuto(); }
    }, { passive: true });

    updateBanner();
    startAuto();


    /* ─────────────────────────────────────────────
       2. ANNOUNCEMENT CAROUSEL + FILTER (doc2)
    ───────────────────────────────────────────── */
    const annInner   = document.getElementById('annCarouselInner');
    const annPrev    = document.getElementById('annPrev');
    const annNext    = document.getElementById('annNext');
    const annBar     = document.getElementById('annProgressBar');
    const annCount   = document.getElementById('annCounter');
    const filterBtns = document.querySelectorAll('.ann-filter-btn');
    const allCards   = Array.from(document.querySelectorAll('.ann-card'));

    if (!annInner) return;

    const cardWidth = () => {
        const c = annInner.querySelector('.ann-card');
        return c ? c.offsetWidth + 16 : 288;
    };

    function updateAnnUI() {
        const visible = allCards.filter(c => c.style.display !== 'none');
        const tot     = visible.length;
        if (!tot) { if (annBar) annBar.style.width = '0%'; if (annCount) annCount.textContent = '0/0'; return; }

        const scrolled = annInner.scrollLeft;
        const maxScroll = annInner.scrollWidth - annInner.clientWidth;
        const pct = maxScroll > 0 ? (scrolled / maxScroll) * 100 : 0;
        if (annBar) annBar.style.width = pct + '%';

        const idx = Math.round(scrolled / cardWidth()) + 1;
        if (annCount) annCount.textContent = Math.min(idx, tot) + '/' + tot;
    }

    annInner.addEventListener('scroll', updateAnnUI);

    if (annPrev) annPrev.addEventListener('click', () => annInner.scrollBy({ left: -cardWidth(), behavior: 'smooth' }));
    if (annNext) annNext.addEventListener('click', () => annInner.scrollBy({ left:  cardWidth(), behavior: 'smooth' }));

    // Filter tabs
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;

            filterBtns.forEach(b => {
                b.classList.remove('bg-primary-600', 'text-white', 'border-primary-600');
                b.classList.add('border-gray-300', 'dark:border-gray-600', 'text-gray-700', 'dark:text-gray-300');
            });
            btn.classList.add('bg-primary-600', 'text-white', 'border-primary-600');
            btn.classList.remove('border-gray-300', 'dark:border-gray-600', 'text-gray-700', 'dark:text-gray-300');

            allCards.forEach(card => {
                const cat  = card.dataset.category;
                const show = filter === 'semua' || cat === filter;
                card.style.display = show ? '' : 'none';
            });

            annInner.scrollLeft = 0;
            setTimeout(updateAnnUI, 50);
        });
    });

    updateAnnUI();

}());
</script>

@endsection