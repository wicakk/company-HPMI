@extends('layouts.admin')
@section('title','Detail Pesan')
@section('content')
<div class="space-y-5 max-w-2xl">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.contact.index') }}" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-700 transition shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Detail Pesan</h2>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="bg-slate-50 dark:bg-slate-800/60 px-6 py-4 border-b border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg shadow-primary-500/30">{{ substr($message->name,0,1) }}</div>
                <div>
                    <p class="font-bold text-slate-900 dark:text-white">{{ $message->name }}</p>
                    <p class="text-sm text-slate-500">{{ $message->email }} @if($message->phone) · {{ $message->phone }} @endif</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Subjek</p>
                <p class="font-bold text-slate-900 dark:text-white">{{ $message->subject }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">Pesan</p>
                <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4 text-sm text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
            </div>
            <p class="text-xs text-slate-400 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Diterima {{ $message->created_at->format('d M Y, H:i') }}
            </p>
        </div>
    </div>

    @if($message->admin_reply)
    <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-200 dark:border-emerald-800 p-6">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-7 h-7 bg-emerald-100 dark:bg-emerald-900/40 rounded-lg flex items-center justify-center"><svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg></div>
            <span class="text-sm font-bold text-emerald-700 dark:text-emerald-400">Balasan Admin</span>
            @if($message->replied_at)<span class="text-xs text-emerald-500">· {{ \Carbon\Carbon::parse($message->replied_at)->format('d M Y, H:i') }}</span>@endif
        </div>
        <p class="text-sm text-slate-700 dark:text-slate-300 whitespace-pre-wrap">{{ $message->admin_reply }}</p>
    </div>
    @else
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
        <h4 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2 text-sm">
            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
            Kirim Balasan
        </h4>
        <form method="POST" action="{{ route('admin.contact.reply', $message->id) }}" class="space-y-4">
            @csrf @method('PUT')
            <textarea name="admin_reply" rows="5" required placeholder="Tulis balasan Anda..." class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">{{ old('admin_reply') }}</textarea>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-primary-500/30 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Kirim Balasan
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
