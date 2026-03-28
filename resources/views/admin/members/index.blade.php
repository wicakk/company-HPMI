@extends('layouts.admin')
@section('title', 'Manajemen Anggota')
@section('content')

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-violet-500 dark:text-violet-400 mb-1">Manajemen</p>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Anggota HPMI</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola semua data keanggotaan</p>
    </div>
    <a href="{{ route('admin.members.export') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-emerald-500/25 transition-all active:scale-95">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
      Export CSV
    </a>
  </div>

  {{-- Filter --}}
  <div class="flex flex-col sm:flex-row gap-3">
    <div class="relative flex-1">
      <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35"/></svg>
      <input id="searchInput" type="text" placeholder="Cari nama, email, kode anggota..." oninput="filterCards()"
        class="w-full pl-10 pr-4 h-10 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
    </div>
    <select id="statusFilter" onchange="filterCards()"
      class="h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition cursor-pointer">
      <option value="">Semua Status</option>
      <option value="active">Aktif</option>
      <option value="pending">Pending</option>
      <option value="expired">Kadaluarsa</option>
      <option value="suspended">Ditangguhkan</option>
    </select>
  </div>

  {{-- Grid Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="membersGrid">
    @forelse($members as $member)
    @php
      $statusMap = [
        'active'    => ['bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400', 'Aktif'],
        'pending'   => ['bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400', 'Pending'],
        'expired'   => ['bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400', 'Kadaluarsa'],
        'suspended' => ['bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400', 'Ditangguhkan'],
      ];
      [$statusClass, $statusLabel] = $statusMap[$member->status] ?? ['bg-slate-100 dark:bg-slate-700 text-slate-500', ucfirst($member->status)];
      $initial = strtoupper(substr($member->user->name ?? 'U', 0, 1));
      $avatarBgs = ['from-blue-500 to-indigo-600','from-emerald-500 to-teal-600','from-violet-500 to-purple-600','from-amber-500 to-orange-600','from-pink-500 to-rose-600'];
      $bg = $avatarBgs[$loop->index % count($avatarBgs)];
    @endphp
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-lg hover:shadow-slate-200/60 dark:hover:shadow-slate-900/60 hover:-translate-y-0.5 transition-all duration-200 event-card"
      data-name="{{ strtolower($member->user->name ?? '') }}" data-status="{{ $member->status }}">

      {{-- Top accent bar --}}
      <div class="h-1 bg-gradient-to-r {{ $bg }}"></div>

      <div class="p-5">
        <div class="flex items-center gap-3">
          <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $bg }} flex items-center justify-center text-white font-bold text-base flex-shrink-0">{{ $initial }}</div>
          <div class="flex-1 min-w-0">
            <h3 class="font-bold text-slate-900 dark:text-white text-sm truncate">{{ $member->user->name ?? '-' }}</h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 truncate">{{ $member->user->email ?? '-' }}</p>
          </div>
          <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusClass }} flex-shrink-0">{{ $statusLabel }}</span>
        </div>

        <div class="mt-4 space-y-1.5">
          <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
            <span class="font-mono font-medium text-slate-700 dark:text-slate-300">{{ $member->member_code }}</span>
          </div>
          @if($member->institution)
          <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
            <span class="truncate">{{ $member->institution }}</span>
          </div>
          @endif
          <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <span>{{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('d M Y') : '-' }}</span>
          </div>
        </div>

        <div class="mt-4">
          <a href="{{ route('admin.members.show', $member) }}" class="block w-full text-center bg-slate-50 dark:bg-slate-700 hover:bg-blue-50 dark:hover:bg-blue-900/30 text-slate-700 dark:text-slate-300 hover:text-blue-700 dark:hover:text-blue-400 rounded-xl py-2 text-xs font-semibold transition-all border border-slate-200 dark:border-slate-600">
            Lihat Detail →
          </a>
        </div>
      </div>
    </div>
    @empty
    <div class="col-span-full text-center py-20">
      <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
      </div>
      <p class="text-base font-bold text-slate-800 dark:text-white">Belum ada anggota</p>
      <p class="text-sm text-slate-400 mt-1 mb-5">Tambahkan anggota pertama Anda</p>
      <a href="{{ route('admin.members.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition shadow-sm shadow-blue-500/25">+ Tambah Anggota</a>
    </div>
    @endforelse
  </div>

  {{-- Pagination --}}
  @if($members->hasPages())
  <div class="flex justify-center">{{ $members->links() }}</div>
  @endif

</div>

<script>
function filterCards() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const s = document.getElementById('statusFilter').value;
  document.querySelectorAll('.event-card').forEach(c => {
    const matchQ = !q || c.dataset.name.includes(q);
    const matchS = !s || c.dataset.status === s;
    c.style.display = (matchQ && matchS) ? '' : 'none';
  });
}
</script>

@endsection
