@extends('layouts.app')
@section('title','Upgrade Premium')
@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="paymentPage()">

  {{-- Header --}}
  <div class="flex items-center gap-3 mb-8">
    <a href="{{ route('member.dashboard') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
      <h1 class="text-2xl font-black text-slate-900 dark:text-white">Upgrade Premium</h1>
      <p class="text-sm text-slate-500 dark:text-slate-400">Akses semua fitur eksklusif HPMI</p>
    </div>
    <a href="{{ route('member.payment.history') }}" class="ml-auto text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">Riwayat →</a>
  </div>

  {{-- Flash --}}
  @if(session('success'))
  <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
  </div>
  @endif

  {{-- ===== SUDAH PREMIUM ===== --}}
  @if($user->isPremium())
  <div class="bg-gradient-to-br from-amber-400 via-orange-500 to-yellow-500 rounded-3xl p-8 text-white text-center shadow-2xl shadow-amber-500/30">
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
  <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-3xl p-8 text-center">
    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mx-auto mb-4">
      <svg class="w-8 h-8 text-blue-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
    </div>
    <h2 class="text-xl font-black text-blue-900 dark:text-blue-100 mb-2">Pengajuan Sedang Divalidasi</h2>
    <p class="text-blue-600 dark:text-blue-400 text-sm">Admin sedang memverifikasi pembayaran Anda dalam 1×24 jam kerja.</p>
  </div>

  {{-- ===== ADA TAGIHAN - BELUM KONFIRMASI ===== --}}
  @elseif($pending && !$pending->payment_method)

  {{-- Card VA --}}
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
      <div class="flex items-center gap-3 mb-6" x-data="{copied:false}"
           @click="navigator.clipboard.writeText('{{ $pending->va_number }}'); copied=true; setTimeout(()=>copied=false,2000)">
        <p class="font-mono text-2xl font-black tracking-widest cursor-pointer hover:text-primary-200 transition">{{ $pending->va_number }}</p>
        <button class="bg-white/10 hover:bg-white/20 rounded-xl px-3 py-1.5 text-xs font-semibold transition">
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

  {{-- Card Bank / Rekening Tujuan --}}
  @if($banks->count())
  <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden mb-5">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
      <div class="w-2 h-2 rounded-full bg-rose-500"></div>
      <h3 class="text-sm font-bold text-slate-900 dark:text-white">Transfer ke Rekening Berikut</h3>
    </div>
    <div class="divide-y divide-slate-100 dark:divide-slate-800">
      @foreach($banks as $bank)
      <div class="px-6 py-4 flex items-center gap-4" x-data="{copied:false}">
        {{-- Logo / Initial --}}
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800 flex items-center justify-center flex-shrink-0 font-black text-slate-600 dark:text-slate-300 text-xs overflow-hidden">
          @if($bank->logo)
            <img src="{{ Storage::url($bank->logo) }}" alt="{{ $bank->bank_name }}" class="w-full h-full object-contain p-1">
          @else
            {{ strtoupper(substr($bank->bank_name, 0, 3)) }}
          @endif
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wide">{{ $bank->bank_name }}</p>
          <p class="font-mono font-black text-slate-900 dark:text-white text-base mt-0.5">{{ $bank->account_number }}</p>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">a.n. {{ $bank->account_name }}</p>
        </div>
        {{-- Copy button --}}
        <button @click="navigator.clipboard.writeText('{{ $bank->account_number }}'); copied=true; setTimeout(()=>copied=false,2000)"
                class="flex-shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition"
                :class="copied ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-600'">
          <span x-show="!copied">📋 Salin</span>
          <span x-show="copied" x-cloak>✅ Tersalin</span>
        </button>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- Tata Cara Pembayaran --}}
  <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-200 dark:border-slate-700 p-5 mb-5">
    <h4 class="text-sm font-bold text-slate-800 dark:text-white mb-3 flex items-center gap-2">
      <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      Tata Cara Pembayaran
    </h4>
    <ol class="space-y-3">
      @foreach([
        ['Pilih rekening tujuan di atas, lalu catat atau salin nomor rekeningnya.', 'bg-rose-500'],
        ['Transfer sejumlah <strong>Rp 300.000</strong> dari bank atau e-wallet Anda.', 'bg-orange-500'],
        ['Simpan bukti transfer (screenshot/foto struk).', 'bg-amber-500'],
        ['Klik tombol <strong>"Konfirmasi Pembayaran"</strong> di bawah dan isi form konfirmasi.', 'bg-emerald-500'],
        ['Admin akan memvalidasi dalam <strong>1×24 jam kerja</strong>. Status akan diperbarui otomatis.', 'bg-blue-500'],
      ] as $i => [$step, $color])
      <li class="flex items-start gap-3">
        <span class="w-6 h-6 rounded-full {{ $color }} text-white text-xs font-black flex items-center justify-center flex-shrink-0 mt-0.5">{{ $i+1 }}</span>
        <p class="text-sm text-slate-600 dark:text-slate-400">{!! $step !!}</p>
      </li>
      @endforeach
    </ol>
  </div>

  {{-- Tombol Konfirmasi --}}
  <button @click="openModal = true"
          class="w-full py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-black text-base rounded-2xl shadow-xl shadow-emerald-500/30 transition flex items-center justify-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    Konfirmasi Pembayaran
  </button>

  {{-- ===== BELUM ADA TAGIHAN ===== --}}
  @else

  {{-- Perbandingan paket --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div class="bg-white dark:bg-slate-900 rounded-2xl border-2 border-slate-200 dark:border-slate-700 p-6">
      <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Akun Gratis (Aktif)</p>
      <p class="text-3xl font-black text-slate-900 dark:text-white mb-4">Rp 0</p>
      <ul class="space-y-2.5 text-sm text-slate-600 dark:text-slate-400">
        @foreach(['✅ Akses artikel & berita','✅ Daftar kegiatan umum','✅ Dashboard member','✅ Profil & keanggotaan','❌ Materi edukasi eksklusif','❌ Webinar premium','❌ Konten member-only'] as $f)
        <li class="{{ str_starts_with($f,'❌') ? 'opacity-40' : '' }}">{{ $f }}</li>
        @endforeach
      </ul>
    </div>
    <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl border-2 border-amber-400 p-6 relative overflow-hidden">
      <div class="absolute top-3 right-3 bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-black px-2.5 py-1 rounded-full">RECOMMENDED</div>
      <p class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider mb-3">Premium</p>
      <p class="text-3xl font-black text-amber-900 dark:text-amber-100 mb-1">Rp 300.000</p>
      <p class="text-xs text-amber-600 dark:text-amber-400 mb-4">per tahun</p>
      <ul class="space-y-2.5 text-sm text-amber-900 dark:text-amber-200">
        @foreach(['✅ Semua fitur gratis','✅ Semua materi edukasi','✅ Webinar & seminar eksklusif','✅ Konten member-only','✅ Akses prioritas kegiatan','✅ Jaringan premium HPMI','✅ Konsultasi online'] as $f)
        <li class="font-semibold">{{ $f }}</li>
        @endforeach
      </ul>
    </div>
  </div>

  {{-- Card Bank --}}
  @if($banks->count())
  <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden mb-5">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
      <div class="w-2 h-2 rounded-full bg-rose-500"></div>
      <h3 class="text-sm font-bold text-slate-900 dark:text-white">Rekening Pembayaran</h3>
    </div>
    <div class="divide-y divide-slate-100 dark:divide-slate-800">
      @foreach($banks as $bank)
      <div class="px-6 py-4 flex items-center gap-4" x-data="{copied:false}">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800 flex items-center justify-center flex-shrink-0 font-black text-slate-600 dark:text-slate-300 text-xs overflow-hidden">
          @if($bank->logo)
            <img src="{{ Storage::url($bank->logo) }}" alt="{{ $bank->bank_name }}" class="w-full h-full object-contain p-1">
          @else
            {{ strtoupper(substr($bank->bank_name, 0, 3)) }}
          @endif
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wide">{{ $bank->bank_name }}</p>
          <p class="font-mono font-black text-slate-900 dark:text-white text-base mt-0.5">{{ $bank->account_number }}</p>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">a.n. {{ $bank->account_name }}</p>
        </div>
        <button @click="navigator.clipboard.writeText('{{ $bank->account_number }}'); copied=true; setTimeout(()=>copied=false,2000)"
                class="flex-shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition"
                :class="copied ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-slate-200'">
          <span x-show="!copied">📋 Salin</span>
          <span x-show="copied" x-cloak>✅ Tersalin</span>
        </button>
      </div>
      @endforeach
    </div>
  </div>
  @endif

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

{{-- ══════════════════════════════════════
     MODAL KONFIRMASI PEMBAYARAN
══════════════════════════════════════ --}}
<div x-show="openModal" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

  {{-- Backdrop --}}
  <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="openModal = false"></div>

  {{-- Modal Box --}}
  <div class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto"
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0 scale-95"
       x-transition:enter-end="opacity-100 scale-100">

    {{-- Modal Header --}}
    <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 dark:border-slate-800 sticky top-0 bg-white dark:bg-slate-900 rounded-t-3xl z-10">
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
          <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h3 class="text-base font-black text-slate-900 dark:text-white">Konfirmasi Pembayaran</h3>
      </div>
      <button @click="openModal = false" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 hover:text-slate-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    {{-- Modal Body --}}
    <form method="POST" action="{{ route('member.payment.confirm', $pending->id ?? 0) }}"
          enctype="multipart/form-data" class="p-6 space-y-5">
      @csrf

      {{-- Nominal (readonly) --}}
      <div>
        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
          Nominal Transfer
        </label>
        <div class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-black font-mono">
          Rp {{ number_format($pending->amount ?? 300000, 0, ',', '.') }}
        </div>
        <p class="text-xs text-slate-400 mt-1">Nominal sudah sesuai tagihan, tidak dapat diubah</p>
      </div>

      {{-- Nama Pengirim --}}
      <div>
        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
          Nama Pengirim <span class="text-red-400">*</span>
        </label>
        <input type="text" name="sender_name" value="{{ old('sender_name') }}"
               placeholder="Nama sesuai rekening pengirim..."
               class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition @error('sender_name') border-red-400 @enderror"
               required>
        @error('sender_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Bank / E-wallet --}}
      <div>
        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
          Bank / E-Wallet <span class="text-red-400">*</span>
        </label>
        <select name="payment_method" required
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition @error('payment_method') border-red-400 @enderror">
          <option value="">Pilih bank/e-wallet yang digunakan...</option>
          @foreach($banks as $bank)
          <option value="{{ $bank->bank_name }}" {{ old('payment_method') == $bank->bank_name ? 'selected' : '' }}>
            {{ $bank->bank_name }} — {{ $bank->account_number }}
          </option>
          @endforeach
          <option value="Lainnya">Lainnya</option>
        </select>
        @error('payment_method')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Tanggal Transfer --}}
      <div>
        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
          Tanggal Transfer <span class="text-red-400">*</span>
        </label>
        <input type="date" name="transfer_date" value="{{ old('transfer_date', date('Y-m-d')) }}"
               max="{{ date('Y-m-d') }}"
               class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition @error('transfer_date') border-red-400 @enderror"
               required>
        @error('transfer_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Upload Bukti --}}
      <div>
        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
          Bukti Transfer <span class="text-red-400">*</span>
        </label>
        <label class="block cursor-pointer" x-data="{fileName: ''}">
          <div class="border-2 border-dashed border-slate-200 dark:border-slate-600 rounded-xl p-5 text-center hover:border-emerald-400 hover:bg-emerald-50/30 dark:hover:bg-emerald-900/10 transition"
               :class="fileName ? 'border-emerald-400 bg-emerald-50 dark:bg-emerald-900/20' : ''">
            <template x-if="!fileName">
              <div>
                <svg class="w-8 h-8 text-slate-300 dark:text-slate-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Klik untuk upload bukti transfer</p>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">JPG, JPEG, PNG — Maks 2 MB</p>
              </div>
            </template>
            <template x-if="fileName">
              <div class="flex items-center justify-center gap-2 text-emerald-700 dark:text-emerald-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-semibold truncate max-w-[200px]" x-text="fileName"></p>
              </div>
            </template>
          </div>
          <input type="file" name="proof" accept=".jpg,.jpeg,.png" class="sr-only"
                 @change="fileName = $event.target.files[0]?.name ?? ''" required>
        </label>
        @error('proof')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Info box --}}
      <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl px-4 py-3 text-xs text-amber-700 dark:text-amber-400 flex gap-2">
        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p>Pastikan data yang Anda masukkan sesuai dengan bukti transfer. Admin akan memvalidasi dalam <strong>1×24 jam kerja</strong>.</p>
      </div>

      {{-- Submit --}}
      <button type="submit"
              class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-black rounded-xl shadow-lg shadow-emerald-500/30 transition flex items-center justify-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
        Kirim Konfirmasi ke Admin
      </button>
    </form>
  </div>
</div>

@push('scripts')
<script>
function paymentPage() {
  return { openModal: false }
}
</script>
@endpush

@endsection