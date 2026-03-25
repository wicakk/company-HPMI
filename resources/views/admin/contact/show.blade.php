@extends('layouts.admin')
@section('title', 'Detail Pesan')
@section('content')
<div class="space-y-5 max-w-2xl">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.contact.index') }}" class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-500 hover:text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Detail Pesan</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
            <div><dt class="text-gray-500 dark:text-gray-400 mb-1">Dari</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $message->name }}</dd></div>
            <div><dt class="text-gray-500 dark:text-gray-400 mb-1">Email</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $message->email }}</dd></div>
            <div><dt class="text-gray-500 dark:text-gray-400 mb-1">Telepon</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $message->phone??'-' }}</dd></div>
            <div><dt class="text-gray-500 dark:text-gray-400 mb-1">Diterima</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $message->created_at->format('d M Y H:i') }}</dd></div>
        </dl>
        <div>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Subjek</p>
            <p class="font-semibold text-gray-900 dark:text-white">{{ $message->subject }}</p>
        </div>
        <div>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">Pesan</p>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
        </div>
    </div>

    @if($message->admin_reply)
    <div class="bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-800 p-6">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
            <span class="text-sm font-semibold text-green-700 dark:text-green-400">Balasan Admin</span>
            <span class="text-xs text-green-600 dark:text-green-500">{{ $message->replied_at ? \Carbon\Carbon::parse($message->replied_at)->format('d M Y H:i') : '' }}</span>
        </div>
        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $message->admin_reply }}</p>
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Kirim Balasan</h4>
        <form method="POST" action="{{ route('admin.contact.reply', $message) }}" class="space-y-4">
            @csrf @method('PATCH')
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Balasan</label>
                <textarea name="admin_reply" rows="5" required class="w-full px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Tulis balasan...">{{ old('admin_reply') }}</textarea>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                Kirim Balasan
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
