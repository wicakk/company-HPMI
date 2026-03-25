@extends('layouts.admin')
@section('title', 'Edit Pengurus')
@section('content')
<div class="space-y-5 max-w-xl">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.org.index') }}" class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-500 hover:text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Pengurus</h2>
    </div>
    <form method="POST" action="{{ route('admin.org.update', $structure) }}">
        @csrf @method('PUT')
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap</label><input type="text" name="name" value="{{ old('name', $structure->name) }}" required class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Jabatan</label><input type="text" name="position" value="{{ old('position', $structure->position) }}" required class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Periode</label><input type="text" name="period" value="{{ old('period', $structure->period) }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">URL Foto</label><input type="url" name="photo" value="{{ old('photo', $structure->photo) }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Bio Singkat</label><textarea name="bio" rows="3" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('bio', $structure->bio) }}</textarea></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Urutan</label><input type="number" name="order_index" value="{{ old('order_index', $structure->order_index) }}" class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"></div>
                <div class="flex items-end pb-1"><label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer"><input type="checkbox" name="is_active" value="1" {{ $structure->is_active?'checked':'' }} class="rounded border-gray-300 text-primary-600"> Aktif</label></div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition">Update</button>
                <a href="{{ route('admin.org.index') }}" class="px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
