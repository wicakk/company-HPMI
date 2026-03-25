@extends('layouts.app')
@section('title', $event->title)
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('events.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            @if($event->thumbnail)<img src="{{ $event->thumbnail }}" class="w-full h-64 object-cover rounded-2xl mb-6" alt="{{ $event->title }}">@endif
            <h1 class="text-3xl font-black text-slate-900 dark:text-white mb-4 leading-tight">{{ $event->title }}</h1>
            <div class="prose dark:prose-invert text-slate-700 dark:text-slate-300 text-sm leading-relaxed">{!! nl2br(e($event->description)) !!}</div>
        </div>
        <div class="space-y-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Detail Kegiatan</h3>
                @foreach([['icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','label'=>'Tanggal','value'=>\Carbon\Carbon::parse($event->start_date)->format('d F Y, H:i').' WIB','c'=>'violet'],['icon'=>'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z','label'=>'Lokasi','value'=>$event->location??'Online','c'=>'blue'],['icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z','label'=>'Biaya','value'=>$event->is_free||$event->price==0?'Gratis':'Rp '.number_format($event->price),'c'=>'emerald'],['icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','label'=>'Kuota','value'=>$event->quota?number_format($event->quota).' peserta':'Tidak dibatasi','c'=>'pink']] as $d)
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-{{ $d['c'] }}-100 dark:bg-{{ $d['c'] }}-900/20 rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-{{ $d['c'] }}-600 dark:text-{{ $d['c'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $d['icon'] }}"/></svg></div>
                    <div><p class="text-xs text-slate-400">{{ $d['label'] }}</p><p class="font-bold text-slate-900 dark:text-white text-sm mt-0.5">{{ $d['value'] }}</p></div>
                </div>
                @endforeach
            </div>
            @if($event->status === 'open')
            @auth
            <a href="{{ route('member.events.show', $event->id) }}" class="flex items-center justify-center gap-2 w-full py-3.5 bg-gradient-to-r from-violet-500 to-violet-600 text-white font-bold rounded-2xl shadow-lg shadow-violet-500/30 transition hover:from-violet-600 hover:to-violet-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Daftar Kegiatan
            </a>
            @else
            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full py-3.5 bg-gradient-to-r from-violet-500 to-violet-600 text-white font-bold rounded-2xl shadow-lg shadow-violet-500/30 transition hover:from-violet-600 hover:to-violet-700">
                Masuk untuk Mendaftar
            </a>
            @endauth
            @elseif($event->meeting_url)
            <a href="{{ $event->meeting_url }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-3.5 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-bold rounded-2xl shadow-lg shadow-purple-500/30 transition hover:from-purple-600 hover:to-purple-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.866v6.268a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                Bergabung Online
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
