@extends('layouts.admin')
@section('title', 'Upload Materi')
@section('content')

<div class="space-y-6">
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.materials.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Upload Materi Baru</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Tambahkan modul, PDF, atau video pembelajaran</p>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.materials.store') }}">
    @csrf
    @if($errors->any())
    <div class="px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 rounded-xl text-sm mb-5">
      <ul class="space-y-0.5 list-disc ml-4">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- LEFT --}}
      <div class="lg:col-span-2">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6 space-y-5">
          <div class="flex items-center gap-2 pb-1 border-b border-slate-100 dark:border-slate-700">
            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Materi</h3>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Judul Materi <span class="text-red-400">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Masukkan judul materi..."
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 transition">
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Deskripsi</label>
            <textarea name="description" rows="5" placeholder="Deskripsi singkat materi ini..."
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 transition resize-none">{{ old('description') }}</textarea>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">URL File / PDF</label>
              <input type="url" name="file_url" value="{{ old('file_url') }}" placeholder="https://..."
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 transition">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">URL Video</label>
              <input type="url" name="video_url" value="{{ old('video_url') }}" placeholder="https://youtube.com/..."
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 transition">
            </div>
          </div>
        </div>
      </div>

      {{-- RIGHT --}}
      <div class="space-y-5">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-5 space-y-4">
          <div class="flex items-center gap-2 pb-1 border-b border-slate-100 dark:border-slate-700">
            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Pengaturan</h4>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tipe Materi</label>
            <select name="type" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 transition cursor-pointer">
              <option value="pdf">PDF</option>
              <option value="video">Video</option>
              <option value="article">Artikel</option>
              <option value="module">Modul</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Kategori</label>
            <select name="category_id" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 transition cursor-pointer">
              <option value="">Tanpa Kategori</option>
              @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">URL Thumbnail</label>
            <input type="text" name="thumbnail" value="{{ old('thumbnail') }}" placeholder="https://..."
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 transition">
          </div>
          <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
            <input type="checkbox" name="is_member_only" value="1" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-emerald-500 focus:ring-emerald-400"> Khusus Anggota
          </label>
        </div>
        <div class="flex gap-3">
          <button type="submit" class="flex-1 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shadow-emerald-500/25 active:scale-95">Simpan</button>
          <a href="{{ route('admin.materials.index') }}" class="flex-1 py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl transition text-center">Batal</a>
        </div>
      </div>

    </div>
  </form>
</div>
@endsection
