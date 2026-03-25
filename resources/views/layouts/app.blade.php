<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode')==='true', menuOpen: false }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', v => localStorage.setItem('darkMode', v))">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HPMI') — Himpunan Perawat Manajer Indonesia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                colors: {
                    primary: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' },
                }
            }
        }
    }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .nav-link { @apply text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors; }
        .nav-link.active { @apply text-primary-600 dark:text-primary-400; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 font-sans antialiased min-h-screen flex flex-col">

    {{-- TOPBAR PREMIUM BANNER (khusus member free yang belum premium) --}}
    @auth
    @if(auth()->user()->isMember() && !auth()->user()->isPremium() && !auth()->user()->isPremiumPending())
    <div class="bg-gradient-to-r from-amber-500 to-orange-500 text-white text-center py-2.5 px-4 text-xs font-semibold flex items-center justify-center gap-3">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/></svg>
        <span>Upgrade ke <strong>Premium</strong> untuk akses materi eksklusif, webinar, & lebih banyak fitur!</span>
        <a href="{{ route('member.payment') }}" class="bg-white text-amber-600 font-black px-3 py-1 rounded-full text-xs hover:bg-amber-50 transition ml-2">
            Upgrade Sekarang →
        </a>
    </div>
    @elseif(auth()->user()->isMember() && auth()->user()->isPremiumPending())
    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-center py-2 px-4 text-xs font-semibold flex items-center justify-center gap-2">
        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        Pengajuan Premium Anda sedang divalidasi admin (1×24 jam)
    </div>
    @endif
    @endauth

    {{-- NAVBAR --}}
    <nav class="sticky top-0 z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur border-b border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Brand --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg shadow-primary-500/30 group-hover:scale-105 transition-transform">H</div>
                    <div>
                        <p class="font-black text-slate-900 dark:text-white text-sm leading-none">HPMI</p>
                        <p class="text-xs text-slate-400 leading-none mt-0.5">Perawat Manajer Indonesia</p>
                    </div>
                </a>

                {{-- Nav Links (desktop) --}}
                <div class="hidden md:flex items-center gap-7">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about*') ? 'active' : '' }}">Tentang</a>
                    <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles*') ? 'active' : '' }}">Artikel</a>
                    <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events*') ? 'active' : '' }}">Kegiatan</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact*') ? 'active' : '' }}">Kontak</a>
                </div>

                {{-- Right side --}}
                <div class="flex items-center gap-2">
                    {{-- Dark mode --}}
                    <button @click="darkMode = !darkMode" class="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    @auth
                    {{-- Tombol Upgrade Premium (kalau belum premium) --}}
                    @if(auth()->user()->isMember() && !auth()->user()->isPremium())
                    <a href="{{ route('member.payment') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white text-xs font-black rounded-xl shadow-lg shadow-amber-500/30 transition">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        {{ auth()->user()->isPremiumPending() ? 'Menunggu Validasi' : 'Upgrade Premium' }}
                    </a>
                    @elseif(auth()->user()->isPremium())
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-amber-400 to-yellow-500 text-white text-xs font-black rounded-xl">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        Premium
                    </span>
                    @endif

                    {{-- User menu --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 px-2.5 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition">
                            <div class="w-7 h-7 {{ auth()->user()->isPremium() ? 'bg-gradient-to-br from-amber-400 to-orange-500' : 'bg-gradient-to-br from-primary-400 to-primary-600' }} rounded-lg flex items-center justify-center text-white font-black text-xs">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="text-xs font-semibold text-slate-700 dark:text-slate-300 hidden sm:block max-w-24 truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.outside="open=false" x-transition
                             class="absolute right-0 mt-2 w-52 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 py-2 z-50">
                            <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-700 mb-1">
                                <p class="font-bold text-slate-900 dark:text-white text-sm truncate">{{ auth()->user()->name }}</p>
                                <div class="flex items-center gap-1.5 mt-1">
                                    @if(auth()->user()->isPremium())
                                    <span class="text-xs font-bold text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-900/30 px-2 py-0.5 rounded-full flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> Premium</span>
                                    @elseif(auth()->user()->isPremiumPending())
                                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/20 px-2 py-0.5 rounded-full">⏳ Pending</span>
                                    @else
                                    <span class="text-xs font-semibold text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-full">Free</span>
                                    @endif
                                </div>
                            </div>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Panel Admin
                            </a>
                            @else
                            <a href="{{ route('member.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('member.profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Profil Saya
                            </a>
                            @if(!auth()->user()->isPremium())
                            <a href="{{ route('member.payment') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition font-semibold">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                Upgrade Premium
                            </a>
                            @endif
                            @endif
                            <div class="border-t border-slate-100 dark:border-slate-700 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 transition px-3 py-2">Masuk</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-primary-500/30 transition">
                        Daftar Gratis
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success') || session('warning') || session('error') || session('info'))
    <div class="max-w-7xl mx-auto px-4 pt-4">
        @foreach(['success'=>['bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],'warning'=>['bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-800 text-amber-700 dark:text-amber-400','M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],'error'=>['bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-700 dark:text-red-400','M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],'info'=>['bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-400','M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z']] as $type=>[$cls,$icon])
        @if(session($type))
        <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,5000)"
             class="flex items-center gap-3 border rounded-xl px-4 py-3 text-sm mb-2 {{ $cls }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
            {{ session($type) }}
            <button @click="show=false" class="ml-auto opacity-60 hover:opacity-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        @endif
        @endforeach
    </div>
    @endif

    <main class="flex-1">@yield('content')</main>

    {{-- FOOTER --}}
    <footer class="bg-slate-900 dark:bg-slate-950 text-slate-400 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center text-white font-black text-sm">H</div>
                        <div>
                            <p class="font-black text-white text-sm">HPMI</p>
                            <p class="text-xs text-slate-400">Perawat Manajer Indonesia</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed">Himpunan Perawat Manajer Indonesia — membangun profesionalisme keperawatan nasional.</p>
                </div>
                <div>
                    <p class="font-bold text-white text-sm mb-4">Tautan Cepat</p>
                    <div class="space-y-2 text-sm">
                        @foreach([['Beranda','home'],['Tentang','about'],['Artikel','articles.index'],['Kegiatan','events.index'],['Kontak','contact']] as [$label,$route])
                        <a href="{{ route($route) }}" class="block hover:text-white transition">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <p class="font-bold text-white text-sm mb-4">Kontak</p>
                    <div class="space-y-2 text-sm">
                        <p>📧 sekretariat@hpmi.id</p>
                        <p>📞 021-12345678</p>
                        <p>📍 Jakarta Pusat, DKI Jakarta</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-6 text-center text-xs">
                © {{ date('Y') }} HPMI — Himpunan Perawat Manajer Indonesia. Semua hak dilindungi.
            </div>
        </div>
    </footer>
</body>
</html>
