@extends('layouts.app')
@section('title','Dashboard Member')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

    {{-- Hero Banner --}}
    <div class="bg-gradient-to-r {{ auth()->user()->isPremium() ? 'from-amber-500 via-orange-500 to-yellow-500' : 'from-primary-600 via-primary-700 to-indigo-700' }} rounded-3xl p-8 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="w-16 h-16 {{ auth()->user()->isPremium() ? 'bg-white/30' : 'bg-white/20' }} backdrop-blur rounded-2xl flex items-center justify-center text-3xl font-black flex-shrink-0 shadow-lg">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="flex-1">
                <p class="text-white/70 text-sm font-medium">Selamat datang kembali,</p>
                <h1 class="text-2xl font-black mt-0.5">{{ $user->name }}</h1>
                @if($member)
                <div class="flex items-center gap-2 mt-2 flex-wrap">
                    <code class="bg-white/20 text-xs font-bold px-2.5 py-1 rounded-lg">{{ $member->member_code }}</code>
                    @if($user->isPremium())
                    <span class="flex items-center gap-1 text-xs font-black bg-white/20 text-white px-2.5 py-1 rounded-lg">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        PREMIUM
                    </span>
                    @elseif($user->isPremiumPending())
                    <span class="text-xs font-semibold bg-white/20 px-2.5 py-1 rounded-lg">⏳ Menunggu Validasi</span>
                    @else
                    <span class="text-xs font-semibold bg-white/20 px-2.5 py-1 rounded-lg">Member Gratis</span>
                    @endif
                </div>
                @endif
            </div>
            @if(!$user->isPremium())
            <a href="{{ route('member.payment') }}" class="flex-shrink-0 bg-white {{ auth()->user()->isPremiumPending() ? 'text-blue-600' : 'text-amber-600' }} font-black px-5 py-3 rounded-2xl text-sm hover:bg-slate-50 transition shadow-xl flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                {{ $user->isPremiumPending() ? 'Cek Status' : 'Upgrade Premium' }}
            </a>
            @endif
        </div>
    </div>

    {{-- Banner Upgrade Premium (kalau free) --}}
    @if($member && $member->isFree())
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-800/50 rounded-2xl p-5">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-amber-500/30">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
            <div class="flex-1">
                <p class="font-black text-amber-900 dark:text-amber-200 text-sm">Upgrade ke Premium — Rp 300.000/tahun</p>
                <p class="text-amber-700 dark:text-amber-400 text-xs mt-1">Akses <strong>semua materi edukasi</strong>, webinar eksklusif, sertifikat resmi, dan lebih banyak konten.</p>
            </div>
            <a href="{{ route('member.payment') }}" class="flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-black text-sm rounded-xl shadow-lg shadow-amber-500/30 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Upgrade Sekarang
            </a>
        </div>
    </div>
    @elseif($member && $member->isPremiumPending())
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-5 flex items-center gap-4">
        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        </div>
        <div>
            <p class="font-bold text-blue-900 dark:text-blue-200 text-sm">Pengajuan Premium Sedang Diproses</p>
            <p class="text-blue-600 dark:text-blue-400 text-xs mt-0.5">Admin akan memvalidasi dalam 1×24 jam kerja. Notifikasi akan dikirim ke email Anda.</p>
        </div>
    </div>
    @endif

    {{-- Stats Cards --}}
    @if($member)
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php $statsCards = [
            ['label'=>'Status Akun','value'=>$user->isPremium()?'Premium':($user->isPremiumPending()?'Pending':'Gratis'),'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','color'=>$user->isPremium()?'amber':($user->isPremiumPending()?'blue':'slate')],
            ['label'=>'Bergabung','value'=>$member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('M Y') : '—','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','color'=>'blue'],
            ['label'=>'Premium Hingga','value'=>$member->expired_at ? \Carbon\Carbon::parse($member->expired_at)->format('M Y') : '—','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'emerald'],
            ['label'=>'Kegiatan Diikuti','value'=>$registrations->count(),'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','color'=>'violet'],
        ];
        $cm=['amber'=>'bg-amber-50 dark:bg-amber-900/20','blue'=>'bg-blue-50 dark:bg-blue-900/20','emerald'=>'bg-emerald-50 dark:bg-emerald-900/20','violet'=>'bg-violet-50 dark:bg-violet-900/20','slate'=>'bg-slate-100 dark:bg-slate-800'];
        $ci=['amber'=>'text-amber-600 dark:text-amber-400','blue'=>'text-blue-600 dark:text-blue-400','emerald'=>'text-emerald-600 dark:text-emerald-400','violet'=>'text-violet-600 dark:text-violet-400','slate'=>'text-slate-500 dark:text-slate-400'];
        @endphp
        @foreach($statsCards as $sc)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-1">{{ $sc['label'] }}</p>
                    <p class="font-black text-slate-900 dark:text-white text-lg leading-tight">{{ $sc['value'] }}</p>
                </div>
                <div class="w-10 h-10 {{ $cm[$sc['color']] }} rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 {{ $ci[$sc['color']] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $sc['icon'] }}"/></svg>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Quick Links --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @php $links = [
            ['route'=>'member.payment','label'=>'Premium','desc'=>$user->isPremium()?'Aktif':'Upgrade','icon'=>'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z','fill'=>true,'color'=>'from-amber-400 to-orange-500','text'=>'text-amber-600 dark:text-amber-400','bg'=>'bg-amber-50 dark:bg-amber-900/20'],
            ['route'=>'member.materials','label'=>'Materi Edukasi','desc'=>$user->isPremium()?'Akses Penuh':'Terbatas','icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13','fill'=>false,'color'=>'from-emerald-400 to-teal-500','text'=>'text-emerald-600 dark:text-emerald-400','bg'=>'bg-emerald-50 dark:bg-emerald-900/20'],
            ['route'=>'member.events','label'=>'Kegiatan','desc'=>'Daftar & Ikuti','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','fill'=>false,'color'=>'from-violet-400 to-purple-500','text'=>'text-violet-600 dark:text-violet-400','bg'=>'bg-violet-50 dark:bg-violet-900/20'],
            ['route'=>'member.profile','label'=>'Profil Saya','desc'=>'Edit Data','icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','fill'=>false,'color'=>'from-pink-400 to-rose-500','text'=>'text-pink-600 dark:text-pink-400','bg'=>'bg-pink-50 dark:bg-pink-900/20'],
        ]; @endphp
        @foreach($links as $link)
        <a href="{{ route($link['route']) }}" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 text-center hover:shadow-lg hover:-translate-y-0.5 transition-all group">
            <div class="w-12 h-12 bg-gradient-to-br {{ $link['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="{{ $link['fill']?'currentColor':'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ $link['fill']?'0':'1.8' }}" d="{{ $link['icon'] }}"/></svg>
            </div>
            <p class="font-bold text-slate-900 dark:text-white text-sm">{{ $link['label'] }}</p>
            <p class="text-xs {{ $link['text'] }} mt-0.5 font-semibold">{{ $link['desc'] }}</p>
        </a>
        @endforeach
    </div>

    {{-- Pengumuman --}}
    @if($announcements->isNotEmpty())
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
            <div class="w-2 h-4 bg-gradient-to-b from-primary-400 to-primary-600 rounded-full"></div>
            <h3 class="font-bold text-slate-900 dark:text-white text-sm">Pengumuman</h3>
        </div>
        <div class="divide-y divide-slate-50 dark:divide-slate-800">
            @foreach($announcements as $ann)
            <div class="px-6 py-3 flex items-start gap-3 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                @if($ann->is_pinned)<svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M16 4v6l2 2v2h-5v5l-1 1-1-1v-5H6v-2l2-2V4h-1V2h10v2h-1z"/></svg>@else<svg class="w-4 h-4 text-slate-300 dark:text-slate-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>@endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $ann->title }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $ann->published_at ? \Carbon\Carbon::parse($ann->published_at)->format('d M Y') : '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
