@extends('layouts.admin')
@section('title','Edit Materi')
@section('content')
<div class="space-y-5">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.materials.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Edit Materi</h2>
    </div>
    <form method="POST" action="{{ route('admin.materials.update', $materi) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Judul Materi <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title',$materi->title) }}" required class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Deskripsi</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">{{ old('description',$materi->description) }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">URL File / PDF</label>
                            <input type="url" name="file_url" value="{{ old('file_url',$materi->file_url) }}" placeholder="https://..." class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">URL Video</label>
                            <input type="url" name="video_url" value="{{ old('video_url',$materi->video_url) }}" placeholder="https://youtube.com/..." class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengaturan</h4>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Tipe Materi</label>
                        <select name="type" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                            @foreach(['pdf'=>'📄 PDF','video'=>'🎬 Video','article'=>'📝 Artikel','module'=>'📦 Modul'] as $v=>$l)
                            <option value="{{ $v }}" {{ $materi->type===$v?'selected':'' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Kategori</label>
                        <select name="category_id" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                            <option value="">Tanpa Kategori</option>
                            @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ $materi->category_id==$cat->id?'selected':'' }}>{{ $cat->name }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">URL Thumbnail</label>
                        <input type="url" name="thumbnail" value="{{ old('thumbnail',$materi->thumbnail) }}" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    </div>
                    <label class="flex items-center gap-3 cursor-pointer pt-1">
                        <div class="relative flex-shrink-0"><input type="checkbox" name="is_member_only" value="1" {{ $materi->is_member_only?'checked':'' }} class="sr-only peer"><div class="w-10 h-5 bg-slate-200 dark:bg-slate-700 rounded-full peer-checked:bg-primary-500 transition-colors"></div><div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div></div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Khusus Anggota</span>
                    </label>
                </div>
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-teal-500/30 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.materials.index') }}" class="block w-full py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-200 transition text-center">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
