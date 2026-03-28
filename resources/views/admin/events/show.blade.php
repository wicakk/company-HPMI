@extends('layouts.admin')
@section('title', 'Detail Kegiatan')
@section('content')

<div class="space-y-6">

  {{-- Topbar --}}
  <div class="flex items-center justify-between gap-3">
    <div class="flex items-center gap-3">
      <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
      </a>
      <div>
        <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Detail Kegiatan</h2>
      </div>
    </div>
    <a href="{{ route('admin.events.edit', $kegiatan) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-violet-500/25 transition-all active:scale-95">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
      Edit
    </a>
  </div>

  {{-- Hero --}}
  <div class="relative rounded-2xl overflow-hidden h-72 bg-gradient-to-br from-violet-900 via-indigo-900 to-slate-900">
    @if($kegiatan->thumbnail)
    <img src="{{ $kegiatan->thumbnail }}" alt="{{ $kegiatan->title }}" class="w-full h-full object-cover">
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-7">
      <div class="flex gap-2 flex-wrap mb-3">
        @php $statusLabel = ['open'=>'Dibuka','draft'=>'Draft','closed'=>'Ditutup','completed'=>'Selesai'][$kegiatan->status] ?? $kegiatan->status; @endphp
        <span class="px-3 py-1 text-xs font-bold rounded-full backdrop-blur-sm border border-white/20 text-white bg-white/15">{{ $statusLabel }}</span>
        @if($kegiatan->is_free)<span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300">Gratis</span>@endif
        @if($kegiatan->is_member_only)<span class="px-3 py-1 text-xs font-bold rounded-full bg-violet-500/20 border border-violet-400/30 text-violet-300">Member Only</span>@endif
      </div>
      <h1 class="text-2xl font-black text-white leading-tight">{{ $kegiatan->title }}</h1>
    </div>
  </div>

  {{-- Stats pills --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
    @foreach([
      ['Kuota', $kegiatan->quota ?? '∞', 'text-violet-600 dark:text-violet-400'],
      ['Harga', $kegiatan->is_free ? 'Gratis' : 'Rp '.number_format($kegiatan->price,0,',','.'), $kegiatan->is_free ? 'text-emerald-600 dark:text-emerald-400' : 'text-violet-600 dark:text-violet-400'],
      ['Mulai', \Carbon\Carbon::parse($kegiatan->start_date)->format('d M'), 'text-sky-600 dark:text-sky-400'],
      ['Selesai', $kegiatan->end_date ? \Carbon\Carbon::parse($kegiatan->end_date)->format('d M') : '—', 'text-amber-600 dark:text-amber-400'],
    ] as [$lbl, $val, $cls])
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-4 text-center">
      <p class="text-xl font-black {{ $cls }}">{{ $val }}</p>
      <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wide mt-1">{{ $lbl }}</p>
    </div>
    @endforeach
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-5">

    {{-- LEFT --}}
    <div class="space-y-5">

      {{-- Info --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
          <div class="w-2 h-2 rounded-full bg-violet-500"></div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Kegiatan</h3>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
          @foreach([
            ['Tanggal Mulai', \Carbon\Carbon::parse($kegiatan->start_date)->isoFormat('D MMMM YYYY, HH:mm')],
            ['Tanggal Selesai', $kegiatan->end_date ? \Carbon\Carbon::parse($kegiatan->end_date)->isoFormat('D MMMM YYYY, HH:mm') : '—'],
            ['Lokasi', $kegiatan->location ?: '—'],
            ['Tipe', $kegiatan->type ?? '—'],
          ] as [$lbl, $val])
          <div class="bg-slate-50 dark:bg-slate-700/40 rounded-xl p-3">
            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">{{ $lbl }}</p>
            <p class="text-sm font-semibold text-slate-800 dark:text-white">{{ $val }}</p>
          </div>
          @endforeach
          <div class="bg-slate-50 dark:bg-slate-700/40 rounded-xl p-3 sm:col-span-2">
            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Slug</p>
            <code class="text-xs font-mono text-slate-600 dark:text-slate-300">{{ $kegiatan->slug }}</code>
          </div>
          @if($kegiatan->meeting_url)
          <div class="sm:col-span-2">
            <a href="{{ $kegiatan->meeting_url }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-violet-50 dark:bg-violet-900/20 text-violet-700 dark:text-violet-400 border border-violet-200 dark:border-violet-800/50 rounded-xl text-sm font-semibold hover:bg-violet-100 dark:hover:bg-violet-900/30 transition-all">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.868v6.264a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
              Buka Link Meeting
            </a>
          </div>
          @endif
        </div>
      </div>

      {{-- Deskripsi --}}
      @if($kegiatan->description)
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
          <div class="w-2 h-2 rounded-full bg-sky-500"></div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Deskripsi</h3>
        </div>
        <div class="p-6">
          <div class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-wrap">{{ $kegiatan->description }}</div>
        </div>
      </div>
      @endif

      {{-- Syarat --}}
      @if($kegiatan->requirements)
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
          <div class="w-2 h-2 rounded-full bg-amber-500"></div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Syarat & Ketentuan</h3>
        </div>
        <div class="p-6 text-sm text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-wrap">{{ $kegiatan->requirements }}</div>
      </div>
      @endif

    </div>

    {{-- RIGHT --}}
    <div class="space-y-5">

      {{-- Actions --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 space-y-3">
        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1">Aksi</h4>
        <a href="{{ route('admin.events.edit', $kegiatan) }}" class="flex items-center gap-3 px-4 py-3 bg-violet-50 dark:bg-violet-900/20 hover:bg-violet-100 dark:hover:bg-violet-900/30 text-violet-700 dark:text-violet-400 rounded-xl text-sm font-semibold transition-all">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
          Edit Kegiatan
        </a>
        <form method="POST" action="{{ route('admin.events.destroy', $kegiatan) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
          @csrf @method('DELETE')
          <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-xl text-sm font-semibold transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Hapus Kegiatan
          </button>
        </form>
      </div>

      {{-- Meta --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5">
        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-3">Metadata</h4>
        <div class="space-y-2">
          @foreach([
            ['Status', $statusLabel],
            ['Tipe Kegiatan', $kegiatan->type ?? '—'],
            ['Member Only', $kegiatan->is_member_only ? 'Ya' : 'Tidak'],
            ['Dibuat', $kegiatan->created_at->format('d M Y')],
            ['Diperbarui', $kegiatan->updated_at->format('d M Y')],
          ] as [$lbl,$val])
          <div class="flex items-center justify-between text-xs">
            <span class="text-slate-500 dark:text-slate-400">{{ $lbl }}</span>
            <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $val }}</span>
          </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>

</div>
@endsection
