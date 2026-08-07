@if ($paginator->hasPages())
    <div class="pwa-pagination-wrap">
        <div class="pwa-pagination-bar">
            @if ($paginator->onFirstPage())
                <button class="pwa-page-btn pwa-page-prev" disabled>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                    Prev
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pwa-page-btn pwa-page-prev">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                    Prev
                </a>
            @endif

            <div class="pwa-page-info">
                <span class="pwa-page-current">{{ $paginator->currentPage() }}</span>
                <span class="pwa-page-sep">/</span>
                <span class="pwa-page-total">{{ $paginator->lastPage() }}</span>
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pwa-page-btn pwa-page-next">
                    Next
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                </a>
            @else
                <button class="pwa-page-btn pwa-page-next" disabled>
                    Next
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            @endif
        </div>

        <div class="pwa-page-dots">
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pwa-dot active"></span>
                        @else
                            <a href="{{ $url }}" class="pwa-dot"></a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>
@endif
