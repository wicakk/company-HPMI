@extends('layouts.admin')
@section('title','Pengaturan Situs')
@section('subtitle','Konfigurasi website HPMI')
@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-5">
    @csrf @method('PUT')
    @php
    $groups = [
        'general' => ['icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4','label'=>'Informasi Organisasi','color'=>'blue'],
        'contact'  => ['icon'=>'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z','label'=>'Kontak','color'=>'emerald'],
        'social'   => ['icon'=>'M7 20l4-16m2 16l4-16M6 9h14M4 15h14','label'=>'Media Sosial','color'=>'violet'],
        'homepage' => ['icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6','label'=>'Beranda','color'=>'amber'],
    ];
    // $settings is a Collection keyed by 'key'. Group by 'group' properly.
    $grouped = $settings->values()->groupBy('group');
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        @foreach($groups as $groupKey => $group)
        @php $groupSettings = $grouped->get($groupKey, collect([])); @endphp
        @if($groupSettings->isNotEmpty())
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
            <h4 class="font-bold text-slate-900 dark:text-white mb-5 flex items-center gap-2 text-sm">
                <div class="w-8 h-8 bg-{{ $group['color'] }}-100 dark:bg-{{ $group['color'] }}-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-{{ $group['color'] }}-600 dark:text-{{ $group['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $group['icon'] }}"/></svg>
                </div>
                {{ $group['label'] }}
            </h4>
            <div class="space-y-4">
                @foreach($groupSettings as $setting)
                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wide">{{ str_replace('_',' ',ucfirst($setting->key)) }}</label>
                    @if($setting->type === 'textarea')
                    <textarea name="{{ $setting->key }}" rows="3" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">{{ $setting->value }}</textarea>
                    @elseif($setting->type === 'boolean')
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative"><input type="checkbox" name="{{ $setting->key }}" value="1" {{ $setting->value?'checked':'' }} class="sr-only peer"><div class="w-10 h-5 bg-slate-200 dark:bg-slate-700 rounded-full peer-checked:bg-primary-500 transition"></div><div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition peer-checked:translate-x-5"></div></div>
                        <span class="text-sm text-slate-700 dark:text-slate-300">Aktifkan</span>
                    </label>
                    @else
                    <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
    </div>

    @if($settings->isEmpty())
    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-5 text-amber-700 dark:text-amber-400 text-sm flex items-center gap-3">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        Belum ada pengaturan. Jalankan seeder terlebih dahulu: <code class="font-mono bg-amber-100 dark:bg-amber-900/30 px-2 py-0.5 rounded">php artisan db:seed</code>
    </div>
    @endif

    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-primary-500/30 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Semua Pengaturan
        </button>
    </div>
</form>
@endsection
