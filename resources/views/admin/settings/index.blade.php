@extends('layouts.admin')
@section('title', 'Pengaturan Website')
@section('subtitle', 'Konfigurasi sistem dan konten homepage')
@section('content')

<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
    @csrf @method('PUT')

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-center gap-3 text-emerald-700 text-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Error Alert --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-700 text-sm">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <strong>Ada kesalahan</strong>
        </div>
        <ul class="ml-8 space-y-1 list-disc">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Pengaturan Website</h1>
            <p class="text-slate-500 text-sm mt-1">Konfigurasi sistem dan konten homepage</p>
        </div>
        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg shadow-blue-500/30 transition active:scale-95 whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
            </svg>
            Simpan Semua
        </button>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT col --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Informasi Organisasi --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Informasi Organisasi</h3>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Organisasi</label>
                        <input type="text" name="org_name" value="{{ $settings['org_name']?->value ?? '' }}"
                               placeholder="Himpunan Perawat Manajer Indonesia"
                               class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tagline / Slogan</label>
                        <input type="text" name="org_tagline" value="{{ $settings['org_tagline']?->value ?? '' }}"
                               placeholder="Bersama Membangun Keperawatan Manajerial Indonesia"
                               class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Organisasi</label>
                        <textarea name="org_description" rows="2"
                                  placeholder="Deskripsi singkat organisasi..."
                                  class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ $settings['org_description']?->value ?? '' }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email Sekretariat</label>
                            <input type="email" name="contact_email" value="{{ $settings['contact_email']?->value ?? '' }}"
                                   placeholder="sekretariat@hpmi.id"
                                   class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon</label>
                            <input type="text" name="contact_phone" value="{{ $settings['contact_phone']?->value ?? '' }}"
                                   placeholder="021-12345678"
                                   class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                        <textarea name="contact_address" rows="2"
                                  placeholder="Jl. Kesehatan No. 1, Jakarta Pusat 10110"
                                  class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ $settings['contact_address']?->value ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Konten Hero Homepage --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center text-sky-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Konten Hero Homepage</h3>
                        <p class="text-xs text-slate-400">Teks pada bagian banner utama halaman depan</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Badge Text</label>
                        <input type="text" name="hero_badge_text" value="{{ $settings['hero_badge_text']?->value ?? '' }}"
                               placeholder="Organisasi Profesi Keperawatan Indonesia"
                               class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Judul (baris 1)</label>
                            <input type="text" name="hero_title" value="{{ $settings['hero_title']?->value ?? '' }}"
                                   placeholder="Himpunan Perawat"
                                   class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Aksen (baris 2)</label>
                            <input type="text" name="hero_title_accent" value="{{ $settings['hero_title_accent']?->value ?? '' }}"
                                   placeholder="Manajer Indonesia"
                                   class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Subtitle / Deskripsi Hero</label>
                        <textarea name="hero_subtitle" rows="2"
                                  placeholder="Bersama membangun kompetensi dan profesionalisme..."
                                  class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ $settings['hero_subtitle']?->value ?? '' }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tombol Utama</label>
                            <input type="text" name="hero_cta_primary" value="{{ $settings['hero_cta_primary']?->value ?? '' }}"
                                   placeholder="Gabung Sekarang"
                                   class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tombol Sekunder</label>
                            <input type="text" name="hero_cta_secondary" value="{{ $settings['hero_cta_secondary']?->value ?? '' }}"
                                   placeholder="Tentang HPMI"
                                   class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Konten CTA Section --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Seksi CTA (Ajakan)</h3>
                        <p class="text-xs text-slate-400">Banner ajakan bergabung di bagian bawah homepage</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Judul CTA</label>
                        <input type="text" name="cta_title" value="{{ $settings['cta_title']?->value ?? '' }}"
                               placeholder="Bergabunglah dengan HPMI"
                               class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Subtitle CTA</label>
                        <textarea name="cta_subtitle" rows="2"
                                  placeholder="Tingkatkan kompetensi Anda bersama ribuan..."
                                  class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ $settings['cta_subtitle']?->value ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Teks Tombol CTA</label>
                        <input type="text" name="cta_button_text" value="{{ $settings['cta_button_text']?->value ?? '' }}"
                               placeholder="Daftar Sekarang"
                               class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                </div>
            </div>

            {{-- Media Sosial --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-violet-100 flex items-center justify-center text-violet-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Media Sosial</h3>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @php
                    $socials = [
                        ['key' => 'social_facebook',  'label' => 'Facebook'],
                        ['key' => 'social_instagram', 'label' => 'Instagram'],
                        ['key' => 'social_youtube',   'label' => 'YouTube'],
                        ['key' => 'social_linkedin',  'label' => 'LinkedIn'],
                    ];
                    @endphp
                    @foreach($socials as $social)
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">{{ $social['label'] }}</label>
                        <input type="text" name="{{ $social['key'] }}"
                               value="{{ $settings[$social['key']]?->value ?? '' }}"
                               placeholder="https://{{ strtolower($social['label']) }}.com/..."
                               class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- RIGHT col --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Fitur Website --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Fitur Website</h3>
                </div>
                <div class="space-y-1">
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
                    <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-b-0">
                        <span class="text-sm font-medium text-slate-900">{{ $label }}</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            {{-- Hidden input untuk kirim value 0 jika tidak dicentang --}}
                            <input type="hidden" name="{{ $key }}" value="0">
                            <input type="checkbox" name="{{ $key }}" value="1"
                                   {{ ($settings[$key]?->value ?? '0') == '1' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-300 peer-checked:bg-blue-600 rounded-full transition peer-focus:ring-2 peer-focus:ring-blue-300"></div>
                            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition peer-checked:translate-x-5"></div>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Iuran & Keuangan --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Iuran &amp; Keuangan</h3>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Biaya Pendaftaran (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-semibold text-sm">Rp</span>
                            <input type="number" name="billing_registration_fee"
                                   value="{{ $settings['billing_registration_fee']?->value ?? '' }}"
                                   placeholder="150000"
                                   class="w-full pl-10 pr-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Iuran Tahunan (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-semibold text-sm">Rp</span>
                            <input type="number" name="billing_annual_fee"
                                   value="{{ $settings['billing_annual_fee']?->value ?? '' }}"
                                   placeholder="300000"
                                   class="w-full pl-10 pr-4 py-3 text-sm border border-slate-200 rounded-lg bg-slate-50 text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Masa Aktif Keanggotaan</label>
                        <div class="relative">
                            <select name="billing_membership_duration"
                                    class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg bg-white text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer appearance-none">
                                <option value="">-- Pilih Durasi --</option>
                                @foreach(['1 Bulan', '3 Bulan', '6 Bulan', '1 Tahun'] as $dur)
                                <option value="{{ $dur }}" {{ ($settings['billing_membership_duration']?->value === $dur) ? 'selected' : '' }}>
                                    {{ $dur }}
                                </option>
                                @endforeach
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</form>
@endsection