{{-- resources/views/admin/categories/form.blade.php --}}
@extends('layouts.admin')
@section('title', $category ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')

<div class="max-w-2xl mx-auto space-y-6">

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
        {{ $category ? 'Perbarui detail kategori' : 'Buat kategori baru untuk konten' }}
      </p>
    </div>
  </div>

  {{-- Form --}}
  <form method="POST"
        action="{{ $category ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
        class="space-y-5">
    @csrf
    @if($category) @method('PUT') @endif

    @if($errors->any())
    <div class="px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 rounded-xl text-sm">
      <ul class="list-disc ml-4 space-y-0.5">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
    @endif

    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">

      {{-- ── Informasi Dasar ── --}}
      <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Kategori</h3>
      </div>

      <div class="p-6 space-y-5">

        {{-- Nama --}}
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
            Nama Kategori <span class="text-red-400">*</span>
          </label>
          <input type="text" name="name"
                 value="{{ old('name', $category?->name) }}"
                 required placeholder="Contoh: Manajemen Keperawatan"
                 class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl
                        bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400
                        focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        </div>

        {{-- Slug --}}
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
            Slug <span class="text-xs font-normal text-slate-400 normal-case">(otomatis)</span>
          </label>
          <div class="relative">
            <input type="text" name="slug" id="slugInput"
                  value="{{ old('slug', $category?->slug) }}"
                  readonly
                  placeholder="akan-terisi-otomatis"
                  class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl
                          bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 font-mono
                          focus:outline-none cursor-not-allowed">
            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400">auto</span>
          </div>
          <p class="text-xs text-slate-400 mt-1">Terisi otomatis dari nama kategori</p>
        </div>

        {{-- Warna & Urutan --}}
        <div class="grid grid-cols-2 gap-4">

          {{-- Warna --}}
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
              Warna Label <span class="text-red-400">*</span>
            </label>
            <div class="flex items-center gap-3">
              <input type="color" name="color" id="colorPicker"
                     value="{{ old('color', $category?->color ?? '#3b82f6') }}"
                     class="w-10 h-10 rounded-xl border border-slate-200 dark:border-slate-600 cursor-pointer bg-white dark:bg-slate-700 p-0.5 flex-shrink-0">
              <input type="text" id="colorHex"
                     value="{{ old('color', $category?->color ?? '#3b82f6') }}"
                     placeholder="#3b82f6" maxlength="7"
                     class="flex-1 px-3 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl
                            bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white font-mono
                            focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div class="mt-2 flex items-center gap-2">
              <span class="w-4 h-4 rounded-full border-2 border-white dark:border-slate-700 shadow-sm flex-shrink-0"
                    id="colorPreview"
                    style="background-color: {{ old('color', $category?->color ?? '#3b82f6') }}"></span>
              <span class="text-xs text-slate-400">Preview warna badge</span>
            </div>
          </div>

          {{-- Urutan --}}
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
              Urutan Tampil
            </label>
            <input type="number" name="sort_order" min="0"
                   value="{{ old('sort_order', $category?->sort_order ?? 0) }}"
                   class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl
                          bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white
                          focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            <p class="text-xs text-slate-400 mt-1">Angka kecil = tampil lebih awal</p>
          </div>

        </div>
      </div>

      {{-- ── Tipe Konten (Checkboxes) ── --}}
      <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700 flex items-center gap-2">
        <div class="w-2 h-2 rounded-full bg-violet-500"></div>
        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Tipe Konten</h3>
        <span class="text-xs text-slate-400 font-normal ml-1">— pilih satu atau lebih <span class="text-red-400">*</span></span>
      </div>

      <div class="px-6 pb-6">
        @error('type')
        <p class="text-xs text-red-500 mb-3 flex items-center gap-1">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          {{ $message }}
        </p>
        @enderror

        @php
          // Ambil nilai yang sudah tersimpan (array dari cast) atau dari old()
          // old('type') = array karena name="type[]"
          $selectedTypes = old('type', $category ? (array)($category->type ?? []) : []);
        @endphp

        <div class="grid grid-cols-3 gap-3" id="typeGrid">

          @php
          $typeOptions = [
            ['artikel', 'Artikel',  '📰', 'sky'],
            ['jurnal',  'Jurnal',   '📚', 'violet'],
            ['materi',  'Materi',   '📖', 'amber'],
            ['ebook',   'E-Book',   '💻', 'emerald'],
            ['event',   'Event',    '🗓️', 'rose'],
            ['lainnya', 'Lainnya',  '📂', 'slate'],
          ];
          @endphp

          @foreach($typeOptions as [$val, $label, $icon, $color])
          @php $checked = in_array($val, (array)$selectedTypes); @endphp
          <label class="type-card cursor-pointer select-none" data-color="{{ $color }}">
            <input type="checkbox" name="type[]" value="{{ $val }}"
                   class="sr-only type-cb"
                   {{ $checked ? 'checked' : '' }}>
            <div class="type-card-inner flex flex-col items-center justify-center gap-2
                        px-3 py-4 rounded-2xl border-2 transition-all
                        {{ $checked
                          ? 'border-'.$color.'-500 bg-'.$color.'-50 dark:bg-'.$color.'-900/20 shadow-sm'
                          : 'border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 hover:border-slate-300' }}">
              <span class="text-xl leading-none">{{ $icon }}</span>
              <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $label }}</span>
              {{-- Checkmark badge --}}
              <div class="type-check w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all
                          {{ $checked
                            ? 'bg-'.$color.'-500 border-'.$color.'-500'
                            : 'border-slate-300 dark:border-slate-500' }}">
                @if($checked)
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
                @endif
              </div>
            </div>
          </label>
          @endforeach

        </div>

      </div>

      {{-- ── Status Aktif ── --}}
      <div class="px-6 py-5 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between">
        <div>
          <p class="text-sm font-semibold text-slate-900 dark:text-white">Status Aktif</p>
          <p class="text-xs text-slate-400 mt-0.5">Kategori nonaktif tidak muncul di pilihan konten</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="hidden" name="is_active" value="0">
          <input type="checkbox" name="is_active" value="1"
                 {{ old('is_active', $category?->is_active ?? true) ? 'checked' : '' }}
                 class="sr-only peer">
          <div class="w-11 h-6 bg-slate-200 dark:bg-slate-700 rounded-full
                      peer peer-checked:bg-blue-500
                      after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                      after:bg-white after:rounded-full after:h-5 after:w-5
                      after:transition-all peer-checked:after:translate-x-full"></div>
        </label>
      </div>

    </div>

    {{-- Tombol aksi --}}
    <div class="flex gap-3">
      <button type="submit"
              class="flex-1 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition shadow-sm shadow-blue-500/25 active:scale-95">
        {{ $category ? 'Simpan Perubahan' : 'Tambah Kategori' }}
      </button>
      <a href="{{ route('admin.categories.index') }}"
         class="px-6 py-3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl transition text-center">
        Batal
      </a>
    </div>

  </form>
