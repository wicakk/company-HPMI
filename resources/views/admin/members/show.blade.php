@extends('layouts.admin')
@section('title','Detail Anggota')
@section('content')
<div class="space-y-5">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.members.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Detail Anggota</h2>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Profile Card --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 text-center">
            <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center text-white font-black text-4xl mx-auto mb-4 shadow-xl shadow-blue-500/30">{{ substr($member->user->name??'?',0,1) }}</div>
            <h3 class="font-bold text-slate-900 dark:text-white text-lg">{{ $member->user->name??'—' }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $member->user->email??'—' }}</p>
            <code class="inline-block mt-3 text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-3 py-1.5 rounded-xl">{{ $member->member_code }}</code>
            @php $sc=['active'=>'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400','pending'=>'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400','expired'=>'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400','suspended'=>'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400'];$sl=['active'=>'Aktif','pending'=>'Pending','expired'=>'Kadaluarsa','suspended'=>'Ditangguhkan']; @endphp
            <div class="mt-3"><span class="text-sm font-bold px-3 py-1.5 rounded-xl {{ $sc[$member->status]??'' }}">{{ $sl[$member->status]??$member->status }}</span></div>
            <form method="POST" action="{{ route('admin.members.status', $member->id) }}" class="mt-5">
                @csrf @method('PUT')
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Ubah Status</label>
                <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    @foreach(['pending'=>'⏳ Pending','active'=>'✅ Aktif','expired'=>'⏰ Kadaluarsa','suspended'=>'🚫 Ditangguhkan'] as $v=>$l)
                    <option value="{{ $v }}" {{ $member->status===$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        {{-- Info --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
                <h4 class="font-bold text-slate-900 dark:text-white mb-5 flex items-center gap-2 text-sm">
                    <div class="w-7 h-7 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center"><svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                    Informasi Pribadi
                </h4>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-3"><dt class="text-xs text-slate-400 mb-1">Nama Lengkap</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $member->user->name??'—' }}</dd></div>
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-3"><dt class="text-xs text-slate-400 mb-1">Email</dt><dd class="font-semibold text-slate-900 dark:text-white truncate">{{ $member->user->email??'—' }}</dd></div>
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-3"><dt class="text-xs text-slate-400 mb-1">Telepon</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $member->phone??'—' }}</dd></div>
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-3"><dt class="text-xs text-slate-400 mb-1">Spesialisasi</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $member->specialty??'—' }}</dd></div>
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-3 sm:col-span-2"><dt class="text-xs text-slate-400 mb-1">Institusi</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $member->institution??'—' }}</dd></div>
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-3 sm:col-span-2"><dt class="text-xs text-slate-400 mb-1">Alamat</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $member->address??'—' }}</dd></div>
                </dl>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-xs text-slate-400">Bergabung</p>
                    </div>
                    <p class="font-bold text-slate-900 dark:text-white text-sm">{{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('d M Y') : '—' }}</p>
                </div>
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs text-slate-400">Kadaluarsa</p>
                    </div>
                    <p class="font-bold text-slate-900 dark:text-white text-sm">{{ $member->expired_at ? \Carbon\Carbon::parse($member->expired_at)->format('d M Y') : '—' }}</p>
                </div>
            </div>
            {{-- Payments --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Riwayat Pembayaran
                    </h4>
                </div>
                <div class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($member->payments??[] as $pay)
                    <div class="px-6 py-3.5 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $pay->invoice_no }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $pay->payment_method??'VA' }} · {{ $pay->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-slate-900 dark:text-white text-sm">Rp {{ number_format($pay->amount) }}</p>
                            @php $ps=['paid'=>'text-emerald-600 dark:text-emerald-400','pending'=>'text-amber-600 dark:text-amber-400','failed'=>'text-red-600 dark:text-red-400','expired'=>'text-slate-500']; @endphp
                            <span class="text-xs font-semibold {{ $ps[$pay->status]??'' }}">{{ ucfirst($pay->status) }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada riwayat pembayaran</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
