@if ($paginator->hasPages())
    <div class="pwa-pagination-wrap px-4 pt-4 pb-[90px]">
        <div class="pwa-pagination-bar flex items-center justify-between bg-white dark:bg-[#1a1d2e] rounded-2xl p-1.5 shadow-lg shadow-primary/8 border border-gray-200 dark:border-[#2a2d3e]">
            @if ($paginator->onFirstPage())
                <button class="pwa-page-btn inline-flex items-center gap-1 px-4 py-2.5 border-none rounded-xl text-[13px] font-semibold cursor-pointer text-primary bg-transparent opacity-30 cursor-default" disabled>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                    Prev
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pwa-page-btn inline-flex items-center gap-1 px-4 py-2.5 border-none rounded-xl text-[13px] font-semibold cursor-pointer text-primary bg-transparent active:scale-95 active:bg-gray-100 dark:active:bg-white/5 transition-all duration-200 no-underline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                    Prev
                </a>
            @endif

            <div class="pwa-page-info flex items-center">
                <span class="pwa-page-current text-xl font-bold text-primary">{{ $paginator->currentPage() }}</span>
                <span class="pwa-page-sep text-sm text-gray-400 font-normal mx-1">/</span>
                <span class="pwa-page-total text-sm text-gray-400 font-medium">{{ $paginator->lastPage() }}</span>
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pwa-page-btn inline-flex items-center gap-1 px-4 py-2.5 border-none rounded-xl text-[13px] font-semibold cursor-pointer text-primary bg-transparent active:scale-95 active:bg-gray-100 dark:active:bg-white/5 transition-all duration-200 no-underline">
                    Next
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                </a>
            @else
                <button class="pwa-page-btn inline-flex items-center gap-1 px-4 py-2.5 border-none rounded-xl text-[13px] font-semibold cursor-pointer text-primary bg-transparent opacity-30 cursor-default" disabled>
                    Next
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            @endif
        </div>

        <div class="pwa-page-dots flex justify-center gap-1.5 pt-3">
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pwa-dot w-[18px] h-1.5 rounded-sm bg-gradient-to-br from-primary to-primary-light"></span>
                        @else
                            <a href="{{ $url }}" class="pwa-dot w-1.5 h-1.5 rounded-full bg-gray-200 dark:bg-[#2a2d3e] transition-all duration-300"></a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>
@endif
