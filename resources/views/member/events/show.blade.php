@extends('layouts.app')
@section('title',$event->title)
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('member.events') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-lg font-bold text-slate-900 dark:text-white truncate">{{ $event->title }}</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                @if($event->thumbnail)<img src="{{ $event->thumbnail }}" class="w-full h-56 object-cover" alt="{{ $event->title }}">@endif
                <div class="p-7">
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white mb-4">{{ $event->title }}</h2>
                    <div class="prose prose-sm prose-slate dark:prose-invert max-w-none text-slate-600 dark:text-slate-400 leading-relaxed">{!! nl2br(e($event->description)) !!}</div>
                </div>
            </div>
        </div>
        <div class="space-y-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-5">Info Kegiatan</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-violet-100 dark:bg-violet-900/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div><p class="text-xs text-slate-400 mb-0.5">Tanggal</p><p class="font-semibold text-slate-900 dark:text-white text-sm">{{ \Carbon\Carbon::parse($event->start_date)->format('d F Y, H:i') }}</p></div>
                    </li>
                    @if($event->location)
                    <li class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-blue-100 dark:bg-blue-900/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div><p class="text-xs text-slate-400 mb-0.5">Lokasi</p><p class="font-semibold text-slate-900 dark:text-white text-sm">{{ $event->location }}</p></div>
                    </li>
                    @endif
                    <li class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-emerald-100 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <div><p class="text-xs text-slate-400 mb-0.5">Biaya</p><p class="font-semibold text-slate-900 dark:text-white text-sm">{{ $event->is_free || $event->price==0 ? 'Gratis' : 'Rp '.number_format($event->price) }}</p></div>
                    </li>
                </ul>
            </div>

            @if($registered)
            <div class="flex items-center justify-center gap-2 py-3.5 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm font-bold rounded-2xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Anda Sudah Terdaftar
            </div>
            <form method="POST" action="{{ route('member.events.cancel', $event->id) }}">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Batalkan pendaftaran ini?')" class="w-full py-2.5 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-xl hover:bg-red-100 transition">
                    Batalkan Pendaftaran
                </button>
            </form>
            @elseif($event->status==='open')
            <form method="POST" action="{{ route('member.events.register', $event->id) }}">
                @csrf
                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-violet-500 to-violet-600 hover:from-violet-600 hover:to-violet-700 text-white font-bold text-sm rounded-2xl shadow-lg shadow-violet-500/30 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Daftar Kegiatan
                </button>
            </form>
            @endif
            @if($event->meeting_url)
            <a href="{{ $event->meeting_url }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-2xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.866v6.268a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                Join Meeting Online
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
