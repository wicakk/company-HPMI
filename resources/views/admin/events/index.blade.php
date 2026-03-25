@extends('layouts.admin')
@section('title', 'Manajemen Kegiatan')
@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Manajemen Kegiatan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Kelola seminar, webinar, dan pelatihan</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kegiatan
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($events as $event)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
            @if($event->thumbnail)
            <img src="{{ $event->thumbnail }}" class="w-full h-36 object-cover" alt="{{ $event->title }}">
            @else
            <div class="w-full h-36 bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/30 dark:to-primary-800/30 flex items-center justify-center">
                <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            @endif
            <div class="p-5">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm leading-snug">{{ $event->title }}</h3>
                    @php $ss=['open'=>'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400','draft'=>'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400','closed'=>'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400','completed'=>'bg-blue-100 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400'];$sl=['open'=>'Buka','draft'=>'Draft','closed'=>'Tutup','completed'=>'Selesai']; @endphp
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium flex-shrink-0 {{ $ss[$event->status]??'' }}">{{ $sl[$event->status]??$event->status }}</span>
                </div>
                <div class="space-y-1 text-xs text-gray-500 dark:text-gray-400">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ Str::limit($event->location, 40) }}
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Quota: {{ $event->quota ?? '∞' }}
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.events.edit', $event) }}" class="flex-1 text-center text-xs text-primary-600 dark:text-primary-400 hover:underline font-medium">Edit</a>
                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 py-16 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-sm">Belum ada kegiatan</p>
        </div>
        @endforelse
    </div>
    @if($events->hasPages())
    <div>{{ $events->links() }}</div>
    @endif
</div>
@endsection
