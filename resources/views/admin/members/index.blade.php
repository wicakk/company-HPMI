@extends('layouts.admin')
@section('title', 'Manajemen Anggota')
@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Manajemen Anggota</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Kelola seluruh anggota HPMI</p>
        </div>
        <a href="{{ route('admin.members.export') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export CSV
        </a>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, kode anggota..." class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <select name="status" class="px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>
                <option value="active" {{ request('status')==='active'?'selected':'' }}>Aktif</option>
                <option value="expired" {{ request('status')==='expired'?'selected':'' }}>Kadaluarsa</option>
                <option value="suspended" {{ request('status')==='suspended'?'selected':'' }}>Ditangguhkan</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition">Filter</button>
            @if(request('search') || request('status'))
            <a href="{{ route('admin.members.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">Reset</a>
            @endif
        </form>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Anggota</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Kode</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Institusi</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Status</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Bergabung</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($members as $member)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center text-primary-700 dark:text-primary-400 font-semibold text-sm flex-shrink-0">{{ substr($member->user->name??'U',0,1) }}</div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $member->user->name??'-' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $member->user->email??'-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5"><code class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded">{{ $member->member_code }}</code></td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-400 max-w-[160px] truncate">{{ $member->institution??'-' }}</td>
                        <td class="px-5 py-3.5">
                            @php $sc=['active'=>'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400','pending'=>'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400','expired'=>'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400','suspended'=>'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400'];$sl=['active'=>'Aktif','pending'=>'Pending','expired'=>'Kadaluarsa','suspended'=>'Ditangguhkan']; @endphp
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $sc[$member->status]??'bg-gray-100 text-gray-600' }}">{{ $sl[$member->status]??$member->status }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-400 text-xs">{{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('d M Y') : '-' }}</td>
                        <td class="px-5 py-3.5">
                            <a href="{{ route('admin.members.show', $member) }}" class="inline-flex items-center gap-1 text-xs text-primary-600 dark:text-primary-400 hover:underline font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-12 text-center text-gray-400 dark:text-gray-500"><svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg><p class="text-sm">Tidak ada anggota ditemukan</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($members->hasPages())
        <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-700">{{ $members->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
