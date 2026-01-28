<style>
    .pagination li.current span {
        background: #ef0505;
        color: #fff;
        padding: 6px 12px;
        border-radius: 4px;
    }
</style>
<div class="product-grid-container">
    @foreach($products as $item)
        @include('frontends.product', ['item' => $item])
    @endforeach
</div>

{{-- <div class="shop_toolbar t_bottom">
    {!! $products->withQueryString()->links('pagination::bootstrap-4') !!}
</div> --}}
@php
    $paginator = $products;
    $lastPage = $paginator->lastPage();
@endphp

<div class="shop_toolbar t_bottom">
    <div class="pagination">
        <ul>

            {{-- Prev --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&laquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}">&laquo;</a></li>
            @endif

            {{-- First 5 pages --}}
            @for ($i = 1; $i <= min(5, $lastPage); $i++)
                @if ($i == $paginator->currentPage())
                    <li class="current"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            {{-- Dots --}}
            @if ($lastPage > 10)
                <li class="disabled"><span>...</span></li>
            @endif

            {{-- Last 5 pages --}}
            @for ($i = max($lastPage - 4, 6); $i <= $lastPage; $i++)
                @if ($i > 5)
                    @if ($i == $paginator->currentPage())
                        <li class="current"><span>{{ $i }}</span></li>
                    @else
                        <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endfor

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}">&raquo;</a></li>
            @else
                <li class="disabled"><span>&raquo;</span></li>
            @endif

        </ul>
    </div>
</div>