@extends('layouts.admin')
@section('title', 'Struktur Organisasi')
@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Struktur Organisasi</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola kepengurusan HPMI</p>
        </div>
        <a href="{{ route('admin.org.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-500/25 transition-all duration-150 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengurus
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($structures as $org)
        <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-lg hover:shadow-slate-200/60 dark:hover:shadow-slate-900/50 hover:-translate-y-0.5 transition-all duration-200">

            {{-- Top color band --}}
            <div class="h-1.5 bg-gradient-to-r from-blue-500 to-violet-500 {{ !$org->is_active ? 'opacity-30' : '' }}"></div>

            <div class="p-5 text-center">
                {{-- Avatar --}}
                <div class="relative inline-block mb-4">
                    @if($org->photo)
                    <img src="{{ Storage::url($org->photo) }}" alt="{{ $org->name }}"
                         class="w-20 h-20 rounded-2xl object-cover ring-4 ring-slate-100 dark:ring-slate-700 {{ !$org->is_active ? 'grayscale opacity-60' : '' }}">
                    @else
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-400 to-violet-500 flex items-center justify-center text-white font-bold text-2xl ring-4 ring-slate-100 dark:ring-slate-700 {{ !$org->is_active ? 'opacity-50' : '' }}">
                        {{ strtoupper(substr($org->name, 0, 1)) }}
                    </div>
                    @endif

                    {{-- Active badge --}}
                    @if($org->is_active)
                    <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-2 border-white dark:border-slate-800 flex items-center justify-center">
                        <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </span>
                    @else
                    <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-slate-400 rounded-full border-2 border-white dark:border-slate-800"></span>
                    @endif
                </div>

                {{-- Info --}}
                <h3 class="font-bold text-slate-900 dark:text-white text-sm leading-tight">{{ $org->name }}</h3>
                <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 mt-1">{{ $org->position }}</p>

                @if($org->period)
                <span class="inline-flex items-center gap-1 mt-2 px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-[10px] font-medium rounded-full">
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $org->period }}
                </span>
                @endif

                @if(!$org->is_active)
                <div class="mt-2">
                    <span class="inline-block text-[10px] font-semibold bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-2.5 py-0.5 rounded-full uppercase tracking-wide">Nonaktif</span>
                </div>
                @endif

                @if($org->bio)
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-2 line-clamp-2 leading-relaxed">{{ $org->bio }}</p>
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex items-center border-t border-slate-100 dark:border-slate-700 divide-x divide-slate-100 dark:divide-slate-700">
                <a href="{{ route('admin.org.edit', $org) }}"
                   class="flex-1 flex items-center justify-center gap-1.5 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.org.destroy', $org) }}"
                      onsubmit="return confirm('Hapus pengurus {{ addslashes($org->name) }}?')" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-1.5 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-4 py-20 text-center">
            <div class="flex flex-col items-center gap-3">
                <div class="w-20 h-20 rounded-2xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                    <svg class="w-10 h-10 text-slate-300 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-slate-400 dark:text-slate-500 font-medium text-sm">Belum ada data kepengurusan</p>
                <a href="{{ route('admin.org.create') }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Tambah pengurus pertama →</a>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($structures->hasPages())
    <div class="pt-2">{{ $structures->links() }}</div>
    @endif

</div>
@endsection