@extends('layouts.admin')
@section('title', 'Detail Anggota')
@section('content')
<div class="space-y-[18px]">

  {{-- Back + Header --}}
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.members.index') }}" class="w-9 h-9 rounded-[9px] bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition-all shadow-[0_1px_3px_rgba(0,0,0,.06)]">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M19 12H5"/>
        <polyline points="12 19 5 12 12 5"/>
      </svg>
    </a>
    <div>
      <h2 class="text-[18px] font-extrabold text-slate-800">Detail Anggota</h2>
      <p class="text-[12px] text-slate-500">{{ $member->member_code }}</p>
    </div>
  </div>

  {{-- Flash Message --}}
  @if(session('success'))
    <div class="p-3 bg-green-100 text-green-800 rounded text-[12px] mb-3">
      {{ session('success') }}
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-[18px]">

    {{-- Profile Card --}}
    <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] p-6 text-center">
      <div class="w-20 h-20 rounded-[18px] bg-[rgba(30,90,255,.12)] text-[#1e5aff] flex items-center justify-center font-extrabold text-[28px] mx-auto mb-4">
        {{ strtoupper(substr(optional($member->user)->name ?? 'U', 0, 1)) }}
      </div>
      <h3 class="text-[16px] font-extrabold text-slate-800">{{ optional($member->user)->name ?? '-' }}</h3>
      <p class="text-[12px] text-slate-500 mt-1">{{ optional($member->user)->email ?? '-' }}</p>
      <code class="inline-block mt-2 text-[11px] bg-[rgba(30,90,255,.08)] text-[#1e5aff] px-3 py-1 rounded-full font-mono">{{ $member->member_code }}</code>

      @php
        $statusColors = [
          'active'    => 'bg-[rgba(16,185,129,.12)] text-[#059669]',
          'pending'   => 'bg-[rgba(245,158,11,.12)] text-[#d97706]',
          'expired'   => 'bg-slate-100 text-slate-500',
          'suspended' => 'bg-[rgba(239,68,68,.1)] text-[#dc2626]',
        ];
        $statusLabels = [
          'active' => 'Aktif', 'pending' => 'Pending',
          'expired' => 'Kadaluarsa', 'suspended' => 'Ditangguhkan',
        ];
      @endphp
      <div class="mt-3">
        <span class="inline-flex px-3 py-1 rounded-full text-[12px] font-semibold {{ $statusColors[$member->status] ?? 'bg-slate-100 text-slate-500' }}">
          {{ $statusLabels[$member->status] ?? ucfirst($member->status) }}
        </span>
      </div>

      {{-- Update Status Form --}}
      <div class="mt-5">
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Ubah Status</p>
        <form method="POST" action="{{ route('admin.members.status', $member->id) }}">
          @csrf
          @method('PUT')
          <select name="status" onchange="this.form.submit()"
            class="w-full px-3 py-2.5 text-[13px] border border-slate-200 rounded-[9px] bg-slate-50 text-slate-700 focus:outline-none focus:border-[#1e5aff] cursor-pointer">
            <option value="pending"   {{ $member->status === 'pending'   ? 'selected' : '' }}>⏳ Set Pending</option>
            <option value="active"    {{ $member->status === 'active'    ? 'selected' : '' }}>✅ Set Aktif</option>
            <option value="expired"   {{ $member->status === 'expired'   ? 'selected' : '' }}>🕐 Set Kadaluarsa</option>
            <option value="suspended" {{ $member->status === 'suspended' ? 'selected' : '' }}>🚫 Set Ditangguhkan</option>
          </select>
        </form>
      </div>

      <div class="mt-3 pt-3 border-t border-slate-100">
        <a href="{{ route('admin.payments.index') }}" class="block w-full py-2 rounded-[9px] border border-slate-200 text-[12px] font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
          Lihat Pembayaran
        </a>
      </div>
    </div>

    {{-- Detail Info --}}
    <div class="lg:col-span-2 space-y-[16px]">

      {{-- Info Pribadi --}}
      <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] p-6">
        <h4 class="text-[13px] font-bold text-slate-800 mb-4 flex items-center gap-2">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1e5aff" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Informasi Pribadi
        </h4>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          @foreach([
            ['Nama Lengkap', optional($member->user)->name ?? '-'],
            ['Email', optional($member->user)->email ?? '-'],
            ['Telepon', $member->phone ?? '-'],
            ['Spesialisasi', $member->specialty ?? '-'],
          ] as [$label, $value])
          <div>
            <dt class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">{{ $label }}</dt>
            <dd class="text-[13px] font-semibold text-slate-700">{{ $value }}</dd>
          </div>
          @endforeach
          <div class="sm:col-span-2">
            <dt class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Institusi</dt>
            <dd class="text-[13px] font-semibold text-slate-700">{{ $member->institution ?? '-' }}</dd>
          </div>
          <div class="sm:col-span-2">
            <dt class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Alamat</dt>
            <dd class="text-[13px] font-semibold text-slate-700">{{ $member->address ?? '-' }}</dd>
          </div>
        </dl>
      </div>

      {{-- Keanggotaan --}}
      <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] p-6">
        <h4 class="text-[13px] font-bold text-slate-800 mb-4 flex items-center gap-2">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1e5aff" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          Keanggotaan
        </h4>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <dt class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Bergabung</dt>
            <dd class="text-[13px] font-semibold text-slate-700">{{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('d F Y') : '-' }}</dd>
          </div>
          <div>
            <dt class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Kadaluarsa</dt>
            <dd class="text-[13px] font-semibold {{ $member->expired_at && \Carbon\Carbon::parse($member->expired_at)->isPast() ? 'text-[#ef4444]' : 'text-slate-700' }}">
              {{ $member->expired_at ? \Carbon\Carbon::parse($member->expired_at)->format('d F Y') : '-' }}
            </dd>
          </div>
        </dl>
      </div>

      {{-- Riwayat Pembayaran --}}
      <div class="bg-white rounded-[14px] border border-slate-200 shadow-[0_1px_3px_rgba(0,0,0,.06)] overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
          <h4 class="text-[13px] font-bold text-slate-800">Riwayat Pembayaran</h4>
          <a href="{{ route('admin.payments.index') }}" class="text-[12px] text-[#1e5aff] hover:underline font-medium">Semua pembayaran</a>
        </div>
        <div class="divide-y divide-slate-100">
          @forelse(optional($member->payments)->sortByDesc('created_at') ?? [] as $pay)
          <div class="px-5 py-3.5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-[9px] flex items-center justify-center flex-shrink-0 {{ $pay->status === 'paid' ? 'bg-[rgba(16,185,129,.1)] text-[#10b981]' : 'bg-[rgba(245,158,11,.1)] text-[#f59e0b]' }}">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-[13px] font-semibold text-slate-800 font-mono">{{ $pay->invoice_no }}</p>
              <p class="text-[11px] text-slate-500">{{ $pay->payment_method ?? 'VA' }} · {{ $pay->created_at->format('d M Y') }}</p>
            </div>
            <div class="text-right flex-shrink-0">
              <p class="text-[13px] font-bold text-slate-800">Rp {{ number_format($pay->amount, 0, ',', '.') }}</p>
              @if($pay->status === 'paid')
                <span class="text-[11px] font-semibold text-[#059669]">Lunas</span>
              @elseif($pay->status === 'pending')
                <span class="text-[11px] font-semibold text-[#d97706]">Pending</span>
              @else
                <span class="text-[11px] text-slate-400">{{ ucfirst($pay->status) }}</span>
              @endif
            </div>
          </div>
          @empty
          <div class="px-5 py-8 text-center">
            <svg class="mx-auto mb-2 text-slate-300" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            <p class="text-[12px] text-slate-400">Belum ada riwayat pembayaran</p>
          </div>
          @endforelse
        </div>
      </div>

    </div>
  </div>
</div>
@endsection