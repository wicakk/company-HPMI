@extends('layouts.admin')
@section('title','Tambah Pengurus')
@section('content')
<div class="space-y-5 max-w-xl">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.org.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Tambah Pengurus</h2>
    </div>
    <form method="POST" action="{{ route('admin.org.store') }}">
        @csrf
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama pengurus..." class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="position" value="{{ old('position') }}" required placeholder="Ketua Umum, Sekretaris..." class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    @error('position')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Periode <span class="text-red-500">*</span></label>
                    <input type="text" name="period" value="{{ old('period') }}" required placeholder="2022-2026" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Urutan</label>
                    <input type="number" name="order_index" value="{{ old('order_index',0) }}" min="0" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">URL Foto</label>
                <input type="url" name="photo" value="{{ old('photo') }}" placeholder="https://..." class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Bio Singkat</label>
                <textarea name="bio" rows="3" placeholder="Ringkasan latar belakang pengurus..." class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">{{ old('bio') }}</textarea>
            </div>
            <label class="flex items-center gap-3 cursor-pointer pt-1">
                <div class="relative flex-shrink-0"><input type="checkbox" name="is_active" value="1" checked class="sr-only peer"><div class="w-10 h-5 bg-slate-200 dark:bg-slate-700 rounded-full peer-checked:bg-emerald-500 transition-colors"></div><div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div></div>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Pengurus Aktif</span>
            </label>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-cyan-500/30 transition">Simpan Pengurus</button>
                <a href="{{ route('admin.org.index') }}" class="flex-1 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-200 transition text-center">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
