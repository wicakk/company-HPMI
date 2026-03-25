@extends('layouts.admin')
@section('title','Edit Pengumuman')
@section('content')
<div class="space-y-5 max-w-2xl">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.announcements.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Edit Pengumuman</h2>
    </div>
    <form method="POST" action="{{ route('admin.announcements.update', $pengumuman) }}">
        @csrf @method('PUT')
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-5">
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title',$pengumuman->title) }}" required class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Tipe</label>
                <select name="type" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    @foreach(['info'=>'ℹ️ Info','warning'=>'⚠️ Peringatan','urgent'=>'🚨 Penting','event'=>'📅 Kegiatan'] as $v=>$l)
                    <option value="{{ $v }}" {{ $pengumuman->type===$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Isi Pengumuman <span class="text-red-500">*</span></label>
                <textarea name="content" rows="6" required class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">{{ old('content',$pengumuman->content) }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Terbit</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', $pengumuman->published_at ? \Carbon\Carbon::parse($pengumuman->published_at)->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Kadaluarsa</label>
                    <input type="datetime-local" name="expired_at" value="{{ old('expired_at', $pengumuman->expired_at ? \Carbon\Carbon::parse($pengumuman->expired_at)->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                </div>
            </div>
            <div class="flex flex-col gap-3 pt-1">
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative flex-shrink-0"><input type="checkbox" name="is_pinned" value="1" {{ $pengumuman->is_pinned?'checked':'' }} class="sr-only peer"><div class="w-10 h-5 bg-slate-200 dark:bg-slate-700 rounded-full peer-checked:bg-amber-500 transition-colors"></div><div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div></div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">📌 Sematkan di atas</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative flex-shrink-0"><input type="checkbox" name="is_member_only" value="1" {{ $pengumuman->is_member_only?'checked':'' }} class="sr-only peer"><div class="w-10 h-5 bg-slate-200 dark:bg-slate-700 rounded-full peer-checked:bg-primary-500 transition-colors"></div><div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div></div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">🔒 Khusus Anggota</span>
                </label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/30 transition">Simpan Perubahan</button>
                <a href="{{ route('admin.announcements.index') }}" class="flex-1 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-200 transition text-center">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
