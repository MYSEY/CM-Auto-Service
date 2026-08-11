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
    <link rel="stylesheet" href="{{ asset('build/pwa.css') }}">
    <style>
        .ios-header {
            background: rgba(255,255,255,0.92);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
        }
        .dark .ios-header { background: rgba(15,17,35,0.92); }
        .cart-item-card { transition: transform 0.3s cubic-bezier(0.25,0.46,0.45,0.94); }
        .cart-item-card:active { transform: scale(0.98); }
        .qty-btn {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.15s ease; -webkit-tap-highlight-color: transparent;
        }
        .qty-btn:active { transform: scale(0.88); }
        .nav-pill { position: relative; }
        .nav-pill.active::before {
            content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 20px; height: 2px; border-radius: 1px; background: #0d1b3e;
        }
        .dark .nav-pill.active::before { background: #60a5fa; }
        .delete-btn {
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.15s ease; -webkit-tap-highlight-color: transparent;
        }
        .delete-btn:active { transform: scale(0.85); background: #fee2e2; }
        .dark .delete-btn:active { background: rgba(239,68,68,0.2); }
        .checkout-btn {
            height: 52px; border-radius: 14px; font-size: 17px; font-weight: 600;
            letter-spacing: 0.2px; transition: all 0.2s ease; -webkit-tap-highlight-color: transparent;
        }
        .checkout-btn:active { transform: scale(0.97); opacity: 0.9; }
        .empty-state-icon {
            width: 80px; height: 80px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;
        }
    </style>
</head>
<body class="bg-[#f2f2f7] dark:bg-[#0f1123] text-gray-900 dark:text-gray-100 font-sans antialiased">
    <!-- iOS Header -->
    <div class="ios-header sticky top-0 z-50 border-b border-gray-200/60 dark:border-[#2a2d3e]/60">
        <div class="max-w-lg mx-auto px-4 h-[52px] flex items-center justify-between">
            <a href="{{ route('pwa.home') }}" class="w-11 h-11 flex items-center justify-center -ml-2 rounded-full active:bg-gray-200/60 dark:active:bg-white/10 transition-colors">
                <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <h1 class="text-[17px] font-semibold text-gray-900 dark:text-white tracking-tight">My Cart</h1>
            <div class="w-11"></div>
        </div>
    </div>

    <!-- Cart Content -->
    <div class="max-w-lg mx-auto px-4 pt-4 pb-[140px]">
        @if(!empty($cart) && count($cart) > 0)
            @foreach($cart as $productId => $item)
                <div class="cart-item-card flex items-center gap-3 p-3 bg-white dark:bg-[#1c1e2d] rounded-2xl mb-3 shadow-sm shadow-black/[0.04] dark:shadow-black/20">
                    <div class="w-[76px] h-[76px] rounded-xl overflow-hidden flex-shrink-0 bg-gray-100 dark:bg-[#252838]">
                        <img src="{{ isset($item['image']) && $item['image'] ? 'https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/' . $item['image'] : asset('frontends/assets/img/logo.png') }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0 py-0.5">
                        <h3 class="text-[15px] font-medium text-gray-900 dark:text-white truncate leading-tight">{{ $item['name'] }}</h3>
                        <p class="text-[15px] font-semibold text-primary mt-1">${{ number_format($item['price'], 2) }}</p>
                        <div class="flex items-center gap-3 mt-2.5">
                            <button class="qty-btn bg-gray-100 dark:bg-[#252838] text-gray-600 dark:text-gray-300" onclick="updateCart({{ $productId }}, {{ $item['quantity'] - 1 }})">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/></svg>
                            </button>
                            <span class="text-[15px] font-semibold text-gray-900 dark:text-white min-w-[24px] text-center tabular-nums">{{ $item['quantity'] }}</span>
                            <button class="qty-btn bg-primary text-white shadow-sm shadow-primary/30" onclick="updateCart({{ $productId }}, {{ $item['quantity'] + 1 }})">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                            </button>
                        </div>
                    </div>
                    <button class="delete-btn" onclick="removeCart({{ $productId }})">
                        <svg class="w-[18px] h-[18px] text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            @endforeach

            <!-- Summary & Checkout -->
            <div class="bg-white dark:bg-[#1c1e2d] rounded-2xl p-4 mt-4 shadow-sm shadow-black/[0.04] dark:shadow-black/20">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[15px] text-gray-500 dark:text-gray-400">Subtotal</span>
                    <span class="text-[17px] font-semibold text-gray-900 dark:text-white">${{ number_format($subtotal, 2) }}</span>
                </div>
                <button type="button" class="checkout-btn w-full bg-gradient-to-r from-primary-dark to-primary text-white shadow-lg shadow-primary/25">
                    Proceed to Checkout
                </button>
            </div>
        @else
            <div class="text-center pt-20 px-6">
                <div class="empty-state-icon bg-gray-200/70 dark:bg-[#252838]">
                    <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                </div>
                <h3 class="text-[17px] font-semibold text-gray-900 dark:text-white mb-1">Your cart is empty</h3>
                <p class="text-[15px] text-gray-500 dark:text-gray-400">Add items to get started</p>
                <a href="{{ route('pwa.home') }}" class="inline-flex items-center justify-center mt-6 px-6 py-3 bg-primary text-white text-[15px] font-semibold rounded-xl shadow-sm shadow-primary/30 active:scale-95 transition-transform">
                    Browse Products
                </a>
            </div>
        @endif
    </div>

    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 z-50">
        <div class="bg-white/90 dark:bg-[#1c1e2d]/90 backdrop-blur-xl border-t border-gray-200/60 dark:border-[#2a2d3e]/60" style="padding-bottom: env(safe-area-inset-bottom, 0);">
            <div class="max-w-lg mx-auto flex justify-around items-center h-[56px]">
                <a href="{{ route('pwa.home') }}" class="nav-pill flex flex-col items-center justify-center gap-0.5 w-16 h-full text-gray-400 dark:text-gray-500 active:text-primary dark:active:text-blue-400 transition-colors">
                    <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <span class="text-[10px] font-medium">Home</span>
                </a>
                <a href="{{ route('pwa.cart') }}" class="nav-pill active flex flex-col items-center justify-center gap-0.5 w-16 h-full text-primary dark:text-blue-400 transition-colors">
                    <span class="relative">
                        <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                        @if(!empty($cart) && count($cart) > 0)
                        <span class="absolute -top-1.5 -right-2 bg-red-500 text-white text-[9px] font-bold min-w-[16px] h-4 px-1 rounded-full flex items-center justify-center leading-none" id="navCartBadge">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                        @endif
                    </span>
                    <span class="text-[10px] font-medium">Cart</span>
                </a>
                <a href="{{ route('pwa.chat') }}" class="nav-pill flex flex-col items-center justify-center gap-0.5 w-16 h-full text-gray-400 dark:text-gray-500 active:text-primary dark:active:text-blue-400 transition-colors">
                    <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    <span class="text-[10px] font-medium">Chat</span>
                </a>
                <a href="{{ route('pwa.wishlist') }}" class="nav-pill flex flex-col items-center justify-center gap-0.5 w-16 h-full text-gray-400 dark:text-gray-500 active:text-primary dark:active:text-blue-400 transition-colors">
                    <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                    <span class="text-[10px] font-medium">Wishlist</span>
                </a>
                <a href="{{ route('pwa.account') }}" class="nav-pill flex flex-col items-center justify-center gap-0.5 w-16 h-full text-gray-400 dark:text-gray-500 active:text-primary dark:active:text-blue-400 transition-colors">
                    <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span class="text-[10px] font-medium">Account</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Theme Panel -->
    <div class="pwa-theme-panel fixed top-[60px] right-3 bg-white dark:bg-[#1c1e2d] rounded-2xl shadow-2xl shadow-black/20 py-2 z-[199] min-w-[180px] opacity-0 -translate-y-2.5 scale-95 pointer-events-none transition-all duration-300 ease-out" id="themePanel">
        <div class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider px-4 pt-2 pb-1">Appearance</div>
        <div class="flex items-center gap-2.5 px-4 py-3 text-sm font-medium cursor-pointer active:bg-gray-100 dark:active:bg-white/5 transition-colors duration-200" onclick="pwaToggleTheme()">
            <span class="text-lg w-6 text-center" id="panelThemeIcon">&#9790;</span>
            <span id="panelThemeLabel">Dark Mode</span>
        </div>
        <div class="flex items-center gap-2.5 px-4 py-3 text-sm font-medium cursor-pointer active:bg-gray-100 dark:active:bg-white/5 transition-colors duration-200" onclick="pwaToggleBlur()">
            <span class="text-lg w-6 text-center">&#128171;</span>
            <span id="panelBlurLabel">Blur On</span>
            <div class="ml-auto w-9 h-5 rounded-full bg-gray-400 relative transition-colors duration-300" id="panelBlurDot">
                <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform duration-300"></div>
            </div>
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
