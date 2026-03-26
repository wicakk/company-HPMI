@extends('layouts.admin')
@section('title', 'Manajemen Anggota')
@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div class="space-y-2">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold uppercase tracking-wide text-purple-700 bg-purple-100 rounded-full">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM6 7a1 1 0 000 2h8a1 1 0 100-2H6z"/>
                </svg>
                Manajemen
            </span>
            <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">Anggota HPMI</h2>
        </div>
        <a href="{{ route('admin.members.export') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export CSV
        </a>
    </div>

    {{-- Filter --}}
    <div class="flex flex-col sm:flex-row gap-3 ">
        <input id="searchInput" type="text" placeholder="Cari nama, email, kode anggota..." class="flex-1 px-4 py-2 bg-white rounded-lg text-sm focus:ring-2 focus:ring-purple-500" oninput="filterCards()">
        <select id="statusFilter" class="px-4 py-2 bg-white rounded-lg text-sm " onchange="filterCards()">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="pending">Pending</option>
            <option value="expired">Kadaluarsa</option>
            <option value="suspended">Ditangguhkan</option>
        </select>
    </div>

    {{-- Grid Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="membersGrid">
        @forelse($members as $member)
        @php
            $statusClass = [
                'active'=>'bg-green-100 text-green-700',
                'pending'=>'bg-yellow-100 text-yellow-700',
                'expired'=>'bg-gray-100 text-gray-600',
                'suspended'=>'bg-red-100 text-red-700'
            ][$member->status] ?? 'bg-gray-100 text-gray-600';
            $statusLabel = [
                'active'=>'Aktif',
                'pending'=>'Pending',
                'expired'=>'Kadaluarsa',
                'suspended'=>'Ditangguhkan'
            ][$member->status] ?? $member->status;
        @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl dark:border-gray-700 overflow-hidden shadow hover:shadow-lg transition p-4 event-card" data-name="{{ strtolower($member->user->name ?? '') }}" data-status="{{ $member->status }}">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-blue-400 font-bold text-lg">
                    {{ substr($member->user->name ?? 'U',0,1) }}
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $member->user->name ?? '-' }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $member->user->email ?? '-' }}</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">{{ $statusLabel }}</span>
            </div>
            <div class="mt-3 text-gray-600 dark:text-gray-400 text-sm">
                <p><span class="font-semibold">Kode:</span> {{ $member->member_code }}</p>
                <p><span class="font-semibold">Institusi:</span> {{ $member->institution ?? '-' }}</p>
                <p><span class="font-semibold">Bergabung:</span> {{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('d M Y') : '-' }}</p>
            </div>
            <div class="mt-3 flex gap-2">
                <a href="{{ route('admin.members.show', $member) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 rounded-lg py-1.5 text-sm font-medium transition">Detail</a>
                {{-- <a href="{{ route('admin.members.edit', $member) }}" class="flex-1 text-center bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg py-1.5 text-sm font-medium hover:bg-blue-200 dark:hover:bg-blue-800 transition">Edit</a> --}}
            </div>
        </div>
        @empty
        <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16">
            <p class="text-lg font-bold text-gray-900 dark:text-white">Belum ada anggota</p>
            <p class="text-sm text-gray-400 mb-4">Tambahkan anggota pertama Anda</p>
            <a href="{{ route('admin.members.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium transition">+ Tambah Anggota</a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($members->hasPages())
    <div class="mt-6 flex justify-center">{{ $members->links() }}</div>
    @endif

</div>

<script>
function filterCards() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const s = document.getElementById('statusFilter').value;
    document.querySelectorAll('.event-card').forEach(c => {
        const matchQ = !q || c.dataset.name.includes(q);
        const matchS = !s || c.dataset.status === s;
        c.style.display = (matchQ && matchS) ? '' : 'none';
    });
}
</script>

@endsection