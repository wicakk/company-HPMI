@extends('layouts.admin')
@section('title', 'Manajemen Kegiatan')
@section('content')

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-violet-500 dark:text-violet-400 mb-1">Manajemen</p>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Kegiatan & Acara</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola semua kegiatan dan acara HPMI</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-violet-500/25 transition-all active:scale-95">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Tambah Kegiatan
    </a>
  </div>

  {{-- Stats --}}
  @php
    $total     = $events->total();
    $open      = $events->getCollection()->where('status','open')->count();
    $draft     = $events->getCollection()->where('status','draft')->count();
    $completed = $events->getCollection()->where('status','completed')->count();
  @endphp
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-1 bg-slate-100 dark:bg-slate-700/50 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-700">
    <div class="bg-white dark:bg-slate-800 p-4 flex items-center gap-3">
      <div class="w-9 h-9 bg-violet-50 dark:bg-violet-900/30 rounded-xl flex items-center justify-center">
        <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
      </div>
      <div><p class="text-xl font-black text-slate-900 dark:text-white leading-none">{{ $total }}</p><p class="text-xs text-slate-400 mt-0.5">Total</p></div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-4 flex items-center gap-3">
      <div class="w-9 h-9 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <div><p class="text-xl font-black text-emerald-600 dark:text-emerald-400 leading-none">{{ $open }}</p><p class="text-xs text-slate-400 mt-0.5">Dibuka</p></div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-4 flex items-center gap-3">
      <div class="w-9 h-9 bg-slate-100 dark:bg-slate-700 rounded-xl flex items-center justify-center">
        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
      </div>
      <div><p class="text-xl font-black text-slate-500 dark:text-slate-400 leading-none">{{ $draft }}</p><p class="text-xs text-slate-400 mt-0.5">Draft</p></div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-4 flex items-center gap-3">
      <div class="w-9 h-9 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
      </div>
      <div><p class="text-xl font-black text-blue-600 dark:text-blue-400 leading-none">{{ $completed }}</p><p class="text-xs text-slate-400 mt-0.5">Selesai</p></div>
    </div>
  </div>

  {{-- Filter --}}
  <div class="flex flex-col sm:flex-row gap-3">
    <div class="relative flex-1">
      <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35"/></svg>
      <input type="text" placeholder="Cari kegiatan..." id="searchInput" oninput="filterCards()"
        class="w-full pl-10 pr-4 h-10 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
    </div>
    <select id="statusFilter" onchange="filterCards()"
      class="h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition cursor-pointer">
      <option value="">Semua Status</option>
      <option value="open">Dibuka</option>
      <option value="draft">Draft</option>
      <option value="closed">Ditutup</option>
      <option value="completed">Selesai</option>
    </select>
  </div>

  {{-- Cards Grid --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="eventsGrid">
    @forelse($events as $event)
    @php
      $statusMap = [
        'open'      => ['bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400', 'Dibuka'],
        'draft'     => ['bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400', 'Draft'],
        'closed'    => ['bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400', 'Ditutup'],
        'completed' => ['bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400', 'Selesai'],
      ];
      [$statusClass, $statusLabel] = $statusMap[$event->status] ?? ['bg-slate-100 dark:bg-slate-700 text-slate-500', ucfirst($event->status)];
    @endphp
    <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:shadow-slate-200/60 dark:hover:shadow-slate-900/60 hover:-translate-y-1 transition-all duration-250 flex flex-col event-card"
      data-title="{{ strtolower($event->title) }}" data-status="{{ $event->status }}">

      {{-- Image --}}
      <div class="relative w-full h-44 overflow-hidden bg-gradient-to-br from-violet-100 to-indigo-200 dark:from-violet-900/30 dark:to-indigo-900/40 flex-shrink-0">
        @if($event->thumbnail)
        <img src="{{ $event->thumbnail }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-400">
        @else
        <div class="w-full h-full flex items-center justify-center">
          <svg class="w-14 h-14 text-violet-300 dark:text-violet-600/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        @endif
        <span class="absolute top-3 right-3 inline-flex px-2.5 py-1 text-[11px] font-bold rounded-full backdrop-blur-sm border {{ $statusClass }} border-current/20">{{ $statusLabel }}</span>
      </div>

      {{-- Body --}}
      <div class="p-5 flex-1 flex flex-col gap-3">
        <h3 class="font-bold text-slate-900 dark:text-white text-sm leading-snug line-clamp-2">{{ $event->title }}</h3>

        <div class="space-y-1.5">
          <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
            <svg class="w-3.5 h-3.5 text-violet-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            {{ \Carbon\Carbon::parse($event->start_date)->isoFormat('D MMM YYYY, HH:mm') }}
          </div>
          @if($event->location)
          <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
            <svg class="w-3.5 h-3.5 text-violet-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="truncate">{{ Str::limit($event->location, 38) }}</span>
          </div>
          @endif
          <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
            <svg class="w-3.5 h-3.5 text-violet-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Kuota: {{ $event->quota ?? '∞' }} peserta
          </div>
        </div>

        <div class="mt-auto pt-1">
          <p class="text-lg font-black {{ $event->is_free ? 'text-emerald-600 dark:text-emerald-400' : 'text-violet-600 dark:text-violet-400' }}">
            {{ $event->is_free ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
          </p>
        </div>
      </div>

      {{-- Footer --}}
      <div class="px-5 pb-5 pt-0 flex items-center gap-2 border-t border-slate-50 dark:border-slate-700/50 pt-4">
        <a href="{{ route('admin.events.show', $event) }}" class="flex-1 inline-flex items-center justify-center py-2 text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-violet-50 dark:hover:bg-violet-900/30 hover:text-violet-700 dark:hover:text-violet-400 rounded-xl transition-all">Lihat</a>
        <a href="{{ route('admin.events.edit', $event) }}" class="flex-1 inline-flex items-center justify-center py-2 text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-amber-50 dark:hover:bg-amber-900/30 hover:text-amber-600 dark:hover:text-amber-400 rounded-xl transition-all">Edit</a>
        <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
          @csrf @method('DELETE')
          <button type="submit" class="inline-flex items-center justify-center w-9 h-9 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-500 dark:hover:text-red-400 rounded-xl transition-all" title="Hapus">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
          </button>
        </form>
      </div>
    </div>
    @empty
    <div class="col-span-full bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 py-20 text-center">
      <div class="w-14 h-14 bg-violet-50 dark:bg-violet-900/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
        <svg class="w-7 h-7 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
      </div>
      <p class="text-sm font-bold text-slate-800 dark:text-white">Belum ada kegiatan</p>
      <p class="text-xs text-slate-400 mt-1 mb-5">Mulai dengan membuat kegiatan pertama</p>
      <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-violet-600 text-white rounded-xl text-xs font-semibold hover:bg-violet-700 transition shadow-sm shadow-violet-500/25">+ Tambah Kegiatan</a>
    </div>
    @endforelse
  </div>

  @if($events->hasPages())
  <div class="flex justify-center">{{ $events->links() }}</div>
  @endif
</div>

<script>
function filterCards() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const s = document.getElementById('statusFilter').value;
  document.querySelectorAll('.event-card').forEach(c => {
    const matchQ = !q || c.dataset.title.includes(q);
    const matchS = !s || c.dataset.status === s;
    c.style.display = (matchQ && matchS) ? '' : 'none';
  });
}
</script>
@endsection
