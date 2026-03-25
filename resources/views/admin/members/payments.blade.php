@extends('layouts.admin')
@section('title', 'Manajemen Pembayaran')
@section('content')
<div class="space-y-5">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Manajemen Pembayaran</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Konfirmasi dan kelola pembayaran anggota</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php $statsCards = [
            ['label'=>'Total Pembayaran','value'=>$payments->total(),'color'=>'blue','icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
            ['label'=>'Menunggu Konfirmasi','value'=>$payments->where('status','pending')->count(),'color'=>'yellow','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label'=>'Lunas','value'=>$payments->where('status','paid')->count(),'color'=>'green','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label'=>'Gagal','value'=>$payments->where('status','failed')->count(),'color'=>'red','icon'=>'M6 18L18 6M6 6l12 12'],
        ];
        $cm=['blue'=>'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400','yellow'=>'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400','green'=>'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400','red'=>'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400']; @endphp
        @foreach($statsCards as $sc)
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $sc['label'] }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $sc['value'] }}</p>
                </div>
                <div class="{{ $cm[$sc['color']] }} p-3 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $sc['icon'] }}"/></svg>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">Daftar Pembayaran</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Anggota</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Invoice</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Nominal</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Tipe</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Status</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Tanggal</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-5 py-3.5">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $payment->member->user->name??'-' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $payment->member->member_code??'-' }}</p>
                        </td>
                        <td class="px-5 py-3.5"><code class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-700 dark:text-gray-300">{{ $payment->invoice_no }}</code></td>
                        <td class="px-5 py-3.5 font-semibold text-gray-900 dark:text-white">Rp {{ number_format($payment->amount) }}</td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-400 capitalize">{{ str_replace('_',' ',$payment->type) }}</td>
                        <td class="px-5 py-3.5">
                            @php $ss=['paid'=>'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400','pending'=>'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400','failed'=>'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400','expired'=>'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400'];$sl=['paid'=>'Lunas','pending'=>'Pending','failed'=>'Gagal','expired'=>'Kadaluarsa']; @endphp
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $ss[$payment->status]??'' }}">{{ $sl[$payment->status]??$payment->status }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-400 text-xs">{{ $payment->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3.5">
                            @if($payment->status === 'pending')
                            <form method="POST" action="{{ route('admin.payments.confirm', $payment) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-xs text-green-600 dark:text-green-400 hover:underline font-medium">Konfirmasi</button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400 text-sm">Belum ada data pembayaran</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
        <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-700">{{ $payments->links() }}</div>
        @endif
    </div>
</div>
@endsection
