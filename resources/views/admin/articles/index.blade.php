@extends('layouts.admin')
@section('title', 'Manajemen Artikel')
@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Manajemen Artikel</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Kelola konten artikel dan berita</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tulis Artikel
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Judul</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Penulis</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Kategori</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Status</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Views</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($articles as $article)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-5 py-3.5 max-w-[280px]">
                            <p class="font-medium text-gray-900 dark:text-white truncate">{{ $article->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $article->created_at->format('d M Y') }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-400">{{ $article->user->name??'-' }}</td>
                        <td class="px-5 py-3.5">
                            @if($article->category)
                            <span class="text-xs bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 px-2 py-0.5 rounded-full">{{ $article->category->name }}</span>
                            @else <span class="text-xs text-gray-400">-</span> @endif
                        </td>
                        <td class="px-5 py-3.5">
                            @php $ss=['published'=>'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400','draft'=>'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400','archived'=>'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400'];$sl=['published'=>'Diterbitkan','draft'=>'Draft','archived'=>'Diarsip']; @endphp
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $ss[$article->status]??'' }}">{{ $sl[$article->status]??$article->status }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-400">{{ number_format($article->views) }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="text-xs text-primary-600 dark:text-primary-400 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Hapus artikel ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">Belum ada artikel</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($articles->hasPages())
        <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-700">{{ $articles->links() }}</div>
        @endif
    </div>
</div>
@endsection
