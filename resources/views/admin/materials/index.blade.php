@extends('layouts.admin')
@section('title', 'Materi Edukasi')
@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Materi Edukasi</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Kelola modul, PDF, dan video pembelajaran</p>
        </div>
        <a href="{{ route('admin.materials.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Upload Materi
        </a>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Materi</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Tipe</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Akses</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Download</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($materials as $mat)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-5 py-3.5">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $mat->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $mat->category->name ?? 'Tanpa Kategori' }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            @php $tc=['pdf'=>'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400','video'=>'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400','article'=>'bg-blue-100 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400','module'=>'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400']; @endphp
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $tc[$mat->type]??'bg-gray-100 text-gray-600' }}">{{ strtoupper($mat->type) }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            @if($mat->is_member_only)
                            <span class="text-xs bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 px-2 py-0.5 rounded-full">Member</span>
                            @else
                            <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-0.5 rounded-full">Publik</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-400">{{ number_format($mat->downloads) }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.materials.edit', $mat) }}" class="text-xs text-primary-600 dark:text-primary-400 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.materials.destroy', $mat) }}" onsubmit="return confirm('Hapus materi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">Belum ada materi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($materials->hasPages())
        <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-700">{{ $materials->links() }}</div>
        @endif
    </div>
</div>
@endsection
