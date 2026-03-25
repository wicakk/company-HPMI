@extends('layouts.app')
@section('title','Tentang HPMI')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">
    {{-- Hero --}}
    <div class="text-center">
        <p class="text-xs font-bold text-primary-600 dark:text-primary-400 uppercase tracking-widest mb-2">Mengenal Lebih Dekat</p>
        <h1 class="text-4xl font-black text-slate-900 dark:text-white mb-4">Tentang HPMI</h1>
        <p class="text-lg text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">Himpunan Perawat Manajer Indonesia (HPMI) adalah organisasi profesi yang menghimpun dan mengembangkan kompetensi perawat manajer di Indonesia.</p>
    </div>
    {{-- Visi Misi --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-3xl p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-10 translate-x-10"></div>
            <div class="relative">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h2 class="text-xl font-black mb-3">Visi</h2>
                <p class="text-primary-200 leading-relaxed">Menjadi organisasi profesi perawat manajer yang terdepan dalam pengembangan ilmu dan praktik manajemen keperawatan di Indonesia.</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8">
            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center mb-5">
                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
            <h2 class="text-xl font-black text-slate-900 dark:text-white mb-3">Misi</h2>
            <ul class="space-y-2.5">
                @foreach(['Meningkatkan kompetensi dan profesionalisme perawat manajer','Mengembangkan riset dan inovasi dalam manajemen keperawatan','Menjalin kerjasama nasional dan internasional','Memberikan advokasi kebijakan profesi keperawatan','Membangun jaringan antar perawat manajer Indonesia'] as $m)
                <li class="flex items-start gap-2.5 text-sm text-slate-600 dark:text-slate-400">
                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ $m }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    {{-- CTA --}}
    <div class="text-center">
        <a href="{{ route('about.structure') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-500/30 transition mr-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Lihat Struktur Organisasi
        </a>
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-500/30 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Bergabung Sekarang
        </a>
    </div>
</div>
@endsection
