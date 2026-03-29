{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Master Kategori')
@section('content')

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-blue-500 dark:text-blue-400 mb-1">Master Data</p>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Kategori</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola kategori untuk Artikel, Jurnal, dan Materi</p>
    </div>
    <a href="{{ route('admin.categories.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-500/25 transition-all active:scale-95 flex-shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Tambah Kategori
    </a>
  </div>

  {{-- Flash --}}
  @if(session('success'))
  <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
  </div>
  @endif

  {{-- Stats --}}
  <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
    @foreach([
      ['Total',   $stats['total'],   'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'],
      // ['Aktif',   $stats['aktif'],   'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400'],
      ['Artikel', $stats['artikel'], 'bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400'],
      ['Jurnal',  $stats['jurnal'],  'bg-violet-50 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400'],
      ['Materi',  $stats['materi'],  'bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400'],
    ] as [$label, $value, $cls])
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-4 flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl {{ $cls }} flex items-center justify-center flex-shrink-0 font-black text-lg">
        {{ $value }}
      </div>
      <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $label }}</p>
    </div>
    @endforeach
  </div>

  {{-- Filter --}}
  <form method="GET" class="flex flex-col sm:flex-row gap-3">
    <div class="relative flex-1">
      <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35"/>
      </svg>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau deskripsi..."
        class="w-full pl-10 pr-4 h-10 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>
    <select name="type"
      class="h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition cursor-pointer">
      <option value="">Semua Tipe</option>
      <option value="artikel" {{ request('type') === 'artikel' ? 'selected' : '' }}>Artikel</option>
      <option value="jurnal"  {{ request('type') === 'jurnal'  ? 'selected' : '' }}>Jurnal</option>
      <option value="materi"  {{ request('type') === 'materi'  ? 'selected' : '' }}>Materi</option>
    </select>
    <select name="status"
      class="h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition cursor-pointer">
      <option value="">Semua Status</option>
      <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Aktif</option>
      <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
    </select>
    <button type="submit"
      class="h-10 px-5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition shadow-sm active:scale-95 flex items-center gap-2">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35"/></svg>
      Cari
    </button>
    @if(request()->hasAny(['q','type','status']))
    <a href="{{ route('admin.categories.index') }}"
      class="h-10 px-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 text-sm font-medium rounded-xl transition flex items-center">
      Reset
    </a>
    @endif
  </form>

  {{-- Table --}}
  <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-slate-100 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-700/30">
            <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider w-8">#</th>
            <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kategori</th>
            <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">Tipe</th>
            <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">Slug</th>
            <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">Urutan</th>
            <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
            <th class="text-right px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
          @forelse($categories as $i => $cat)
          <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/20 transition-colors group">

            {{-- No --}}
            <td class="px-6 py-4 text-xs text-slate-400 font-mono">
              {{ $categories->firstItem() + $i }}
            </td>

            {{-- Nama --}}
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <span class="w-4 h-4 rounded-full flex-shrink-0 border-2 border-white dark:border-slate-700 shadow-sm"
                      style="background-color: {{ $cat->color }}"></span>
                <div>
                  <p class="font-semibold text-slate-900 dark:text-white">{{ $cat->name }}</p>
                  @if($cat->description)
                  <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 line-clamp-1 max-w-[220px]">{{ $cat->description }}</p>
                  @endif
                </div>
              </div>
            </td>

            {{-- Tipe --}}
            <td class="px-6 py-4 hidden md:table-cell">
              @php
                $typeColors = [
                  'artikel' => 'bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-400',
                  'jurnal'  => 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-400',
                  'materi'  => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
                ];
              @endphp
              <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $typeColors[$cat->type] ?? '' }}">
                {{ ucfirst($cat->type) }}
              </span>
            </td>

            {{-- Slug --}}
            <td class="px-6 py-4 hidden lg:table-cell">
              <code class="text-xs bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-2 py-1 rounded-lg">
                {{ $cat->slug }}
              </code>
            </td>

            {{-- Urutan --}}
            <td class="px-6 py-4 hidden lg:table-cell">
              <span class="text-sm font-mono text-slate-500 dark:text-slate-400">{{ $cat->sort_order }}</span>
            </td>

            {{-- Status --}}
            <td class="px-6 py-4">
              <form method="POST" action="{{ route('admin.categories.toggle-active', $cat) }}">
                @csrf @method('PATCH')
                <button type="submit"
                  class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition hover:opacity-80
                    {{ $cat->is_active
                      ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400'
                      : 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400' }}">
                  <span class="w-1.5 h-1.5 rounded-full {{ $cat->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                  {{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}
                </button>
              </form>
            </td>

            {{-- Aksi --}}
            <td class="px-6 py-4">
              <div class="flex items-center justify-end gap-1.5">
                <a href="{{ route('admin.categories.edit', $cat) }}"
                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-amber-50 dark:hover:bg-amber-900/30 hover:text-amber-600 dark:hover:text-amber-400 transition-all"
                   title="Edit">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                  </svg>
                </a>
                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                      onsubmit="return confirm('Hapus kategori \"{{ addslashes($cat->name) }}\"?')">
                  @csrf @method('DELETE')
                  <button type="submit"
                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-red-400 transition-all"
                    title="Hapus">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </form>
              </div>
            </td>

          </tr>
          @empty
          <tr>
            <td colspan="7" class="px-6 py-20 text-center">
              <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                </svg>
              </div>
              <p class="text-sm font-bold text-slate-800 dark:text-white">
                {{ request()->hasAny(['q','type','status']) ? 'Tidak ada kategori yang cocok' : 'Belum ada kategori' }}
              </p>
              <p class="text-xs text-slate-400 mt-1 mb-5">
                {{ request()->hasAny(['q','type','status']) ? 'Coba ubah filter pencarian' : 'Tambahkan kategori pertama' }}
              </p>
              @if(!request()->hasAny(['q','type','status']))
              <a href="{{ route('admin.categories.create') }}"
                 class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kategori
              </a>
              @endif
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if($categories->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between gap-4">
      <p class="text-xs text-slate-500 dark:text-slate-400">
        Menampilkan {{ $categories->firstItem() }}–{{ $categories->lastItem() }} dari {{ $categories->total() }} kategori
      </p>
      {{ $categories->links() }}
    </div>
    @endif
  </div>

</div>
@endsection