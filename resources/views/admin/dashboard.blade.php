@extends('layouts.admin')
@section('title','Dashboard')
@section('subtitle','Ringkasan data platform HPMI')
@section('content')
<div class="space-y-6">
    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
        $cards = [
            ['label'=>'Total Anggota','value'=>$stats['total_members'],'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','from'=>'from-blue-500','to'=>'to-blue-600','light'=>'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400'],
            ['label'=>'Anggota Aktif','value'=>$stats['active_members'],'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','from'=>'from-emerald-500','to'=>'to-emerald-600','light'=>'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400'],
            ['label'=>'Menunggu Aktivasi','value'=>$stats['pending_members'],'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','from'=>'from-amber-500','to'=>'to-amber-600','light'=>'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400'],
            ['label'=>'Bayar Tertunda','value'=>$stats['pending_payments'],'icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z','from'=>'from-red-500','to'=>'to-red-600','light'=>'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400'],
            ['label'=>'Total Kegiatan','value'=>$stats['total_events'],'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','from'=>'from-violet-500','to'=>'to-violet-600','light'=>'bg-violet-50 dark:bg-violet-900/20 text-violet-600 dark:text-violet-400'],
            ['label'=>'Total Artikel','value'=>$stats['total_articles'],'icon'=>'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z','from'=>'from-indigo-500','to'=>'to-indigo-600','light'=>'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400'],
            ['label'=>'Pesan Belum Dibaca','value'=>$stats['unread_messages'],'icon'=>'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z','from'=>'from-pink-500','to'=>'to-pink-600','light'=>'bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400'],
        ];
        @endphp
        @foreach($cards as $card)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                    <p class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($card['value']) }}</p>
                </div>
                <div class="{{ $card['light'] }} p-3 rounded-xl flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $card['icon'] }}"/></svg>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Recent Data --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Members --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-4 bg-gradient-to-b from-blue-400 to-blue-600 rounded-full"></div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-sm">Anggota Terbaru</h3>
                </div>
                <a href="{{ route('admin.members.index') }}" class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">
                    Semua <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($recent_members as $member)
                <div class="flex items-center gap-3 px-6 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">{{ substr($member->user->name??'?',0,1) }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $member->user->name??'-' }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ $member->member_code }}</p>
                    </div>
                    @php $sc=['active'=>'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400','pending'=>'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400','expired'=>'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400','suspended'=>'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'];$sl=['active'=>'Aktif','pending'=>'Pending','expired'=>'Expired','suspended'=>'Suspend']; @endphp
                    <span class="text-xs font-semibold px-2 py-1 rounded-lg {{ $sc[$member->status]??'bg-slate-100 text-slate-600' }}">{{ $sl[$member->status]??$member->status }}</span>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-slate-400 text-sm">Belum ada anggota</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Payments --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-4 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-sm">Pembayaran Terbaru</h3>
                </div>
                <a href="{{ route('admin.payments.index') }}" class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">
                    Semua <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($recent_payments as $payment)
                <div class="flex items-center gap-3 px-6 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $payment->member->user->name??'-' }}</p>
                        <p class="text-xs text-slate-400">{{ $payment->invoice_no }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-900 dark:text-white">Rp {{ number_format($payment->amount) }}</p>
                        @php $ps=['paid'=>'text-emerald-600 dark:text-emerald-400','pending'=>'text-amber-600 dark:text-amber-400','failed'=>'text-red-600 dark:text-red-400']; @endphp
                        <span class="text-xs font-semibold {{ $ps[$payment->status]??'text-slate-500' }}">{{ ucfirst($payment->status) }}</span>
                    </div>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-slate-400 text-sm">Belum ada pembayaran</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
