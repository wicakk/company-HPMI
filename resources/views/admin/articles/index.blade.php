@extends('layouts.admin')
@section('title', 'Manajemen Artikel')
@section('content')

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <p class="text-xs font-semibold uppercase tracking-widest text-sky-500 dark:text-sky-400 mb-1">Konten</p>
      <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Manajemen Artikel</h1>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola konten artikel dan berita HPMI</p>
    </div>
    <a href="{{ route('admin.articles.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-indigo-500/20 transition-all active:scale-95 self-start sm:self-auto">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Tulis Artikel
    </a>
  </div>

  {{-- Flash --}}
  @if(session('success'))
  <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
  </div>
  @endif

  {{-- Stats --}}
  @php
    $total     = $articles->total();
    $published = $articles->getCollection()->where('status','published')->count();
    $draft     = $articles->getCollection()->where('status','draft')->count();
  @endphp
  <div class="grid grid-cols-3 gap-4">
    @foreach([['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>','bg'=>'bg-sky-50 dark:bg-sky-500/10','icon_color'=>'text-sky-600 dark:text-sky-400','label'=>'Total Artikel','val'=>$total],['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>','bg'=>'bg-emerald-50 dark:bg-emerald-500/10','icon_color'=>'text-emerald-600 dark:text-emerald-400','label'=>'Diterbitkan','val'=>$published],['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>','bg'=>'bg-amber-50 dark:bg-amber-500/10','icon_color'=>'text-amber-600 dark:text-amber-400','label'=>'Draft','val'=>$draft]] as $s)
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-4 flex items-center gap-3 shadow-sm">
      <div class="w-10 h-10 rounded-xl {{ $s['bg'] }} flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 {{ $s['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $s['icon'] !!}</svg>
      </div>
      <div>
        <p class="text-xl font-black text-slate-900 dark:text-white">{{ $s['val'] }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $s['label'] }}</p>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Table --}}
  <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-700/20">
            <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Artikel</th>
            <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider hidden md:table-cell">Penulis</th>
            <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider hidden lg:table-cell">Kategori</th>
            <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Status</th>
            <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider hidden lg:table-cell">Views</th>
            <th class="text-right px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
          @forelse($articles as $article)
          <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/20 transition-colors group">
            <td class="px-5 py-4">
              <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl overflow-hidden flex-shrink-0 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600">
                  @if($article->thumbnail)
                    <img src="{{ Storage::url($article->thumbnail) }}" alt="" class="w-full h-full object-cover">
                  @else
                    <div class="w-full h-full flex items-center justify-center">
                      <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                  @endif
                </div>
                <div class="min-w-0">
                  <p class="font-semibold text-slate-900 dark:text-white truncate max-w-[220px] group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $article->title }}</p>
                  <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $article->created_at->format('d M Y') }}</p>
                </div>
              </div>
            </td>
            <td class="px-5 py-4 hidden md:table-cell">
              <span class="text-sm text-slate-600 dark:text-slate-400">{{ optional($article->author)->name ?? 'Admin' }}</span>
            </td>
            <td class="px-5 py-4 hidden lg:table-cell">
              @if($article->category)
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 text-xs font-medium">{{ $article->category }}</span>
              @else<span class="text-slate-400 dark:text-slate-600 text-xs">—</span>@endif
            </td>
            <td class="px-5 py-4">
              @if($article->status === 'published')
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 text-xs font-semibold">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Published
                </span>
              @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 text-xs font-semibold">
                  <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Draft
                </span>
              @endif
            </td>
            <td class="px-5 py-4 hidden lg:table-cell">
              <span class="text-sm text-slate-600 dark:text-slate-400">{{ number_format($article->views ?? 0) }}</span>
            </td>
            <td class="px-5 py-4">
              <div class="flex items-center justify-end gap-1">
                <a href="{{ route('admin.articles.show', $article) }}"
                   class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all" title="Lihat">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </a>
                <a href="{{ route('admin.articles.edit', $article) }}"
                   class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-all" title="Edit">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Hapus artikel ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-all" title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-5 py-16 text-center">
              <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
              </div>
              <p class="font-bold text-slate-900 dark:text-white">Belum ada artikel</p>
              <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-4">Mulai tulis artikel pertama Anda</p>
              <a href="{{ route('admin.articles.create') }}"
                 class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-medium transition-colors">
                + Tulis Artikel
              </a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($articles->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-700">{{ $articles->links() }}</div>
    @endif
  </div>

</div>
@endsection
