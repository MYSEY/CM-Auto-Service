<div class="grid grid-cols-2 gap-2.5">
    @foreach($products as $item)
        <a href="{{ route('pwa.product', $item->id) }}" class="pwa-product-card relative bg-white dark:bg-[#1a1d2e] rounded-xl overflow-hidden shadow-sm active:scale-[0.97] transition-transform duration-150">
            @if(($item->status ?? 0) == 1)
                <span class="absolute top-2 left-2 px-2 py-0.5 bg-red-600/90 backdrop-blur-sm text-white font-bold text-[10px] rounded-md z-[6] shadow-md tracking-wider">🚫 អស់ស្តុក</span>
            @endif
            <button type="button" class="pwa-wishlist-btn absolute top-2 right-2 w-8 h-8 rounded-full border-none bg-white/90 text-accent-red text-base cursor-pointer flex items-center justify-center z-[5] shadow-md active:scale-[0.85] transition-all duration-200" data-id="{{ $item->id }}" onclick="event.preventDefault();event.stopPropagation();toggleWishlist(this,{{ $item->id }})">&#9825;</button>
            <img src="https://cdn.cmautoservic.com/{{ $item->product_photo }}" alt="{{ $item->name }}" class="pwa-product-img w-full aspect-square object-cover bg-gray-100 dark:bg-gray-700 {{ ($item->status ?? 0) == 1 ? 'grayscale opacity-75' : '' }}" loading="lazy">
            <div class="pwa-product-info p-2.5">
                <div class="pwa-product-cat text-[10px] text-gray-400 uppercase tracking-wider">{{ $item->productType->name ?? '' }}</div>
                <div class="pwa-product-name text-xs font-medium my-1 line-clamp-2 leading-tight">{{ $item->category->name ?? '' }} {{ $item->subCategory->name ?? '' }} {{ $item->proEngine?->name ?? '' }}</div>
                <div class="pwa-product-price text-sm font-bold text-primary">${{ number_format($item->price, 2) }}</div>
                @if(($item->status ?? 0) == 1)
                    <button class="pwa-add-cart block w-full py-2 bg-gray-400 dark:bg-gray-600 text-white border-none rounded-md text-[11px] font-bold mt-2 text-center opacity-80 cursor-not-allowed" disabled onclick="event.preventDefault();event.stopPropagation();">🚫 អស់ស្តុក</button>
                @else
                    <button class="pwa-add-cart block w-full py-2 bg-gradient-to-br from-primary to-primary-light text-white border-none rounded-md text-[11px] font-medium cursor-pointer mt-2 text-center transition-all duration-200 active:bg-primary-dark disabled:opacity-70 disabled:cursor-default" onclick="event.preventDefault();event.stopPropagation();addToCart({{ $item->id }})">Add to Cart</button>
                @endif
            </div>
        </a>
    @endforeach
</div>
{{ $products->withQueryString()->links('pwa.partials.pagination') }}
