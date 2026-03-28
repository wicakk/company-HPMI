@extends('layouts.admin')
@section('title', 'Buat Pengumuman')
@section('content')
<div class="space-y-5 max-w-2xl">
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
      <h2 class="text-lg font-black text-slate-900 dark:text-white">Buat Pengumuman</h2>
    </div>
  </div>
  <form method="POST" action="{{ route('admin.announcements.store') }}">
    @csrf
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6 space-y-4">
      @if($errors->any())
      <div class="px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl text-sm">
        <ul class="space-y-0.5 list-disc ml-4">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
      </div>
      @endif
      <div>
        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Judul <span class="text-red-400">*</span></label>
        <input type="text" name="title" value="{{ old('title') }}" required
          class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 dark:focus:ring-amber-400 transition">
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Isi Pengumuman <span class="text-red-400">*</span></label>
        <textarea name="content" rows="8" required
          class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 dark:focus:ring-amber-400 transition resize-none">{{ old('content') }}</textarea>
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tipe</label>
        <input type="text" name="type" value="{{ old('type', 'info') }}" placeholder="info, warning, urgent"
          class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 dark:focus:ring-amber-400 transition">
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tanggal Terbit</label>
          <input type="datetime-local" name="published_at" value="{{ old('published_at') }}"
            class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 dark:focus:ring-amber-400 transition">
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tanggal Kadaluarsa</label>
          <input type="datetime-local" name="expired_at" value="{{ old('expired_at') }}"
            class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 dark:focus:ring-amber-400 transition">
        </div>
      </div>
      <div class="flex gap-6">
        <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
          <input type="checkbox" name="is_pinned" value="1" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-amber-500 focus:ring-amber-400"> Sematkan
        </label>
        <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
          <input type="checkbox" name="is_member_only" value="1" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-amber-500 focus:ring-amber-400"> Khusus Anggota
        </label>
      </div>
      <div class="flex gap-3 pt-2">
        <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shadow-amber-500/25 active:scale-95">Simpan</button>
        <a href="{{ route('admin.announcements.index') }}" class="px-6 py-2.5 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition">Batal</a>
      </div>
    </div>
  </form>
</div>
@endsection
