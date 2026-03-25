@extends('layouts.admin')
@section('title','Struktur Organisasi')
@section('subtitle','Kelola kepengurusan HPMI')
@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-cyan-100 dark:bg-cyan-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $structures->total() }} pengurus</p>
                <p class="text-xs text-slate-500">Aktif & nonaktif</p>
            </div>
        </div>
        <a href="{{ route('admin.org.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-cyan-500/30 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengurus
        </a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4">
        @forelse($structures as $strukturOrganisasi)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 text-center hover:shadow-lg transition-all group {{ !$strukturOrganisasi->is_active ? 'opacity-60' : '' }}">
            @if($strukturOrganisasi->photo)
            <img src="{{ $strukturOrganisasi->photo }}" class="w-20 h-20 rounded-2xl object-cover mx-auto mb-3 ring-4 ring-cyan-100 dark:ring-cyan-900/30 group-hover:ring-cyan-200 transition" alt="{{ $strukturOrganisasi->name }}">
            @else
            <div class="w-20 h-20 bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto mb-3 shadow-lg shadow-cyan-500/30">{{ substr($strukturOrganisasi->name,0,1) }}</div>
            @endif
            <h3 class="font-bold text-slate-900 dark:text-white text-sm leading-tight">{{ $strukturOrganisasi->name }}</h3>
            <p class="text-xs text-cyan-600 dark:text-cyan-400 mt-1 font-semibold">{{ $strukturOrganisasi->position }}</p>
            <p class="text-xs text-slate-400 mt-0.5">{{ $strukturOrganisasi->period }}</p>
            @if(!$strukturOrganisasi->is_active)
            <span class="inline-block mt-2 text-xs bg-slate-100 dark:bg-slate-800 text-slate-500 px-2 py-0.5 rounded-lg">Nonaktif</span>
            @endif
            <div class="flex justify-center gap-2 mt-4 pt-3 border-t border-slate-100 dark:border-slate-800">
                <a href="{{ route('admin.org.edit', $strukturOrganisasi) }}" class="flex-1 py-1.5 text-xs font-semibold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-xl hover:bg-primary-100 transition">Edit</a>
                <form method="POST" action="{{ route('admin.org.destroy', $strukturOrganisasi) }}" onsubmit="return confirm('Hapus pengurus ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-xl hover:bg-red-100 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-5 py-20 text-center text-slate-400">
            <svg class="w-14 h-14 mx-auto mb-3 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <p class="text-sm">Belum ada data kepengurusan</p>
        </div>
        @endforelse
    </div>
    @if($structures->hasPages())<div class="mt-4">{{ $structures->links() }}</div>@endif
</div>
@endsection
