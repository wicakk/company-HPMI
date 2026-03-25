@extends('layouts.admin')
@section('title', 'Struktur Organisasi')
@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Struktur Organisasi</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Kelola kepengurusan HPMI</p>
        </div>
        <a href="{{ route('admin.org.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengurus
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($structures as $org)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 text-center hover:shadow-md transition">
            @if($org->photo)
            <img src="{{ $org->photo }}" class="w-20 h-20 rounded-full object-cover mx-auto mb-3" alt="{{ $org->name }}">
            @else
            <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center text-primary-700 dark:text-primary-400 font-bold text-2xl mx-auto mb-3">{{ substr($org->name, 0, 1) }}</div>
            @endif
            <h3 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $org->name }}</h3>
            <p class="text-xs text-primary-600 dark:text-primary-400 mt-1">{{ $org->position }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Periode {{ $org->period }}</p>
            @if(!$org->is_active)<span class="inline-block mt-2 text-xs bg-gray-100 dark:bg-gray-700 text-gray-500 px-2 py-0.5 rounded-full">Nonaktif</span>@endif
            <div class="flex justify-center gap-3 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('admin.org.edit', $org) }}" class="text-xs text-primary-600 dark:text-primary-400 hover:underline">Edit</a>
                <form method="POST" action="{{ route('admin.org.destroy', $org) }}" onsubmit="return confirm('Hapus pengurus ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-4 py-16 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <p class="text-sm">Belum ada data kepengurusan</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
