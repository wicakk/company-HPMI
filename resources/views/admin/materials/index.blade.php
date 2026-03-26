@extends('layouts.admin')
@section('title', 'Materi Edukasi')
@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Materi Edukasi</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Kelola modul, PDF, dan video pembelajaran
            </p>
        </div>

        <a href="{{ route('admin.materials.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-500/25 transition active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor">
                <path stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Upload Materi
        </a>
    </div>

    {{-- Stats --}}
    @php
        $total = $materials->total();
        $pdf   = $materials->getCollection()->where('type','pdf')->count();
        $video = $materials->getCollection()->where('type','video')->count();
    @endphp

    <div class="grid grid-cols-3 gap-4">
        {{-- Total --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor">
                    <path stroke-width="2" d="M19 11H5m14-4H5m14 8H5"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $total }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Total Materi</p>
            </div>
        </div>

        {{-- PDF --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-red-50 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor">
                    <path stroke-width="2" d="M7 16V4h10v12M7 16l5 4 5-4"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $pdf }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">PDF</p>
            </div>
        </div>

        {{-- Video --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor">
                    <path stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 6h10v12H5z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $video }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Video</p>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Materi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Tipe</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Akses</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Download</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                    @forelse($materials as $mat)
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/20 transition-colors group">

                        {{-- Materi --}}
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 transition">
                                {{ $mat->title }}
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ $mat->category->name ?? 'Tanpa Kategori' }}
                            </p>
                        </td>

                        {{-- Tipe --}}
                        <td class="px-6 py-4">
                            @php
                                $tc = [
                                    'pdf' => 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400',
                                    'video' => 'bg-purple-50 text-purple-700 dark:bg-purple-900/20 dark:text-purple-400',
                                    'module' => 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400',
                                ];
                            @endphp
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $tc[$mat->type] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ strtoupper($mat->type) }}
                            </span>
                        </td>

                        {{-- Akses --}}
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium
                                {{ $mat->is_member_only ? 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400' }}">
                                {{ $mat->is_member_only ? 'Member' : 'Publik' }}
                            </span>
                        </td>

                        {{-- Download --}}
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-medium tabular-nums">
                            {{ number_format($mat->downloads) }}
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-1">

                                {{-- Edit --}}
                                <a href="{{ route('admin.materials.edit', $mat) }}"
                                   class="p-2 rounded-lg text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor">
                                        <path stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L12 14l-4 1 1-4 7.5-7.5z"/>
                                    </svg>
                                </a>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('admin.materials.destroy', $mat) }}"
                                      onsubmit="return confirm('Hapus materi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor">
                                            <path stroke-width="2" d="M19 7l-1 12H6L5 7m5 4v6m4-6v6M9 7V4h6v3"/>
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-300 dark:text-slate-500" fill="none" stroke="currentColor">
                                        <path stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400 dark:text-slate-500 text-sm font-medium">
                                    Belum ada materi
                                </p>
                                <a href="{{ route('admin.materials.create') }}"
                                   class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    Upload pertama →
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($materials->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
            {{ $materials->links() }}
        </div>
        @endif
    </div>

</div>
@endsection