@extends('layouts.admin')
@section('title', 'Tambah Kegiatan')
@section('content')

<div class="space-y-6"
     x-data="{ preview: null, dragging: false, handleFile(f) { if(!f||!f.type.startsWith('image/'))return; const r=new FileReader(); r.onload=e=>this.preview=e.target.result; r.readAsDataURL(f); } }">

  {{-- Header --}}
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Tambah Kegiatan</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Buat kegiatan atau acara baru HPMI</p>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf

    @if($errors->any())
    <div class="px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 rounded-xl text-sm">
      <ul class="space-y-0.5 list-disc ml-4">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- LEFT 2/3 --}}
      <div class="lg:col-span-2 space-y-5">

        {{-- Informasi Utama --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-violet-500"></div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Kegiatan</h3>
          </div>
          <div class="p-6 space-y-5">
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Judul Kegiatan <span class="text-red-400">*</span></label>
              <input type="text" name="title" value="{{ old('title') }}" required placeholder="Nama kegiatan atau acara..."
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Deskripsi</label>
              <textarea name="description" rows="5" placeholder="Jelaskan detail kegiatan, tujuan, dan manfaatnya..."
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition resize-none">{{ old('description') }}</textarea>
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Syarat & Ketentuan</label>
              <textarea name="requirements" rows="3" placeholder="Persyaratan peserta, dokumen yang dibutuhkan..."
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition resize-none">{{ old('requirements') }}</textarea>
            </div>
          </div>
        </div>

        {{-- Waktu & Lokasi --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-sky-500"></div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Waktu & Lokasi</h3>
          </div>
          <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tanggal Mulai <span class="text-red-400">*</span></label>
                <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required
                  class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tanggal Selesai</label>
                <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                  class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
              </div>
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Lokasi / Alamat</label>
              <input type="text" name="location" value="{{ old('location') }}" placeholder="Gedung X, Jakarta / Online"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Link Meeting (opsional)</label>
              <input type="url" name="meeting_url" value="{{ old('meeting_url') }}" placeholder="https://zoom.us/j/..."
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
            </div>
          </div>
        </div>

        {{-- Thumbnail --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Thumbnail</h3>
          </div>
          <div class="p-6 space-y-4">
            <label class="block cursor-pointer"
              @dragover.prevent="dragging=true" @dragleave.prevent="dragging=false"
              @drop.prevent="dragging=false; handleFile($event.dataTransfer.files[0]); $refs.fi.files=$event.dataTransfer.files">
              <div class="relative border-2 border-dashed rounded-2xl transition-all overflow-hidden"
                   :class="dragging?'border-violet-500 bg-violet-50 dark:bg-violet-900/10':'border-slate-200 dark:border-slate-600 hover:border-violet-400 dark:hover:border-violet-500 hover:bg-slate-50 dark:hover:bg-slate-700/30'">
                <div x-show="preview">
                  <img :src="preview" class="w-full h-48 object-cover rounded-2xl">
                  <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition flex items-center justify-center rounded-2xl">
                    <span class="text-white text-sm font-semibold">Klik untuk ganti</span>
                  </div>
                </div>
                <div x-show="!preview" class="flex flex-col items-center justify-center py-10">
                  <div class="w-12 h-12 rounded-xl bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                  </div>
                  <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">Drag & drop atau <span class="text-violet-600 dark:text-violet-400">pilih file</span></p>
                  <p class="text-xs text-slate-400 mt-1">PNG, JPG, WEBP — Maks. 2MB</p>
                </div>
              </div>
              <input type="file" name="thumbnail_file" accept="image/*" x-ref="fi" class="sr-only" @change="handleFile($event.target.files[0])">
            </label>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Atau masukkan URL gambar</label>
              <input type="text" name="thumbnail" value="{{ old('thumbnail') }}" placeholder="https://..."
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
            </div>
          </div>
        </div>

      </div>

      {{-- RIGHT 1/3 --}}
      <div class="space-y-5">

        {{-- Pengaturan --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden sticky top-5">
          <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-amber-500"></div>
            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Pengaturan Acara</h4>
          </div>
          <div class="p-5 space-y-4">
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Status</label>
              <select name="status" class="w-full px-3 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition cursor-pointer">
                <option value="draft"     {{ old('status')=='draft'?'selected':'' }}>📝 Draft</option>
                <option value="open"      {{ old('status')=='open'?'selected':'' }}>✅ Buka Pendaftaran</option>
                <option value="closed"    {{ old('status')=='closed'?'selected':'' }}>🔒 Tutup Pendaftaran</option>
                <option value="completed" {{ old('status')=='completed'?'selected':'' }}>🏆 Selesai</option>
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
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Kuota Peserta</label>
              <input type="number" name="quota" value="{{ old('quota') }}" min="0" placeholder="Kosongkan = tak terbatas"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Harga (Rp)</label>
              <input type="number" name="price" value="{{ old('price', 0) }}" min="0"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 transition">
            </div>
            <div class="space-y-2.5 pt-1">
              <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                <input type="checkbox" name="is_free" value="1" {{ old('is_free')?'checked':'' }} class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-emerald-500 focus:ring-emerald-400">
                Gratis
              </label>
              <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                <input type="checkbox" name="is_member_only" value="1" {{ old('is_member_only')?'checked':'' }} class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-violet-500 focus:ring-violet-400">
                Khusus Anggota
              </label>
            </div>
          </div>
          <div class="px-5 pb-5 flex gap-3">
            <button type="submit" class="flex-1 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shadow-violet-500/25 active:scale-95">Simpan</button>
            <a href="{{ route('admin.events.index') }}" class="flex-1 py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl transition text-center">Batal</a>
          </div>
        </div>

      </div>
    </div>
  </form>
</div>
@endsection
