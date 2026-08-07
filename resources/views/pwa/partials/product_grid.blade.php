<div class="pwa-product-grid">
    @foreach($products as $item)
        <a href="{{ route('pwa.product', $item->id) }}" class="pwa-product-card">
            <button type="button" class="pwa-wishlist-btn" data-id="{{ $item->id }}" onclick="event.preventDefault();event.stopPropagation();toggleWishlist(this,{{ $item->id }})">&#9825;</button>
            <img src="https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/{{ $item->product_photo }}" alt="{{ $item->name }}" class="pwa-product-img" loading="lazy">
            <div class="pwa-product-info">
                <div class="pwa-product-cat">{{ $item->productType->name ?? '' }}</div>
                <div class="pwa-product-name">{{ $item->category->name ?? '' }} {{ $item->subCategory->name ?? '' }} {{ $item->proEngine?->name ?? '' }}</div>
                <div class="pwa-product-price">${{ number_format($item->price, 2) }}</div>
                <button class="pwa-add-cart" onclick="event.preventDefault();event.stopPropagation();addToCart({{ $item->id }})">Add to Cart</button>
            </div>
        </a>
    @endforeach
</div>
{{ $products->withQueryString()->links('pwa.partials.pagination') }}