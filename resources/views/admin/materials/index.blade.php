@extends('layouts.admin')
@section('title', 'Materi Edukasi')
@section('content')

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-emerald-500 dark:text-emerald-400 mb-1">Edukasi</p>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Materi Edukasi</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola modul, PDF, dan video pembelajaran</p>
    </div>
    <a href="{{ route('admin.materials.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-emerald-500/25 transition-all active:scale-95">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
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
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-4 flex items-center gap-3 hover:shadow-md dark:hover:shadow-slate-900/50 transition-all">
      <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4H5m14 8H5"/></svg>
      </div>
      <div>
        <p class="text-2xl font-black text-slate-900 dark:text-white leading-none">{{ $total }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Total Materi</p>
      </div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-4 flex items-center gap-3 hover:shadow-md dark:hover:shadow-slate-900/50 transition-all">
      <div class="w-10 h-10 bg-red-50 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
      </div>
      <div>
        <p class="text-2xl font-black text-slate-900 dark:text-white leading-none">{{ $pdf }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Dokumen PDF</p>
      </div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-4 flex items-center gap-3 hover:shadow-md dark:hover:shadow-slate-900/50 transition-all">
      <div class="w-10 h-10 bg-violet-50 dark:bg-violet-900/30 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 6h10v12H5z"/></svg>
      </div>
      <div>
        <p class="text-2xl font-black text-slate-900 dark:text-white leading-none">{{ $video }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Video</p>
      </div>
    </div>
  </div>

  {{-- Table --}}
  <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-slate-100 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-700/30">
            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Materi</th>
            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden sm:table-cell">Tipe</th>
            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">Kategori</th>
            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">Tanggal</th>
            <th class="px-6 py-3.5 text-right text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
          @forelse($materials as $material)
          <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/20 transition-colors group">
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                @php
                  $typeIcon = match($material->type ?? '') {
                    'video' => ['bg-violet-50 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 6h10v12H5z"/>'],
                    'link'  => ['bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>'],
                    default => ['bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                  };
                @endphp
                <div class="w-10 h-10 rounded-xl {{ $typeIcon[0] }} flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $typeIcon[1] !!}</svg>
                </div>
                <div class="min-w-0">
                  <p class="font-semibold text-slate-900 dark:text-white truncate max-w-[200px] group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ $material->title }}</p>
                  @if($material->description)
                  <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 truncate max-w-[200px]">{{ Str::limit($material->description, 50) }}</p>
                  @endif
                </div>
              </div>
            </td>
            <td class="px-6 py-4 hidden sm:table-cell">
              @php
                $typeBadge = match($material->type ?? 'pdf') {
                  'video' => 'bg-violet-50 dark:bg-violet-900/20 text-violet-700 dark:text-violet-400',
                  'link'  => 'bg-sky-50 dark:bg-sky-900/20 text-sky-700 dark:text-sky-400',
                  default => 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400',
                };
              @endphp
              <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-lg {{ $typeBadge }}">{{ strtoupper($material->type ?? 'PDF') }}</span>
            </td>
            <td class="px-6 py-4 hidden md:table-cell">
              @if($material->category)
              <span class="inline-flex px-2.5 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-medium rounded-lg">{{ $material->category }}</span>
              @else
              <span class="text-slate-400">—</span>
              @endif
            </td>
            <td class="px-6 py-4 hidden lg:table-cell">
              <span class="text-xs text-slate-500 dark:text-slate-400">{{ $material->created_at->format('d M Y') }}</span>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center justify-end gap-1.5">
                <a href="{{ route('admin.materials.edit', $material) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-amber-50 dark:hover:bg-amber-900/30 hover:text-amber-600 dark:hover:text-amber-400 transition-all" title="Edit">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.materials.destroy', $material) }}" onsubmit="return confirm('Hapus materi ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-500 dark:hover:text-red-400 transition-all" title="Hapus">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-6 py-20 text-center">
              <div class="w-14 h-14 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 19.5A2.5 2.5 0 016.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
              </div>
              <p class="text-sm font-bold text-slate-800 dark:text-white">Belum ada materi</p>
              <p class="text-xs text-slate-400 mt-1 mb-4">Upload materi edukasi pertama</p>
              <a href="{{ route('admin.materials.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition shadow-sm shadow-emerald-500/25">+ Upload Materi</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($materials->hasPages())
  <div class="flex justify-center">{{ $materials->links() }}</div>
  @endif

</div>
@endsection
