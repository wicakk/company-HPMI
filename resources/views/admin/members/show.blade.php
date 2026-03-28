@extends('layouts.admin')
@section('title', 'Detail Anggota')
@section('content')

<div class="space-y-6">

  {{-- Back + Header --}}
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.members.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Detail Anggota</h2>
      <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 font-mono">{{ $member->member_code }}</p>
    </div>
  </div>

  @if(session('success'))
  <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
  </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Profile Card --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6 text-center">
      <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-black text-3xl mx-auto mb-4">
        {{ strtoupper(substr(optional($member->user)->name ?? 'U', 0, 1)) }}
      </div>
      <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ optional($member->user)->name ?? '-' }}</h3>
      <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ optional($member->user)->email ?? '-' }}</p>
      <code class="inline-block mt-2 text-xs bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 px-3 py-1 rounded-full font-mono">{{ $member->member_code }}</code>

      @php
        $statusMap = [
          'active'    => 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
          'pending'   => 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
          'expired'   => 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400',
          'suspended' => 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400',
        ];
        $statusLabels = ['active'=>'Aktif','pending'=>'Pending','expired'=>'Kadaluarsa','suspended'=>'Ditangguhkan'];
      @endphp
      <div class="mt-3">
        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $statusMap[$member->status] ?? 'bg-slate-100 dark:bg-slate-700 text-slate-500' }}">
          {{ $statusLabels[$member->status] ?? ucfirst($member->status) }}
        </span>
      </div>

      <div class="mt-5">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Ubah Status</p>
        <form method="POST" action="{{ route('admin.members.status', $member->id) }}">
          @csrf @method('PUT')
          <select name="status" onchange="this.form.submit()"
            class="w-full px-3 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition cursor-pointer">
            <option value="pending"   {{ $member->status==='pending'?'selected':'' }}>⏳ Set Pending</option>
            <option value="active"    {{ $member->status==='active'?'selected':'' }}>✅ Set Aktif</option>
            <option value="expired"   {{ $member->status==='expired'?'selected':'' }}>🕐 Set Kadaluarsa</option>
            <option value="suspended" {{ $member->status==='suspended'?'selected':'' }}>🚫 Set Ditangguhkan</option>
          </select>
        </form>
      </div>

      <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-700">
        <a href="{{ route('admin.payments.index') }}" class="block w-full py-2 rounded-xl border border-slate-200 dark:border-slate-600 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
          Lihat Pembayaran
        </a>
      </div>
    </div>

    {{-- Detail Info --}}
    <div class="lg:col-span-2 space-y-5">

      {{-- Info Pribadi --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
          <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          Informasi Pribadi
        </h4>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          @foreach([['Nama Lengkap', optional($member->user)->name??'-'],['Email',optional($member->user)->email??'-'],['Telepon',$member->phone??'-'],['Spesialisasi',$member->specialty??'-']] as [$lbl,$val])
          <div class="bg-slate-50 dark:bg-slate-700/40 rounded-xl p-3">
            <dt class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">{{ $lbl }}</dt>
            <dd class="text-sm font-semibold text-slate-800 dark:text-white">{{ $val }}</dd>
          </div>
          @endforeach
          <div class="sm:col-span-2 bg-slate-50 dark:bg-slate-700/40 rounded-xl p-3">
            <dt class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Institusi</dt>
            <dd class="text-sm font-semibold text-slate-800 dark:text-white">{{ $member->institution ?? '-' }}</dd>
          </div>
          <div class="sm:col-span-2 bg-slate-50 dark:bg-slate-700/40 rounded-xl p-3">
            <dt class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Alamat</dt>
            <dd class="text-sm font-semibold text-slate-800 dark:text-white">{{ $member->address ?? '-' }}</dd>
          </div>
        </dl>
      </div>

      {{-- Keanggotaan --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
          <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Keanggotaan
        </h4>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="bg-slate-50 dark:bg-slate-700/40 rounded-xl p-3">
            <dt class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Tanggal Bergabung</dt>
            <dd class="text-sm font-semibold text-slate-800 dark:text-white">{{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('d F Y') : '-' }}</dd>
          </div>
          <div class="bg-slate-50 dark:bg-slate-700/40 rounded-xl p-3">
            <dt class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Kadaluarsa</dt>
            <dd class="text-sm font-semibold {{ $member->expired_at && \Carbon\Carbon::parse($member->expired_at)->isPast() ? 'text-red-500 dark:text-red-400' : 'text-slate-800 dark:text-white' }}">
              {{ $member->expired_at ? \Carbon\Carbon::parse($member->expired_at)->format('d F Y') : '-' }}
            </dd>
          </div>
        </dl>
      </div>

      {{-- Riwayat Pembayaran --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
          <h4 class="text-sm font-bold text-slate-900 dark:text-white">Riwayat Pembayaran</h4>
          <a href="{{ route('admin.payments.index') }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">Semua →</a>
        </div>
        <div class="divide-y divide-slate-50 dark:divide-slate-700/50">
          @forelse(optional($member->payments)->sortByDesc('created_at') ?? [] as $pay)
          <div class="px-5 py-3.5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ $pay->status==='paid' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400' }}">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold text-slate-800 dark:text-white font-mono">{{ $pay->invoice_no }}</p>
              <p class="text-xs text-slate-400 dark:text-slate-500">{{ $pay->payment_method ?? 'VA' }} · {{ $pay->created_at->format('d M Y') }}</p>
            </div>
            <div class="text-right flex-shrink-0">
              <p class="text-sm font-bold text-slate-800 dark:text-white">Rp {{ number_format($pay->amount,0,',','.') }}</p>
              @if($pay->status==='paid')
              <span class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">Lunas</span>
              @elseif($pay->status==='pending')
              <span class="text-[11px] font-semibold text-amber-600 dark:text-amber-400">Pending</span>
              @else
              <span class="text-[11px] text-slate-400">{{ ucfirst($pay->status) }}</span>
              @endif
            </div>
          </div>
          @empty
          <div class="px-5 py-10 text-center">
            <svg class="w-7 h-7 mx-auto mb-2 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            <p class="text-sm text-slate-400 dark:text-slate-500">Belum ada riwayat pembayaran</p>
          </div>
          @endforelse
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
