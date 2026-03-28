{{-- resources/views/admin/categories/form.blade.php --}}
@extends('layouts.admin')
@section('title', $category ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')

<div class="space-y-6 max-w-2xl">

  {{-- Header --}}
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.categories.index') }}"
       class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
    </a>
    <div>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
        {{ $category ? 'Edit Kategori' : 'Tambah Kategori' }}
      </h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
        {{ $category ? 'Perbarui data kategori "'.$category->name.'"' : 'Buat kategori baru untuk konten' }}
      </p>
    </div>
  </div>

  {{-- Error --}}
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

  <form method="POST"
        action="{{ $category ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
        class="space-y-5">
    @csrf
    @if($category) @method('PUT') @endif

    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
        <div class="w-2 h-2 rounded-full bg-rose-500"></div>
        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Kategori</h3>
      </div>
      <div class="p-6 space-y-5">

        {{-- Nama --}}
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
            Nama Kategori <span class="text-red-400">*</span>
          </label>
          <input type="text" name="name" id="name" value="{{ old('name', $category?->name) }}"
                 placeholder="Contoh: Keperawatan Kritis"
                 class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 transition @error('name') border-red-400 @enderror">
          {{-- Slug preview --}}
          <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">
            Slug: <code id="slugPreview" class="bg-slate-100 dark:bg-slate-700 px-1.5 py-0.5 rounded text-slate-500 dark:text-slate-400">
              {{ $category?->slug ?? '—' }}
            </code>
          </p>
          @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Deskripsi --}}
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Deskripsi</label>
          <textarea name="description" rows="3" placeholder="Deskripsi singkat kategori ini..."
            class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 transition resize-none">{{ old('description', $category?->description) }}</textarea>
        </div>

        {{-- Tipe & Sort Order --}}
        {{-- Tipe (checklist multi-pilih) --}}
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-3">
            Tipe <span class="text-red-400">*</span>
          </label>

          @php
            $selectedTypes = old('type', $category?->type ?? []);
            if (is_string($selectedTypes)) $selectedTypes = json_decode($selectedTypes, true) ?? [];
            $tipes = [
              'artikel' => ['Artikel & Berita', '📰', 'sky'],
              'jurnal'  => ['Jurnal Ilmiah',    '📚', 'violet'],
              'materi'  => ['Materi Edukasi',   '🎓', 'amber'],
            ];
          @endphp

          <div class="space-y-2">
            @foreach($tipes as $val => [$label, $icon, $color])
            <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all select-none
                          {{ in_array($val, (array)$selectedTypes)
                            ? 'border-'.$color.'-400 bg-'.$color.'-50 dark:bg-'.$color.'-900/20'
                            : 'border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 hover:border-slate-300 dark:hover:border-slate-500' }}"
                  id="label-{{ $val }}">

              {{-- Checkbox custom --}}
              <div class="relative flex-shrink-0">
                <input type="checkbox"
                      name="type[]"
                      value="{{ $val }}"
                      id="type-{{ $val }}"
                      {{ in_array($val, (array)$selectedTypes) ? 'checked' : '' }}
                      class="sr-only peer"
                      onchange="toggleTypeLabel('{{ $val }}', '{{ $color }}', this.checked)">
                <div id="box-{{ $val }}"
                    class="w-5 h-5 rounded-md border-2 flex items-center justify-center transition-all
                            {{ in_array($val, (array)$selectedTypes)
                              ? 'bg-'.$color.'-500 border-'.$color.'-500'
                              : 'border-slate-300 dark:border-slate-500 bg-white dark:bg-slate-700' }}">
                  <svg class="{{ in_array($val, (array)$selectedTypes) ? '' : 'hidden' }} w-3 h-3 text-white" id="check-{{ $val }}"
                      fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
              </div>

              {{-- Label --}}
              <span class="text-lg leading-none">{{ $icon }}</span>
              <div class="flex-1">
                <p class="text-sm font-semibold text-slate-800 dark:text-white">{{ $label }}</p>
              </div>

              {{-- Badge aktif --}}
              <span id="badge-{{ $val }}"
                    class="text-[10px] font-bold px-2 py-0.5 rounded-full transition-all
                          {{ in_array($val, (array)$selectedTypes) ? 'bg-'.$color.'-100 dark:bg-'.$color.'-900/40 text-'.$color.'-600 dark:text-'.$color.'-400' : 'hidden' }}">
                ✓ Dipilih
              </span>

            </label>
            @endforeach
          </div>

          @error('type')
          <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            Pilih minimal 1 tipe
          </p>
          @enderror
        </div>

        {{-- Warna --}}
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Warna Badge</label>
          <div class="flex items-center gap-3">
            <input type="color" name="color" id="colorPicker" value="{{ old('color', $category?->color ?? '#6366f1') }}"
                   class="w-10 h-10 rounded-xl border border-slate-200 dark:border-slate-600 cursor-pointer bg-transparent p-0.5">
            <input type="text" id="colorHex" value="{{ old('color', $category?->color ?? '#6366f1') }}"
                   class="w-28 px-3 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white font-mono focus:outline-none focus:ring-2 focus:ring-rose-500 transition"
                   placeholder="#6366f1" readonly>
            {{-- Preview badge --}}
            <span id="badgePreview"
                  class="px-3 py-1 rounded-full text-xs font-bold"
                  style="background-color: {{ old('color', $category?->color ?? '#6366f1') }}; color: #fff">
              Preview
            </span>
          </div>
          {{-- Preset colors --}}
          <div class="flex flex-wrap gap-2 mt-3">
            @foreach(['#ef4444','#f97316','#eab308','#22c55e','#06b6d4','#3b82f6','#6366f1','#a855f7','#ec4899','#64748b'] as $preset)
            <button type="button" onclick="setColor('{{ $preset }}')"
                    class="w-6 h-6 rounded-full border-2 border-white dark:border-slate-700 shadow-sm hover:scale-110 transition-transform"
                    style="background-color: {{ $preset }}" title="{{ $preset }}"></button>
            @endforeach
          </div>
        </div>

        {{-- Status Aktif --}}
        <div class="flex items-center justify-between py-3 border-t border-slate-100 dark:border-slate-700">
          <div>
            <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Status Aktif</p>
            <p class="text-xs text-slate-400 dark:text-slate-500">Kategori nonaktif tidak muncul di publik</p>
          </div>
          <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1"
                   {{ old('is_active', $category?->is_active ?? true) ? 'checked' : '' }}
                   class="sr-only peer">
            <div class="w-10 h-[22px] bg-slate-200 dark:bg-slate-600 peer-checked:bg-rose-500 rounded-full transition-colors peer-focus:ring-2 peer-focus:ring-rose-300 dark:peer-focus:ring-rose-700"></div>
            <div class="absolute left-0.5 top-0.5 w-[18px] h-[18px] bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-[18px]"></div>
          </label>
        </div>

      </div>
    </div>

    {{-- Actions --}}
    <div class="flex gap-3">
      <button type="submit"
        class="flex-1 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl transition shadow-sm shadow-rose-500/25 active:scale-95">
        {{ $category ? 'Simpan Perubahan' : 'Tambah Kategori' }}
      </button>
      <a href="{{ route('admin.categories.index') }}"
        class="flex-1 py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl transition text-center">
        Batal
      </a>
    </div>

  </form>
</div>

@push('scripts')
<script>
// Slug preview dari nama
document.getElementById('name').addEventListener('input', function () {
  const slug = this.value.toLowerCase()
    .replace(/[^a-z0-9\s-]/g, '')
    .replace(/\s+/g, '-')
    .replace(/-+/g, '-')
    .trim();
  document.getElementById('slugPreview').textContent = slug || '—';
});

// Sync color picker ↔ hex input ↔ badge preview
const picker = document.getElementById('colorPicker');
const hexInput = document.getElementById('colorHex');
const badge = document.getElementById('badgePreview');

function setColor(hex) {
  picker.value = hex;
  hexInput.value = hex;
  badge.style.backgroundColor = hex;
}

picker.addEventListener('input', () => setColor(picker.value));
</script>
@endpush

@endsection