@extends('layouts.admin')
@section('title', 'Edit Pengurus')
@section('content')

<div class=""
     x-data="{
         preview: '{{ $structure->photo ? Storage::url($structure->photo) : '' }}',
         removed: false,
         handleFile(file) {
             if (!file || !file.type.startsWith('image/')) return;
             const r = new FileReader();
             r.onload = e => { this.preview = e.target.result; this.removed = false; };
             r.readAsDataURL(file);
         },
         removePhoto() { this.preview = null; this.removed = true; }
     }">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.org.index') }}"
           class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Edit Pengurus</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $structure->name }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.org.update', $structure) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="remove_photo" :value="removed ? '1' : '0'">

        <div class="space-y-5">

            {{-- Photo Upload --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-900 dark:text-white text-sm">Foto Pengurus</h3>
                    <button type="button" x-show="preview" @click="removePhoto()"
                            class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus Foto
                    </button>
                </div>
                <div class="p-6 flex items-center gap-6">

                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden ring-4 ring-slate-100 dark:ring-slate-700">
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!preview">
                                <div class="w-full h-full bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-600 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="flex-1">
                        <label class="block cursor-pointer">
                            <div class="border-2 border-dashed border-slate-200 dark:border-slate-600 hover:border-blue-400 dark:hover:border-blue-500 rounded-xl p-5 text-center transition-all hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                <svg class="w-6 h-6 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    <span x-text="preview ? 'Klik untuk ganti foto' : 'Klik untuk pilih foto'"></span>
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">JPG, PNG, WEBP — Maks. 2MB</p>
                            </div>
                            <input type="file" name="photo" accept="image/*" class="sr-only"
                                   @change="handleFile($event.target.files[0])">
                        </label>
                        @error('photo')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Data Utama --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="font-semibold text-slate-900 dark:text-white text-sm">Informasi Pengurus</h3>
                </div>
                <div class="p-6 space-y-4">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $structure->name) }}" required
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('name')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Jabatan <span class="text-red-500">*</span></label>
                            <input type="text" name="position" value="{{ old('position', $structure->position) }}" required
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('position')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Periode</label>
                            <input type="text" name="period" value="{{ old('period', $structure->period) }}"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Bio Singkat</label>
                            <textarea name="bio" rows="3"
                                      class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('bio', $structure->bio) }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-1">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Urutan Tampil</label>
                            <input type="number" name="order_index" value="{{ old('order_index', $structure->order_index) }}" min="0"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <p class="text-xs text-slate-400 mt-1">Angka kecil tampil lebih dulu</p>
                        </div>
                        <div class="flex flex-col justify-center">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Status</label>
                            <label class="inline-flex items-center gap-3 cursor-pointer">
                                <div class="relative">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1"
                                           {{ $structure->is_active ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-300 dark:bg-slate-600 peer-checked:bg-blue-600 rounded-full transition-colors duration-200 peer-focus:ring-2 peer-focus:ring-blue-500/30"></div>
                                    <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-5"></div>
                                </div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3">
                <button type="submit"
                        class="flex-1 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-500/25 transition-all duration-150 active:scale-95">
                    Update Pengurus
                </button>
                <a href="{{ route('admin.org.index') }}"
                   class="flex-1 py-3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl transition text-center">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection