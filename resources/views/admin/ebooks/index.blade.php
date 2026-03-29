
@extends('layouts.admin')
@section('title','Manajemen Ebook')
@section('content')
<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-blue-500 dark:text-blue-400 mb-1">Konten</p>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Manajemen Ebook</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola koleksi ebook HPMI</p>
    </div>
    <a href="{{ route('admin.ebooks.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-500/25 transition-all active:scale-95 flex-shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Tambah Ebook
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
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach([
      ['Total Ebook',    $stats['total'],     'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'],
      ['Gratis',         $stats['free'],      'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400'],
      ['Premium',        $stats['premium'],   'bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400'],
      ['Total Unduhan',  number_format($stats['downloads']), 'bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400'],
    ] as [$label, $value, $cls])
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 flex items-center gap-4">
      <div class="w-11 h-11 rounded-xl {{ $cls }} flex items-center justify-center flex-shrink-0 font-black text-lg">
        {{ $value }}
      </div>
      <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $label }}</p>
    </div>
    @endforeach
  </div>

  {{-- Filter --}}
  <form method="GET" class="flex flex-col sm:flex-row gap-3">
    <div class="relative flex-1">
      <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35"/></svg>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau penulis..."
        class="w-full pl-10 pr-4 h-10 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>
    <select name="access" class="h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition cursor-pointer">
      <option value="">Semua Akses</option>
      <option value="free"    {{ request('access')==='free'    ? 'selected':'' }}>Gratis</option>
      <option value="premium" {{ request('access')==='premium' ? 'selected':'' }}>Premium</option>
    </select>
    <select name="status" class="h-10 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition cursor-pointer">
      <option value="">Semua Status</option>
      <option value="published" {{ request('status')==='published' ? 'selected':'' }}>Published</option>
      <option value="draft"     {{ request('status')==='draft'     ? 'selected':'' }}>Draft</option>
    </select>
    <button type="submit" class="h-10 px-5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition shadow-sm active:scale-95">Cari</button>
    @if(request()->hasAny(['q','access','status']))
    <a href="{{ route('admin.ebooks.index') }}" class="h-10 px-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 text-slate-600 dark:text-slate-300 text-sm font-medium rounded-xl transition flex items-center">Reset</a>
    @endif
  </form>

  {{-- Table --}}
  <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-slate-100 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-700/30">
            <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Ebook</th>
            <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">Kategori</th>
            <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">Akses</th>
            <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
            <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">Unduhan</th>
            <th class="text-right px-6 py-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
          @forelse($ebooks as $ebook)
          <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/20 transition-colors group">

            {{-- Cover + Info --}}
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <div class="w-12 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100 dark:bg-slate-700">
                  @if($ebook->cover_path)
                  <img src="{{ Storage::url($ebook->cover_path) }}" alt="{{ $ebook->title }}" class="w-full h-full object-cover">
                  @else
                  <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                  </div>
                  @endif
                </div>
                <div class="min-w-0">
                  <p class="font-semibold text-slate-900 dark:text-white line-clamp-1 max-w-[200px]">{{ $ebook->title }}</p>
                  <p class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ $ebook->author }}
                  </p>
                  <div class="flex items-center gap-2 mt-1">
                    @if($ebook->year)<span class="text-xs text-slate-300 dark:text-slate-600">{{ $ebook->year }}</span>@endif
                    @if($ebook->pages)<span class="text-xs text-slate-300 dark:text-slate-600">· {{ $ebook->pages }} hal</span>@endif
                    @if($ebook->file_size)<span class="text-xs text-slate-300 dark:text-slate-600">· {{ $ebook->file_size }}</span>@endif
                  </div>
                </div>
              </div>
            </td>

            {{-- Kategori --}}
            <td class="px-6 py-4 hidden md:table-cell">
              @if($ebook->category)
              <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-medium rounded-lg">{{ $ebook->category }}</span>
              @else
              <span class="text-slate-300 dark:text-slate-600">—</span>
              @endif
            </td>

            {{-- Akses --}}
            <td class="px-6 py-4 hidden lg:table-cell">
              @if($ebook->isFree())
              <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-semibold rounded-lg">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Gratis
              </span>
              @else
              <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-semibold rounded-lg">
                ⭐ Premium
              </span>
              @endif
            </td>

            {{-- Status toggle --}}
            <td class="px-6 py-4">
              <form method="POST" action="{{ route('admin.ebooks.toggle-publish', $ebook) }}">
                @csrf @method('PATCH')
                <button type="submit"
                  class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition hover:opacity-80
                    {{ $ebook->is_published ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400' }}">
                  <span class="w-1.5 h-1.5 rounded-full {{ $ebook->is_published ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                  {{ $ebook->is_published ? 'Published' : 'Draft' }}
                </button>
              </form>
            </td>

            {{-- Download count --}}
            <td class="px-6 py-4 hidden md:table-cell">
              <div class="flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400">
                <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                {{ number_format($ebook->download_count) }}
              </div>
            </td>

            {{-- Aksi --}}
            <td class="px-6 py-4">
              <div class="flex items-center justify-end gap-1.5">
                <a href="{{ route('admin.ebooks.download', $ebook) }}"
                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-sky-50 dark:hover:bg-sky-900/30 hover:text-sky-600 dark:hover:text-sky-400 transition-all" title="Download">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </a>
                <a href="{{ route('admin.ebooks.edit', $ebook) }}"
                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-amber-50 dark:hover:bg-amber-900/30 hover:text-amber-600 dark:hover:text-amber-400 transition-all" title="Edit">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.ebooks.destroy', $ebook) }}"
                      onsubmit="return confirm('Hapus ebook ini? File juga akan dihapus permanen.')">
                  @csrf @method('DELETE')
                  <button type="submit"
                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-red-400 transition-all" title="Hapus">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </form>
              </div>
            </td>

          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-6 py-20 text-center">
              <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
              </div>
              <p class="text-sm font-bold text-slate-800 dark:text-white">Belum ada ebook</p>
              <p class="text-xs text-slate-400 mt-1 mb-5">Tambahkan ebook pertama untuk koleksi HPMI</p>
              <a href="{{ route('admin.ebooks.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Ebook
              </a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($ebooks->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between gap-4">
      <p class="text-xs text-slate-500 dark:text-slate-400">Menampilkan {{ $ebooks->firstItem() }}–{{ $ebooks->lastItem() }} dari {{ $ebooks->total() }} ebook</p>
      {{ $ebooks->links() }}
    </div>
    @endif
  </div>

</div>
@endsection