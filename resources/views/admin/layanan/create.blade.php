
@extends('layouts.admin')

@section('title', 'Tambah Layanan')

@section('content')
<div class="px-6 py-6 max-w-3xl">

    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.layanan.index') }}" class="hover:text-blue-600 transition">Manajemen Layanan</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">Tambah Layanan</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Layanan Baru</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.layanan.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Nama & Ikon --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Layanan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-400 @enderror"
                           placeholder="cth. Poli Jantung">
                    @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Ikon (Emoji)</label>
                    <input type="text" name="ikon" value="{{ old('ikon') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-2xl text-center focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="❤️" maxlength="5">
                    @error('ikon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Kategori & Urutan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($kategoriOptions as $k)
                            <option value="{{ $k }}" @selected(old('kategori') === $k)>{{ $k }}</option>
                        @endforeach
                    </select>
                    @error('kategori')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Urutan <span class="text-red-500">*</span></label>
                    <input type="number" name="urutan" value="{{ old('urutan', 1) }}" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('urutan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Deskripsi Singkat --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Singkat <span class="text-red-500">*</span></label>
                <textarea name="deskripsi_singkat" rows="3" maxlength="500"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none @error('deskripsi_singkat') border-red-400 @enderror"
                          placeholder="Deskripsi singkat yang tampil di kartu layanan...">{{ old('deskripsi_singkat') }}</textarea>
                @error('deskripsi_singkat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Deskripsi Lengkap --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Lengkap</label>
                <textarea name="deskripsi_lengkap" rows="6"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                          placeholder="Deskripsi detail layanan (mendukung HTML)...">{{ old('deskripsi_lengkap') }}</textarea>
                @error('deskripsi_lengkap')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Gambar Banner (opsional)</label>
                <input type="file" name="gambar" accept="image/*"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WebP. Maks 2MB.</p>
                @error('gambar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="aktif" @checked(old('status','aktif') === 'aktif') class="accent-blue-600">
                        <span class="text-sm text-gray-700">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="nonaktif" @checked(old('status') === 'nonaktif') class="accent-blue-600">
                        <span class="text-sm text-gray-700">Nonaktif</span>
                    </label>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2.5 rounded-xl transition">
                    Simpan Layanan
                </button>
                <a href="{{ route('admin.layanan.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-800 px-4 py-2.5 rounded-xl hover:bg-gray-100 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection