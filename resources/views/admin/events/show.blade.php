@extends('layouts.admin')
@section('title', 'Detail Kegiatan')
@section('content')

<style>
    /* @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap');
    .detail-root { font-family: 'Plus Jakarta Sans', sans-serif; } */
    .page-title  { font-family: 'Syne', sans-serif; font-size: 1.4rem; font-weight: 800; color: #0f172a; }
    .dark .page-title { color: #f8fafc; }

    .back-btn {
        width: 38px; height: 38px; border-radius: 11px; display: grid; place-items: center;
        background: #fff; border: 1.5px solid #e2e8f0; color: #64748b;
        transition: all .15s; text-decoration: none; flex-shrink: 0;
    }
    .back-btn:hover { border-color: #a78bfa; color: #7c3aed; background: #f5f3ff; }
    .dark .back-btn { background: #1f2937; border-color: #374151; color: #9ca3af; }

    /* Hero banner */
    .hero-banner {
        border-radius: 20px; overflow: hidden; position: relative;
        height: 320px; background: linear-gradient(135deg,#1e1b4b,#312e81,#3730a3);
    }
    .hero-banner img { width: 100%; height: 100%; object-fit: cover; }
    .hero-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,.7) 0%, transparent 60%);
    }
    .hero-content { position: absolute; bottom: 0; left: 0; right: 0; padding: 28px 32px; }
    .hero-badges { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px; }
    .badge {
        padding: 4px 14px; border-radius: 999px; font-size: 11px; font-weight: 700;
        letter-spacing: .05em; text-transform: uppercase; border: 1px solid rgba(255,255,255,.25);
        backdrop-filter: blur(8px);
    }
    .badge-status-open     { background: rgba(16,185,129,.2); color: #6ee7b7; }
    .badge-status-draft    { background: rgba(148,163,184,.2); color: #cbd5e1; }
    .badge-status-closed   { background: rgba(239,68,68,.2); color: #fca5a5; }
    .badge-status-completed{ background: rgba(59,130,246,.2); color: #93c5fd; }
    .badge-free   { background: rgba(16,185,129,.2); color: #6ee7b7; }
    .badge-member { background: rgba(168,85,247,.2); color: #d8b4fe; }
    .hero-title { font-family: 'Syne',sans-serif; font-size: 1.8rem; font-weight: 800; color: #fff; line-height: 1.2; }

    /* Cards */
    .detail-card {
        background: #fff; border-radius: 20px; border: 1.5px solid #f1f5f9; overflow: hidden;
    }
    .dark .detail-card { background: #1f2937; border-color: #374151; }
    .card-hd {
        padding: 16px 24px; border-bottom: 1.5px solid #f1f5f9;
        display: flex; align-items: center; gap: 10px;
    }
    .dark .card-hd { border-color: #374151; }
    .card-hd-icon { width: 32px; height: 32px; border-radius: 9px; display: grid; place-items: center; flex-shrink: 0; }
    .card-hd-title { font-weight: 800; font-size: 13px; color: #0f172a; }
    .dark .card-hd-title { color: #f8fafc; }
    .card-bd { padding: 24px; }

    /* Info grid */
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .info-item { display: flex; flex-direction: column; gap: 4px; }
    .info-lbl { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #94a3b8; }
    .info-val { font-size: 14px; font-weight: 600; color: #0f172a; }
    .dark .info-val { color: #f8fafc; }

    /* Description */
    .desc-content { font-size: 14px; color: #374151; line-height: 1.8; }
    .dark .desc-content { color: #d1d5db; }

    /* Stats row */
    .stats-row { display: flex; gap: 12px; flex-wrap: wrap; }
    .stat-pill {
        flex: 1; min-width: 100px; padding: 14px 16px; border-radius: 14px;
        text-align: center; background: #fafafa; border: 1.5px solid #f1f5f9;
    }
    .dark .stat-pill { background: #111827; border-color: #374151; }
    .stat-pill-val { font-size: 22px; font-weight: 800; color: #7c3aed; }
    .stat-pill-lbl { font-size: 11px; color: #94a3b8; font-weight: 600; margin-top: 2px; text-transform: uppercase; letter-spacing: .05em; }

    /* Link button */
    .link-btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 18px; border-radius: 12px; font-size: 13px; font-weight: 700;
        background: #f5f3ff; color: #7c3aed; text-decoration: none; transition: all .15s;
        border: 1.5px solid #ede9fe;
    }
    .link-btn:hover { background: #ede9fe; border-color: #c4b5fd; }

    /* Action buttons */
    .action-grid { display: flex; flex-direction: column; gap: 10px; }
    .btn-primary {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        height: 44px; border-radius: 12px; font-weight: 800; font-size: 13.5px;
        background: linear-gradient(135deg,#7c3aed,#4f46e5); color: #fff;
        border: none; cursor: pointer; font-family: inherit; text-decoration: none;
        transition: all .2s; box-shadow: 0 4px 12px rgba(109,40,217,.3);
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 18px rgba(109,40,217,.4); }
    .btn-secondary {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        height: 44px; border-radius: 12px; font-weight: 700; font-size: 13px;
        background: #f1f5f9; color: #475569; border: none; cursor: pointer;
        font-family: inherit; text-decoration: none; transition: background .15s;
    }
    .btn-secondary:hover { background: #e2e8f0; }
    .dark .btn-secondary { background: #374151; color: #9ca3af; }

    /* Status timeline */
    .timeline { display: flex; flex-direction: column; gap: 0; }
    .tl-item { display: flex; gap: 14px; padding: 12px 0; position: relative; }
    .tl-item:not(:last-child)::after {
        content: ''; position: absolute; left: 11px; top: 34px;
        width: 2px; bottom: 0; background: #f1f5f9;
    }
    .dark .tl-item:not(:last-child)::after { background: #374151; }
    .tl-dot {
        width: 24px; height: 24px; border-radius: 50%; flex-shrink: 0;
        display: grid; place-items: center; border: 2px solid #e2e8f0; background: #fff;
        margin-top: 2px;
    }
    .dark .tl-dot { background: #1f2937; }
    .tl-dot.active { background: #7c3aed; border-color: #7c3aed; }
    .tl-dot.done   { background: #059669; border-color: #059669; }
    .tl-lbl { font-size: 13px; font-weight: 600; color: #374151; }
    .dark .tl-lbl { color: #d1d5db; }
    .tl-sub { font-size: 11px; color: #94a3b8; margin-top: 1px; }

    @media (max-width: 1024px) { .layout-grid { grid-template-columns: 1fr !important; } }
    @media (max-width: 640px) { .info-grid { grid-template-columns: 1fr; } .hero-title { font-size: 1.3rem; } }
</style>

<div class="detail-root space-y-6">

    {{-- Topbar --}}
    <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ url()->previous() }}" class="back-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <p class="page-title">Detail Kegiatan</p>
        </div>
        <a href="{{ route('admin.events.edit', $kegiatan) }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:11px;font-size:12px;font-weight:700;background:linear-gradient(135deg,#7c3aed,#4f46e5);color:#fff;text-decoration:none;box-shadow:0 3px 10px rgba(109,40,217,.3)">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
        </a>
    </div>

    {{-- Hero --}}
    <div class="hero-banner">
        @if($kegiatan->thumbnail)
            <img src="{{ $kegiatan->thumbnail }}" alt="{{ $kegiatan->title }}">
        @endif
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-badges">
                @php
                    $statusLabel = ['open'=>'Buka','draft'=>'Draft','closed'=>'Tutup','completed'=>'Selesai'][$kegiatan->status] ?? $kegiatan->status;
                @endphp
                <span class="badge badge-status-{{ $kegiatan->status }}">{{ $statusLabel }}</span>
                @if($kegiatan->is_free) <span class="badge badge-free">Gratis</span> @endif
                @if($kegiatan->is_member_only) <span class="badge badge-member">Member Only</span> @endif
            </div>
            <h1 class="hero-title">{{ $kegiatan->title }}</h1>
        </div>
    </div>

    {{-- Stats pills --}}
    <div class="stats-row">
        <div class="stat-pill">
            <div class="stat-pill-val">{{ $kegiatan->quota ?? '∞' }}</div>
            <div class="stat-pill-lbl">Kuota</div>
        </div>
        <div class="stat-pill">
            <div class="stat-pill-val" style="color:{{ $kegiatan->is_free ? '#059669' : '#7c3aed' }}">
                {{ $kegiatan->is_free ? 'Gratis' : 'Rp ' . number_format($kegiatan->price, 0, ',', '.') }}
            </div>
            <div class="stat-pill-lbl">Harga</div>
        </div>
        <div class="stat-pill">
            <div class="stat-pill-val" style="color:#0ea5e9">{{ \Carbon\Carbon::parse($kegiatan->start_date)->format('d M') }}</div>
            <div class="stat-pill-lbl">Mulai</div>
        </div>
        <div class="stat-pill">
            <div class="stat-pill-val" style="color:#f59e0b">
                {{ $kegiatan->end_date ? \Carbon\Carbon::parse($kegiatan->end_date)->format('d M') : '—' }}
            </div>
            <div class="stat-pill-lbl">Selesai</div>
        </div>
    </div>

    <div class="layout-grid" style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start">

        {{-- LEFT --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            {{-- Info --}}
            <div class="detail-card">
                <div class="card-hd">
                    <div class="card-hd-icon" style="background:#f5f3ff">
                        <svg class="w-4 h-4" style="color:#7c3aed" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="card-hd-title">Informasi Kegiatan</span>
                </div>
                <div class="card-bd">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-lbl">Tanggal Mulai</span>
                            <span class="info-val">{{ \Carbon\Carbon::parse($kegiatan->start_date)->isoFormat('D MMMM YYYY, HH:mm') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-lbl">Tanggal Selesai</span>
                            <span class="info-val">{{ $kegiatan->end_date ? \Carbon\Carbon::parse($kegiatan->end_date)->isoFormat('D MMMM YYYY, HH:mm') : '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-lbl">Lokasi</span>
                            <span class="info-val">{{ $kegiatan->location ?: '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-lbl">Slug</span>
                            <span class="info-val" style="font-size:12px;font-family:monospace;background:#f1f5f9;padding:3px 8px;border-radius:6px;display:inline-block">{{ $kegiatan->slug }}</span>
                        </div>
                        @if($kegiatan->meeting_url)
                        <div class="info-item" style="grid-column:1/-1">
                            <span class="info-lbl">Link Meeting</span>
                            <a href="{{ $kegiatan->meeting_url }}" target="_blank" class="link-btn" style="width:fit-content;margin-top:4px">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.868v6.264a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                Buka Link Meeting
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Description --}}
            @if($kegiatan->description)
            <div class="detail-card">
                <div class="card-hd">
                    <div class="card-hd-icon" style="background:#fff7ed">
                        <svg class="w-4 h-4" style="color:#ea580c" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="card-hd-title">Deskripsi</span>
                </div>
                <div class="card-bd">
                    <div class="desc-content">{!! nl2br(e($kegiatan->description)) !!}</div>
                </div>
            </div>
            @endif

        </div>

        {{-- RIGHT --}}
        <div style="display:flex;flex-direction:column;gap:20px;position:sticky;top:20px">

            {{-- Actions --}}
            <div class="detail-card">
                <div class="card-hd">
                    <div class="card-hd-icon" style="background:#f0fdf4">
                        <svg class="w-4 h-4" style="color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <span class="card-hd-title">Aksi</span>
                </div>
                <div class="card-bd">
                    <div class="action-grid">
                        <a href="{{ route('admin.events.edit', $kegiatan) }}" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Kegiatan
                        </a>
                        <a href="{{ route('admin.events.index') }}" class="btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            Semua Kegiatan
                        </a>
                        <form method="POST" action="{{ route('admin.events.destroy', $kegiatan) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="width:100%;height:44px;border-radius:12px;font-size:13px;font-weight:700;background:transparent;border:1.5px solid #fecdd3;color:#e11d48;cursor:pointer;font-family:inherit;transition:all .15s;display:flex;align-items:center;justify-content:center;gap:8px"
                                    onmouseover="this.style.background='#fff1f2'" onmouseout="this.style.background='transparent'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Kegiatan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Status timeline --}}
            <div class="detail-card">
                <div class="card-hd">
                    <div class="card-hd-icon" style="background:#eff6ff">
                        <svg class="w-4 h-4" style="color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <span class="card-hd-title">Status Alur</span>
                </div>
                <div class="card-bd">
                    <div class="timeline">
                        @php
                            $steps = [
                                'draft'     => ['label'=>'Draft', 'desc'=>'Belum dipublikasikan'],
                                'open'      => ['label'=>'Buka Pendaftaran', 'desc'=>'Peserta dapat mendaftar'],
                                'closed'    => ['label'=>'Pendaftaran Ditutup', 'desc'=>'Kuota penuh atau waktu habis'],
                                'completed' => ['label'=>'Selesai', 'desc'=>'Kegiatan telah berlangsung'],
                            ];
                            $order   = array_keys($steps);
                            $current = array_search($kegiatan->status, $order);
                        @endphp
                        @foreach($steps as $key => $step)
                        @php $idx = array_search($key, $order); @endphp
                        <div class="tl-item">
                            <div class="tl-dot {{ $idx < $current ? 'done' : ($idx === $current ? 'active' : '') }}">
                                @if($idx < $current)
                                    <svg class="w-3 h-3" style="color:#fff" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                @elseif($idx === $current)
                                    <div style="width:8px;height:8px;border-radius:50%;background:#fff"></div>
                                @endif
                            </div>
                            <div>
                                <div class="tl-lbl" style="{{ $idx === $current ? 'color:#7c3aed;font-weight:800' : '' }}">{{ $step['label'] }}</div>
                                <div class="tl-sub">{{ $step['desc'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Meta --}}
            <div class="detail-card">
                <div class="card-bd" style="gap:8px;display:flex;flex-direction:column">
                    <p style="font-size:11px;font-weight:700;color:#94a3b8;letter-spacing:.06em;text-transform:uppercase">Metadata</p>
                    <div style="font-size:12px;color:#64748b;display:flex;flex-direction:column;gap:6px">
                        <div>Dibuat: <strong style="color:#374151">{{ $kegiatan->created_at->format('d M Y, H:i') }}</strong></div>
                        <div>Diperbarui: <strong style="color:#374151">{{ $kegiatan->updated_at->format('d M Y, H:i') }}</strong></div>
                        @if($kegiatan->user)
                        <div>Dibuat oleh: <strong style="color:#374151">{{ $kegiatan->user->name }}</strong></div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection