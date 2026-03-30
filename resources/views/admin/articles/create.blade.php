@extends('layouts.admin')
@section('title', 'Tulis Artikel')
@section('content')

<div class="space-y-6"
     x-data="{ preview: null, dragging: false, handleFile(f) { if(!f||!f.type.startsWith('image/'))return; const r=new FileReader(); r.onload=e=>this.preview=e.target.result; r.readAsDataURL(f); } }">

  {{-- Header --}}
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Tulis Artikel Baru</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Buat dan publikasikan artikel HPMI</p>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf

    @if($errors->any())
    <div class="px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 rounded-xl text-sm">
      <ul class="space-y-0.5 list-disc ml-4">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- LEFT: Konten --}}
      <div class="lg:col-span-2 space-y-5">

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Konten Artikel</h3>
          </div>
          <div class="p-6 space-y-5">
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Judul Artikel <span class="text-red-400">*</span></label>
              <input type="text" name="title" value="{{ old('title') }}" required placeholder="Masukkan judul artikel yang menarik..."
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
              @error('title')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Ringkasan</label>
              <textarea name="excerpt" rows="3" placeholder="Ringkasan singkat artikel (tampil di halaman daftar)..."
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition resize-none">{{ old('excerpt') }}</textarea>
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Konten Artikel <span class="text-red-400">*</span></label>
              <textarea name="content" rows="18" required placeholder="Tulis konten artikel di sini..."
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition font-mono leading-relaxed resize-y">{{ old('content') }}</textarea>
              @error('content')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>
          </div>
        </div>

        {{-- Thumbnail --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Thumbnail / Gambar Utama</h3>
          </div>
          <div class="p-6">
            <label class="block cursor-pointer"
              @dragover.prevent="dragging=true" @dragleave.prevent="dragging=false"
              @drop.prevent="dragging=false; handleFile($event.dataTransfer.files[0]); $refs.fi.files=$event.dataTransfer.files">
              <div class="relative border-2 border-dashed rounded-2xl transition-all duration-200 overflow-hidden"
                   :class="dragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/10' : 'border-slate-200 dark:border-slate-600 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-slate-50 dark:hover:bg-slate-700/30'">
                <div x-show="preview" class="relative">
                  <img :src="preview" alt="" class="w-full h-56 object-cover rounded-2xl">
                  <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition-opacity rounded-2xl flex items-center justify-center">
                    <span class="text-white text-sm font-semibold">Klik untuk ganti</span>
                  </div>
                </div>
                <div x-show="!preview" class="flex flex-col items-center justify-center py-12 px-6 text-center">
                  <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center mb-4" :class="dragging?'scale-110':''">
                    <svg class="w-7 h-7 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                  </div>
                  <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Drag & drop atau <span class="text-blue-600 dark:text-blue-400">pilih file</span></p>
                  <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">PNG, JPG, WEBP — Maks. 2MB</p>
                </div>
              </div>
              <input type="file" name="thumbnail" accept="image/*" x-ref="fi" class="sr-only" @change="handleFile($event.target.files[0])">
            </label>
            @error('thumbnail')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
          </div>
        </div>

      </div>

      {{-- RIGHT: Settings --}}
      <div class="space-y-5">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden sticky top-5">
          <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Pengaturan Publikasi</h4>
          </div>
          <div class="p-5 space-y-4">
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Status</label>
              <select name="status" class="w-full px-3 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition cursor-pointer">
                <option value="draft" {{ old('status')=='draft'?'selected':'' }}>📝 Draft</option>
                <option value="published" {{ old('status')=='published'?'selected':'' }}>✅ Diterbitkan</option>
              </select>
            </div>
           <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                Kategori / Tipe
              </label>
              @if($categories->count())
              <select name="category_id"
                class="w-full px-3 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition cursor-pointer">
                <option value="">— Pilih Kategori —</option>
                @foreach($categories as $id => $name)
                {{-- untuk create --}}
                <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                  {{ $name }}
                </option>
                @endforeach
              </select>
              @else
              <div class="px-4 py-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl text-xs text-amber-700 dark:text-amber-400 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Belum ada kategori tipe "Kegiatan". 
                <a href="{{ route('admin.categories.create') }}" class="font-bold underline">Tambah sekarang →</a>
              </div>
              @endif
            </div>
          </div>
          <div class="px-5 pb-5 flex gap-3">
            <button type="submit" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-all active:scale-95 shadow-sm shadow-blue-500/25">Simpan</button>
            <a href="{{ route('admin.articles.index') }}" class="flex-1 py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl transition text-center">Batal</a>
          </div>
        </div>

        <div class="bg-blue-50 dark:bg-blue-900/10 rounded-2xl border border-blue-100 dark:border-blue-900/30 p-5">
          <h4 class="text-sm font-semibold text-blue-700 dark:text-blue-300 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Tips Penulisan
          </h4>
          <ul class="space-y-1.5 text-xs text-blue-700 dark:text-blue-400">
            <li class="flex items-start gap-1.5"><span>•</span> Judul yang baik mengandung kata kunci utama</li>
            <li class="flex items-start gap-1.5"><span>•</span> Ringkasan maks. 160 karakter untuk SEO optimal</li>
            <li class="flex items-start gap-1.5"><span>•</span> Thumbnail ideal berukuran 1200×630 piksel</li>
            <li class="flex items-start gap-1.5"><span>•</span> Simpan sebagai Draft dulu sebelum diterbitkan</li>
          </ul>
        </div>
      </div>

    </div>
  </form>
</div>
@endsection
