@extends('layouts.admin')
@section('title','Data Anggota')
@section('subtitle','Kelola member dan validasi upgrade premium')
@section('content')
<div class="space-y-5">
    {{-- Stats bar --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @php
        $sts = [
            ['label'=>'Total Member','val'=>\App\Models\Member::count(),'color'=>'blue'],
            ['label'=>'Gratis','val'=>\App\Models\Member::where('status','free')->count(),'color'=>'slate'],
            ['label'=>'Menunggu Validasi','val'=>\App\Models\Member::where('status','premium_pending')->count(),'color'=>'amber'],
            ['label'=>'Premium Aktif','val'=>\App\Models\Member::where('status','premium')->count(),'color'=>'emerald'],
        ];
        $cc=['blue'=>'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400','slate'=>'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400','amber'=>'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400','emerald'=>'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400'];
        @endphp
        @foreach($sts as $s)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4">
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">{{ $s['label'] }}</p>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $s['val'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
        <form method="GET" class="flex gap-2 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="flex-1 px-4 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
            <select name="status" class="px-4 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                <option value="">Semua Status</option>
                <option value="free" {{ request('status')==='free'?'selected':'' }}>Gratis</option>
                <option value="premium_pending" {{ request('status')==='premium_pending'?'selected':'' }}>⏳ Menunggu Validasi</option>
                <option value="premium" {{ request('status')==='premium'?'selected':'' }}>⭐ Premium</option>
                <option value="expired" {{ request('status')==='expired'?'selected':'' }}>Expired</option>
                <option value="suspended" {{ request('status')==='suspended'?'selected':'' }}>Suspended</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-xl transition">Cari</button>
        </form>
        <a href="{{ route('admin.members.export') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export CSV
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800">
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Anggota</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Kode</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Status</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Premium Hingga</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($members as $member)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition {{ $member->status==='premium_pending' ? 'bg-amber-50/50 dark:bg-amber-900/10' : '' }}">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl {{ $member->status==='premium'?'bg-gradient-to-br from-amber-400 to-orange-500':'bg-gradient-to-br from-primary-400 to-primary-600' }} flex items-center justify-center text-white font-bold text-sm flex-shrink-0">{{ substr($member->user->name??'?',0,1) }}</div>
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $member->user->name??'-' }}</p>
                                    <p class="text-xs text-slate-400">{{ $member->user->email??'-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4"><code class="text-xs bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-lg font-mono text-slate-600 dark:text-slate-400">{{ $member->member_code }}</code></td>
                        <td class="px-5 py-4">
                            @php $sc=['free'=>'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400','premium_pending'=>'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400','premium'=>'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400','expired'=>'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400','suspended'=>'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400'];$sl=['free'=>'Gratis','premium_pending'=>'⏳ Pending','premium'=>'⭐ Premium','expired'=>'Expired','suspended'=>'Suspended']; @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-lg {{ $sc[$member->status]??'' }}">{{ $sl[$member->status]??$member->status }}</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-slate-500 dark:text-slate-400">{{ $member->expired_at ? \Carbon\Carbon::parse($member->expired_at)->format('d M Y') : '—' }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.members.show', $member->id) }}" class="px-3 py-1.5 text-xs font-semibold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-lg hover:bg-primary-100 transition">Detail</a>
                                @if($member->status === 'premium_pending')
                                <form method="POST" action="{{ route('admin.payments.confirm', $member->payments()->where('status','pending')->first()?->id ?? 0) }}">
                                    @csrf @method('PUT')
                                    <button type="submit" class="px-3 py-1.5 text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg hover:bg-emerald-200 transition" onclick="return confirm('Validasi dan aktifkan Premium untuk anggota ini?')">
                                        ✅ Validasi Premium
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-16 text-center text-slate-400 text-sm">Belum ada anggota</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($members->hasPages())<div class="px-5 py-3 border-t border-slate-100 dark:border-slate-800">{{ $members->links() }}</div>@endif
    </div>
</div>
@endsection
