@extends('layouts.admin')
@section('title','Tambah Kegiatan')
@section('content')
<div class="space-y-5">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.events.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Tambah Kegiatan Baru</h2>
    </div>
    <form method="POST" action="{{ route('admin.events.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Judul Kegiatan <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Nama seminar, webinar, atau pelatihan..." class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="6" required placeholder="Deskripsi lengkap kegiatan..." class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">{{ old('description') }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Tanggal Selesai <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" required class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Lokasi / Tempat</label>
                        <input type="text" name="location" value="{{ old('location') }}" placeholder="Nama tempat atau 'Online via Zoom'" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Link Meeting (Opsional)</label>
                        <input type="url" name="meeting_url" value="{{ old('meeting_url') }}" placeholder="https://zoom.us/..." class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengaturan</h4>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Status</label>
                        <select name="status" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                            <option value="draft">📝 Draft</option>
                            <option value="open">🟢 Buka Pendaftaran</option>
                            <option value="closed">🔴 Tutup</option>
                            <option value="completed">✅ Selesai</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price',0) }}" min="0" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Kuota Peserta</label>
                        <input type="number" name="quota" value="{{ old('quota') }}" min="1" placeholder="Kosongkan jika tak dibatasi" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">URL Thumbnail</label>
                        <input type="url" name="thumbnail" value="{{ old('thumbnail') }}" placeholder="https://..." class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    </div>
                    <div class="space-y-2 pt-2">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative"><input type="checkbox" name="is_free" value="1" {{ old('is_free')?'checked':'' }} class="sr-only peer"><div class="w-10 h-5 bg-slate-200 dark:bg-slate-700 rounded-full peer-checked:bg-primary-500 transition"></div><div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition peer-checked:translate-x-5"></div></div>
                            <span class="text-sm text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white transition">Gratis</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative"><input type="checkbox" name="is_member_only" value="1" {{ old('is_member_only')?'checked':'' }} class="sr-only peer"><div class="w-10 h-5 bg-slate-200 dark:bg-slate-700 rounded-full peer-checked:bg-primary-500 transition"></div><div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition peer-checked:translate-x-5"></div></div>
                            <span class="text-sm text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white transition">Khusus Anggota</span>
                        </label>
                    </div>
                </div>
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-violet-500 to-violet-600 hover:from-violet-600 hover:to-violet-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-violet-500/30 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Kegiatan
                </button>
                <a href="{{ route('admin.events.index') }}" class="block w-full py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-200 transition text-center">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
