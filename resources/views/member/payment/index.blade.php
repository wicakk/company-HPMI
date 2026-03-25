@extends('layouts.app')
@section('title','Upgrade Premium')
@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('member.dashboard') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Upgrade Premium</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Akses semua fitur eksklusif HPMI</p>
        </div>
        <a href="{{ route('member.payment.history') }}" class="ml-auto text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">Riwayat →</a>
    </div>

    {{-- ===== SUDAH PREMIUM ===== --}}
    @if($user->isPremium())
    <div class="bg-gradient-to-br from-amber-400 via-orange-500 to-yellow-500 rounded-3xl p-8 text-white text-center mb-6 shadow-2xl shadow-amber-500/30">
        <div class="w-20 h-20 bg-white/20 rounded-3xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <h2 class="text-2xl font-black mb-2">Anda adalah Anggota Premium! ⭐</h2>
        <p class="text-white/80 text-sm mb-4">Nikmati akses penuh ke semua fitur eksklusif HPMI</p>
        @if($member->expired_at)
        <div class="inline-block bg-white/20 rounded-2xl px-6 py-3">
            <p class="text-xs text-white/70 mb-1">Aktif hingga</p>
            <p class="text-xl font-black">{{ \Carbon\Carbon::parse($member->expired_at)->format('d F Y') }}</p>
        </div>
        @endif
    </div>

    {{-- ===== MENUNGGU VALIDASI ===== --}}
    @elseif($user->isPremiumPending())
    <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-3xl p-8 text-center mb-6">
        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-blue-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        </div>
        <h2 class="text-xl font-black text-blue-900 dark:text-blue-100 mb-2">Pengajuan Sedang Divalidasi</h2>
        <p class="text-blue-600 dark:text-blue-400 text-sm mb-4">Admin sedang memverifikasi pembayaran Anda. Proses ini membutuhkan waktu 1×24 jam kerja.</p>
        @if($pending)
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 text-left space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-slate-400">Invoice</span><span class="font-mono font-bold text-slate-900 dark:text-white">{{ $pending->invoice_no }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Nominal</span><span class="font-bold text-slate-900 dark:text-white">Rp {{ number_format($pending->amount, 0, ',', '.') }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Metode</span><span class="font-bold text-slate-900 dark:text-white">{{ $pending->payment_method ?? 'Belum dikonfirmasi' }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Status</span><span class="font-bold text-blue-600 dark:text-blue-400">Menunggu Validasi Admin</span></div>
        </div>
        @endif
    </div>

    {{-- ===== ADA TAGIHAN BELUM DIKONFIRMASI ===== --}}
    @elseif($pending && !$pending->payment_method)
    {{-- Kartu VA --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-violet-900 rounded-3xl p-8 text-white mb-5 overflow-hidden shadow-2xl shadow-primary-900/40">
        <div class="absolute top-0 right-0 w-60 h-60 bg-white/5 rounded-full -translate-y-20 translate-x-20"></div>
        <div class="relative">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-primary-300">Tagihan Upgrade Premium</p>
                    <p class="text-sm text-white/60 mt-0.5">{{ $pending->invoice_no }}</p>
                </div>
                <span class="bg-amber-400/20 border border-amber-400/40 text-amber-300 text-xs font-bold px-3 py-1.5 rounded-xl">Belum Dibayar</span>
            </div>
            <p class="text-xs text-primary-300 uppercase tracking-widest font-semibold mb-2">Nomor Virtual Account</p>
            <div class="flex items-center gap-3 mb-6" x-data="{copied:false}" @click="navigator.clipboard.writeText('{{ $pending->va_number }}'); copied=true; setTimeout(()=>copied=false,2000)">
                <p class="font-mono text-2xl font-black tracking-widest cursor-pointer hover:text-primary-200 transition">{{ $pending->va_number }}</p>
                <button class="bg-white/10 hover:bg-white/20 rounded-xl px-3 py-1.5 text-xs font-semibold transition flex items-center gap-1.5">
                    <span x-show="!copied">📋 Salin</span>
                    <span x-show="copied" x-cloak class="text-emerald-300">✅ Tersalin!</span>
                </button>
            </div>
            <div class="flex items-end justify-between pt-5 border-t border-white/10">
                <div><p class="text-xs text-primary-300 mb-1">Total</p><p class="text-3xl font-black">Rp {{ number_format($pending->amount, 0, ',', '.') }}</p></div>
                <div class="text-right"><p class="text-xs text-primary-300 mb-1">Kadaluarsa</p><p class="text-sm font-semibold text-amber-300">{{ $pending->expired_at ? \Carbon\Carbon::parse($pending->expired_at)->format('d M Y, H:i') : '24 jam' }}</p></div>
            </div>
        </div>
    </div>

    {{-- Form konfirmasi --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden mb-5" x-data="{ open:false, method:'' }">
        <button @click="open=!open" class="w-full flex items-center justify-between px-6 py-4 font-bold text-sm text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800/60 transition">
            <span class="flex items-center gap-2"><svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Sudah Transfer? Konfirmasi di sini</span>
            <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open&&'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div x-show="open" x-transition x-cloak class="px-6 pb-6 pt-4 border-t border-slate-100 dark:border-slate-800">
            <p class="text-sm text-slate-500 mb-4">Pilih bank/e-wallet yang Anda gunakan:</p>
            <form method="POST" action="{{ route('member.payment.confirm', $pending->id) }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-4 gap-2">
                    @foreach(['bca'=>'BCA','bni'=>'BNI','mandiri'=>'Mandiri','bri'=>'BRI','dana'=>'DANA','gopay'=>'GoPay','ovo'=>'OVO','qris'=>'QRIS'] as $val=>$lbl)
                    <label class="relative cursor-pointer">
                        <input type="radio" name="payment_method" value="{{ $val }}" x-model="method" class="sr-only peer" required>
                        <div class="peer-checked:ring-2 peer-checked:ring-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/30 peer-checked:border-primary-400 border-2 border-slate-200 dark:border-slate-700 rounded-xl py-2.5 text-center hover:border-slate-300 transition bg-slate-50 dark:bg-slate-800">
                            <p class="font-black text-xs text-slate-900 dark:text-white">{{ $lbl }}</p>
                        </div>
                        <div x-show="method==='{{ $val }}'" x-cloak class="absolute -top-1 -right-1 w-4 h-4 bg-primary-500 rounded-full flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </label>
                    @endforeach
                </div>
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl px-4 py-3 text-xs text-amber-700 dark:text-amber-400 flex gap-2">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>Pastikan Anda sudah transfer <strong>Rp {{ number_format($pending->amount, 0, ',', '.') }}</strong> ke VA <strong>{{ $pending->va_number }}</strong>. Setelah konfirmasi, admin akan memvalidasi dalam 1×24 jam.</p>
                </div>
                <button type="submit" :disabled="!method" :class="method?'bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 shadow-lg shadow-emerald-500/30 cursor-pointer':'bg-slate-200 dark:bg-slate-700 text-slate-400 cursor-not-allowed'" class="w-full py-3.5 text-white font-black rounded-xl transition flex items-center justify-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Kirim Konfirmasi ke Admin
                </button>
            </form>
        </div>
    </div>

    {{-- ===== BELUM ADA TAGIHAN - PILIH PAKET ===== --}}
    @else
    {{-- Perbandingan Free vs Premium --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        {{-- Free --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl border-2 border-slate-200 dark:border-slate-700 p-6">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Akun Gratis (Aktif)</p>
            <p class="text-3xl font-black text-slate-900 dark:text-white mb-4">Rp 0</p>
            <ul class="space-y-2.5 text-sm text-slate-600 dark:text-slate-400">
                @foreach(['✅ Akses artikel & berita','✅ Daftar kegiatan umum','✅ Dashboard member','✅ Profil & keanggotaan','❌ Materi edukasi eksklusif','❌ Webinar premium','❌ Konten member-only'] as $f)
                <li class="{{ str_starts_with($f,'❌') ? 'opacity-40' : '' }}">{{ $f }}</li>
                @endforeach
            </ul>
        </div>
        {{-- Premium --}}
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl border-2 border-amber-400 p-6 relative overflow-hidden">
            <div class="absolute top-3 right-3 bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-black px-2.5 py-1 rounded-full">RECOMMENDED</div>
            <p class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider mb-3">Premium</p>
            <p class="text-3xl font-black text-amber-900 dark:text-amber-100 mb-1">Rp 300.000</p>
            <p class="text-xs text-amber-600 dark:text-amber-400 mb-4">per tahun</p>
            <ul class="space-y-2.5 text-sm text-amber-900 dark:text-amber-200">
                @foreach (['✅ Semua fitur gratis','✅ Semua materi edukasi','✅ Webinar & seminar eksklusif','✅ Konten member-only','✅ Akses prioritas kegiatan','✅ Jaringan premium HPMI','✅ Konsultasi online'] as $f)
                <li class="font-semibold">{{ $f }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <form method="POST" action="{{ route('member.payment.pay') }}">
        @csrf
        <button type="submit" class="w-full py-4 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-black text-base rounded-2xl shadow-xl shadow-amber-500/30 transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Ajukan Upgrade Premium — Rp 300.000/tahun
        </button>
        <p class="text-center text-xs text-slate-400 mt-3">Setelah klik, Anda akan mendapat nomor Virtual Account untuk pembayaran</p>
    </form>
    @endif

</div>
@endsection
