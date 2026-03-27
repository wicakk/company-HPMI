@extends('layouts.admin')

@section('title', 'Analitik Website — HPMI')

@section('content')
<div class="p-6 bg-slate-100 min-h-screen space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Analytics Dashboard</h1>
            <p class="text-sm text-slate-500">Monitoring performa website secara realtime</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-600 text-sm font-medium">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                {{ $activeUsers['count'] }} online
            </div>

            <select onchange="changePeriod(this.value)"
                class="px-3 py-2 text-sm border rounded-lg bg-white shadow">
                <option value="7" {{ $days == 7 ? 'selected' : '' }}>7 Hari</option>
                <option value="30" {{ $days == 30 ? 'selected' : '' }}>30 Hari</option>
                <option value="90" {{ $days == 90 ? 'selected' : '' }}>90 Hari</option>
            </select>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- Visitors --}}
        <div class="bg-white rounded-2xl p-5 shadow-md">
            <div class="flex justify-between items-center mb-4">
                <div class="p-3 bg-indigo-100 rounded-xl">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M15 12a3 3 0 11-6 0"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5
                                 c4.478 0 8.268 2.943 9.542 7
                                 -1.274 4.057-5.064 7-9.542 7
                                 -4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>

                <span class="text-xs font-semibold {{ $summary['visitors_pct'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ $summary['visitors_pct'] >= 0 ? '+' : '-' }}{{ abs($summary['visitors_pct']) }}%
                </span>
            </div>

            <div class="text-3xl font-bold text-slate-800">
                {{ number_format($summary['visitors']) }}
            </div>
            <div class="text-sm text-slate-500">Total Visitors</div>
        </div>

        {{-- Pageviews --}}
        <div class="bg-white rounded-2xl p-5 shadow-md">
            <div class="flex justify-between mb-4">
                <div class="p-3 bg-cyan-100 rounded-xl">
                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M7 8h10M7 12h10M7 16h6"/>
                    </svg>
                </div>

                <span class="text-xs {{ $summary['pageviews_pct'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ $summary['pageviews_pct'] >= 0 ? '+' : '-' }}{{ abs($summary['pageviews_pct']) }}%
                </span>
            </div>

            <div class="text-3xl font-bold text-slate-800">
                {{ number_format($summary['pageviews']) }}
            </div>
            <div class="text-sm text-slate-500">Pageviews</div>
        </div>

        {{-- Duration --}}
        <div class="bg-white rounded-2xl p-5 shadow-md">
            <div class="flex justify-between mb-4">
                <div class="p-3 bg-emerald-100 rounded-xl">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
            </div>

            <div class="text-3xl font-bold text-slate-800">
                {{ gmdate('i:s', $summary['avg_duration']) }}
            </div>
            <div class="text-sm text-slate-500">Avg Duration</div>
        </div>

        {{-- Bounce --}}
        <div class="bg-white rounded-2xl p-5 shadow-md">
            <div class="flex justify-between mb-4">
                <div class="p-3 bg-rose-100 rounded-xl">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            <div class="text-3xl font-bold text-slate-800">
                {{ $summary['bounce_rate'] }}%
            </div>
            <div class="text-sm text-slate-500">Bounce Rate</div>
        </div>

    </div>

    {{-- CONTENT COUNTER --}}
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-2xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-indigo-100 rounded-xl">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-bold">{{ number_format($contentStats['total_articles']) }}</div>
                <div class="text-sm text-slate-500">Artikel</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-cyan-100 rounded-xl">
                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M8 7V3m8 4V3M4 11h16M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-bold">{{ number_format($contentStats['total_events']) }}</div>
                <div class="text-sm text-slate-500">Kegiatan</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-md flex items-center gap-4">
            <div class="p-3 bg-emerald-100 rounded-xl">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M17 20h5V4H2v16h5"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-bold">{{ number_format($contentStats['total_users']) }}</div>
                <div class="text-sm text-slate-500">Member</div>
            </div>
        </div>
    </div>

    {{-- CHART + POPULAR --}}
    <div class="grid md:grid-cols-3 gap-6">

        <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-md">
            <h3 class="font-semibold text-slate-700 mb-4">Traffic Overview</h3>
            <canvas id="lineChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h3 class="font-semibold text-slate-700 mb-4">Halaman Populer</h3>

            @php $max = collect($popularPages)->max('views') ?: 1; @endphp

            @foreach($popularPages as $page)
            <div class="mb-4">
                <div class="text-xs mb-1 truncate">{{ $page['title'] }}</div>
                <div class="w-full bg-slate-100 h-2 rounded">
                    <div class="bg-indigo-500 h-2 rounded"
                         style="width: {{ ($page['views'] / $max) * 100 }}%">
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>

    {{-- REALTIME --}}
    <div class="bg-white rounded-2xl p-6 shadow-md">
        <div class="flex justify-between mb-4">
            <h3 class="font-semibold text-slate-700">Realtime Activity</h3>
            <span class="text-green-500 text-sm font-medium">● Live</span>
        </div>

        <table class="w-full text-sm">
            <thead class="text-xs text-slate-400 border-b">
                <tr>
                    <th class="text-left py-2">PAGE</th>
                    <th>DEVICE</th>
                    <th>LAST SEEN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activeUsers['users'] as $user)
                <tr class="border-b hover:bg-slate-50">
                    <td class="py-3">{{ Str::limit($user['page'],20) }}</td>
                    <td class="text-center">{{ ucfirst($user['device']) }}</td>
                    <td class="text-center">{{ $user['last_seen'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
const dailyData = @json($dailyData);

new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: dailyData.map(d => d.label),
        datasets: [{
            data: dailyData.map(d => d.visitors),
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79,70,229,0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        plugins: { legend: { display: false }},
        scales: {
            x: { grid: { display: false }},
            y: { grid: { color: '#eee' }}
        }
    }
});
</script>
@endpush