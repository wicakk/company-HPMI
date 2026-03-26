@extends('layouts.app')
@section('title', 'Beranda - ' . ($settings['org_name']?->value ?? 'HPMI'))

@php
    // Helper: ambil value setting dengan fallback
    $s = fn(string $key, string $default = '') => $settings[$key]?->value ?? $default;
@endphp

@section('content')

{{-- SLIDESHOW BANNER --}}
<div class="relative w-full max-w-full p-32 mx-auto py-16 overflow-hidden bg-primary-50 dark:bg-primary-900/10" style="perspective:1200px;">
    
    <!-- Track -->
    <div id="carouselTrack" class="relative w-full h-64">
        
        <!-- Slide -->
        <a href="#" class="carousel-slide absolute w-64 h-64 rounded-2xl shadow-lg bg-cover bg-center transition-all duration-500"
           style="background-image: url('https://images.unsplash.com/photo-1588776814546-1c0c7c86d50d?w=900&q=80')">
            <div class="absolute bottom-4 left-4 text-dark">
                <h3 class="font-bold text-lg">Kegiatan Pelatihan Medis</h3>
                <span class="text-xs text-dark/80">Selengkapnya →</span>
            </div>
        </a>

        <a href="#" class="carousel-slide absolute w-64 h-64 rounded-2xl shadow-lg bg-cover bg-center transition-all duration-500"
           style="background-image: url('https://images.unsplash.com/photo-1579154203451-4f06e6d1780e?w=900&q=80')">
            <div class="absolute bottom-4 left-4 text-dark">
                <h3 class="font-bold text-lg">Seminar Kesehatan Nasional</h3>
                <span class="text-xs text-dark/80">Selengkapnya →</span>
            </div>
        </a>

        <a href="#" class="carousel-slide absolute w-64 h-64 rounded-2xl shadow-lg bg-cover bg-center transition-all duration-500"
           style="background-image: url('https://images.unsplash.com/photo-1581091870622-90df50b79819?w=900&q=80')">
            <div class="absolute bottom-4 left-4 text-dark">
                <h3 class="font-bold text-lg">Donor Darah Bersama</h3>
                <span class="text-xs text-dark/80">Selengkapnya →</span>
            </div>
        </a>

        <a href="#" class="carousel-slide absolute w-64 h-64 rounded-2xl shadow-lg bg-cover bg-center transition-all duration-500"
           style="background-image: url('https://images.unsplash.com/photo-1588776814546-1c0c7c86d50d?w=900&q=80')">
            <div class="absolute bottom-4 left-4 text-dark">
                <h3 class="font-bold text-lg">Kunjungan RS Anggota</h3>
                <span class="text-xs text-dark/80">Selengkapnya →</span>
            </div>
        </a>

        <a href="#" class="carousel-slide absolute w-64 h-64 rounded-2xl shadow-lg bg-cover bg-center transition-all duration-500"
           style="background-image: url('https://images.unsplash.com/photo-1579154203451-4f06e6d1780e?w=900&q=80')">
            <div class="absolute bottom-4 left-4 text-dark">
                <h3 class="font-bold text-lg">Workshop RS</h3>
                <span class="text-xs text-dark/80">Selengkapnya →</span>
            </div>
        </a>

    </div>

    <!-- Navigation -->
    <button id="prevBtn" class="absolute top-1/2 left-2 -translate-y-1/2 w-10 h-10 bg-white/80 rounded-full shadow flex items-center justify-center">‹</button>
    <button id="nextBtn" class="absolute top-1/2 right-2 -translate-y-1/2 w-10 h-10 bg-white/80 rounded-full shadow flex items-center justify-center">›</button>

</div>
{{-- END SLIDESHOW BANNER --}}

{{-- Hero --}}
<section class="relative bg-gradient-to-br from-primary-700 via-primary-600 to-primary-800 text-white py-24 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-accent-400 rounded-full filter blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
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
            <div>
                <div class="text-4xl font-bold text-primary-600 dark:text-primary-400">{{ number_format($stats['members']) }}+</div>
                <div class="text-gray-500 dark:text-gray-400 mt-1">Anggota Aktif</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-primary-600 dark:text-primary-400">{{ number_format($stats['events']) }}+</div>
                <div class="text-gray-500 dark:text-gray-400 mt-1">Kegiatan Terlaksana</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-primary-600 dark:text-primary-400">{{ number_format($stats['articles']) }}+</div>
                <div class="text-gray-500 dark:text-gray-400 mt-1">Artikel Edukasi</div>
            </div>
        </div>
    </div>
</section>

{{-- Announcements --}}
@if($announcements->count())
<section class="py-12 bg-primary-50 dark:bg-primary-900/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-3">
            @foreach($announcements as $ann)
            <div class="flex items-start gap-3 bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-primary-100 dark:border-gray-700">
                @if($ann->is_pinned)<span class="flex-shrink-0 mt-0.5 w-5 h-5 text-primary-600">📌</span>@endif
                <div>
                    <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $ann->title }}</span>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ Str::limit($ann->content, 120) }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Latest Articles --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Artikel Terbaru</h2>
            <a href="{{ route('articles.index') }}" class="text-primary-600 dark:text-primary-400 text-sm hover:underline">Lihat semua →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
            <article class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition group">
                <div class="h-44 bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900 dark:to-primary-800 flex items-center justify-center">
                    <svg class="w-12 h-12 text-primary-300 dark:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2"/>
                    </svg>
                </div>
                <div class="p-5">
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
<section class="py-20 mx-20 md:mx-5 rounded-3xl bg-primary-600 dark:bg-primary-800 text-white text-center">
    <div class="max-w-2xl mx-auto px-4">
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

<script>
(function(){
    const track = document.getElementById('carouselTrack');
    const slides = track.querySelectorAll('.carousel-slide');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    let current = 0;

    function updateSlides(){
        const total = slides.length;

        slides.forEach((slide,i)=>{
            const offset = i - current;

            const scale = i === current ? 1 : 0.7;
            const rotateY = offset * 20;
            const translateX = offset * 360;
            const translateZ = i === current ? 0 : -200;

            slide.style.transform =
                `translateX(${translateX}px)
                 translateZ(${translateZ}px)
                 rotateY(${rotateY}deg)
                 scale(${scale})`;

            slide.style.zIndex = total - Math.abs(offset);
            slide.style.opacity = i === current ? 1 : 0.5;
        });
    }

    function next(){
        current = (current + 1) % slides.length;
        updateSlides();
    }

    function prev(){
        current = (current - 1 + slides.length) % slides.length;
        updateSlides();
    }

    nextBtn.onclick = next;
    prevBtn.onclick = prev;

    // autoplay
    setInterval(next, 4000);

    updateSlides();
})();
</script>

@endsection