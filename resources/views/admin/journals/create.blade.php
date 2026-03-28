@extends('layouts.admin')
@section('title', 'Upload Jurnal')
@section('content')

<div class="space-y-6"
     x-data="{
       file: null,
       fileName: '',
       fileSize: '',
       fileType: '',
       dragging: false,
       handleFile(f) {
         if (!f) return;
         const allowed = ['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
         if (!allowed.includes(f.type)) {
           alert('Format file tidak didukung. Gunakan PDF, DOC, atau DOCX.');
           return;
         }
         if (f.size > 20 * 1024 * 1024) {
           alert('Ukuran file terlalu besar. Maksimal 20 MB.');
           return;
         }
         this.file     = f;
         this.fileName = f.name;
         this.fileSize = f.size >= 1048576 ? (f.size/1048576).toFixed(1) + ' MB' : (f.size/1024).toFixed(1) + ' KB';
         this.fileType = f.name.split('.').pop().toUpperCase();
       }
     }">

  {{-- Header --}}
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.journals.index') }}"
       class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
    </a>
    <div>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Upload Jurnal</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Tambahkan jurnal ilmiah ke koleksi HPMI</p>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.journals.store') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf

    {{-- Error alert --}}
    @if($errors->any())
    <div class="px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 text-red-600 dark:text-red-400 rounded-xl text-sm">
      <p class="font-semibold mb-1 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Ada kesalahan
      </p>
      <ul class="ml-6 list-disc space-y-0.5 text-xs">
        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
      </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- ── LEFT: Form Utama ── --}}
      <div class="lg:col-span-2 space-y-5">

        {{-- Informasi Jurnal --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-rose-500"></div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Jurnal</h3>
          </div>
          <div class="p-6 space-y-5">

            {{-- Judul --}}
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                Judul Jurnal <span class="text-red-400">*</span>
              </label>
              <input type="text" name="title" value="{{ old('title') }}" 
                     placeholder="Masukkan judul jurnal ilmiah..."
                     class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 dark:focus:ring-rose-400 transition @error('title') border-red-400 dark:border-red-500 @enderror">
              @error('title')
              <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
              </p>
              @enderror
            </div>

            {{-- Author --}}
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                Author / Penulis <span class="text-red-400">*</span>
              </label>
              <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <input type="text" name="author" value="{{ old('author') }}" 
                       placeholder="Nama penulis / peneliti..."
                       class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 dark:focus:ring-rose-400 transition @error('author') border-red-400 dark:border-red-500 @enderror">
              </div>
              @error('author')
              <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
              @enderror
            </div>

            {{-- Abstrak --}}
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Abstrak</label>
              <textarea name="abstract" rows="4" placeholder="Ringkasan / abstrak jurnal..."
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 dark:focus:ring-rose-400 transition resize-none">{{ old('abstract') }}</textarea>
            </div>

          </div>
        </div>

        {{-- Upload File --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-sky-500"></div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">File Jurnal</h3>
          </div>
          <div class="p-6">

            <label for="fileInput" class="block cursor-pointer">
              <div id="dropZone"
                  class="border-2 border-dashed border-slate-200 dark:border-slate-600 rounded-2xl py-10 px-6 text-center hover:border-rose-400 hover:bg-rose-50/30 transition-all duration-200">

                {{-- Icon --}}
                <div class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center mx-auto mb-4">
                  <svg class="w-7 h-7 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                </div>

                {{-- Empty state text --}}
                <div id="emptyState">
                  <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Drag & drop atau <span class="text-rose-600 dark:text-rose-400">pilih file</span>
                  </p>
                  <p class="text-xs text-slate-400 dark:text-slate-500">PDF, DOC, DOCX — Maksimal <strong>20 MB</strong></p>
                </div>

                {{-- File preview (hidden by default) --}}
                <div id="filePreview" class="hidden">
                  <p id="fileNameText" class="text-sm font-semibold text-emerald-700 dark:text-emerald-400"></p>
                  <p id="fileSizeText" class="text-xs text-slate-500 mt-0.5"></p>
                  <p class="text-xs text-slate-400 mt-2">Klik untuk ganti file</p>
                </div>

              </div>

              <input type="file" id="fileInput" name="file" accept=".pdf,.doc,.docx" class="sr-only">
            </label>

            @error('file')
            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              {{ $message }}
            </p>
            @enderror

          </div>
        </div>

      </div>

      {{-- ── RIGHT: Settings & Actions ── --}}
      <div class="space-y-5">

        {{-- Metadata --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden sticky top-5">
          <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-violet-500"></div>
            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Metadata Jurnal</h4>
          </div>
          <div class="p-5 space-y-4">

            {{-- Kategori --}}
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Kategori</label>
              <input type="text" name="category" value="{{ old('category') }}"
                     list="categoryList"
                     placeholder="Cth: Keperawatan, Manajerial..."
                     class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
              @if($categories->count())
              <datalist id="categoryList">
                @foreach($categories as $cat)
                <option value="{{ $cat }}">
                @endforeach
              </datalist>
              @endif
            </div>

            {{-- Volume & Tahun --}}
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Volume</label>
                <input type="text" name="volume" value="{{ old('volume') }}" placeholder="cth: 12"
                  class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tahun</label>
                <input type="number" name="year" value="{{ old('year', date('Y')) }}"
                       min="1900" max="{{ date('Y') + 1 }}"
                       class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
              </div>
            </div>

            {{-- Status Publish --}}
            <div class="pt-1 pb-1">
              <div class="flex items-center justify-between py-3 border-b border-slate-50 dark:border-slate-700/50">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Langsung Publish</span>
                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                  <input type="hidden" name="is_published" value="0">
                  <input type="checkbox" name="is_published" value="1"
                         {{ old('is_published', true) ? 'checked' : '' }}
                         class="sr-only peer">
                  <div class="w-10 h-[22px] bg-slate-200 dark:bg-slate-600 peer-checked:bg-rose-500 rounded-full transition-colors peer-focus:ring-2 peer-focus:ring-rose-300 dark:peer-focus:ring-rose-700"></div>
                  <div class="absolute left-0.5 top-0.5 w-[18px] h-[18px] bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-[18px]"></div>
                </label>
              </div>
            </div>

          </div>

          {{-- Action buttons --}}
          <div class="px-5 pb-5 flex gap-3">
            <button type="submit"
              class="flex-1 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shadow-rose-500/25 active:scale-95">
              Upload Jurnal
            </button>
            <a href="{{ route('admin.journals.index') }}"
              class="flex-1 py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl transition text-center">
              Batal
            </a>
          </div>
        </div>

        {{-- Tips box --}}
        <div class="bg-rose-50 dark:bg-rose-900/10 rounded-2xl border border-rose-100 dark:border-rose-900/30 p-5">
          <h4 class="text-sm font-semibold text-rose-700 dark:text-rose-300 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Panduan Upload
          </h4>
          <ul class="space-y-1.5 text-xs text-rose-700 dark:text-rose-400">
            <li class="flex items-start gap-1.5"><span class="mt-0.5 font-bold">•</span> Format: PDF, DOC, atau DOCX</li>
            <li class="flex items-start gap-1.5"><span class="mt-0.5 font-bold">•</span> Ukuran maks: 20 MB per file</li>
            <li class="flex items-start gap-1.5"><span class="mt-0.5 font-bold">•</span> Judul & author wajib diisi</li>
            <li class="flex items-start gap-1.5"><span class="mt-0.5 font-bold">•</span> Abstrak membantu pencarian</li>
            <li class="flex items-start gap-1.5"><span class="mt-0.5 font-bold">•</span> Status Draft: tidak tampil publik</li>
          </ul>
        </div>

      </div>

    </div>
  </form>
  
</div>
@endsection
