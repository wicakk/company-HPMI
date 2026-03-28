@extends('layouts.admin')
@section('title', 'Detail Pesan')
@section('content')

<div class="space-y-5 max-w-2xl">

  {{-- Back + Title --}}
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.contact.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
      <h2 class="text-lg font-black text-slate-900 dark:text-white">Detail Pesan</h2>
    </div>
  </div>

  {{-- Message card --}}
  <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6 space-y-5">
    <div class="grid grid-cols-2 gap-4">
      @foreach([['Dari', $message->name], ['Email', $message->email], ['Telepon', $message->phone ?? '-'], ['Diterima', $message->created_at->format('d M Y H:i')]] as [$label, $val])
      <div class="bg-slate-50 dark:bg-slate-700/40 rounded-xl p-3">
        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium mb-0.5">{{ $label }}</p>
        <p class="text-sm font-semibold text-slate-800 dark:text-white">{{ $val }}</p>
      </div>
      @endforeach
    </div>
    <div>
      <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 dark:text-slate-500 mb-1.5">Subjek</p>
      <p class="text-base font-bold text-slate-900 dark:text-white">{{ $message->subject }}</p>
    </div>
    <div>
      <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 dark:text-slate-500 mb-2">Pesan</p>
      <div class="bg-slate-50 dark:bg-slate-700/40 rounded-xl p-4 text-sm text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
    </div>
  </div>

  {{-- Reply --}}
  @if($message->admin_reply)
  <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-200 dark:border-emerald-800/50 p-6">
    <div class="flex items-center gap-2 mb-3">
      <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
      <span class="text-sm font-bold text-emerald-700 dark:text-emerald-400">Balasan Admin</span>
      @if($message->replied_at)
      <span class="text-xs text-emerald-500 dark:text-emerald-600">{{ \Carbon\Carbon::parse($message->replied_at)->format('d M Y H:i') }}</span>
      @endif
    </div>
    <p class="text-sm text-slate-700 dark:text-slate-300 whitespace-pre-wrap leading-relaxed">{{ $message->admin_reply }}</p>
  </div>
  @else
  <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-6">
    <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
      <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
      Kirim Balasan
    </h4>
    <form method="POST" action="{{ route('admin.contact.reply', $message) }}" class="space-y-4">
      @csrf @method('PATCH')
      <div>
        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Balasan</label>
        <textarea name="admin_reply" rows="5" required placeholder="Tulis balasan..."
          class="w-full px-4 py-3 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition resize-none">{{ old('admin_reply') }}</textarea>
      </div>
      <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shadow-blue-500/25 active:scale-95">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
        Kirim Balasan
      </button>
    </form>
  </div>
  @endif

</div>
@endsection
