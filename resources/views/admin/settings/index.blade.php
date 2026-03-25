@extends('layouts.admin')
@section('title', 'Pengaturan Situs')
@section('content')
<div class="space-y-5">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Pengaturan Situs</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Konfigurasi website HPMI</p>
    </div>
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            {{-- General --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Informasi Organisasi
                </h4>
                <div class="space-y-4">
                    @php $general = $settings->where('group','general'); @endphp
                    @foreach($general as $setting)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ ucwords(str_replace('_',' ',$setting->key)) }}</label>
                        @if($setting->type === 'textarea')
                        <textarea name="settings[{{ $setting->key }}]" rows="3" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">{{ $setting->value }}</textarea>
                        @else
                        <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Contact info --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Kontak
                </h4>
                <div class="space-y-4">
                    @php $contact = $settings->where('group','contact'); @endphp
                    @foreach($contact as $setting)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ ucwords(str_replace('_',' ',$setting->key)) }}</label>
                        <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Social media --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                    Media Sosial
                </h4>
                <div class="space-y-4">
                    @php $social = $settings->where('group','social'); @endphp
                    @foreach($social as $setting)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ ucwords($setting->key) }}</label>
                        <input type="url" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="https://...">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Homepage --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Beranda
                </h4>
                <div class="space-y-4">
                    @php $homepage = $settings->where('group','homepage'); @endphp
                    @foreach($homepage as $setting)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ ucwords(str_replace('_',' ',$setting->key)) }}</label>
                        @if($setting->type === 'textarea')
                        <textarea name="settings[{{ $setting->key }}]" rows="2" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">{{ $setting->value }}</textarea>
                        @else
                        <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-5">
            <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
