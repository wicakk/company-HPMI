@extends('layouts.app')
@section('title','Kegiatan')
@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <p class="text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-widest mb-2">Program & Kegiatan</p>
        <h1 class="text-4xl font-black text-slate-900 dark:text-white">Kegiatan HPMI</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-3">Seminar, webinar, pelatihan & workshop keperawatan manajemen</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
        <a href="{{ route('events.show', $event->slug) }}" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all group">
            <div class="h-48 overflow-hidden bg-gradient-to-br from-violet-100 to-indigo-100 dark:from-violet-900/30 dark:to-indigo-900/30">
                @if($event->thumbnail)<img src="{{ $event->thumbnail }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $event->title }}">@else<div class="w-full h-full flex items-center justify-center"><svg class="w-12 h-12 text-violet-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>@endif
            </div>
            <div class="p-5">
                @php $ss=['open'=>'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400','closed'=>'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400','completed'=>'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400'];$sl=['open'=>'Buka Pendaftaran','closed'=>'Pendaftaran Ditutup','completed'=>'Selesai']; @endphp
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-violet-600 dark:text-violet-400">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-lg {{ $ss[$event->status]??'bg-slate-100 text-slate-600' }}">{{ $sl[$event->status]??$event->status }}</span>
                </div>
                <h2 class="font-black text-slate-900 dark:text-white line-clamp-2 mb-3">{{ $event->title }}</h2>
                <div class="space-y-1 text-xs text-slate-400">
                    @if($event->location)<div class="flex items-center gap-1 truncate"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>{{ Str::limit($event->location,40) }}</div>@endif
                    <div class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>{{ $event->is_free || $event->price==0 ? 'Gratis' : 'Rp '.number_format($event->price) }}</div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-3 py-20 text-center text-slate-400">
            <svg class="w-14 h-14 mx-auto mb-3 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p>Belum ada kegiatan</p>
        </div>
        @endforelse
    </div>
    @if($events->hasPages())<div class="mt-10">{{ $events->withQueryString()->links() }}</div>@endif
</div>
@endsection
