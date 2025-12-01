<div class="product-grid-container">
    @foreach($products as $item)
        @include('frontends.product', ['item' => $item])
    @endforeach
</div>

<div class="shop_toolbar t_bottom">
    {!! $products->withQueryString()->links('pagination::bootstrap-4') !!}
</div>
