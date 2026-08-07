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
    <title>Cart — CM Auto</title>
    <link rel="stylesheet" href="{{ asset('pwa/pwa.css') }}">
    <style>
        .pwa-cart-item { display: flex; gap: 12px; padding: 12px; background: var(--card); border-radius: var(--radius); margin-bottom: 8px; box-shadow: var(--shadow); }
        .pwa-cart-img { width: 72px; height: 72px; border-radius: 8px; object-fit: cover; background: var(--bg); flex-shrink: 0; }
        .pwa-cart-info { flex: 1; min-width: 0; }
        .pwa-cart-name { font-size: 13px; font-weight: 500; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .pwa-cart-price { font-size: 14px; font-weight: 700; color: var(--primary); }
        .pwa-cart-qty { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
        .pwa-cart-qty button { width: 28px; height: 28px; border-radius: 6px; border: 1px solid var(--border); background: var(--card); font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .pwa-cart-qty span { font-size: 14px; font-weight: 500; min-width: 20px; text-align: center; }
        .pwa-cart-remove { color: var(--accent); font-size: 18px; cursor: pointer; padding: 4px; }
        .pwa-cart-footer { padding: 16px; background: var(--card); border-radius: var(--radius); margin-top: 12px; box-shadow: var(--shadow); }
        .pwa-cart-total { display: flex; justify-content: space-between; font-size: 16px; font-weight: 600; margin-bottom: 12px; }
        .pwa-cart-empty { text-align: center; padding: 60px 16px; color: var(--text-light); }
        .pwa-cart-empty-icon { font-size: 48px; margin-bottom: 12px; }
        .pwa-section-title { font-size: 16px; font-weight: 600; margin-bottom: 12px; color: var(--primary); padding: 0 16px; }
    </style>
</head>
<body>
    <div class="pwa-header">
        <a href="{{ route('pwa.home') }}" class="pwa-back" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;font-size:13px;color:#fff;font-weight:500;">&#8592; Back</a>
        <div class="pwa-header-icons">
            <button type="button" class="pwa-refresh-btn" onclick="location.reload()" title="Refresh">&#8635;</button>
            <button type="button" class="pwa-refresh-btn" onclick="pwaTogglePanel()" id="floatThemeBtn" title="Theme">&#9881;</button>
            <a href="{{ route('pwa.wishlist') }}">
                &#9825;
                <span class="pwa-badge">{{ $wishlistCount ?? 0 }}</span>
            </a>
        </div>
    </div>

    <div class="pwa-content" style="padding: 16px;">
        <h2 class="pwa-section-title">My Cart</h2>

        @if(!empty($cart) && count($cart) > 0)
            @foreach($cart as $productId => $item)
                <div class="pwa-cart-item">
                    <img src="{{ isset($item['image']) && $item['image'] ? 'https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/' . $item['image'] : asset('frontends/assets/img/logo.png') }}" alt="{{ $item['name'] }}" class="pwa-cart-img">
                    <div class="pwa-cart-info">
                        <div class="pwa-cart-name">{{ $item['name'] }}</div>
                        <div class="pwa-cart-price">${{ number_format($item['price'], 2) }}</div>
                        <div class="pwa-cart-qty">
                            <button onclick="updateCart({{ $productId }}, {{ $item['quantity'] - 1 }})">-</button>
                            <span>{{ $item['quantity'] }}</span>
                            <button onclick="updateCart({{ $productId }}, {{ $item['quantity'] + 1 }})">+</button>
                        </div>
                    </div>
                    <div class="pwa-cart-remove" onclick="removeCart({{ $productId }})">&#10005;</div>
                </div>
            @endforeach

            <div class="pwa-cart-footer">
                <div class="pwa-cart-total">
                    <span>Total</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <button class="pwa-detail-btn" style="display:block;width:100%;padding:14px;background:linear-gradient(135deg,var(--primary-dark),var(--primary-light));color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;text-align:center;box-shadow:0 4px 12px rgba(13,27,62,0.3);">Checkout</button>
            </div>
        @else
            <div class="pwa-cart-empty">
                <div class="pwa-cart-empty-icon">&#128722;</div>
                <p>Your cart is empty</p>
            </div>
        @endif
    </div>

    <div class="pwa-bottom-nav">
        <a href="{{ route('pwa.home') }}" class="pwa-nav-item">
            <span class="nav-icon">&#127968;</span>
            <span>Home</span>
        </a>
        <a href="{{ route('pwa.cart') }}" class="pwa-nav-item active">
            <span class="nav-badge">
                <span class="nav-icon">&#128722;</span>
                <span class="badge">{{ array_sum(array_column($cart, 'quantity')) }}</span>
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
        function updateCart(productId, quantity) {
            if (typeof pwaIsOffline === 'function' && pwaIsOffline()) {
                if (typeof pwaHandleError === 'function') pwaHandleError('You are offline. Please check your connection.');
                return;
            }
            fetch('{{ route("pwa.cart.update") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: 'product_id=' + productId + '&quantity=' + quantity
            })
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success') location.reload();
            })
            .catch(() => {
                if (typeof pwaHandleError === 'function') pwaHandleError('Failed to update cart. Please try again.');
            });
        }

        function removeCart(productId) {
            if (typeof pwaIsOffline === 'function' && pwaIsOffline()) {
                if (typeof pwaHandleError === 'function') pwaHandleError('You are offline. Please check your connection.');
                return;
            }
            fetch('{{ route("pwa.cart.remove") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: 'product_id=' + productId
            })
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success') location.reload();
            })
            .catch(() => {
                if (typeof pwaHandleError === 'function') pwaHandleError('Failed to remove item. Please try again.');
            });
        }
    </script>
</body>
</html>
