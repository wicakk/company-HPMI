@extends('layouts.admin')
@section('title', 'Detail Anggota')
@section('content')
<div class="space-y-5">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.members.index') }}" class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-500 hover:text-gray-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Detail Anggota</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Profile card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
            <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center text-primary-700 dark:text-primary-400 font-bold text-3xl mx-auto mb-4">{{ substr($member->user->name??'U',0,1) }}</div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $member->user->name??'-' }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $member->user->email??'-' }}</p>
            <code class="inline-block mt-2 text-xs bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 px-3 py-1 rounded-full">{{ $member->member_code }}</code>
            @php $sc=['active'=>'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400','pending'=>'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400','expired'=>'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400','suspended'=>'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400'];$sl=['active'=>'Aktif','pending'=>'Pending','expired'=>'Kadaluarsa','suspended'=>'Ditangguhkan']; @endphp
            <div class="mt-3"><span class="text-sm px-3 py-1 rounded-full font-medium {{ $sc[$member->status]??'' }}">{{ $sl[$member->status]??$member->status }}</span></div>

            <div class="mt-6 space-y-2">
                <form method="POST" action="{{ route('admin.members.updateStatus', $member) }}">
                    @csrf @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none">
                        <option value="pending" {{ $member->status==='pending'?'selected':'' }}>Set Pending</option>
                        <option value="active" {{ $member->status==='active'?'selected':'' }}>Set Aktif</option>
                        <option value="expired" {{ $member->status==='expired'?'selected':'' }}>Set Kadaluarsa</option>
                        <option value="suspended" {{ $member->status==='suspended'?'selected':'' }}>Set Ditangguhkan</option>
                    </select>
                </form>
            </div>
        </div>

        {{-- Info detail --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Informasi Pribadi
                </h4>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500 dark:text-gray-400 mb-1">Nama Lengkap</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->user->name??'-' }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400 mb-1">Email</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->user->email??'-' }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400 mb-1">Telepon</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->phone??'-' }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400 mb-1">Spesialisasi</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->specialty??'-' }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-gray-500 dark:text-gray-400 mb-1">Institusi</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->institution??'-' }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-gray-500 dark:text-gray-400 mb-1">Alamat</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->address??'-' }}</dd></div>
                </dl>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Keanggotaan
                </h4>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500 dark:text-gray-400 mb-1">Tanggal Bergabung</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('d F Y') : '-' }}</dd></div>
                    <div><dt class="text-gray-500 dark:text-gray-400 mb-1">Tanggal Kadaluarsa</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->expired_at ? \Carbon\Carbon::parse($member->expired_at)->format('d F Y') : '-' }}</dd></div>
                </dl>
            </div>

            {{-- Payment history --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Riwayat Pembayaran</h4>
                    <a href="{{ route('admin.payments.index') }}?member={{ $member->id }}" class="text-xs text-primary-600 dark:text-primary-400 hover:underline">Lihat semua</a>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($member->payments ?? [] as $pay)
                    <div class="px-6 py-3 flex items-center justify-between text-sm">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $pay->invoice_no }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $pay->payment_method??'-' }} &bull; {{ $pay->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($pay->amount) }}</p>
                            <span class="text-xs {{ $pay->status==='paid'?'text-green-600 dark:text-green-400':'text-yellow-600 dark:text-yellow-400' }}">{{ ucfirst($pay->status) }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-6 text-center text-gray-400 dark:text-gray-500 text-sm">Belum ada riwayat pembayaran</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
