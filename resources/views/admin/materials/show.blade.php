@extends('layouts.admin')
@section('title', 'Detail Materi')
@section('content')

<div class="space-y-5 max-w-2xl">
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.materials.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <h2 class="text-lg font-black text-slate-900 dark:text-white">Detail Materi</h2>
  </div>

  <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="h-1.5 bg-gradient-to-r from-emerald-500 to-teal-600"></div>
    <div class="p-6 space-y-5">
      <div class="flex items-start gap-4">
        @php
          $typeClasses = ['video'=>'bg-violet-50 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400','link'=>'bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400'];
          $tc = $typeClasses[$material->type ?? ''] ?? 'bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400';
        @endphp
        <div class="w-12 h-12 rounded-xl {{ $tc }} flex items-center justify-center flex-shrink-0">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            @if(($material->type??'')=='video')
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 6h10v12H5z"/>
            @else
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            @endif
          </svg>
        </div>
        <div class="flex-1">
          <h3 class="text-base font-bold text-slate-900 dark:text-white leading-snug">{{ $material->title }}</h3>
          <div class="flex items-center gap-2 mt-1">
            <span class="inline-flex px-2 py-0.5 text-xs font-semibold {{ $tc }} rounded-lg">{{ strtoupper($material->type ?? 'PDF') }}</span>
            @if($material->is_member_only)
            <span class="inline-flex px-2 py-0.5 text-xs font-semibold bg-violet-50 dark:bg-violet-900/20 text-violet-700 dark:text-violet-400 rounded-lg">Member Only</span>
            @endif
          </div>
        </div>
      </div>

      @if($material->description)
      <div class="bg-slate-50 dark:bg-slate-700/40 rounded-xl p-4">
        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{{ $material->description }}</p>
      </div>
      @endif

      <div class="grid grid-cols-2 gap-3">
        @foreach([
          ['Kategori', $material->category->name ?? '—'],
          ['Download', number_format($material->downloads ?? 0).' kali'],
          ['Dibuat', $material->created_at->format('d M Y')],
          ['Diperbarui', $material->updated_at->format('d M Y')],
        ] as [$lbl,$val])
        <div class="bg-slate-50 dark:bg-slate-700/40 rounded-xl p-3">
          <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">{{ $lbl }}</p>
          <p class="text-sm font-semibold text-slate-800 dark:text-white">{{ $val }}</p>
        </div>
        @endforeach
      </div>

      <div class="flex gap-3">
        @if($material->file_url)
        <a href="{{ $material->file_url }}" target="_blank" class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shadow-emerald-500/25">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
          Buka File
        </a>
        @endif
        <a href="{{ route('admin.materials.edit', $material) }}" class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50 text-sm font-semibold rounded-xl hover:bg-amber-100 dark:hover:bg-amber-900/30 transition-all">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
          Edit
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
