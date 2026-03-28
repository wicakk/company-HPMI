@extends('layouts.admin')
@section('title', 'Pengaturan Website')
@section('content')

<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
  @csrf @method('PUT')

  {{-- Alerts --}}
  @if(session('success'))
  <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span>{{ session('success') }}</span>
  </div>
  @endif
  @if($errors->any())
  <div class="px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl text-sm">
    <div class="flex items-center gap-2 mb-2 font-semibold"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Ada kesalahan</div>
    <ul class="ml-6 space-y-0.5 list-disc text-xs">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
  </div>
  @endif

  {{-- Header --}}
  <div class="flex items-start justify-between">
    <div>
      <p class="text-xs font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1">Konfigurasi</p>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Pengaturan Website</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Konfigurasi sistem dan konten homepage</p>
    </div>
    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-sm shadow-blue-500/25 transition-all active:scale-95">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
      Simpan Semua
    </button>
  </div>

  {{-- Main Grid --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT 2/3 --}}
    <div class="lg:col-span-2 space-y-5">

      {{-- Informasi Organisasi --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          </div>
          <div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Organisasi</h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Identitas dan kontak resmi</p>
          </div>
        </div>
        <div class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nama Organisasi</label>
            <input type="text" name="org_name" value="{{ $settings['org_name']?->value ?? '' }}" placeholder="Himpunan Perawat Manajer Indonesia"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tagline / Slogan</label>
            <input type="text" name="org_tagline" value="{{ $settings['org_tagline']?->value ?? '' }}" placeholder="Bersama Membangun Keperawatan Manajerial Indonesia"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Deskripsi Organisasi</label>
            <textarea name="org_description" rows="2" placeholder="Deskripsi singkat organisasi..."
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition resize-none">{{ $settings['org_description']?->value ?? '' }}</textarea>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Email Sekretariat</label>
              <input type="email" name="contact_email" value="{{ $settings['contact_email']?->value ?? '' }}" placeholder="sekretariat@hpmi.id"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">No. Telepon</label>
              <input type="text" name="contact_phone" value="{{ $settings['contact_phone']?->value ?? '' }}" placeholder="021-12345678"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
            </div>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Alamat</label>
            <textarea name="contact_address" rows="2" placeholder="Jl. Kesehatan No. 1, Jakarta Pusat 10110"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition resize-none">{{ $settings['contact_address']?->value ?? '' }}</textarea>
          </div>
        </div>
      </div>

      {{-- Hero Section --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-sky-50 dark:bg-sky-900/30 flex items-center justify-center text-sky-600 dark:text-sky-400 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
          </div>
          <div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Konten Hero Homepage</h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Teks pada bagian banner utama halaman depan</p>
          </div>
        </div>
        <div class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Badge Text</label>
            <input type="text" name="hero_badge_text" value="{{ $settings['hero_badge_text']?->value ?? '' }}" placeholder="Organisasi Profesi Keperawatan Indonesia"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Judul (baris 1)</label>
              <input type="text" name="hero_title" value="{{ $settings['hero_title']?->value ?? '' }}" placeholder="Himpunan Perawat"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Judul Aksen (baris 2)</label>
              <input type="text" name="hero_title_accent" value="{{ $settings['hero_title_accent']?->value ?? '' }}" placeholder="Manajer Indonesia"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
            </div>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Subtitle / Deskripsi Hero</label>
            <textarea name="hero_subtitle" rows="2" placeholder="Bersama membangun kompetensi dan profesionalisme..."
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition resize-none">{{ $settings['hero_subtitle']?->value ?? '' }}</textarea>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tombol Utama</label>
              <input type="text" name="hero_cta_primary" value="{{ $settings['hero_cta_primary']?->value ?? '' }}" placeholder="Gabung Sekarang"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tombol Sekunder</label>
              <input type="text" name="hero_cta_secondary" value="{{ $settings['hero_cta_secondary']?->value ?? '' }}" placeholder="Tentang HPMI"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
            </div>
          </div>
        </div>
      </div>

      {{-- CTA Section --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-500 dark:text-rose-400 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/></svg>
          </div>
          <div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Seksi CTA (Ajakan)</h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Banner ajakan bergabung di bagian bawah homepage</p>
          </div>
        </div>
        <div class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Judul CTA</label>
            <input type="text" name="cta_title" value="{{ $settings['cta_title']?->value ?? '' }}" placeholder="Bergabunglah dengan HPMI"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Subtitle CTA</label>
            <textarea name="cta_subtitle" rows="2" placeholder="Tingkatkan kompetensi Anda bersama ribuan..."
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition resize-none">{{ $settings['cta_subtitle']?->value ?? '' }}</textarea>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Teks Tombol CTA</label>
            <input type="text" name="cta_button_text" value="{{ $settings['cta_button_text']?->value ?? '' }}" placeholder="Daftar Sekarang"
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
          </div>
        </div>
      </div>

      {{-- Media Sosial --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center text-violet-600 dark:text-violet-400 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
          </div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Media Sosial</h3>
        </div>
        <div class="grid grid-cols-2 gap-4">
          @php $socials = [['social_facebook','Facebook'],['social_instagram','Instagram'],['social_youtube','YouTube'],['social_linkedin','LinkedIn']]; @endphp
          @foreach($socials as [$key, $label])
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">{{ $label }}</label>
            <input type="text" name="{{ $key }}" value="{{ $settings[$key]?->value ?? '' }}" placeholder="https://{{ strtolower($label) }}.com/..."
              class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
          </div>
          @endforeach
        </div>
      </div>

    </div>

    {{-- RIGHT 1/3 --}}
    <div class="lg:col-span-1 space-y-5">

      {{-- Fitur Website --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Fitur Website</h3>
        </div>
        <div class="space-y-0.5">
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
          @foreach($features as $key => $label)
          <div class="flex items-center justify-between py-3 border-b border-slate-50 dark:border-slate-700/50 last:border-b-0">
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $label }}</span>
            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
              <input type="hidden" name="{{ $key }}" value="0">
              <input type="checkbox" name="{{ $key }}" value="1" {{ ($settings[$key]?->value ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer">
              <div class="w-10 h-[22px] bg-slate-200 dark:bg-slate-600 peer-checked:bg-blue-500 rounded-full transition-colors peer-focus:ring-2 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-700"></div>
              <div class="absolute left-0.5 top-0.5 w-[18px] h-[18px] bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-[18px]"></div>
            </label>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Iuran & Keuangan --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
          </div>
          <h3 class="text-sm font-bold text-slate-900 dark:text-white">Iuran &amp; Keuangan</h3>
        </div>
        <div class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Biaya Pendaftaran (Rp)</label>
            <div class="relative">
              <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400">Rp</span>
              <input type="number" name="billing_registration_fee" value="{{ $settings['billing_registration_fee']?->value ?? '' }}" placeholder="150000"
                class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
            </div>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Iuran Tahunan (Rp)</label>
            <div class="relative">
              <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400">Rp</span>
              <input type="number" name="billing_annual_fee" value="{{ $settings['billing_annual_fee']?->value ?? '' }}" placeholder="300000"
                class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
            </div>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Masa Aktif Keanggotaan</label>
            <div class="relative">
              <select name="billing_membership_duration"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition cursor-pointer appearance-none">
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

    </div>
  </div>

</form>
@endsection
