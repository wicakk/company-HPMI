
@extends('layouts.admin')

@section('title', 'Manajemen Layanan')

@section('content')
<div class="px-6 py-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Layanan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola daftar layanan rumah sakit yang tampil di halaman publik.</p>
        </div>
        <a href="{{ route('admin.layanan.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Layanan Baru
        </a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari layanan..."
               class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">

        <select name="kategori"
                class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Kategori</option>
            @foreach(['Darurat','Rawat Inap','Poliklinik','Lainnya'] as $k)
                <option value="{{ $k }}" @selected(request('kategori') === $k)>{{ $k }}</option>
            @endforeach
        </select>

        <select name="status"
                class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Status</option>
            <option value="aktif"    @selected(request('status') === 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
        </select>

        <button type="submit"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl transition">
            Filter
        </button>
        @if(request()->hasAny(['search','kategori','status']))
            <a href="{{ route('admin.layanan.index') }}"
               class="text-sm text-gray-500 hover:text-gray-800 px-3 py-2 rounded-xl hover:bg-gray-100 transition">
                Reset
            </a>
        @endif
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-sm font-semibold text-gray-700">Daftar Layanan</p>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider">
                    <th class="text-left px-6 py-4 font-semibold">Layanan</th>
                    <th class="text-left px-6 py-4 font-semibold">Kategori</th>
                    <th class="text-center px-6 py-4 font-semibold">Urutan</th>
                    <th class="text-center px-6 py-4 font-semibold">Status</th>
                    <th class="text-center px-6 py-4 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($layanans as $layanan)
                <tr class="hover:bg-gray-50/50 transition">
                    {{-- Layanan --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-xl shrink-0">
                                {{ $layanan->ikon ?? '🏥' }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $layanan->nama }}</p>
                                <p class="text-gray-400 text-xs mt-0.5 line-clamp-1">{{ $layanan->deskripsi_singkat }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Kategori --}}
                    <td class="px-6 py-4 text-gray-600">{{ $layanan->kategori }}</td>

                    {{-- Urutan --}}
                    <td class="px-6 py-4 text-center text-gray-600">{{ $layanan->urutan }}</td>

                    {{-- Status --}}
                    <td class="px-6 py-4 text-center">
                        <button
                            onclick="toggleStatus({{ $layanan->id }}, this)"
                            class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition
                                {{ $layanan->status === 'aktif'
                                    ? 'bg-green-50 text-green-700 hover:bg-green-100'
                                    : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}"
                            data-status="{{ $layanan->status }}">
                            {{ $layanan->status_label }}
                        </button>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.layanan.edit', $layanan) }}"
                               title="Edit"
                               class="p-2 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            <form method="POST" action="{{ route('admin.layanan.destroy', $layanan) }}"
                                  onsubmit="return confirm('Hapus layanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus"
                                        class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-gray-400">
                            <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-sm">Belum ada layanan.</p>
                            <a href="{{ route('admin.layanan.create') }}"
                               class="text-blue-600 text-sm font-medium hover:underline">Tambah layanan baru</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if ($layanans->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $layanans->links() }}
        </div>
        @endif
    </div>

</div>

<script>
function toggleStatus(id, btn) {
    fetch(`/admin/layanan/${id}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            btn.textContent = data.label;
            btn.dataset.status = data.status;
            if (data.status === 'aktif') {
                btn.className = 'status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition bg-green-50 text-green-700 hover:bg-green-100';
            } else {
                btn.className = 'status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition bg-gray-100 text-gray-500 hover:bg-gray-200';
            }
        }
    });
}
</script>
@endsection