</div>

<script>
// ── Color picker sync ──
const picker   = document.getElementById('colorPicker');
const hexInput = document.getElementById('colorHex');
const preview  = document.getElementById('colorPreview');

picker.addEventListener('input', () => {
  hexInput.value = picker.value;
  preview.style.backgroundColor = picker.value;
});
hexInput.addEventListener('input', () => {
  const v = hexInput.value;
  if (/^#[0-9A-Fa-f]{6}$/.test(v)) {
    picker.value = v;
    preview.style.backgroundColor = v;
  }
});

// ── Checkbox type card interaction ──
// Karena Tailwind dynamic classes (bg-sky-500 dll) mungkin tidak di-purge,
// kita pakai inline style untuk warna aktif agar selalu tampil
const colorMap = {
  sky:     { bg: '#e0f2fe', border: '#0ea5e9', check: '#0ea5e9', dark: '#0c4a6e' },
  violet:  { bg: '#ede9fe', border: '#8b5cf6', check: '#8b5cf6', dark: '#2e1065' },
  amber:   { bg: '#fef3c7', border: '#f59e0b', check: '#f59e0b', dark: '#451a03' },
  emerald: { bg: '#d1fae5', border: '#10b981', check: '#10b981', dark: '#022c22' },
  rose:    { bg: '#ffe4e6', border: '#f43f5e', check: '#f43f5e', dark: '#4c0519' },
  slate:   { bg: '#f1f5f9', border: '#64748b', check: '#64748b', dark: '#0f172a' },
};

document.querySelectorAll('.type-card').forEach(card => {
  const cb     = card.querySelector('.type-cb');
  const inner  = card.querySelector('.type-card-inner');
  const check  = card.querySelector('.type-check');
  const color  = colorMap[card.dataset.color] || colorMap.slate;

  const render = () => {
    if (cb.checked) {
      inner.style.borderColor     = color.border;
      inner.style.backgroundColor = color.bg;
      inner.style.boxShadow       = '0 1px 4px 0 '+color.border+'44';
      check.style.backgroundColor = color.check;
      check.style.borderColor     = color.check;
      check.innerHTML = `<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
      </svg>`;
    } else {
      inner.style.borderColor     = '';
      inner.style.backgroundColor = '';
      inner.style.boxShadow       = '';
      check.style.backgroundColor = '';
      check.style.borderColor     = '';
      check.innerHTML = '';
    }
  };

  render(); // init state
  cb.addEventListener('change', render);
});

// ── Auto-slug dari nama ──
const nameInput = document.querySelector('input[name="name"]');
const slugInput = document.getElementById('slugInput');

function toSlug(str) {
  return str
    .toLowerCase()
    .trim()
    .replace(/[^\w\s-]/g, '')   // hapus karakter spesial
    .replace(/[\s_-]+/g, '-')   // spasi/underscore jadi dash
    .replace(/^-+|-+$/g, '');   // trim dash di tepi
}

nameInput.addEventListener('input', () => {
  slugInput.value = toSlug(nameInput.value);
});
</script>

@endsection