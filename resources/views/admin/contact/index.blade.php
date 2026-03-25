@extends('layouts.admin')
@section('title','Pesan Masuk')
@section('subtitle','Pesan dari formulir kontak website')
@section('content')
<div class="space-y-4">
    @forelse($messages as $msg)
    <a href="{{ route('admin.contact.show', $msg->id) }}" class="block bg-white dark:bg-slate-900 rounded-2xl border {{ !$msg->is_read ? 'border-primary-300 dark:border-primary-700 shadow-md shadow-primary-100 dark:shadow-primary-900/20' : 'border-slate-200 dark:border-slate-800' }} p-5 hover:shadow-lg transition-all group">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-start gap-3 min-w-0">
                <div class="flex-shrink-0 w-10 h-10 {{ !$msg->is_read ? 'bg-gradient-to-br from-primary-400 to-primary-600' : 'bg-gradient-to-br from-slate-300 to-slate-400 dark:from-slate-600 dark:to-slate-700' }} rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-md">{{ substr($msg->name,0,1) }}</div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="font-bold text-slate-900 dark:text-white text-sm">{{ $msg->name }}</p>
                        @if(!$msg->is_read)<span class="w-2 h-2 bg-primary-500 rounded-full flex-shrink-0"></span><span class="text-xs font-semibold text-primary-600 dark:text-primary-400">Baru</span>@endif
                    </div>
                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-300 mt-0.5">{{ $msg->subject }}</p>
                    <p class="text-xs text-slate-400 mt-1 truncate">{{ Str::limit($msg->message,90) }}</p>
                </div>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="text-xs text-slate-400">{{ $msg->created_at->diffForHumans() }}</p>
                @if($msg->admin_reply)
                <span class="mt-1.5 inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Dibalas
                </span>
                @endif
            </div>
        </div>
    </a>
    @empty
    <div class="py-20 text-center text-slate-400">
        <svg class="w-14 h-14 mx-auto mb-3 opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <p class="text-sm">Belum ada pesan masuk</p>
    </div>
    @endforelse
    @if($messages->hasPages())<div>{{ $messages->links() }}</div>@endif
</div>
@endsection
