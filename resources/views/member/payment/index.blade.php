@extends('layouts.app')
@section('title','Upgrade Premium')

@php
    $pendingId         = data_get($pending, 'id', 0);
    $pendingInvoice    = data_get($pending, 'invoice_no', '-');
    $pendingVa         = data_get($pending, 'va_number', '-');
    $pendingAmount     = data_get($pending, 'amount', 300000);
    $pendingExpired    = data_get($pending, 'expired_at');
    $pendingMethod     = data_get($pending, 'payment_method');
    $pendingExpiredFmt = $pendingExpired
        ? \Carbon\Carbon::parse($pendingExpired)->format('d M Y, H:i')
        : '24 jam';
@endphp

@section('content')

{{-- ✅ x-data wraps EVERYTHING including modal --}}
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ openModal: false }">

  {{-- Header --}}
  <div class="flex items-center gap-3 mb-8">
    <a href="{{ route('member.dashboard') }}"
       class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
    </a>
    <div>
      <h1 class="text-2xl font-black text-slate-900 dark:text-white">Upgrade Premium</h1>
      <p class="text-sm text-slate-500 dark:text-slate-400">Akses semua fitur eksklusif HPMI</p>
    </div>
    <a href="{{ route('member.payment.history') }}"
       class="ml-auto text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">Riwayat →</a>
  </div>

  {{-- Flash sukses --}}
  @if(session('success'))
  <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
  </div>
  @endif

  @if(session('error'))
  <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl text-sm">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('error') }}
  </div>
  @endif

  {{-- ══ STATE 1: SUDAH PREMIUM ══ --}}
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

  {{-- ══ STATE 2: MENUNGGU VALIDASI ══ --}}
  @elseif($user->isPremiumPending())
  <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-3xl p-8 text-center">
    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mx-auto mb-4">
      <svg class="w-8 h-8 text-blue-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
      </svg>
    </div>
    <h2 class="text-xl font-black text-blue-900 dark:text-blue-100 mb-2">Pengajuan Sedang Divalidasi</h2>
    <p class="text-blue-600 dark:text-blue-400 text-sm">Admin sedang memverifikasi pembayaran Anda dalam 1×24 jam kerja.</p>
  </div>

  {{-- ══ STATE 3: ADA TAGIHAN PENDING LAMA (belum konfirmasi) ══ --}}
  @elseif($pending && !$pendingMethod)

  <div class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-violet-900 rounded-3xl p-8 text-white mb-5 overflow-hidden shadow-2xl">
    <div class="absolute top-0 right-0 w-60 h-60 bg-white/5 rounded-full -translate-y-20 translate-x-20"></div>
    <div class="relative">
      <div class="flex items-start justify-between mb-6">
        <div>
          <p class="text-xs font-bold uppercase tracking-widest text-primary-300">Tagihan Upgrade Premium</p>
          <p class="text-sm text-white/60 mt-0.5">{{ $pendingInvoice }}</p>
        </div>
        <span class="bg-amber-400/20 border border-amber-400/40 text-amber-300 text-xs font-bold px-3 py-1.5 rounded-xl">Menunggu Konfirmasi</span>
      </div>
      <div class="flex items-end justify-between pt-5 border-t border-white/10">
        <div>
          <p class="text-xs text-primary-300 mb-1">Total</p>
          <p class="text-3xl font-black">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</p>
        </div>
        <div class="text-right">
          <p class="text-xs text-primary-300 mb-1">Kadaluarsa</p>
          <p class="text-sm font-semibold text-amber-300">{{ $pendingExpiredFmt }}</p>
        </div>
      </div>
    </div>
  </div>

  <button type="button"
          x-on:click="openModal = true"
          class="w-full py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-black text-base rounded-2xl shadow-xl shadow-emerald-500/30 transition flex items-center justify-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    Konfirmasi Pembayaran
  </button>

  {{-- ══ STATE 4: BELUM ADA TAGIHAN ══ --}}
  @else

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div class="bg-white dark:bg-slate-900 rounded-2xl border-2 border-slate-200 dark:border-slate-700 p-6">
      <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Akun Gratis (Aktif)</p>
      <p class="text-3xl font-black text-slate-900 dark:text-white mb-4">Rp 0</p>
      <ul class="space-y-2.5 text-sm text-slate-600 dark:text-slate-400">
        <li>✅ Akses artikel &amp; berita</li>
        <li>✅ Daftar kegiatan umum</li>
        <li>✅ Dashboard member</li>
        <li>✅ Profil &amp; keanggotaan</li>
        <li class="opacity-40">❌ Materi edukasi eksklusif</li>
        <li class="opacity-40">❌ Webinar premium</li>
        <li class="opacity-40">❌ Konten member-only</li>
      </ul>
    </div>
    <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl border-2 border-amber-400 p-6 relative overflow-hidden">
      <div class="absolute top-3 right-3 bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-black px-2.5 py-1 rounded-full">RECOMMENDED</div>
      <p class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider mb-3">Premium</p>
      <p class="text-3xl font-black text-amber-900 dark:text-amber-100 mb-1">
        Rp {{ number_format($settings['billing_registration_fee'] ?? 300000, 0, ',', '.') }}
      </p>
      <p class="text-xs text-amber-600 dark:text-amber-400 mb-4">
        {{ $settings['billing_membership_duration'] ?? 'per tahun' }}
      </p>
      <ul class="space-y-2.5 text-sm text-amber-900 dark:text-amber-200 font-semibold">
        <li>✅ Semua fitur gratis</li>
        <li>✅ Semua materi edukasi</li>
        <li>✅ Webinar &amp; seminar eksklusif</li>
        <li>✅ Konten member-only</li>
        <li>✅ Akses prioritas kegiatan</li>
        <li>✅ Jaringan premium HPMI</li>
        <li>✅ Konsultasi online</li>
      </ul>
    </div>
  </div>

  {{-- Rekening pembayaran --}}
  @if(count($banks) > 0)
  <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden mb-5">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
      <div class="w-2 h-2 rounded-full bg-rose-500"></div>
      <h3 class="text-sm font-bold text-slate-900 dark:text-white">Rekening Pembayaran</h3>
    </div>
    <div class="divide-y divide-slate-100 dark:divide-slate-800">
      @foreach($banks as $bank)
      @php
        $bName = data_get($bank, 'bank_name', '');
        $bNo   = data_get($bank, 'account_number', '');
        $bAcc  = data_get($bank, 'account_name', '');
      @endphp
      <div class="px-6 py-4 flex items-center gap-4" x-data="{ copied: false }">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800 flex items-center justify-center flex-shrink-0 font-black text-slate-600 dark:text-slate-300 text-xs">
          {{ strtoupper(substr($bName, 0, 3)) }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wide">{{ $bName }}</p>
          <p class="font-mono font-black text-slate-900 dark:text-white text-base mt-0.5">{{ $bNo }}</p>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">a.n. {{ $bAcc }}</p>
        </div>
        <button type="button"
                data-no="{{ $bNo }}"
                x-on:click="navigator.clipboard.writeText($el.dataset.no); copied = true; setTimeout(() => copied = false, 2000)"
                class="flex-shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition"
                :class="copied ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-slate-200'">
          <span x-show="!copied">📋 Salin</span>
          <span x-show="copied" x-cloak>✅ Tersalin</span>
        </button>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- ✅ Tombol buka modal — TANPA form wrapper --}}
  <button type="button"
          x-on:click="openModal = true"
          class="w-full py-4 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-black text-base rounded-2xl shadow-xl shadow-amber-500/30 transition flex items-center justify-center gap-2">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
      <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
    </svg>
    Ajukan Upgrade Premium — Rp {{ number_format($settings['billing_registration_fee'] ?? 300000, 0, ',', '.') }}/tahun
  </button>
  <p class="text-center text-xs text-slate-400 mt-3">Upload bukti transfer untuk divalidasi admin</p>

  @endif

  {{-- ══════════════════════════════════════
       MODAL — di dalam div x-data yang sama
       Ini kunci agar openModal bisa dibaca
  ══════════════════════════════════════ --}}
  <div x-show="openModal"
       x-cloak
       class="fixed inset-0 z-50 flex items-center justify-center p-4"
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0">

    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" x-on:click="openModal = false"></div>

    <div class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">

      {{-- Header modal --}}
      <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 dark:border-slate-800 sticky top-0 bg-white dark:bg-slate-900 rounded-t-3xl z-10">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
            <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
          </div>
          <h3 class="text-base font-black text-slate-900 dark:text-white">Ajukan Upgrade Premium</h3>
        </div>
        <button type="button" x-on:click="openModal = false"
                class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 hover:text-slate-600 transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <form method="POST"
            action="{{ route('member.payment.pay') }}"
            enctype="multipart/form-data"
            class="p-6 space-y-5">
        @csrf

        {{-- Nominal --}}
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl px-4 py-3">
          <p class="text-xs text-amber-600 dark:text-amber-400 font-semibold uppercase tracking-wide mb-1">Total yang harus ditransfer</p>
          <p class="text-2xl font-black text-amber-900 dark:text-amber-100">
            Rp {{ number_format($settings['billing_registration_fee'] ?? 300000, 0, ',', '.') }}
          </p>
        </div>

        {{-- Transfer ke rekening mana --}}
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
            Transfer ke Rekening <span class="text-red-400">*</span>
          </label>
          <select name="target_bank" required
                  class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
            <option value="">-- Pilih rekening tujuan --</option>
            @foreach($banks as $bank)
            @php
              $bName = data_get($bank, 'bank_name', '');
              $bNo   = data_get($bank, 'account_number', '');
              $bOwn  = data_get($bank, 'account_name', '');
            @endphp
            <option value="{{ $bName }} - {{ $bNo }} (a.n. {{ $bOwn }})">
              {{ $bName }} — {{ $bNo }} · a.n. {{ $bOwn }}
            </option>
            @endforeach
          </select>
          @error('target_bank')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Nama pengirim --}}
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
            Nama Pengirim <span class="text-red-400">*</span>
          </label>
          <input type="text" name="sender_name"
                 value="{{ old('sender_name') }}"
                 placeholder="Nama sesuai rekening/e-wallet pengirim" required
                 class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
          @error('sender_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Bank pengirim --}}
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
            Dari Bank / E-Wallet <span class="text-red-400">*</span>
          </label>
          <input type="text" name="payment_method"
                 value="{{ old('payment_method') }}"
                 placeholder="cth: BCA, BNI, Mandiri, GoPay, DANA..." required
                 class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
          @error('payment_method')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Tanggal transfer --}}
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
            Tanggal Transfer <span class="text-red-400">*</span>
          </label>
          <input type="date" name="transfer_date"
                 value="{{ old('transfer_date', date('Y-m-d')) }}"
                 max="{{ date('Y-m-d') }}" required
                 class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
          @error('transfer_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Upload bukti --}}
        <div>
          <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
            Foto Bukti Transfer <span class="text-red-400">*</span>
          </label>
          <label class="block cursor-pointer" x-data="{ fileName: '' }">
            <div class="border-2 border-dashed rounded-xl p-5 text-center transition"
                 :class="fileName
                   ? 'border-amber-400 bg-amber-50 dark:bg-amber-900/20'
                   : 'border-slate-200 dark:border-slate-600 hover:border-amber-400'">
              <template x-if="!fileName">
                <div>
                  <svg class="w-8 h-8 text-slate-300 dark:text-slate-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Klik untuk upload bukti transfer</p>
                  <p class="text-xs text-slate-400 mt-1">JPG, JPEG, PNG — Maks 2 MB</p>
                </div>
              </template>
              <template x-if="fileName">
                <div class="flex items-center justify-center gap-2 text-amber-700 dark:text-amber-400">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  <p class="text-sm font-semibold truncate max-w-xs" x-text="fileName"></p>
                </div>
              </template>
            </div>
            <input type="file" name="proof" accept=".jpg,.jpeg,.png" class="sr-only"
                   x-on:change="fileName = $event.target.files[0]?.name ?? ''" required>
          </label>
          @error('proof')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Info --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl px-4 py-3 text-xs text-blue-700 dark:text-blue-400 flex gap-2">
          <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <p>Admin akan memvalidasi bukti transfer dalam <strong>1×24 jam kerja</strong>. Status akun diperbarui otomatis setelah disetujui.</p>
        </div>

        <button type="submit"
                class="w-full py-3.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-black rounded-xl shadow-lg shadow-amber-500/30 transition flex items-center justify-center gap-2 text-sm active:scale-95">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
          </svg>
          Kirim Pengajuan ke Admin
        </button>
      </form>
    </div>
  </div>
  {{-- ══ END MODAL ══ --}}

</div>{{-- ✅ Tutup div x-data di paling bawah --}}

@endsection