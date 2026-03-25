@extends('layouts.admin')
@section('title', 'Pengumuman')
@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Pengumuman</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Kelola pengumuman untuk anggota dan publik</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Pengumuman
        </a>
    </div>
    <div class="space-y-3">
        @forelse($announcements as $ann)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 flex items-start gap-4">
            @if($ann->is_pinned)
            <div class="flex-shrink-0 w-8 h-8 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M16.5 3C14.76 3 13.09 3.81 12 5.08 10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3z"/></svg>
            </div>
            @else
            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            </div>
            @endif
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $ann->title }}</h3>
                    @if($ann->is_pinned)<span class="text-xs bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 px-2 py-0.5 rounded-full">Disematkan</span>@endif
                    @if($ann->is_member_only)<span class="text-xs bg-primary-100 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 px-2 py-0.5 rounded-full">Member Only</span>@endif
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">{{ Str::limit(strip_tags($ann->content), 120) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ $ann->created_at->format('d M Y') }}</p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('admin.announcements.edit', $ann) }}" class="text-xs text-primary-600 dark:text-primary-400 hover:underline">Edit</a>
                <form method="POST" action="{{ route('admin.announcements.destroy', $ann) }}" onsubmit="return confirm('Hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="py-16 text-center text-gray-400">
            <svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            <p class="text-sm">Belum ada pengumuman</p>
        </div>
        @endforelse
    </div>
    @if($announcements->hasPages())
    <div>{{ $announcements->links() }}</div>
    @endif
</div>
@endsection
