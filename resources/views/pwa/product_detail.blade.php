<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0d1b3e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="CM Auto">
    <link rel="manifest" href="{{ asset('pwa/manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('frontends/assets/img/logo.png') }}">
    <title>{{ $product->name }} — CM Auto</title>
    <link rel="stylesheet" href="{{ asset('pwa/pwa.css') }}">
    <style>
        .pwa-detail-img { width: 100%; aspect-ratio: 1; object-fit: cover; background: var(--bg); border-radius: var(--radius); margin-bottom: 16px; }
        .pwa-detail-info { padding: 0 0 16px; }
        .pwa-detail-cat { font-size: 11px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .pwa-detail-name { font-size: 18px; font-weight: 600; margin-bottom: 8px; }
        .pwa-detail-price { font-size: 22px; font-weight: 700; color: var(--primary); margin-bottom: 12px; }
        .pwa-detail-meta { font-size: 12px; color: var(--text-light); margin-bottom: 16px; line-height: 1.6; }
        .pwa-detail-meta strong { color: var(--text); }
        .pwa-detail-desc { font-size: 13px; line-height: 1.6; color: var(--text); margin-bottom: 16px; padding: 12px; background: var(--card); border-radius: var(--radius); }
        .pwa-detail-btn { display: block; width: 100%; padding: 14px; background: linear-gradient(135deg, var(--primary-dark), var(--primary-light)); color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; text-align: center; box-shadow: 0 4px 12px rgba(13,27,62,0.3); }
        .pwa-detail-btn:active { background: #0f0f1e; }
        .pwa-related { padding: 16px; }
        .pwa-related-title { font-size: 15px; font-weight: 600; margin-bottom: 12px; color: var(--primary); }
        .pwa-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; font-size: 13px; color: var(--primary); font-weight: 500; }
    </style>
</head>
<body>
    <div class="pwa-header">
        <a href="{{ route('pwa.home') }}" class="pwa-back">&#8592; Back</a>
        <div class="pwa-header-icons">
            <button type="button" class="pwa-refresh-btn" onclick="pwaTogglePanel()" id="floatThemeBtn" title="Theme">&#9881;</button>
            <button type="button" class="pwa-wishlist-btn" data-id="{{ $product->id }}" onclick="toggleWishlist(this,{{ $product->id }})" id="detailWishBtn">&#9825;</button>
            <a href="{{ route('pwa.wishlist') }}">
                &#9825;
                <span class="pwa-badge">{{ $wishlistCount ?? 0 }}</span>
            </a>
            <a href="{{ route('pwa.cart') }}">
                &#128722;
                <span class="pwa-badge">{{ array_sum(array_column(session('cart', []), 'quantity')) }}</span>
            </a>
        </div>
    </div>

    <div class="pwa-content" style="padding: 16px;">
        <img src="{{ $product->product_photo ? 'https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/' . $product->product_photo : asset('frontends/assets/img/logo.png') }}" alt="{{ $product->name }}" class="pwa-detail-img">

        <div class="pwa-detail-info">
            <div class="pwa-detail-cat">{{ $product->category->name ?? '' }} {{ $product->subCategory->name ? '/ ' . $product->subCategory->name : '' }}</div>
            <h1 class="pwa-detail-name">{{ $product->name }}</h1>
            <div class="pwa-detail-price">${{ number_format($product->price, 2) }}</div>
            <div class="pwa-detail-meta">
                <strong>SKU:</strong> {{ $product->number ?? 'N/A' }}<br>
                @if($product->proEngine)
                    <strong>Engine:</strong> {{ $product->proEngine->name }}<br>
                    <strong>Part Number:</strong> {{ $product->proEngine->part_number ?? 'N/A' }}
                @endif
            </div>
            @if($product->description)
                <div class="pwa-detail-desc">{!! $product->description !!}</div>
            @endif
            <button class="pwa-detail-btn" onclick="addToCart({{ $product->id }})">Add to Cart</button>
        </div>

        @if($relatedProducts->count())
            <div class="pwa-related">
                <div class="pwa-related-title">Related Products</div>
                <div class="pwa-product-grid">
                    @foreach($relatedProducts as $rp)
                        <a href="{{ route('pwa.product', $rp->id) }}" class="pwa-product-card">
                            <img src="{{ $rp->product_photo ? 'https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/' . $rp->product_photo : asset('frontends/assets/img/logo.png') }}" alt="{{ $rp->name }}" class="pwa-product-img">
                            <div class="pwa-product-info">
                                <div class="pwa-product-name">{{ $rp->name }}</div>
                                <div class="pwa-product-price">${{ number_format($rp->price, 2) }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="pwa-bottom-nav">
        <a href="{{ route('pwa.home') }}" class="pwa-nav-item">
            <span class="nav-icon">&#127968;</span>
            <span>Home</span>
        </a>
        <a href="{{ route('pwa.cart') }}" class="pwa-nav-item">
            <span class="nav-badge">
                <span class="nav-icon">&#128722;</span>
                <span class="badge">{{ array_sum(array_column(session('cart', []), 'quantity')) }}</span>
            </span>
            <span>Cart</span>
        </a>
        <a href="{{ route('pwa.chat') }}" class="pwa-nav-item">
            <span class="nav-icon">&#128172;</span>
            <span>Chat</span>
        </a>
        <a href="{{ route('pwa.wishlist') }}" class="pwa-nav-item">
            <span class="nav-icon">&#9825;</span>
            <span>Wishlist</span>
        </a>
        <a href="{{ route('pwa.account') }}" class="pwa-nav-item">
            <span class="nav-icon">&#128100;</span>
            <span>Account</span>
        </a>
    </div>

    <!-- Theme Panel -->
    <div class="pwa-theme-panel" id="themePanel">
        <div class="pwa-panel-title">Appearance</div>
        <div class="pwa-panel-item" onclick="pwaToggleTheme()">
            <span class="pwa-panel-icon" id="panelThemeIcon">&#9790;</span>
            <span id="panelThemeLabel">Dark Mode</span>
        </div>
        <div class="pwa-panel-item" onclick="pwaToggleBlur()">
            <span class="pwa-panel-icon">&#128171;</span>
            <span id="panelBlurLabel">Blur On</span>
            <div class="pwa-panel-dot" id="panelBlurDot"></div>
        </div>
    </div>

    <script src="{{ asset('pwa/error-handler.js') }}"></script>
    <script src="{{ asset('pwa/pwa-connectivity.js') }}"></script>
    <script src="{{ asset('pwa/pwa-theme.js') }}"></script>
    <script src="{{ asset('pwa/pwa.js') }}"></script>
    <script>
        function toggleWishlist(btn, productId) {
            if (typeof pwaIsOffline === 'function' && pwaIsOffline()) {
                if (typeof pwaHandleError === 'function') pwaHandleError('You are offline. Please check your connection.');
                return;
            }
            fetch('{{ route("wishlist.toggle") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                body: 'product_id=' + productId
            })
            .then(r => r.json())
            .then(res => {
                var badges = document.querySelectorAll('.pwa-badge');
                if (res.status === 'added') {
                    btn.classList.add('active');
                    btn.innerHTML = '&#10084;';
                    badges.forEach(function(b) { if (b.id !== 'cartBadge') b.textContent = parseInt(b.textContent || 0) + 1; });
                } else if (res.status === 'removed') {
                    btn.classList.remove('active');
                    btn.innerHTML = '&#9825;';
                    badges.forEach(function(b) { if (b.id !== 'cartBadge') b.textContent = Math.max(0, parseInt(b.textContent || 0) - 1); });
                }
            })
            .catch(() => {
                if (typeof pwaHandleError === 'function') pwaHandleError('Failed to update wishlist.');
            });
        }

        (function() {
            var btn = document.getElementById('detailWishBtn');
            if (!btn) return;
            var id = btn.getAttribute('data-id');
            fetch('{{ route("wishlist.check") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                body: 'product_id=' + id
            })
            .then(r => r.json())
            .then(res => {
                if (res.in_wishlist) {
                    btn.classList.add('active');
                    btn.innerHTML = '&#10084;';
                }
            })
            .catch(() => {});
        })();

        function pwaShowSuccess(msg) {
            var t = document.createElement('div');
            t.style.cssText = 'position:fixed;bottom:80px;left:50%;transform:translateX(-50%);background:#27ae60;color:#fff;padding:10px 24px;border-radius:8px;font-size:13px;font-weight:500;z-index:99999;opacity:0;transition:opacity 0.3s;box-shadow:0 4px 12px rgba(39,174,96,0.3);white-space:nowrap;';
            t.textContent = msg;
            document.body.appendChild(t);
            requestAnimationFrame(function() { t.style.opacity = '1'; });
            setTimeout(function() {
                t.style.opacity = '0';
                setTimeout(function() { if (t.parentNode) t.parentNode.removeChild(t); }, 300);
            }, 2000);
        }

        function addToCart(id) {
            if (typeof pwaIsOffline === 'function' && pwaIsOffline()) {
                if (typeof pwaHandleError === 'function') pwaHandleError('You are offline. Please check your connection.');
                return;
            }
            var btn = document.querySelector('.pwa-detail-btn');
            if (btn) { btn.textContent = 'Adding...'; btn.disabled = true; }
            fetch('{{ route("pwa.cart.add") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: 'id=' + id
            })
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success') {
                    if (btn) btn.textContent = 'Added ✓';
                    document.getElementById('cartBadge').textContent = res.count;
                    document.getElementById('navCartBadge').textContent = res.count;
                    pwaShowSuccess('Added to cart!');
                    setTimeout(function() {
                        if (btn) { btn.textContent = 'Add to Cart'; btn.disabled = false; }
                    }, 1500);
                }
            })
            .catch(() => {
                if (btn) { btn.textContent = 'Add to Cart'; btn.disabled = false; }
                if (typeof pwaHandleError === 'function') pwaHandleError('Failed to add to cart. Please try again.');
            });
        }
    </script>
</body>
</html>
