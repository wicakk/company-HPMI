@extends('layouts.admin')
@section('title', 'Pesan Masuk')
@section('content')
<div class="space-y-5">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Pesan Masuk</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Pesan dari formulir kontak website</p>
    </div>
    <div class="space-y-3">
        @forelse($messages as $msg)
        <a href="{{ route('admin.contact.show', $msg) }}" class="block bg-white dark:bg-gray-800 rounded-xl border {{ !$msg->is_read ? 'border-primary-300 dark:border-primary-700' : 'border-gray-200 dark:border-gray-700' }} p-5 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start gap-3 min-w-0">
                    <div class="flex-shrink-0 w-9 h-9 bg-{{ !$msg->is_read ? 'primary' : 'gray' }}-100 dark:bg-{{ !$msg->is_read ? 'primary' : 'gray' }}-900/30 rounded-full flex items-center justify-center text-{{ !$msg->is_read ? 'primary' : 'gray' }}-700 dark:text-{{ !$msg->is_read ? 'primary' : 'gray' }}-400 font-semibold text-sm">{{ substr($msg->name, 0, 1) }}</div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $msg->name }}</p>
                            @if(!$msg->is_read)<span class="w-2 h-2 bg-primary-500 rounded-full inline-block"></span>@endif
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $msg->subject }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1 truncate">{{ Str::limit($msg->message, 80) }}</p>
                    </div>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $msg->created_at->diffForHumans() }}</p>
                    @if($msg->admin_reply)<span class="mt-1 inline-block text-xs text-green-600 dark:text-green-400">Sudah dibalas</span>@endif
                </div>
            </div>
        </a>
        @empty
        <div class="py-16 text-center text-gray-400">
            <svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <p class="text-sm">Belum ada pesan masuk</p>
        </div>
        @endforelse
    </div>
    @if($messages->hasPages())
    <div>{{ $messages->links() }}</div>
    @endif
</div>
@endsection
