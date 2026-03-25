@if ($paginator->hasPages())
<nav class="flex items-center gap-1">
    @if ($paginator->onFirstPage())
    <span class="px-3 py-1.5 text-xs font-semibold text-slate-300 dark:text-slate-600 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg cursor-not-allowed">←</span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg hover:border-primary-400 hover:text-primary-600 transition-colors">←</a>
    @endif
    <span class="px-3 py-1.5 text-xs text-slate-400">Hal. {{ $paginator->currentPage() }}</span>
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg hover:border-primary-400 hover:text-primary-600 transition-colors">→</a>
    @else
    <span class="px-3 py-1.5 text-xs font-semibold text-slate-300 dark:text-slate-600 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg cursor-not-allowed">→</span>
    @endif
</nav>
@endif
