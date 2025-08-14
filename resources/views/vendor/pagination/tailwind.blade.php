@props(['paginator'])

@if ($paginator->hasPages())
<div class="flex justify-between items-center px-4 py-3">
    {{-- Showing Info --}}
    <div class="text-sm text-slate-500">
        Showing <b>{{ $paginator->firstItem() }} - {{ $paginator->lastItem() }}</b> of {{ $paginator->total() }}
    </div>

    {{-- Pagination --}}
    <div class="flex space-x-1">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
        <span
            class="px-3 py-1 min-w-9 min-h-9 text-sm text-slate-400 bg-white border border-slate-200 rounded cursor-not-allowed">
            Prev
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}"
            class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">
            Prev
        </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
        @if ($page == $paginator->currentPage())
        <span
            class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-white bg-brand-800 border border-brand-800 rounded">
            {{ $page }}
        </span>
        @else
        <a href="{{ $url }}"
            class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">
            {{ $page }}
        </a>
        @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
            class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-500 bg-white border border-slate-200 rounded hover:bg-slate-50 hover:border-slate-400 transition duration-200 ease">
            Next
        </a>
        @else
        <span
            class="px-3 py-1 min-w-9 min-h-9 text-sm text-slate-400 bg-white border border-slate-200 rounded cursor-not-allowed">
            Next
        </span>
        @endif
    </div>
</div>
@endif
