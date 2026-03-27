<!DOCTYPE html>
<html lang="id" class="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>HPMI Admin — @yield('title', 'Panel Kontrol')</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<style type="text/tailwindcss">
  @theme {
    --font-sans: 'Plus Jakarta Sans', sans-serif;
    --font-mono: 'JetBrains Mono', monospace;
    --color-accent: #1e5aff;
    --color-success: #10b981;
    --color-warning: #f59e0b;
    --color-danger: #ef4444;
    --color-purple: #8b5cf6;
  }
  html.dark body { background: #080e1a; color: #cbd5e1; }
  html.dark .bg-white { background: #0f1b2d !important; }
  html.dark .bg-slate-50 { background: #080e1a !important; }
  html.dark .border-slate-200 { border-color: #1e2d42 !important; }
  html.dark .border-slate-100 { border-color: #1e2d42 !important; }
  html.dark .text-slate-800 { color: #f1f5f9 !important; }
  html.dark .text-slate-700 { color: #e2e8f0 !important; }
  html.dark .text-slate-600 { color: #94a3b8 !important; }
  html.dark .text-slate-500 { color: #64748b !important; }
  html.dark .bg-slate-100 { background: #0f1b2d !important; }
  html.dark input, html.dark select, html.dark textarea { background: #0f1b2d !important; border-color: #263a56 !important; color: #cbd5e1 !important; }
  html.dark .hover\:bg-slate-50:hover { background: #0f1b2d !important; }
  html.dark .hover\:bg-slate-100:hover { background: #1a2d47 !important; }
  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
  @keyframes fadeUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
  .page-fade { animation: fadeUp .2s ease; }
  .sidebar-collapsed { width: 68px !important; }
  .sidebar-collapsed .sidebar-label,.sidebar-collapsed .nav-label,.sidebar-collapsed .nav-badge,.sidebar-collapsed .brand-text,.sidebar-collapsed .user-info { opacity:0; width:0; overflow:hidden; pointer-events:none; }
  .sidebar-collapsed .nav-item { justify-content: center; padding: 9px !important; }
  .sidebar-collapsed .brand-inner { justify-content: center; }
  .sidebar-collapsed .user-card { justify-content: center; }
  .main-expanded { margin-left: 260px; }
  .main-collapsed { margin-left: 68px; }
  .theme-toggle { width:52px; height:28px; background:#e2e8f0; border-radius:99px; position:relative; cursor:pointer; transition:background .18s; flex-shrink:0; }
  .theme-toggle.on { background:#1e5aff; }
  .theme-knob { width:22px; height:22px; background:#fff; border-radius:50%; position:absolute; top:3px; left:3px; transition:transform .18s; box-shadow:0 1px 4px rgba(0,0,0,.2); display:flex; align-items:center; justify-content:center; font-size:11px; }
  .theme-toggle.on .theme-knob { transform:translateX(24px); }
  [data-tip] { position: relative; }
  [data-tip]::after { content: attr(data-tip); position: absolute; bottom: calc(100% + 6px); left: 50%; transform: translateX(-50%); background: #0a1628; color: #fff; font-size: 11px; padding: 4px 9px; border-radius: 6px; white-space: nowrap; pointer-events: none; opacity: 0; transition: opacity .15s; z-index: 9999; }
  [data-tip]:hover::after { opacity: 1; }
  .stat-card { transition: transform .15s, box-shadow .15s; }
  .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,.08); }
</style>
</head>
<body class="font-sans bg-slate-50 text-slate-700 min-h-screen overflow-x-hidden transition-colors duration-200">

<!-- ════════ SIDEBAR ════════ -->
<aside id="sidebar" class="w-[260px] min-h-screen bg-[#0f1b2d] flex flex-col fixed left-0 top-0 bottom-0 z-[100] overflow-hidden transition-all duration-[180ms]">
  <div class="brand-inner flex items-center gap-3 px-[18px] py-5 border-b border-white/[.07] flex-shrink-0">
    <div class="w-9 h-9 bg-[#1e5aff] rounded-[10px] flex items-center justify-center text-white font-extrabold text-[15px] flex-shrink-0 tracking-tight">H</div>
    <div class="brand-text overflow-hidden whitespace-nowrap transition-all duration-[180ms]">
      <div class="text-white text-[14px] font-bold leading-tight">HPMI Admin</div>
      <div class="text-white/40 text-[10.5px]">CMS Panel v2.0</div>
    </div>
    <button onclick="toggleSidebar()" class="ml-auto w-7 h-7 rounded-[7px] flex items-center justify-center text-white/40 hover:bg-white/[.08] hover:text-white/80 transition-all flex-shrink-0">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
    </button>
  </div>

  <div class="flex-1 overflow-y-auto overflow-x-hidden px-[10px] pt-[10px]">
    @php
    $navGroups = [
      'Utama' => [
        ['route'=>'admin.dashboard','label'=>'Dashboard','icon'=>'<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>'],
        ['route'=>'admin.analytics.index','label'=>'Analytics','icon'=>'<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>'],
      ],
      'Manajemen' => [
        ['route'=>'admin.members.index','label'=>'Anggota','icon'=>'<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>','badge'=>'pending_members'],
        ['route'=>'admin.payments.index','label'=>'Pembayaran','icon'=>'<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>','badge'=>'pending_payments'],
        ['route'=>'admin.events.index','label'=>'Kegiatan','icon'=>'<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>'],
      ],
      'Konten' => [
        ['route'=>'admin.articles.index','label'=>'Artikel & Berita','icon'=>'<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>'],
        ['route'=>'admin.materials.index','label'=>'Materi Edukasi','icon'=>'<path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>'],
        ['route'=>'admin.announcements.index','label'=>'Pengumuman','icon'=>'<path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>'],
      ],
      'Lainnya' => [
        ['route'=>'admin.org.index','label'=>'Struktur Org','icon'=>'<rect x="8" y="2" width="8" height="4" rx="1"/><rect x="1" y="10" width="8" height="4" rx="1"/><rect x="15" y="10" width="8" height="4" rx="1"/><path d="M12 6v4M4 14v2a2 2 0 002 2h12a2 2 0 002-2v-2"/>'],
        ['route'=>'admin.contact.index','label'=>'Pesan Masuk','icon'=>'<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>','badge'=>'unread_messages'],
        ['route'=>'admin.settings.index','label'=>'Pengaturan','icon'=>'<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/>'],
      ],
    ];
    $badges = [
      'pending_members' => \App\Models\Member::where('status','pending')->count(),
      'pending_payments' => \App\Models\Payment::where('status','pending')->count(),
      'unread_messages' => \App\Models\ContactMessage::where('is_read',false)->count(),
    ];
    @endphp

    @foreach($navGroups as $groupName => $items)
    <div class="mb-1">
      <div class="sidebar-label text-[10px] font-bold text-white/[.22] tracking-widest uppercase px-[10px] py-[10px] pb-1 whitespace-nowrap overflow-hidden transition-all duration-[180ms]">{{ $groupName }}</div>
      @foreach($items as $item)
      @php
        $isActive = request()->routeIs($item['route'].'*') || request()->routeIs($item['route']);
        $badgeCount = isset($item['badge']) ? ($badges[$item['badge']] ?? 0) : 0;
      @endphp
      <a href="{{ route($item['route']) }}" data-tip="{{ $item['label'] }}"
        class="nav-item flex items-center gap-[10px] px-[10px] py-[9px] rounded-[9px] cursor-pointer transition-colors mb-[1px] {{ $isActive ? 'bg-[#1e4080]' : 'hover:bg-[#1a2d47]' }}">
        <div class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] flex-shrink-0 {{ $isActive ? 'text-white' : 'text-[#94a3b8]' }}">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">{!! $item['icon'] !!}</svg>
        </div>
        <span class="nav-label text-[13px] font-medium flex-1 overflow-hidden whitespace-nowrap transition-all duration-[180ms] {{ $isActive ? 'text-white' : 'text-[#94a3b8]' }}">{{ $item['label'] }}</span>
        @if($badgeCount > 0)
        <span class="nav-badge text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-[#ef4444] text-white flex-shrink-0 transition-all duration-[180ms]">{{ $badgeCount }}</span>
        @endif
      </a>
      @endforeach
    </div>
    @endforeach
  </div>

  <!-- User Card -->
  <div class="user-card flex items-center gap-3 px-[14px] py-[14px] border-t border-white/[.07] flex-shrink-0">
    <div class="w-9 h-9 rounded-[9px] bg-[#1e4080] flex items-center justify-center font-bold text-white text-[13px] flex-shrink-0">
      {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
    </div>
    <div class="user-info flex-1 min-w-0 overflow-hidden whitespace-nowrap transition-all duration-[180ms]">
      <div class="text-white text-[12.5px] font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
      <div class="text-white/40 text-[11px]">Administrator</div>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="user-info flex-shrink-0">
      @csrf
      <button type="submit" data-tip="Keluar" class="w-7 h-7 rounded-[7px] flex items-center justify-center text-white/40 hover:bg-white/[.08] hover:text-[#ef4444] transition-all">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      </button>
    </form>
  </div>
</aside>

<!-- ════════ MAIN ════════ -->
<div id="main" class="main-expanded transition-all duration-[180ms] min-h-screen flex flex-col">
  <!-- Top Bar -->
  <header class="bg-white border-b border-slate-200 px-6 h-[60px] flex items-center justify-between sticky top-0 z-50 shadow-[0_1px_3px_rgba(0,0,0,.04)]">
    <div class="flex items-center gap-3">
      <button onclick="toggleSidebar()" class="w-8 h-8 rounded-[8px] flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-all">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <h1 class="text-[14px] font-bold text-slate-800">@yield('title', 'Dashboard')</h1>
    </div>
    <div class="flex items-center gap-2">
      <a href="{{ route('home') }}" target="_blank" class="h-8 px-3 rounded-[8px] border border-slate-200 flex items-center gap-1.5 text-[12px] font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
        <span>Website</span>
      </a>
      <button onclick="toggleTheme()" id="themeToggle" class="theme-toggle">
        <div class="theme-knob">☀️</div>
      </button>
      <div class="h-8 px-3 rounded-[8px] bg-slate-100 flex items-center gap-2 text-[12px] font-semibold text-slate-700">
        <div class="w-5 h-5 rounded-full bg-[#1e5aff] flex items-center justify-center text-white text-[9px] font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
        <span>{{ auth()->user()->name ?? 'Admin' }}</span>
      </div>
    </div>
  </header>

  <!-- Page Content -->
  <main class="flex-1 p-6 page-fade">
    @if(session('success'))
    <div class="mb-5 bg-[rgba(16,185,129,.08)] border border-[rgba(16,185,129,.25)] text-[#059669] rounded-[12px] px-4 py-3 text-[13px] font-medium flex items-center gap-2.5">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-5 bg-[rgba(239,68,68,.08)] border border-[rgba(239,68,68,.2)] text-[#dc2626] rounded-[12px] px-4 py-3 text-[13px] font-medium flex items-center gap-2.5">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ session('error') }}
    </div>
    @endif
    @yield('content')
  </main>
</div>

<script>
function toggleSidebar() {
  const sb = document.getElementById('sidebar');
  const main = document.getElementById('main');
  sb.classList.toggle('sidebar-collapsed');
  if (sb.classList.contains('sidebar-collapsed')) {
    main.classList.remove('main-expanded');
    main.classList.add('main-collapsed');
  } else {
    main.classList.remove('main-collapsed');
    main.classList.add('main-expanded');
  }
}
function toggleTheme() {
  const html = document.documentElement;
  const toggle = document.getElementById('themeToggle');
  const knob = toggle.querySelector('.theme-knob');
  const isDark = html.classList.contains('dark');
  html.classList.toggle('dark', !isDark);
  toggle.classList.toggle('on', !isDark);
  knob.textContent = isDark ? '☀️' : '🌙';
  localStorage.setItem('hpmiDark', !isDark);
}
if (localStorage.getItem('hpmiDark') === 'true') {
  document.documentElement.classList.add('dark');
  const t = document.getElementById('themeToggle');
  if (t) { t.classList.add('on'); t.querySelector('.theme-knob').textContent = '🌙'; }
}
</script>
@stack('scripts')
</body>
</html>
