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
    <title>Wishlist — CM Auto</title>
    <link rel="stylesheet" href="{{ asset('pwa/pwa.css') }}">
</head>
<body>
    <div class="pwa-header">
        <a href="{{ route('pwa.home') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;font-size:13px;color:#fff;font-weight:500;">&#8592; Back</a>
        <div class="pwa-header-icons">
            <button type="button" class="pwa-refresh-btn" onclick="pwaTogglePanel()" id="floatThemeBtn" title="Theme">&#9881;</button>
            <button type="button" class="pwa-refresh-btn" onclick="location.reload()" title="Refresh">&#8635;</button>
            <a href="{{ route('pwa.cart') }}">
                &#128722;
                <span class="pwa-badge">{{ array_sum(array_column(session('cart', []), 'quantity')) }}</span>
            </a>
        </div>
    </div>

    <div class="pwa-content" style="padding: 16px;">
        <h2 class="pwa-section-title">My Wishlist</h2>

        @if($wishlistItems->count() > 0)
            @foreach($wishlistItems as $item)
                @if($item->product)
                <div class="pwa-wishlist-item" id="wishlist-item-{{ $item->product_id }}">
                    <a href="{{ route('pwa.product', $item->product_id) }}">
                        <img src="{{ $item->product->product_photo ? 'https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/' . $item->product->product_photo : asset('frontends/assets/img/logo.png') }}" alt="{{ $item->product->name }}" class="pwa-wishlist-img">
                    </a>
                    <div class="pwa-wishlist-info">
                        <a href="{{ route('pwa.product', $item->product_id) }}">
                            <div class="pwa-wishlist-name">{{ $item->product->name }}</div>
                        </a>
                        <div class="pwa-wishlist-price">${{ number_format($item->product->price, 2) }}</div>
                    </div>
                    <div class="pwa-wishlist-remove" onclick="removeWishlist({{ $item->product_id }})">&#10005;</div>
                </div>
                @endif
            @endforeach
        @else
            <div class="pwa-wishlist-empty">
                <div class="pwa-wishlist-empty-icon">&#9825;</div>
                <p>Your wishlist is empty</p>
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
        <a href="{{ route('pwa.wishlist') }}" class="pwa-nav-item active">
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
        function removeWishlist(productId) {
            if (typeof pwaIsOffline === 'function' && pwaIsOffline()) {
                if (typeof pwaHandleError === 'function') pwaHandleError('You are offline. Please check your connection.');
                return;
            }
            fetch('{{ route("wishlist.remove") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                body: 'product_id=' + productId
            })
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success') {
                    var el = document.getElementById('wishlist-item-' + productId);
                    if (el) {
                        el.style.opacity = '0';
                        el.style.transform = 'translateX(20px)';
                        el.style.transition = 'all 0.3s';
                        setTimeout(function() { el.remove(); }, 300);
                    }
                }
            })
            .catch(() => {
                if (typeof pwaHandleError === 'function') pwaHandleError('Failed to remove from wishlist.');
            });
        }
    </script>
</body>
</html>
