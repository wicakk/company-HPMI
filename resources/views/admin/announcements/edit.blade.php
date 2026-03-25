@extends('layouts.admin')
@section('title', 'Edit Pengumuman')
@section('content')
<div class="space-y-5 max-w-2xl">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.announcements.index') }}" class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-500 hover:text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Pengumuman</h2>
    </div>
    <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}">
        @csrf @method('PUT')
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Judul</label>
                <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Isi Pengumuman</label>
                <textarea name="content" rows="8" required class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('content', $announcement->content) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tipe</label>
                <input type="text" name="type" value="{{ old('type', $announcement->type) }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Terbit</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', $announcement->published_at ? \Carbon\Carbon::parse($announcement->published_at)->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Kadaluarsa</label>
                    <input type="datetime-local" name="expired_at" value="{{ old('expired_at', $announcement->expired_at ? \Carbon\Carbon::parse($announcement->expired_at)->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
            </div>
            <div class="flex gap-6">
                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                    <input type="checkbox" name="is_pinned" value="1" {{ $announcement->is_pinned?'checked':'' }} class="rounded border-gray-300 text-primary-600"> Sematkan
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                    <input type="checkbox" name="is_member_only" value="1" {{ $announcement->is_member_only?'checked':'' }} class="rounded border-gray-300 text-primary-600"> Khusus Anggota
                </label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition">Update</button>
                <a href="{{ route('admin.announcements.index') }}" class="px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
