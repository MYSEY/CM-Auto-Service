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
    <link rel="stylesheet" href="{{ asset('build/pwa.css') }}">
    <style>
        .ios-header {
            background: rgba(255,255,255,0.92);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
        }
        .dark .ios-header { background: rgba(15,17,35,0.92); }
        .nav-pill { position: relative; }
        .nav-pill.active::before {
            content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 20px; height: 2px; border-radius: 1px; background: #0d1b3e;
        }
        .dark .nav-pill.active::before { background: #60a5fa; }
    </style>
</head>
<body class="bg-[#f2f2f7] dark:bg-[#0f1123] text-gray-900 dark:text-gray-200 font-sans antialiased">

    <!-- iOS Header -->
    <div class="ios-header sticky top-0 z-50 px-4 pt-[14px] pb-[10px] flex items-center justify-between" style="padding-top: calc(14px + env(safe-area-inset-top, 0));">
        <a href="{{ route('pwa.home') }}" class="flex items-center gap-0.5 text-[17px] font-normal text-[#0d1b3e] dark:text-white">
            <svg class="w-[20px] h-[20px] -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div class="text-[17px] font-semibold text-[#0d1b3e] dark:text-white tracking-tight">Wishlist</div>
        <div class="w-[20px]"></div>
    </div>

    <!-- Content -->
    <div class="px-4 pt-3 pb-[90px]">

        @if($wishlistItems->count() > 0)
            @foreach($wishlistItems as $item)
                @if($item->product)
                <div class="flex items-center gap-3.5 p-3.5 mb-2.5 rounded-2xl shadow-sm shadow-black/[0.04] dark:shadow-black/20 bg-white dark:bg-[#1c1e2d] transition-all duration-200" id="wishlist-item-{{ $item->product_id }}">
                    <a href="{{ route('pwa.product', $item->product_id) }}" class="flex-shrink-0">
                        <img src="{{ $item->product->product_photo ? 'https://cdn.cmautoservic.com/' . $item->product->product_photo : asset('frontends/assets/img/logo.png') }}" alt="{{ $item->product->name }}" class="w-[64px] h-[64px] rounded-xl object-cover bg-[#f2f2f7] dark:bg-white/5">
                    </a>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('pwa.product', $item->product_id) }}">
                            <div class="text-[15px] font-medium text-[#0d1b3e] dark:text-white truncate leading-tight">{{ $item->product->name }}</div>
                        </a>
                        <div class="text-[15px] font-semibold text-[#0d1b3e] dark:text-[#60a5fa] mt-1">${{ number_format($item->product->price, 2) }}</div>
                    </div>
                    <button type="button" onclick="removeWishlist({{ $item->product_id }})" class="flex-shrink-0 w-[34px] h-[34px] rounded-full bg-[#f2f2f7] dark:bg-white/5 flex items-center justify-center text-[#ff3b30] active:scale-90 transition-transform duration-150">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>
                @endif
            @endforeach
        @else
            <div class="text-center py-24 px-6">
                <div class="w-[80px] h-[80px] rounded-full bg-[#f2f2f7] dark:bg-white/5 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-[36px] h-[36px] text-[#c7c7cc] dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                </div>
                <p class="text-[17px] font-semibold text-[#0d1b3e] dark:text-white mb-1">No items yet</p>
                <p class="text-[13px] text-[#8e8e93] dark:text-gray-400">Items you save to your wishlist will appear here.</p>
            </div>
        @endif
    </div>

    <!-- iOS Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-white/90 dark:bg-[#1c1e2d]/90 backdrop-blur-xl border-t border-black/[0.06] dark:border-white/[0.08] z-50" style="padding-bottom: calc(8px + env(safe-area-inset-bottom, 0));">
        <div class="flex justify-around items-end pt-1.5 pb-1">
            <a href="{{ route('pwa.home') }}" class="nav-pill flex flex-col items-center gap-[2px] px-3 py-1 text-[10px] font-medium text-[#8e8e93] dark:text-gray-500">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Home</span>
            </a>
            <a href="{{ route('pwa.cart') }}" class="nav-pill flex flex-col items-center gap-[2px] px-3 py-1 text-[10px] font-medium text-[#8e8e93] dark:text-gray-500">
                <span class="relative">
                    <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                    @if(array_sum(array_column(session('cart', []), 'quantity')) > 0)
                    <span class="absolute -top-1 -right-1.5 bg-[#ff3b30] text-white text-[9px] font-semibold px-[5px] py-[1px] rounded-full min-w-[15px] text-center leading-[14px]">{{ array_sum(array_column(session('cart', []), 'quantity')) }}</span>
                    @endif
                </span>
                <span>Cart</span>
            </a>
            <a href="{{ route('pwa.chat') }}" class="nav-pill flex flex-col items-center gap-[2px] px-3 py-1 text-[10px] font-medium text-[#8e8e93] dark:text-gray-500">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                <span>Chat</span>
            </a>
            <a href="{{ route('pwa.wishlist') }}" class="nav-pill active flex flex-col items-center gap-[2px] px-3 py-1 text-[10px] font-semibold text-[#0d1b3e] dark:text-[#60a5fa]">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                <span>Wishlist</span>
            </a>
            <a href="{{ route('pwa.account') }}" class="nav-pill flex flex-col items-center gap-[2px] px-3 py-1 text-[10px] font-medium text-[#8e8e93] dark:text-gray-500">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span>Account</span>
            </a>
        </div>
    </div>

    <!-- Theme Panel -->
    <div class="pwa-theme-panel fixed top-[60px] right-3 bg-white dark:bg-[#1c1e2d] rounded-xl shadow-2xl shadow-black/20 py-2 z-[199] min-w-[180px] opacity-0 -translate-y-2.5 scale-95 pointer-events-none transition-all duration-300 ease-out" id="themePanel">
        <div class="text-[11px] font-semibold text-[#8e8e93] dark:text-gray-500 uppercase tracking-wider px-4 pt-2 pb-1">Appearance</div>
        <div class="flex items-center gap-2.5 px-4 py-3 text-sm font-medium cursor-pointer active:bg-[#f2f2f7] dark:active:bg-white/5 transition-colors duration-200 rounded-lg mx-1" onclick="pwaToggleTheme()">
            <span class="text-lg w-6 text-center" id="panelThemeIcon">&#9790;</span>
            <span id="panelThemeLabel">Dark Mode</span>
        </div>
        <div class="flex items-center gap-2.5 px-4 py-3 text-sm font-medium cursor-pointer active:bg-[#f2f2f7] dark:active:bg-white/5 transition-colors duration-200 rounded-lg mx-1" onclick="pwaToggleBlur()">
            <span class="text-lg w-6 text-center">&#128171;</span>
            <span id="panelBlurLabel">Blur On</span>
            <div class="ml-auto w-9 h-5 rounded-full bg-[#c7c7cc] relative transition-colors duration-300" id="panelBlurDot">
                <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform duration-300"></div>
            </div>
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
