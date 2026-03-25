@extends('layouts.admin')
@section('title','Detail Pengumuman')
@section('content')
<div class="max-w-2xl space-y-5">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.announcements.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white flex-1">{{ $pengumuman->title }}</h2>
        <a href="{{ route('admin.announcements.edit', $pengumuman) }}" class="px-3 py-1.5 text-xs font-semibold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-lg hover:bg-primary-100 transition">Edit</a>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
        <div class="flex gap-2 mb-4 flex-wrap">
            @if($pengumuman->is_pinned)<span class="text-xs font-semibold bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 px-2.5 py-1 rounded-lg">📌 Pinned</span>@endif
            <span class="text-xs font-semibold {{ $pengumuman->is_member_only ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400' }} px-2.5 py-1 rounded-lg">{{ $pengumuman->is_member_only ? 'Anggota' : 'Publik' }}</span>
            <span class="text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-2.5 py-1 rounded-lg">{{ ucfirst($pengumuman->type) }}</span>
        </div>
        <div class="text-slate-700 dark:text-slate-300 leading-relaxed text-sm whitespace-pre-wrap">{{ $pengumuman->content }}</div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 text-xs text-slate-400 flex gap-4">
            <span>Terbit: {{ $pengumuman->published_at ? \Carbon\Carbon::parse($pengumuman->published_at)->format('d M Y') : '—' }}</span>
            <span>Kadaluarsa: {{ $pengumuman->expired_at ? \Carbon\Carbon::parse($pengumuman->expired_at)->format('d M Y') : 'Tidak ada' }}</span>
        </div>
    </div>
</div>
@endsection
