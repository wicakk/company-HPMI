@extends('layouts.admin')
@section('title', 'Edit Materi')
@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.materials.index') }}"
           class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor">
                <path stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Edit Materi</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 truncate max-w-md">
                {{ $materi->title }}
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.materials.update', $materi) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Konten --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h3 class="font-semibold text-slate-900 dark:text-white text-sm">Informasi Materi</h3>
                    </div>

                    <div class="p-6 space-y-5">

                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Judul Materi
                            </label>
                            <input type="text" name="title"
                                   value="{{ old('title', $materi->title) }}"
                                   class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="description" rows="5"
                                      class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 dark:text-white">{{ old('description', $materi->description) }}</textarea>
                        </div>

                        {{-- Type --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Tipe Materi
                            </label>
                            <select name="type"
                                    class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 dark:text-white">
                                @foreach(['pdf','video','article','module'] as $type)
                                    <option value="{{ $type }}"
                                        {{ old('type', $materi->type) == $type ? 'selected' : '' }}>
                                        {{ strtoupper($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- File URL --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                File URL
                            </label>
                            <input type="url" name="file_url"
                                   value="{{ old('file_url', $materi->file_url) }}"
                                   class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 dark:text-white">
                        </div>

                        {{-- Video URL --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Video URL
                            </label>
                            <input type="url" name="video_url"
                                   value="{{ old('video_url', $materi->video_url) }}"
                                   class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 dark:text-white">
                        </div>

                    </div>
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="space-y-5">

                {{-- Setting --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700">
                    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h4 class="font-semibold text-slate-900 dark:text-white text-sm">
                            Pengaturan
                        </h4>
                    </div>

                    <div class="p-5 space-y-4">

                        {{-- Category --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">
                                Kategori
                            </label>
                            <select name="category_id"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 dark:text-white">
                                <option value="">— Tanpa Kategori —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $materi->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Access --}}
                        <div class="flex items-center gap-2 pt-2">
                            <input type="checkbox" name="is_member_only" value="1"
                                {{ old('is_member_only', $materi->is_member_only) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <label class="text-sm text-slate-600 dark:text-slate-400">
                                Khusus Member
                            </label>
                        </div>

                    </div>

                    {{-- Meta --}}
                    <div class="px-5 pb-4 space-y-2 text-xs text-slate-500 dark:text-slate-400">
                        <div class="flex justify-between border-t pt-3">
                            <span>Dibuat</span>
                            <span>{{ $materi->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Download</span>
                            <span>{{ number_format($materi->downloads) }}</span>
                        </div>
                    </div>

                    {{-- Action --}}
                    <div class="px-5 pb-5 flex gap-3">
                        <button type="submit"
                                class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                            Update
                        </button>
                        <a href="{{ route('admin.materials.index') }}"
                           class="flex-1 py-2.5 bg-slate-100 dark:bg-slate-700 text-center text-sm font-semibold rounded-xl">
                            Batal
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </form>
</div>

@endsection