
@extends('layouts.app')

@section('title', $layanan->nama)

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-blue-600 to-blue-800 py-12 text-white">
    <div class="max-w-7xl mx-auto px-6">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-blue-200 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('layanan.index') }}" class="hover:text-white transition">Layanan</a>
            <span>/</span>
            <span class="text-white font-medium">{{ $layanan->nama }}</span>
        </nav>

        <div class="flex items-start gap-5">
            <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center text-4xl shrink-0">
                {{ $layanan->ikon ?? '🏥' }}
            </div>
            <div>
                <span class="inline-block bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">
                    {{ $layanan->kategori }}
                </span>
                <h1 class="text-3xl font-bold">{{ $layanan->nama }}</h1>
                <p class="text-blue-100 mt-2 text-lg max-w-2xl">{{ $layanan->deskripsi_singkat }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Konten --}}
<section class="py-14">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Konten Utama --}}
            <div class="lg:col-span-2">

                @if($layanan->gambar_url)
                <img src="{{ $layanan->gambar_url }}" alt="{{ $layanan->nama }}"
                     class="w-full h-64 object-cover rounded-2xl mb-8 shadow-sm">
                @endif

                @if($layanan->deskripsi_lengkap)
                <div class="prose prose-blue prose-sm max-w-none text-gray-700 leading-relaxed">
                    {!! $layanan->deskripsi_lengkap !!}
                </div>
                @else
                <p class="text-gray-600 leading-relaxed">{{ $layanan->deskripsi_singkat }}</p>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">

                {{-- Info Layanan --}}
                <div class="bg-blue-50 rounded-2xl p-6">
                    <h3 class="text-sm font-bold text-blue-900 mb-4 uppercase tracking-wide">Info Layanan</h3>
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-gray-500 text-xs">Kategori</dt>
                            <dd class="font-semibold text-gray-800 mt-0.5">{{ $layanan->kategori }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-xs">Status</dt>
                            <dd class="mt-0.5">
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    <span class="font-semibold text-green-700">Tersedia</span>
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Hubungi --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-3">Daftar / Hubungi</h3>
                    <p class="text-xs text-gray-500 mb-4">Hubungi kami untuk informasi jadwal dan pendaftaran.</p>
                    <a href="{{ route('contact') }}"
                       class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-3 rounded-xl transition">
                        Contact Sekarang
                    </a>
                </div>

                {{-- Layanan Lain --}}
                @if($related->isNotEmpty())
                <div>
                    <h3 class="text-sm font-bold text-gray-700 mb-3">Layanan Terkait</h3>
                    <div class="space-y-2">
                        @foreach($related as $rel)
                        <a href="{{ route('layanan.show', $rel->slug) }}"
                           class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition group">
                            <span class="text-xl">{{ $rel->ikon ?? '🏥' }}</span>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700 transition">{{ $rel->nama }}</span>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500 ml-auto transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <a href="{{ route('home') }}"
                   class="flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Lihat Semua Layanan
                </a>

            </aside>
        </div>
    </div>
</section>

@endsection