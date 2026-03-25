@extends('layouts.admin')
@section('title','Kegiatan')
@section('subtitle','Kelola seminar, webinar & pelatihan')
@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-violet-100 dark:bg-violet-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $events->total() }} kegiatan</p>
                <p class="text-xs text-slate-500">Semua kegiatan HPMI</p>
            </div>
        </div>
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-violet-500 to-violet-600 hover:from-violet-600 hover:to-violet-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-violet-500/30 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kegiatan
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($events as $kegiatan)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden hover:shadow-lg hover:shadow-slate-200/60 dark:hover:shadow-slate-900 transition-all group">
            @if($kegiatan->thumbnail)
            <div class="h-36 overflow-hidden"><img src="{{ $kegiatan->thumbnail }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $kegiatan->title }}"></div>
            @else
            <div class="h-36 bg-gradient-to-br from-violet-100 via-purple-100 to-indigo-100 dark:from-violet-900/30 dark:to-indigo-900/30 flex items-center justify-center">
                <svg class="w-12 h-12 text-violet-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            @endif
            <div class="p-5">
                @php $ss=['open'=>'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400','draft'=>'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400','closed'=>'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400','completed'=>'bg-blue-100 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400'];$sl=['open'=>'Buka','draft'=>'Draft','closed'=>'Tutup','completed'=>'Selesai']; @endphp
                <div class="flex items-start justify-between gap-2 mb-3">
                    <h3 class="font-bold text-slate-900 dark:text-white text-sm leading-snug line-clamp-2">{{ $kegiatan->title }}</h3>
                    <span class="text-xs font-semibold px-2 py-1 rounded-lg flex-shrink-0 {{ $ss[$kegiatan->status]??'bg-slate-100 text-slate-600' }}">{{ $sl[$kegiatan->status]??$kegiatan->status }}</span>
                </div>
                <div class="space-y-1.5 text-xs text-slate-500 dark:text-slate-400 mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ \Carbon\Carbon::parse($kegiatan->start_date)->format('d M Y') }}
                    </div>
                    @if($kegiatan->location)
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ Str::limit($kegiatan->location,35) }}
                    </div>
                    @endif
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Kuota: {{ $kegiatan->quota ?? '∞' }}
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('admin.events.edit', $kegiatan) }}" class="flex-1 text-center py-2 text-xs font-semibold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-xl hover:bg-primary-100 transition">Edit</a>
                    <form method="POST" action="{{ route('admin.events.destroy', $kegiatan) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-xl hover:bg-red-100 transition">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 py-20 text-center text-slate-400">
            <svg class="w-14 h-14 mx-auto mb-3 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-sm">Belum ada kegiatan</p>
        </div>
        @endforelse
    </div>
    @if($events->hasPages())<div class="mt-4">{{ $events->links() }}</div>@endif
</div>
@endsection
