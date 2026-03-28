{{-- resources/views/admin/settings/index.blade.php --}}
{{-- Pure Blade + Vanilla JS — TIDAK menggunakan Alpine.js / React / Livewire --}}

@extends('layouts.admin')
@section('title', 'Pengaturan Website')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" id="settingsForm">
  @csrf @method('PUT')

  {{-- ── Alert sukses ── --}}
  @if(session('success'))
  <div class="flex items-center gap-3 px-4 py-3 mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
  </div>
  @endif

  {{-- ── Alert error ── --}}
  @if($errors->any())
  <div class="px-4 py-3 mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl text-sm">
    <p class="font-semibold mb-1">Ada kesalahan:</p>
    <ul class="list-disc ml-5 space-y-0.5 text-xs">
      @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
  @endif

  {{-- ── Header ── --}}
  <div class="flex items-start justify-between mb-6">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">Konfigurasi</p>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white">Pengaturan Website</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Konfigurasi sistem dan konten homepage</p>
    </div>
    <button type="submit"
      class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition active:scale-95">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
      </svg>
      Simpan Semua
    </button>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ════════════════════════════════════
         KOLOM KIRI (2/3)
    ════════════════════════════════════ --}}
    <div class="lg:col-span-2 space-y-5">

      {{-- ── Informasi Organisasi ── --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          </div>
          <div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Organisasi</h3>
            <p class="text-xs text-slate-400 mt-0.5">Identitas dan kontak resmi</p>
          </div>
        </div>
        <div class="space-y-4">
          @php
          $orgFields = [
            ['org_name',        'Nama Organisasi',    'text',  'Himpunan Perawat Manajer Indonesia'],
            ['org_tagline',     'Tagline / Slogan',   'text',  'Bersama Membangun Keperawatan Manajerial Indonesia'],
            ['contact_email',   'Email Sekretariat',  'email', 'sekretariat@hpmi.id'],
            ['contact_phone',   'No. Telepon',        'text',  '021-12345678'],
          ];
          @endphp

          @foreach($orgFields as [$key, $label, $type, $placeholder])
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">{{ $label }}</label>
            <input type="{{ $type }}" name="{{ $key }}"
              value="{{ $settings[$key]?->value ?? '' }}"
              placeholder="{{ $placeholder }}"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
          </div>
          @endforeach

          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Deskripsi Organisasi</label>
            <textarea name="org_description" rows="2" placeholder="Deskripsi singkat..."
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none">{{ $settings['org_description']?->value ?? '' }}</textarea>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Alamat</label>
            <textarea name="contact_address" rows="2" placeholder="Jl. Kesehatan No. 1, Jakarta Pusat"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none">{{ $settings['contact_address']?->value ?? '' }}</textarea>
          </div>
        </div>
      </div>

      {{-- ════════════════════════════════════
           BANNER SLIDER — Pure Blade + Vanilla JS
           Data diambil dari $slides (PHP variable)
           yang sudah diproses di controller
      ════════════════════════════════════ --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">

        {{-- Header banner --}}
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 flex-shrink-0">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="3" width="20" height="14" rx="2"/>
                <path d="M8 21h8M12 17v4"/>
              </svg>
            </div>
            <div>
              <h3 class="text-sm font-bold text-slate-900 dark:text-white">Banner Slider Homepage</h3>
              <p class="text-xs text-slate-400 mt-0.5">Gambar disimpan ke storage • Rekomendasi <strong class="text-indigo-500">1366 × 768 px</strong></p>
            </div>
          </div>
        </div>

        {{-- Tab buttons (Pure Blade — tidak perlu JS untuk render) --}}
        <div class="flex border-b border-slate-100 dark:border-slate-700 overflow-x-auto" id="slideTabs">
          @foreach($slides as $slide)
          <button type="button"
            onclick="showSlide({{ $slide['index'] }})"
            id="tab-{{ $slide['index'] }}"
            class="slide-tab relative flex items-center gap-2 px-5 py-3 text-xs font-semibold whitespace-nowrap transition-all flex-shrink-0
              {{ $slide['index'] === 1
                ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 bg-indigo-50/50'
                : 'text-slate-500 dark:text-slate-400 hover:text-slate-700' }}">
            <span class="w-5 h-5 rounded-full text-[10px] font-black flex items-center justify-center
              {{ $slide['active'] ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 dark:bg-slate-700 text-slate-400' }}">
              {{ $slide['index'] }}
            </span>
            Slide {{ $slide['index'] }}
            @if($slide['active'] && $slide['preview_url'])
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 absolute top-2 right-2"></span>
            @elseif(!$slide['active'])
              <span class="w-1.5 h-1.5 rounded-full bg-slate-300 absolute top-2 right-2"></span>
            @endif
          </button>
          @endforeach
        </div>

        {{-- Panel setiap slide — semua di-render oleh Blade, JS hanya toggle show/hide --}}
        <div class="p-6">
          @foreach($slides as $slide)
          <div id="panel-{{ $slide['index'] }}"
               class="slide-panel space-y-5 {{ $slide['index'] !== 1 ? 'hidden' : '' }}">

            {{-- Toggle aktif --}}
            <div class="flex items-center justify-between">
              <label class="text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide">
                Gambar Banner Slide {{ $slide['index'] }}
              </label>
              <label class="flex items-center gap-2 cursor-pointer select-none">
                <input type="hidden" name="banner_slide_{{ $slide['index'] }}_active" value="0">
                <input type="checkbox"
                  name="banner_slide_{{ $slide['index'] }}_active"
                  value="1"
                  id="active-{{ $slide['index'] }}"
                  {{ $slide['active'] ? 'checked' : '' }}
                  class="sr-only peer">
                <div class="relative w-9 h-5 bg-slate-200 dark:bg-slate-600 rounded-full transition peer-checked:bg-indigo-500">
                  <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"
                       id="toggle-thumb-{{ $slide['index'] }}"></div>
                </div>
                <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Tampilkan</span>
              </label>
            </div>

            {{-- ── Upload gambar ── --}}
            <div>
              {{-- Drop zone — klik membuka file picker --}}
              <label for="file-{{ $slide['index'] }}"
                class="block cursor-pointer group"
                id="dropzone-{{ $slide['index'] }}"
                ondragover="event.preventDefault()"
                ondrop="handleDrop(event, {{ $slide['index'] }})">

                <div class="relative border-2 border-dashed rounded-2xl overflow-hidden transition-all
                  {{ $slide['preview_url'] ? 'border-indigo-300 dark:border-indigo-600' : 'border-slate-200 dark:border-slate-600 group-hover:border-indigo-400' }}"
                  id="dropzone-inner-{{ $slide['index'] }}">

                  {{-- Preview dari DB (sudah ada gambar) --}}
                  @if($slide['preview_url'])
                  <div class="relative" id="preview-wrap-{{ $slide['index'] }}">
                    <img src="{{ $slide['preview_url'] }}"
                         alt="Slide {{ $slide['index'] }}"
                         class="w-full object-cover rounded-2xl"
                         style="aspect-ratio:1366/768; max-height:220px;"
                         id="preview-img-{{ $slide['index'] }}">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all rounded-2xl flex items-center justify-center">
                      <span class="opacity-0 group-hover:opacity-100 transition text-white text-sm font-semibold bg-black/50 px-4 py-2 rounded-xl">Klik untuk ganti</span>
                    </div>
                    <div class="absolute bottom-2 left-2 px-2 py-0.5 bg-black/60 text-white text-[10px] font-mono rounded-lg">1366 × 768</div>
                  </div>
                  @else
                  {{-- Placeholder — belum ada gambar --}}
                  <div class="flex flex-col items-center justify-center py-10 gap-3" id="placeholder-{{ $slide['index'] }}">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
                      <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                    </div>
                    <div class="text-center">
                      <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">
                        Drag & drop atau <span class="text-indigo-600 dark:text-indigo-400">pilih file</span>
                      </p>
                      <p class="text-xs text-slate-400 mt-1">PNG, JPG, WEBP • Rekomendasi <strong>1366 × 768 px</strong></p>
                    </div>
                  </div>
                  @endif

                  {{-- Preview baru (muncul setelah user pilih file baru, via JS) --}}
                  @if(!$slide['preview_url'])
                  <div class="hidden relative" id="new-preview-wrap-{{ $slide['index'] }}">
                    <img src="" alt="Preview baru"
                         class="w-full object-cover rounded-2xl"
                         style="aspect-ratio:1366/768; max-height:220px;"
                         id="new-preview-img-{{ $slide['index'] }}">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all rounded-2xl flex items-center justify-center">
                      <span class="opacity-0 group-hover:opacity-100 transition text-white text-sm font-semibold bg-black/50 px-4 py-2 rounded-xl">Klik untuk ganti</span>
                    </div>
                  </div>
                  @endif

                </div>
              </label>

              {{-- Input file tersembunyi --}}
              <input type="file"
                id="file-{{ $slide['index'] }}"
                name="banner_slide_{{ $slide['index'] }}_image_file"
                accept="image/jpeg,image/png,image/webp"
                class="sr-only"
                onchange="previewImage(this, {{ $slide['index'] }})">
            </div>

            {{-- ── Field teks slide ── --}}
            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Judul Slide</label>
                <input type="text"
                  name="banner_slide_{{ $slide['index'] }}_title"
                  value="{{ $slide['title'] }}"
                  placeholder="Judul slide banner..."
                  id="input-title-{{ $slide['index'] }}"
                  oninput="updatePreview({{ $slide['index'] }})"
                  class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
              </div>
              <div class="col-span-2">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Subtitle</label>
                <input type="text"
                  name="banner_slide_{{ $slide['index'] }}_subtitle"
                  value="{{ $slide['subtitle'] }}"
                  placeholder="Deskripsi singkat..."
                  id="input-subtitle-{{ $slide['index'] }}"
                  oninput="updatePreview({{ $slide['index'] }})"
                  class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">URL Tautan (opsional)</label>
                <input type="text"
                  name="banner_slide_{{ $slide['index'] }}_link"
                  value="{{ $slide['link'] }}"
                  placeholder="https://..."
                  class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Warna Overlay</label>
                <div class="flex items-center gap-3">
                  <input type="color"
                    name="banner_slide_{{ $slide['index'] }}_color"
                    value="{{ $slide['color'] }}"
                    id="input-color-{{ $slide['index'] }}"
                    oninput="syncColor({{ $slide['index'] }}, this.value); updatePreview({{ $slide['index'] }})"
                    class="w-10 h-10 rounded-xl border border-slate-200 cursor-pointer p-0.5 bg-slate-50">
                  <input type="text"
                    value="{{ $slide['color'] }}"
                    id="color-text-{{ $slide['index'] }}"
                    oninput="syncColor({{ $slide['index'] }}, this.value)"
                    class="flex-1 px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white font-mono focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                </div>
              </div>
            </div>

            {{-- ── Live preview mini (CSS only, update via JS) ── --}}
            <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700"
                 id="mini-preview-{{ $slide['index'] }}"
                 style="{{ !$slide['preview_url'] && !$slide['title'] ? 'display:none' : '' }}">
              <div class="px-3 py-2 bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-400"></span>
                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                <span class="text-xs text-slate-400 ml-1">Preview</span>
              </div>
              <div class="relative overflow-hidden" style="aspect-ratio:1366/768;max-height:160px;"
                   id="mini-preview-bg-{{ $slide['index'] }}"
                   style="background:{{ $slide['color'] }}">
                @if($slide['preview_url'])
                <img src="{{ $slide['preview_url'] }}"
                     class="w-full h-full object-cover absolute inset-0"
                     id="mini-preview-img-{{ $slide['index'] }}">
                @else
                <img src="" class="w-full h-full object-cover absolute inset-0 hidden"
                     id="mini-preview-img-{{ $slide['index'] }}">
                @endif
                <div class="absolute inset-0"
                     id="mini-overlay-{{ $slide['index'] }}"
                     style="background:linear-gradient(to right, {{ $slide['color'] }}cc, {{ $slide['color'] }}44)"></div>
                <div class="absolute inset-0 flex flex-col justify-center px-6 py-4">
                  <p class="text-white font-black text-sm leading-tight" id="preview-title-{{ $slide['index'] }}">
                    {{ $slide['title'] ?: 'Judul Slide' }}
                  </p>
                  <p class="text-white/70 text-[11px] mt-1" id="preview-subtitle-{{ $slide['index'] }}">
                    {{ $slide['subtitle'] }}
                  </p>
                </div>
              </div>
            </div>

          </div>{{-- /panel --}}
          @endforeach
        </div>
      </div>


      {{-- ── Hero Section ── --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-sky-50 dark:bg-sky-900/30 flex items-center justify-center text-sky-600 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
          </div>
          <div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Konten Hero Homepage</h3>
            <p class="text-xs text-slate-400 mt-0.5">Teks pada bagian utama halaman depan</p>
          </div>
        </div>
        <div class="space-y-4">
          @php
          $heroFields = [
            ['hero_badge_text',    'Badge Text',         'text', 'Organisasi Profesi Keperawatan Indonesia'],
            ['hero_title',         'Judul (baris 1)',    'text', 'Himpunan Perawat'],
            ['hero_title_accent',  'Judul Aksen (baris 2)', 'text', 'Manajer Indonesia'],
            ['hero_cta_primary',   'Tombol Utama',       'text', 'Gabung Sekarang'],
            ['hero_cta_secondary', 'Tombol Sekunder',    'text', 'Tentang HPMI'],
          ];
          @endphp
          @foreach($heroFields as [$key, $label, $type, $placeholder])
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">{{ $label }}</label>
            <input type="{{ $type }}" name="{{ $key }}"
              value="{{ $settings[$key]?->value ?? '' }}"
              placeholder="{{ $placeholder }}"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
          </div>
          @endforeach
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Subtitle / Deskripsi</label>
            <textarea name="hero_subtitle" rows="2" placeholder="Bersama membangun kompetensi..."
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none">{{ $settings['hero_subtitle']?->value ?? '' }}</textarea>
          </div>
        </div>
      </div>

      {{-- ── CTA ── --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-500 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/></svg>
          </div>
          <div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Seksi CTA (Ajakan)</h3>
            <p class="text-xs text-slate-400 mt-0.5">Banner ajakan bergabung di bawah homepage</p>
          </div>
        </div>
        <div class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Judul CTA</label>
            <input type="text" name="cta_title" value="{{ $settings['cta_title']?->value ?? '' }}" placeholder="Bergabunglah dengan HPMI"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Subtitle CTA</label>
            <textarea name="cta_subtitle" rows="2" placeholder="Tingkatkan kompetensi Anda..."
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none">{{ $settings['cta_subtitle']?->value ?? '' }}</textarea>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Teks Tombol</label>
            <input type="text" name="cta_button_text" value="{{ $settings['cta_button_text']?->value ?? '' }}" placeholder="Daftar Sekarang"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
          </div>
        </div>
      </div>

      {{-- ── Media Sosial ── --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center text-violet-600 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
          </div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Media Sosial</h3>
        </div>
        <div class="grid grid-cols-2 gap-4">
          @foreach([['social_facebook','Facebook'],['social_instagram','Instagram'],['social_youtube','YouTube'],['social_linkedin','LinkedIn']] as [$key,$label])
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">{{ $label }}</label>
            <input type="text" name="{{ $key }}" value="{{ $settings[$key]?->value ?? '' }}"
              placeholder="https://{{ strtolower($label) }}.com/hpmi"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
          </div>
          @endforeach
        </div>
      </div>

    </div>{{-- /LEFT --}}


    {{-- ════════════════════════════════════
         KOLOM KANAN (1/3)
    ════════════════════════════════════ --}}
    <div class="lg:col-span-1 space-y-5">

      {{-- ── Fitur Website ── --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Fitur Website</h3>
        </div>
        @php
        $features = [
          'feature_registration'       => 'Mode Pendaftaran Anggota',
          'feature_virtual_payment'    => 'Pembayaran Virtual Account',
          'feature_maintenance'        => 'Mode Maintenance',
          'feature_email_notification' => 'Notifikasi Email Otomatis',
          'feature_article_comment'    => 'Komentar Artikel',
          'feature_dark_mode'          => 'Dark Mode Default',
        ];
        @endphp
        <div class="space-y-0.5">
          @foreach($features as $key => $label)
          <div class="flex items-center justify-between py-3 border-b border-slate-50 dark:border-slate-700/50 last:border-0">
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $label }}</span>
            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
              {{-- Hidden input untuk fallback nilai 0 saat checkbox tidak dicentang --}}
              <input type="hidden" name="{{ $key }}" value="0">
              <input type="checkbox" name="{{ $key }}" value="1"
                class="sr-only peer"
                {{ ($settings[$key]?->value ?? '0') === '1' ? 'checked' : '' }}>
              <div class="w-10 h-[22px] bg-slate-200 dark:bg-slate-600 peer-checked:bg-blue-500 rounded-full transition-colors"></div>
              <div class="absolute left-0.5 top-0.5 w-[18px] h-[18px] bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-[18px]"></div>
            </label>
          </div>
          @endforeach
        </div>
      </div>

      {{-- ── Iuran & Keuangan ── --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
          </div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Iuran &amp; Keuangan</h3>
        </div>
        <div class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Biaya Pendaftaran (Rp)</label>
            <div class="relative">
              <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400">Rp</span>
              <input type="number" name="billing_registration_fee"
                value="{{ $settings['billing_registration_fee']?->value ?? '' }}" placeholder="150000"
                class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Iuran Tahunan (Rp)</label>
            <div class="relative">
              <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400">Rp</span>
              <input type="number" name="billing_annual_fee"
                value="{{ $settings['billing_annual_fee']?->value ?? '' }}" placeholder="300000"
                class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Masa Aktif Keanggotaan</label>
            <div class="relative">
              <select name="billing_membership_duration"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition appearance-none cursor-pointer">
                <option value="">-- Pilih Durasi --</option>
                @foreach(['1 Bulan','3 Bulan','6 Bulan','1 Tahun'] as $dur)
                <option value="{{ $dur }}" {{ ($settings['billing_membership_duration']?->value === $dur) ? 'selected' : '' }}>{{ $dur }}</option>
                @endforeach
              </select>
              <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </div>
          </div>
        </div>
      </div>

    </div>{{-- /RIGHT --}}
  </div>
</form>

{{-- ════════════════════════════════════
     VANILLA JAVASCRIPT
     Tidak ada framework — murni JS biasa
     Fungsi: tab slide, preview gambar, sync warna
════════════════════════════════════ --}}
<script>
// ── Tab slide: tampilkan/sembunyikan panel ──────────────────────
function showSlide(index) {
  // Sembunyikan semua panel
  document.querySelectorAll('.slide-panel').forEach(p => p.classList.add('hidden'));
  // Reset semua tab
  document.querySelectorAll('.slide-tab').forEach(t => {
    t.classList.remove('border-b-2', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400', 'bg-indigo-50/50');
    t.classList.add('text-slate-500', 'dark:text-slate-400');
  });

  // Tampilkan panel yang dipilih
  const panel = document.getElementById('panel-' + index);
  if (panel) panel.classList.remove('hidden');

  // Aktifkan tab yang dipilih
  const tab = document.getElementById('tab-' + index);
  if (tab) {
    tab.classList.add('border-b-2', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400', 'bg-indigo-50/50');
    tab.classList.remove('text-slate-500', 'dark:text-slate-400');
  }
}

// ── Preview gambar baru sebelum upload ─────────────────────────
function previewImage(input, index) {
  const file = input.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function(e) {
    const url = e.target.result;

    // Sembunyikan placeholder, tampilkan preview baru
    const placeholder = document.getElementById('placeholder-' + index);
    if (placeholder) placeholder.classList.add('hidden');

    // Tampilkan preview wrap baru
    const newWrap = document.getElementById('new-preview-wrap-' + index);
    const newImg  = document.getElementById('new-preview-img-' + index);
    if (newWrap && newImg) {
      newImg.src = url;
      newWrap.classList.remove('hidden');
    }

    // Jika sudah ada preview lama (dari DB), update gambarnya
    const oldImg = document.getElementById('preview-img-' + index);
    if (oldImg) oldImg.src = url;

    // Update mini preview
    const miniImg = document.getElementById('mini-preview-img-' + index);
    if (miniImg) {
      miniImg.src = url;
      miniImg.classList.remove('hidden');
    }

    // Tampilkan mini preview jika sebelumnya tersembunyi
    const miniPreview = document.getElementById('mini-preview-' + index);
    if (miniPreview) miniPreview.style.display = '';
  };
  reader.readAsDataURL(file);
}

// ── Handle drag & drop ─────────────────────────────────────────
function handleDrop(event, index) {
  event.preventDefault();
  const file = event.dataTransfer.files[0];
  if (!file || !file.type.startsWith('image/')) return;

  // Masukkan file ke input
  const input = document.getElementById('file-' + index);
  const dt = new DataTransfer();
  dt.items.add(file);
  input.files = dt.files;

  // Trigger preview
  previewImage(input, index);
}

// ── Update teks live preview saat mengetik ─────────────────────
function updatePreview(index) {
  const title    = document.getElementById('input-title-' + index)?.value || 'Judul Slide';
  const subtitle = document.getElementById('input-subtitle-' + index)?.value || '';
  const color    = document.getElementById('input-color-' + index)?.value || '#1a4e8a';

  // Update teks di mini preview
  const prevTitle = document.getElementById('preview-title-' + index);
  if (prevTitle) prevTitle.textContent = title;

  const prevSub = document.getElementById('preview-subtitle-' + index);
  if (prevSub) prevSub.textContent = subtitle;

  // Update warna overlay
  const overlay = document.getElementById('mini-overlay-' + index);
  if (overlay) overlay.style.background = `linear-gradient(to right, ${color}cc, ${color}44)`;

  // Tampilkan mini preview jika ada konten
  const miniPreview = document.getElementById('mini-preview-' + index);
  if (miniPreview && title) miniPreview.style.display = '';
}

// ── Sinkronisasi color picker ↔ text input ─────────────────────
function syncColor(index, value) {
  const picker = document.getElementById('input-color-' + index);
  const text   = document.getElementById('color-text-' + index);

  if (picker && picker.value !== value) picker.value = value;
  if (text   && text.value   !== value) text.value   = value;

  // Update overlay mini preview
  const overlay = document.getElementById('mini-overlay-' + index);
  if (overlay) overlay.style.background = `linear-gradient(to right, ${value}cc, ${value}44)`;
}

// ── Handle toggle active (update dot indikator di tab) ─────────
document.querySelectorAll('[id^="active-"]').forEach(checkbox => {
  checkbox.addEventListener('change', function() {
    const index = this.id.replace('active-', '');
    const thumb = document.getElementById('toggle-thumb-' + index);
    if (thumb) {
      if (this.checked) {
        thumb.style.transform = 'translateX(1rem)';
      } else {
        thumb.style.transform = 'translateX(0)';
      }
    }
  });
});
</script>
@endsection
