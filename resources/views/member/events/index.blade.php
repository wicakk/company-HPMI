@extends('layouts.app')
@section('title','Kegiatan')
@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ tab: 'upcoming' }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-violet-100 dark:bg-violet-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white">Kegiatan HPMI</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Seminar, webinar & pelatihan</p>
            </div>
        </div>
        {{-- Tabs --}}
        <div class="flex bg-slate-100 dark:bg-slate-800 rounded-xl p-1 gap-1">
            <button @click="tab='upcoming'" :class="tab==='upcoming' ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'" class="px-4 py-2 text-xs font-semibold rounded-lg transition">Mendatang</button>
            <button @click="tab='registered'" :class="tab==='registered' ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'" class="px-4 py-2 text-xs font-semibold rounded-lg transition">Terdaftar</button>
        </div>
    </div>

    {{-- Upcoming Events --}}
    <div x-show="tab==='upcoming'">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($events as $event)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden hover:shadow-xl transition-all group hover:-translate-y-0.5">
                @if($event->thumbnail)
                <div class="h-44 overflow-hidden"><img src="{{ $event->thumbnail }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $event->title }}"></div>
                @else
                <div class="h-44 bg-gradient-to-br from-violet-100 to-indigo-100 dark:from-violet-900/30 dark:to-indigo-900/30 flex items-center justify-center">
                    <svg class="w-12 h-12 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                @endif
                <div class="p-5">
                    @php $ss=['open'=>'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400','closed'=>'bg-red-100 text-red-700','completed'=>'bg-slate-100 text-slate-500']; @endphp
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm leading-snug line-clamp-2">{{ $event->title }}</h3>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-lg flex-shrink-0 {{ $ss[$event->status]??'bg-slate-100 text-slate-500' }}">{{ $event->status==='open'?'Buka':($event->status==='closed'?'Tutup':'Selesai') }}</span>
                    </div>
                    <div class="space-y-1.5 text-xs text-slate-500 dark:text-slate-400 mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                        </div>
                        @if($event->location)
                        <div class="flex items-center gap-2 truncate">
                            <svg class="w-3.5 h-3.5 text-violet-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="truncate">{{ Str::limit($event->location, 30) }}</span>
                        </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            {{ $event->is_free || $event->price == 0 ? 'Gratis' : 'Rp '.number_format($event->price) }}
                        </div>
                    </div>
                    @php $isRegistered = $event->registrations->where('user_id', auth()->id())->count() > 0; @endphp
                    @if($isRegistered)
                    <div class="w-full py-2.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-bold rounded-xl text-center flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Sudah Terdaftar
                    </div>
                    @elseif($event->status === 'open')
                    <form method="POST" action="{{ route('member.events.register', $event->id) }}">
                        @csrf
                        <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-violet-500 to-violet-600 hover:from-violet-600 hover:to-violet-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-violet-500/20 transition">
                            Daftar Sekarang
                        </button>
                    </form>
                    @else
                    <div class="w-full py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-400 text-xs font-semibold rounded-xl text-center">Pendaftaran Ditutup</div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-3 py-20 text-center text-slate-400">
                <svg class="w-14 h-14 mx-auto mb-4 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-sm font-medium">Tidak ada kegiatan tersedia</p>
            </div>
            @endforelse
        </div>
        @if($events->hasPages())<div class="mt-6">{{ $events->links() }}</div>@endif
    </div>

    {{-- Registered Events --}}
    <div x-show="tab==='registered'" x-cloak>
        @php $myRegistrations = auth()->user()->eventRegistrations()->with('event')->latest()->get(); @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($myRegistrations as $reg)
            @if($reg->event)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="h-36 bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 flex items-center justify-center">
                    @if($reg->event->thumbnail)
                    <img src="{{ $reg->event->thumbnail }}" class="w-full h-full object-cover" alt="{{ $reg->event->title }}">
                    @else
                    <svg class="w-10 h-10 text-emerald-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @endif
                </div>
                <div class="p-5">
                    <div class="inline-flex items-center gap-1.5 text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-2.5 py-1 rounded-lg mb-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Terdaftar
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-sm leading-snug line-clamp-2 mb-2">{{ $reg->event->title }}</h3>
                    <p class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($reg->event->start_date)->format('d M Y') }}</p>
                    @if($reg->event->meeting_url)
                    <a href="{{ $reg->event->meeting_url }}" target="_blank" class="mt-3 flex items-center justify-center gap-1.5 w-full py-2.5 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-xs font-bold rounded-xl transition hover:from-purple-600 hover:to-purple-700">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.866v6.268a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                        Bergabung Online
                    </a>
                    @endif
                    <form method="POST" action="{{ route('member.events.cancel', $reg->event->id) }}" onsubmit="return confirm('Batalkan pendaftaran?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="mt-2 w-full py-2 text-xs font-semibold text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition">Batalkan Pendaftaran</button>
                    </form>
                </div>
            </div>
            @endif
            @empty
            <div class="col-span-3 py-20 text-center text-slate-400">
                <svg class="w-14 h-14 mx-auto mb-4 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="text-sm font-medium">Belum ada kegiatan yang didaftarkan</p>
                <button @click="tab='upcoming'" class="mt-3 text-sm font-semibold text-primary-600 dark:text-primary-400 hover:underline">Lihat kegiatan tersedia →</button>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
