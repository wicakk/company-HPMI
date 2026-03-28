@extends('layouts.admin')
@section('title', 'Detail Jurnal')
@section('content')

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex items-center justify-between gap-3">
    <div class="flex items-center gap-3">
      <a href="{{ route('admin.journals.index') }}"
         class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Detail Jurnal</h2>
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Diupload {{ $journal->created_at->format('d M Y, H:i') }}</p>
      </div>
    </div>
    <a href="{{ route('admin.journals.edit', $journal) }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-rose-500/25 transition-all active:scale-95">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
      </svg>
      Edit Jurnal
    </a>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── LEFT: Main Content ── --}}
    <div class="lg:col-span-2 space-y-5">

      {{-- Jurnal Card --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">

        {{-- Gradient top bar --}}
        <div class="h-1.5 bg-gradient-to-r from-rose-500 to-pink-600"></div>

        <div class="p-6">
          {{-- Status & type --}}
          <div class="flex items-center gap-2 mb-4">
            @php $ext = strtolower($journal->file_type ?? 'pdf'); @endphp
            <span class="inline-flex px-2.5 py-1 text-xs font-bold rounded-lg {{ $ext === 'pdf' ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400' : 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' }}">
              {{ strtoupper($ext) }}
            </span>
            @if($journal->is_published)
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-semibold rounded-full">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Dipublikasikan
            </span>
            @else
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-semibold rounded-full">
              <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Draft
            </span>
            @endif
            @if($journal->category)
            <span class="inline-flex px-2.5 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-medium rounded-full">
              {{ $journal->category }}
            </span>
            @endif
          </div>

          {{-- Title --}}
          <h1 class="text-xl font-black text-slate-900 dark:text-white leading-snug mb-4">
            {{ $journal->title }}
          </h1>

          {{-- Author --}}
          <div class="flex items-center gap-3 mb-5 pb-5 border-b border-slate-100 dark:border-slate-700">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-rose-400 to-pink-600 flex items-center justify-center text-white font-bold">
              {{ strtoupper(substr($journal->author, 0, 1)) }}
            </div>
            <div>
              <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $journal->author }}</p>
              <p class="text-xs text-slate-400 dark:text-slate-500">Author</p>
            </div>
            @if($journal->year || $journal->volume)
            <div class="ml-auto flex items-center gap-3">
              @if($journal->year)
              <div class="text-right">
                <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $journal->year }}</p>
                <p class="text-xs text-slate-400 dark:text-slate-500">Tahun</p>
              </div>
              @endif
              @if($journal->volume)
              <div class="text-right">
                <p class="text-sm font-bold text-slate-800 dark:text-white">Vol. {{ $journal->volume }}</p>
                <p class="text-xs text-slate-400 dark:text-slate-500">Volume</p>
              </div>
              @endif
            </div>
            @endif
          </div>

          {{-- Abstrak --}}
          @if($journal->abstract)
          <div>
            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Abstrak</h3>
            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{{ $journal->abstract }}</p>
          </div>
          @else
          <p class="text-sm text-slate-400 dark:text-slate-500 italic">Tidak ada abstrak.</p>
          @endif
        </div>
      </div>

      {{-- File preview card --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
          <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
          File Jurnal
        </h3>
        <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-700/40 rounded-xl">
          <div class="w-14 h-14 rounded-xl {{ $ext === 'pdf' ? 'bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400' : 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400' }} flex items-center justify-center font-black text-sm flex-shrink-0">
            {{ strtoupper($ext) }}
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-slate-800 dark:text-white truncate">{{ $journal->file_name }}</p>
            <div class="flex items-center gap-3 mt-1">
              @if($journal->file_size)
              <span class="text-xs text-slate-400 dark:text-slate-500">{{ $journal->file_size }}</span>
              @endif
              <span class="text-xs text-slate-300 dark:text-slate-600">·</span>
              <span class="text-xs text-sky-600 dark:text-sky-400 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                {{ number_format($journal->download_count) }} unduhan
              </span>
            </div>
          </div>
          <a href="{{ route('admin.journals.download', $journal) }}"
             class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold rounded-xl transition-all shadow-sm shadow-sky-500/25 active:scale-95 flex-shrink-0">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download
          </a>
        </div>
      </div>

    </div>

    {{-- ── RIGHT: Sidebar ── --}}
    <div class="space-y-5">

      {{-- Quick stats --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5">
        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Statistik</h4>
        <div class="space-y-3">
          @foreach([
            ['Total Unduhan', number_format($journal->download_count), 'text-sky-600 dark:text-sky-400', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>'],
          ] as [$lbl, $val, $cls, $path])
          <div class="flex items-center justify-between">
            <span class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
              <svg class="w-3.5 h-3.5 {{ $cls }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $path !!}</svg>
              {{ $lbl }}
            </span>
            <span class="text-sm font-bold {{ $cls }}">{{ $val }}</span>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Info meta --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5">
        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Informasi</h4>
        <div class="space-y-3">
          @foreach([
            ['Kategori',   $journal->category ?? '—'],
            ['Volume',     $journal->volume   ? 'Vol. ' . $journal->volume : '—'],
            ['Tahun',      $journal->year     ?? '—'],
            ['Tipe File',  strtoupper($journal->file_type ?? '—')],
            ['Ukuran',     $journal->file_size ?? '—'],
            ['Diupload',   $journal->created_at->format('d M Y')],
            ['Oleh',       $journal->uploader?->name ?? 'Admin'],
          ] as [$lbl, $val])
          <div class="flex items-center justify-between text-xs">
            <span class="text-slate-500 dark:text-slate-400">{{ $lbl }}</span>
            <span class="font-semibold text-slate-700 dark:text-slate-300 text-right max-w-[140px] truncate">{{ $val }}</span>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Actions --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 space-y-2.5">
        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1">Aksi</h4>

        <a href="{{ route('admin.journals.edit', $journal) }}"
           class="flex items-center gap-3 px-4 py-3 bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/30 text-rose-700 dark:text-rose-400 rounded-xl text-sm font-semibold transition-all">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
          Edit Jurnal
        </a>

        <form method="POST" action="{{ route('admin.journals.toggle-publish', $journal) }}">
          @csrf @method('PATCH')
          <button type="submit"
            class="w-full flex items-center gap-3 px-4 py-3 {{ $journal->is_published ? 'bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/30 text-amber-700 dark:text-amber-400' : 'bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' }} rounded-xl text-sm font-semibold transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              @if($journal->is_published)
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
              @else
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              @endif
            </svg>
            {{ $journal->is_published ? 'Jadikan Draft' : 'Publikasikan' }}
          </button>
        </form>

        <form method="POST" action="{{ route('admin.journals.destroy', $journal) }}"
              onsubmit="return confirm('Hapus jurnal ini? File juga akan dihapus permanen.')">
          @csrf @method('DELETE')
          <button type="submit"
            class="w-full flex items-center gap-3 px-4 py-3 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-xl text-sm font-semibold transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Hapus Jurnal
          </button>
        </form>
      </div>

    </div>
  </div>

</div>
@endsection
