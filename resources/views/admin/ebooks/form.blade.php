{{-- resources/views/admin/ebooks/form.blade.php --}}
@extends('layouts.admin')
@section('title', $ebook ? 'Edit Ebook' : 'Tambah Ebook')
@section('content')

<div class="space-y-6">

  {{-- Header --}}
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.ebooks.index') }}"
       class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700 transition shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
        {{ $ebook ? 'Edit Ebook' : 'Tambah Ebook' }}
      </h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
        {{ $ebook ? 'Perbarui data ebook "'.$ebook->title.'"' : 'Upload ebook baru ke koleksi HPMI' }}
      </p>
    </div>
  </div>

  {{-- Error --}}
  @if($errors->any())
  <div class="px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 text-red-600 dark:text-red-400 rounded-xl text-sm">
    <p class="font-semibold mb-1">Ada kesalahan:</p>
    <ul class="ml-5 list-disc space-y-0.5 text-xs">
      @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
    </ul>
  </div>
  @endif

  <form method="POST"
        action="{{ $ebook ? route('admin.ebooks.update', $ebook) : route('admin.ebooks.store') }}"
        enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf
    @if($ebook) @method('PUT') @endif

    {{-- ── KIRI ── --}}
    <div class="lg:col-span-2 space-y-5">

      {{-- Info Ebook --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
          <div class="w-2 h-2 rounded-full bg-rose-500"></div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Ebook</h3>
        </div>
        <div class="p-6 space-y-5">

          {{-- Judul --}}
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Judul Ebook <span class="text-red-400">*</span></label>
            <input type="text" name="title" value="{{ old('title', $ebook?->title) }}"
                   placeholder="Masukkan judul ebook..."
                   class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 transition @error('title') border-red-400 @enderror">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
          </div>

          {{-- Penulis --}}
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Penulis / Author <span class="text-red-400">*</span></label>
            <div class="relative">
              <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
              <input type="text" name="author" value="{{ old('author', $ebook?->author) }}"
                     placeholder="Nama penulis..."
                     class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 transition @error('author') border-red-400 @enderror">
            </div>
            @error('author')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
          </div>

          {{-- Deskripsi --}}
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Deskripsi / Sinopsis</label>
            <textarea name="description" rows="4" placeholder="Ringkasan isi ebook..."
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 transition resize-none">{{ old('description', $ebook?->description) }}</textarea>
          </div>

        </div>
      </div>

      {{-- Upload Cover --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
          <div class="w-2 h-2 rounded-full bg-violet-500"></div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Cover Ebook</h3>
        </div>
        <div class="p-6">
          <label class="block cursor-pointer" x-data="{coverName:'',coverUrl:'{{ $ebook?->cover_path ? Storage::url($ebook->cover_path) : '' }}'}">
            <div class="border-2 border-dashed rounded-2xl transition-all duration-200 overflow-hidden"
                 :class="coverUrl ? 'border-violet-300 dark:border-violet-700' : 'border-slate-200 dark:border-slate-600 hover:border-violet-400'">
              <template x-if="coverUrl">
                <div class="relative">
                  <img :src="coverUrl" class="w-full max-h-48 object-cover rounded-2xl">
                  <div class="absolute inset-0 bg-black/0 hover:bg-black/30 transition rounded-2xl flex items-center justify-center">
                    <span class="opacity-0 hover:opacity-100 text-white text-xs font-semibold bg-black/50 px-3 py-1.5 rounded-xl">Klik untuk ganti</span>
                  </div>
                </div>
              </template>
              <template x-if="!coverUrl">
                <div class="py-10 text-center">
                  <div class="w-14 h-14 rounded-2xl bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                  </div>
                  <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">Upload cover ebook</p>
                  <p class="text-xs text-slate-400 mt-1">JPG, PNG, WEBP — Maks 2 MB</p>
                </div>
              </template>
            </div>
            <input type="file" name="cover" accept=".jpg,.jpeg,.png,.webp" class="sr-only"
                   @change="const f=$event.target.files[0]; if(f){coverUrl=URL.createObjectURL(f); coverName=f.name}">
          </label>
          @error('cover')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Upload File PDF --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
          <div class="w-2 h-2 rounded-full bg-sky-500"></div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">File PDF Ebook <span class="text-red-400">*</span></h3>
        </div>
        <div class="p-6">
          <label class="block cursor-pointer" x-data="{fileName:'{{ $ebook?->file_path ? basename($ebook->file_path) : '' }}', fileSize:'{{ $ebook?->file_size ?? '' }}'}">
            <template x-if="fileName">
              <div class="border-2 border-emerald-300 dark:border-emerald-700 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 p-5">
                <div class="flex items-center gap-4">
                  <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400 flex items-center justify-center font-black text-xs flex-shrink-0">PDF</div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 dark:text-white truncate" x-text="fileName"></p>
                    <p class="text-xs text-slate-500 mt-0.5" x-text="fileSize"></p>
                  </div>
                  <div class="flex items-center gap-1.5 flex-shrink-0">
                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Siap</span>
                  </div>
                </div>
                <p class="text-xs text-slate-400 mt-3 text-center">Klik untuk ganti file</p>
              </div>
            </template>
            <template x-if="!fileName">
              <div class="border-2 border-dashed border-slate-200 dark:border-slate-600 rounded-2xl py-10 px-6 text-center hover:border-sky-400 hover:bg-sky-50/30 dark:hover:bg-sky-900/10 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-sky-50 dark:bg-sky-900/30 flex items-center justify-center mx-auto mb-3">
                  <svg class="w-7 h-7 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">Upload file PDF ebook</p>
                <p class="text-xs text-slate-400 mt-1">PDF saja — Maks 50 MB</p>
              </div>
            </template>
            <input type="file" name="file" accept=".pdf" class="sr-only"
                   @change="const f=$event.target.files[0]; if(f){fileName=f.name; fileSize=f.size>=1048576?(f.size/1048576).toFixed(1)+' MB':(f.size/1024).toFixed(1)+' KB'}">
          </label>
          @error('file')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
        </div>
      </div>

    </div>

    {{-- ── KANAN ── --}}
    <div class="space-y-5">
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden sticky top-5">
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
          <div class="w-2 h-2 rounded-full bg-amber-500"></div>
          <h4 class="text-sm font-bold text-slate-900 dark:text-white">Pengaturan</h4>
        </div>
        <div class="p-5 space-y-4">

          {{-- Kategori --}}
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Kategori</label>
            <input type="text" name="category" value="{{ old('category', $ebook?->category) }}"
                   list="catList" placeholder="cth: Keperawatan, Manajemen..."
                   class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
            <datalist id="catList">
              @foreach($categories as $cat)<option value="{{ $cat }}">@endforeach
            </datalist>
          </div>

          {{-- Tahun & Halaman --}}
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tahun</label>
              <input type="number" name="year" value="{{ old('year', $ebook?->year ?? date('Y')) }}"
                     min="1900" max="{{ date('Y') }}"
                     class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Halaman</label>
              <input type="number" name="pages" value="{{ old('pages', $ebook?->pages) }}"
                     min="1" placeholder="0"
                     class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
            </div>
          </div>

          {{-- Akses --}}
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tipe Akses <span class="text-red-400">*</span></label>
            <div class="grid grid-cols-2 gap-2">
              @foreach(['free' => ['Gratis','bg-emerald-50 dark:bg-emerald-900/30 border-emerald-400 text-emerald-700 dark:text-emerald-400','Semua member'], 'premium' => ['⭐ Premium','bg-amber-50 dark:bg-amber-900/30 border-amber-400 text-amber-700 dark:text-amber-400','Member premium']] as $val => [$lbl,$cls,$desc])
              <label class="relative cursor-pointer">
                <input type="radio" name="access" value="{{ $val }}"
                       {{ old('access', $ebook?->access ?? 'free') === $val ? 'checked' : '' }}
                       class="sr-only peer">
                <div class="peer-checked:{{ $cls }} peer-checked:border-2 border-2 border-slate-200 dark:border-slate-600 rounded-xl p-3 text-center hover:border-slate-300 transition bg-slate-50 dark:bg-slate-700/50">
                  <p class="font-bold text-xs text-slate-700 dark:text-slate-300 peer-checked:text-current">{{ $lbl }}</p>
                  <p class="text-[10px] text-slate-400 mt-0.5">{{ $desc }}</p>
                </div>
              </label>
              @endforeach
            </div>
          </div>

          {{-- Publish --}}
          <div class="flex items-center justify-between py-3 border-t border-slate-100 dark:border-slate-700">
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Langsung Publish</span>
            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
              <input type="hidden" name="is_published" value="0">
              <input type="checkbox" name="is_published" value="1"
                     {{ old('is_published', $ebook?->is_published ?? true) ? 'checked' : '' }}
                     class="sr-only peer">
              <div class="w-10 h-[22px] bg-slate-200 dark:bg-slate-600 peer-checked:bg-rose-500 rounded-full transition-colors"></div>
              <div class="absolute left-0.5 top-0.5 w-[18px] h-[18px] bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-[18px]"></div>
            </label>
          </div>

        </div>

        {{-- Actions --}}
        <div class="px-5 pb-5 flex gap-3">
          <button type="submit"
            class="flex-1 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl transition shadow-sm active:scale-95">
            {{ $ebook ? 'Simpan' : 'Upload Ebook' }}
          </button>
          <a href="{{ route('admin.ebooks.index') }}"
            class="flex-1 py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl transition text-center">
            Batal
          </a>
        </div>
      </div>
    </div>

  </form>
</div>
@endsection