@extends('layouts.admin')
@section('title','Edit Artikel')
@section('content')
<div class="space-y-5">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.articles.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Edit Artikel</h2>
    </div>
    <form method="POST" action="{{ route('admin.articles.update', $artikel) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Judul Artikel <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title',$artikel->title) }}" required class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Ringkasan</label>
                        <textarea name="excerpt" rows="2" class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none transition">{{ old('excerpt',$artikel->excerpt) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wide">Konten <span class="text-red-500">*</span></label>
                        <textarea name="content" rows="18" required class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">{{ old('content',$artikel->content) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengaturan</h4>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Status</label>
                        <select name="status" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                            <option value="draft" {{ $artikel->status==='draft'?'selected':'' }}>📝 Draft</option>
                            <option value="published" {{ $artikel->status==='published'?'selected':'' }}>✅ Terbitkan</option>
                            <option value="archived" {{ $artikel->status==='archived'?'selected':'' }}>📦 Arsip</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Kategori</label>
                        <select name="category_id" class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                            <option value="">Tanpa Kategori</option>
                            @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ $artikel->category_id==$cat->id?'selected':'' }}>{{ $cat->name }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">URL Thumbnail</label>
                        <input type="url" name="thumbnail" value="{{ old('thumbnail',$artikel->thumbnail) }}" placeholder="https://..." class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    </div>
                </div>
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-primary-500/30 transition hover:from-primary-600 hover:to-primary-700 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.articles.index') }}" class="block w-full py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-200 transition text-center">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
