@extends('layouts.admin')
@section('title', 'Manajemen Kegiatan')
@section('content')

<style>
    /* @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap');

    .events-root { font-family: 'Plus Jakarta Sans', sans-serif; } */

    /* Header */
    .page-eyebrow {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
        color: #7c3aed; background: #f5f3ff; border: 1px solid #ede9fe;
        padding: 4px 12px; border-radius: 999px;
    }
    .dark .page-eyebrow { background: rgba(109,40,217,.2); border-color: rgba(139,92,246,.3); color: #a78bfa; }

    .page-title { font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 800; color: #0f172a; line-height: 1.1; }
    .dark .page-title { color: #f8fafc; }

    /* Add button */
    .btn-add {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        color: #fff; border: none; cursor: pointer; transition: all .2s;
        box-shadow: 0 4px 14px rgba(109,40,217,.35);
        text-decoration: none;
    }
    .btn-add:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(109,40,217,.45); }

    /* Stats bar */
    .stats-bar {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px;
        background: #e2e8f0; border-radius: 14px; overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .dark .stats-bar { background: #374151; border-color: #374151; }
    .stat-item {
        background: #fff; padding: 16px 20px; display: flex; align-items: center; gap: 12px;
    }
    .dark .stat-item { background: #1f2937; }
    .stat-icon { width: 36px; height: 36px; border-radius: 10px; display: grid; place-items: center; flex-shrink: 0; }
    .stat-val { font-size: 22px; font-weight: 800; color: #0f172a; line-height: 1; }
    .dark .stat-val { color: #f8fafc; }
    .stat-lbl { font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-top: 2px; }

    /* Filters */
    .filter-bar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .filter-search {
        flex: 1; min-width: 220px; display: flex; align-items: center; gap: 10px;
        background: #fff; border: 1.5px solid #e2e8f0; border-radius: 12px;
        padding: 0 14px; height: 42px;
    }
    .dark .filter-search { background: #1f2937; border-color: #374151; }
    .filter-search input { border: none; background: transparent; outline: none; font-size: 13px; color: #0f172a; width: 100%; font-family: inherit; }
    .dark .filter-search input { color: #f8fafc; }
    .filter-search input::placeholder { color: #94a3b8; }
    .filter-select {
        height: 42px; padding: 0 14px; border-radius: 12px; border: 1.5px solid #e2e8f0;
        font-size: 13px; font-weight: 600; background: #fff; color: #374151;
        outline: none; cursor: pointer; font-family: inherit;
    }
    .dark .filter-select { background: #1f2937; border-color: #374151; color: #d1d5db; }

    /* Grid */
    .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }

    /* Card */
    .event-card {
        background: #fff; border-radius: 20px; border: 1.5px solid #f1f5f9;
        overflow: hidden; transition: all .25s; position: relative;
        display: flex; flex-direction: column;
    }
    .dark .event-card { background: #1f2937; border-color: #374151; }
    .event-card:hover { border-color: #c4b5fd; transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.1); }
    .dark .event-card:hover { box-shadow: 0 20px 40px rgba(0,0,0,.4); }

    .card-image { position: relative; width: 100%; height: 180px; overflow: hidden; }
    .card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .event-card:hover .card-image img { transform: scale(1.05); }

    .card-img-placeholder {
        width: 100%; height: 100%;
        background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 50%, #c4b5fd 100%);
        display: flex; align-items: center; justify-content: center;
    }
    .dark .card-img-placeholder { background: linear-gradient(135deg, #1e1b4b, #312e81, #3730a3); }

    .card-status {
        position: absolute; top: 12px; right: 12px;
        padding: 4px 12px; border-radius: 999px; font-size: 10.5px; font-weight: 700;
        letter-spacing: .05em; text-transform: uppercase;
        backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,.3);
    }
    .status-open    { background: rgba(16,185,129,.15); color: #059669; border-color: rgba(16,185,129,.3); }
    .status-draft   { background: rgba(148,163,184,.15); color: #475569; border-color: rgba(148,163,184,.3); }
    .status-closed  { background: rgba(239,68,68,.12); color: #dc2626; border-color: rgba(239,68,68,.25); }
    .status-completed { background: rgba(59,130,246,.12); color: #2563eb; border-color: rgba(59,130,246,.25); }
    .dark .status-open     { color: #34d399; }
    .dark .status-draft    { color: #94a3b8; }
    .dark .status-closed   { color: #f87171; }
    .dark .status-completed { color: #60a5fa; }

    .card-body { padding: 20px; flex: 1; display: flex; flex-direction: column; gap: 12px; }
    .card-title { font-weight: 800; font-size: 15px; color: #0f172a; line-height: 1.4; }
    .dark .card-title { color: #f8fafc; }

    .card-meta { display: flex; flex-direction: column; gap: 6px; }
    .meta-row { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #64748b; }
    .dark .meta-row { color: #94a3b8; }
    .meta-icon { width: 14px; height: 14px; flex-shrink: 0; color: #a78bfa; }

    .card-price {
        font-size: 18px; font-weight: 800; color: #7c3aed; margin-top: auto;
    }
    .dark .card-price { color: #a78bfa; }
    .card-price.free { color: #059669; }
    .dark .card-price.free { color: #34d399; }

    .card-footer { 
        padding: 14px 20px; border-top: 1.5px solid #f1f5f9;
        display: flex; align-items: center; gap: 8px;
    }
    .dark .card-footer { border-color: #374151; }

    .btn-action {
        flex: 1; height: 36px; border-radius: 10px; font-size: 12px; font-weight: 700;
        border: none; cursor: pointer; font-family: inherit; text-decoration: none;
        display: grid; place-items: center; transition: all .15s; letter-spacing: .02em;
    }
    .btn-edit { background: #f5f3ff; color: #7c3aed; }
    .btn-edit:hover { background: #ede9fe; }
    .dark .btn-edit { background: rgba(109,40,217,.15); color: #a78bfa; }
    .dark .btn-edit:hover { background: rgba(109,40,217,.25); }

    .btn-view { background: #f0fdf4; color: #059669; }
    .btn-view:hover { background: #dcfce7; }
    .dark .btn-view { background: rgba(5,150,105,.12); color: #34d399; }

    .btn-del { background: #fff1f2; color: #e11d48; border: none; cursor: pointer; font-family: inherit; }
    .btn-del:hover { background: #ffe4e6; }
    .dark .btn-del { background: rgba(225,29,72,.1); color: #fb7185; }

    /* Empty state */
    .empty-state {
        grid-column: 1/-1; text-align: center; padding: 80px 20px;
    }
    .empty-icon {
        width: 80px; height: 80px; border-radius: 24px;
        background: #f5f3ff; display: grid; place-items: center; margin: 0 auto 20px;
    }
    .dark .empty-icon { background: rgba(109,40,217,.15); }

    /* Pagination */
    .pagination-wrap { display: flex; justify-content: center; }
    .pagination-wrap nav { display: flex; }

    @media (max-width: 640px) {
        .page-title { font-size: 1.5rem; }
        .stats-bar { grid-template-columns: repeat(2, 1fr); }
        .events-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="events-root space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div class="space-y-2">
            <span class="page-eyebrow">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                Manajemen
            </span>
            <h2 class="page-title">Kegiatan & Acara</h2>
        </div>
        
        <a href="{{ route('admin.events.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-500/25 transition active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor">
                <path stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kegiatan
        </a>
    </div>

    {{-- Stats --}}
    @php
        $total     = $events->total();
        $open      = $events->getCollection()->where('status','open')->count();
        $draft     = $events->getCollection()->where('status','draft')->count();
        $completed = $events->getCollection()->where('status','completed')->count();
    @endphp
    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-icon" style="background:#f5f3ff">
                <svg class="w-5 h-5" style="color:#7c3aed" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div>
                <div class="stat-val">{{ $total }}</div>
                <div class="stat-lbl">Total</div>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon" style="background:#f0fdf4">
                <svg class="w-5 h-5" style="color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="stat-val" style="color:#059669">{{ $open }}</div>
                <div class="stat-lbl">Dibuka</div>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon" style="background:#fafafa">
                <svg class="w-5 h-5" style="color:#94a3b8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div>
                <div class="stat-val" style="color:#94a3b8">{{ $draft }}</div>
                <div class="stat-lbl">Draft</div>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon" style="background:#eff6ff">
                <svg class="w-5 h-5" style="color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <div class="stat-val" style="color:#3b82f6">{{ $completed }}</div>
                <div class="stat-lbl">Selesai</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-bar">
        <div class="filter-search">
            <svg class="w-4 h-4 flex-shrink-0" style="color:#94a3b8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Cari kegiatan..." id="searchInput" oninput="filterCards()">
        </div>
        <select class="filter-select" id="statusFilter" onchange="filterCards()">
            <option value="">Semua Status</option>
            <option value="open">Dibuka</option>
            <option value="draft">Draft</option>
            <option value="closed">Ditutup</option>
            <option value="completed">Selesai</option>
        </select>
    </div>

    {{-- Cards --}}
    <div class="events-grid" id="eventsGrid">
        @forelse($events as $event)
        @php
            $statusClass = ['open'=>'status-open','draft'=>'status-draft','closed'=>'status-closed','completed'=>'status-completed'][$event->status] ?? '';
            $statusLabel = ['open'=>'Buka','draft'=>'Draft','closed'=>'Tutup','completed'=>'Selesai'][$event->status] ?? $event->status;
        @endphp
        <div class="event-card" data-title="{{ strtolower($event->title) }}" data-status="{{ $event->status }}">
            <div class="card-image">
                @if($event->thumbnail)
                    <img src="{{ $event->thumbnail }}" alt="{{ $event->title }}">
                @else
                    <div class="card-img-placeholder">
                        <svg class="w-16 h-16" style="color:rgba(139,92,246,.4)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
                <span class="card-status {{ $statusClass }}">{{ $statusLabel }}</span>
            </div>

            <div class="card-body">
                <div class="card-title">{{ $event->title }}</div>

                <div class="card-meta">
                    <div class="meta-row">
                        <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ \Carbon\Carbon::parse($event->start_date)->isoFormat('D MMM YYYY, HH:mm') }}</span>
                    </div>
                    @if($event->location)
                    <div class="meta-row">
                        <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ Str::limit($event->location, 40) }}</span>
                    </div>
                    @endif
                    <div class="meta-row">
                        <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Kuota: {{ $event->quota ?? '∞' }} peserta</span>
                    </div>
                </div>

                <div class="card-price {{ $event->is_free ? 'free' : '' }}">
                    {{ $event->is_free ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('admin.events.show', $event) }}" class="btn-action btn-view">Lihat</a>
                <a href="{{ route('admin.events.edit', $event) }}" class="btn-action btn-edit">Edit</a>
                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-action btn-del" style="width:36px;height:36px;border-radius:10px;flex:none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg class="w-10 h-10" style="color:#a78bfa" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <p class="font-bold text-gray-900 dark:text-white text-lg mb-1">Belum ada kegiatan</p>
            <p class="text-sm text-gray-400 mb-5">Mulai dengan membuat kegiatan pertama Anda</p>
            <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-500/25 transition active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor">
                    <path stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>Tambah Kegiatan
            </a>
        </div>
        @endforelse
    </div>

    @if($events->hasPages())
    <div class="pagination-wrap">{{ $events->links() }}</div>
    @endif
</div>

<script>
function filterCards() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const s = document.getElementById('statusFilter').value;
    document.querySelectorAll('.event-card').forEach(c => {
        const matchQ = !q || c.dataset.title.includes(q);
        const matchS = !s || c.dataset.status === s;
        c.style.display = (matchQ && matchS) ? '' : 'none';
    });
}
</script>
@endsection