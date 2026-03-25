@extends('layouts.admin')
@section('title','Pembayaran & Validasi Premium')
@section('subtitle','Validasi pengajuan upgrade Premium dari anggota')
@section('content')
<div class="space-y-5">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <div>
            <p class="font-bold text-slate-900 dark:text-white">{{ $payments->total() }} transaksi</p>
            <p class="text-xs text-slate-500">Pengajuan upgrade Premium dari anggota</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800">
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Anggota</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Invoice</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Nominal</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Metode Bayar</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Status</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition {{ $payment->status==='pending' && $payment->payment_method ? 'bg-amber-50/50 dark:bg-amber-900/10' : '' }}">
                        <td class="px-5 py-4">
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $payment->member->user->name??'-' }}</p>
                            <p class="text-xs text-slate-400">{{ $payment->member->user->email??'-' }}</p>
                        </td>
                        <td class="px-5 py-4"><code class="text-xs font-mono text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-lg">{{ $payment->invoice_no }}</code></td>
                        <td class="px-5 py-4 font-bold text-slate-900 dark:text-white">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td class="px-5 py-4">
                            @if($payment->payment_method)
                            <span class="text-xs font-bold bg-blue-100 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 px-2.5 py-1 rounded-lg">{{ $payment->payment_method }}</span>
                            @else
                            <span class="text-xs text-slate-400 italic">Belum dikonfirmasi</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @php $ps=['paid'=>'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400','pending'=>'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400','failed'=>'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400']; @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-lg {{ $ps[$payment->status]??'bg-slate-100 text-slate-600' }}">
                                {{ $payment->status==='paid' ? '✅ Lunas' : ($payment->status==='pending' && $payment->payment_method ? '⏳ Dikonfirmasi Member' : ($payment->status==='pending' ? '🕐 Belum Bayar' : ucfirst($payment->status))) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            @if($payment->status === 'pending' && $payment->payment_method)
                            <form method="POST" action="{{ route('admin.payments.confirm', $payment->id) }}">
                                @csrf @method('PUT')
                                <button type="submit"
                                        onclick="return confirm('Validasi pembayaran ini dan aktifkan Premium untuk {{ $payment->member->user->name }}?')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 rounded-xl shadow-lg shadow-emerald-500/20 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Validasi & Aktifkan
                                </button>
                            </form>
                            @elseif($payment->status === 'paid')
                            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold">Premium Aktif ✓</span>
                            @else
                            <span class="text-xs text-slate-400">Menunggu konfirmasi member</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-16 text-center text-slate-400 text-sm">Belum ada transaksi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())<div class="px-5 py-3 border-t border-slate-100 dark:border-slate-800">{{ $payments->links() }}</div>@endif
    </div>
</div>
@endsection
