@extends('layouts.admin')
@section('title', 'Detail')
@section('content')
<div class="flex items-center gap-3 mb-5">
    <a href="{{ url()->previous() }}" class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-500 hover:text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Detail</h2>
</div>
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
    <p class="text-gray-500 dark:text-gray-400 text-sm">Halaman detail tersedia.</p>
</div>
@endsection
