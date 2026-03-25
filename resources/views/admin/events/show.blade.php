@extends('layouts.admin')
@section('title','Detail Kegiatan')
@section('content')
<div class="max-w-3xl space-y-5">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.events.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white flex-1 truncate">{{ $kegiatan->title }}</h2>
        <a href="{{ route('admin.events.edit', $kegiatan) }}" class="px-3 py-1.5 text-xs font-semibold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-lg hover:bg-primary-100 transition">Edit</a>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
        <div class="grid grid-cols-2 gap-5 text-sm">
            @foreach([
                ['Status', ucfirst($kegiatan->status)],
                ['Mulai', $kegiatan->start_date ? \Carbon\Carbon::parse($kegiatan->start_date)->format('d M Y H:i') : '—'],
                ['Selesai', $kegiatan->end_date ? \Carbon\Carbon::parse($kegiatan->end_date)->format('d M Y H:i') : '—'],
                ['Lokasi', $kegiatan->location ?? 'Online'],
                ['Kuota', $kegiatan->quota ?? 'Tidak terbatas'],
                ['Harga', $kegiatan->is_free ? 'Gratis' : 'Rp '.number_format($kegiatan->price)],
            ] as [$l, $v])
            <div><p class="text-xs text-slate-400 mb-1">{{ $l }}</p><p class="font-semibold text-slate-900 dark:text-white">{{ $v }}</p></div>
            @endforeach
            <div class="col-span-2"><p class="text-xs text-slate-400 mb-2">Deskripsi</p><p class="text-slate-700 dark:text-slate-300 text-sm leading-relaxed">{{ $kegiatan->description }}</p></div>
        </div>
    </div>
</div>
@endsection
