@extends('layouts.admin')
@section('title', 'Pesan Masuk')
@section('content')

<div class="space-y-6">

  {{-- Header --}}
  <div>
    <p class="text-xs font-bold uppercase tracking-widest text-blue-500 dark:text-blue-400 mb-1">Inbox</p>
    <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Pesan Masuk</h2>
    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Pesan dari formulir kontak website</p>
  </div>

  {{-- List --}}
  <div class="space-y-2.5">
    @forelse($messages as $msg)
    @php $unread = !$msg->is_read; @endphp
    <a href="{{ route('admin.contact.show', $msg) }}"
      class="flex items-start gap-4 p-5 bg-white dark:bg-slate-800 rounded-2xl border {{ $unread ? 'border-blue-200 dark:border-blue-700/60 shadow-sm shadow-blue-100 dark:shadow-none' : 'border-slate-100 dark:border-slate-700' }} hover:shadow-md dark:hover:shadow-slate-900/50 hover:-translate-y-0.5 transition-all duration-200 block">

      {{-- Avatar --}}
      <div class="flex-shrink-0 w-10 h-10 rounded-xl {{ $unread ? 'bg-blue-600' : 'bg-slate-200 dark:bg-slate-600' }} flex items-center justify-center {{ $unread ? 'text-white' : 'text-slate-500 dark:text-slate-300' }} font-bold text-sm">
        {{ strtoupper(substr($msg->name, 0, 1)) }}
      </div>

      {{-- Content --}}
      <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2 flex-wrap">
          <p class="font-bold text-slate-900 dark:text-white text-sm {{ $unread ? '' : 'font-semibold' }}">{{ $msg->name }}</p>
          @if($unread)
          <span class="inline-flex w-2 h-2 bg-blue-500 rounded-full"></span>
          <span class="text-[11px] font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 rounded-full">Baru</span>
          @endif
        </div>
        <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mt-0.5">{{ $msg->subject }}</p>
        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 truncate">{{ Str::limit($msg->message, 90) }}</p>
      </div>

      {{-- Meta --}}
      <div class="text-right flex-shrink-0 flex flex-col items-end gap-1.5">
        <p class="text-xs text-slate-400 dark:text-slate-500">{{ $msg->created_at->diffForHumans() }}</p>
        @if($msg->admin_reply)
        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-full">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          Dibalas
        </span>
        @endif
      </div>
    </a>
    @empty
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 py-20 text-center">
      <div class="w-14 h-14 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-3">
        <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
      </div>
      <p class="text-sm font-bold text-slate-800 dark:text-white">Belum ada pesan masuk</p>
      <p class="text-xs text-slate-400 mt-1">Pesan dari formulir kontak akan muncul di sini</p>
    </div>
    @endforelse
  </div>

  @if($messages->hasPages())
  <div class="flex justify-center">{{ $messages->links() }}</div>
  @endif

</div>
@endsection
