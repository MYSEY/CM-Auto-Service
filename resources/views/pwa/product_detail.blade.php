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
    <header class="ios-header sticky top-0 z-50 border-b border-black/[0.06] dark:border-white/[0.08]" style="padding-top: env(safe-area-inset-top, 0);">
        <div class="px-4 py-3 flex items-center justify-between">
            <a href="{{ route('pwa.home') }}" class="inline-flex items-center gap-1 text-[15px] font-medium text-[#0d1b3e] dark:text-blue-400">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2"><path d="M15 19l-7-7 7-7"/></svg>
                Back
            </a>
            <div class="flex gap-3 items-center">
                <button type="button" onclick="pwaTogglePanel()" id="floatThemeBtn" title="Theme" class="w-9 h-9 rounded-full flex items-center justify-center text-[#636366] dark:text-[#98989d] active:bg-black/[0.06] dark:active:bg-white/[0.08] transition-colors duration-200">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                </button>
                <button type="button" class="relative w-9 h-9 rounded-full flex items-center justify-center text-[#636366] dark:text-[#98989d] active:bg-black/[0.06] dark:active:bg-white/[0.08] transition-colors duration-200" data-id="{{ $product->id }}" onclick="toggleWishlist(this,{{ $product->id }})" id="detailWishBtn">
                    <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                </button>
                <a href="{{ route('pwa.cart') }}" class="relative w-9 h-9 rounded-full flex items-center justify-center text-[#636366] dark:text-[#98989d] active:bg-black/[0.06] dark:active:bg-white/[0.08] transition-colors duration-200">
                    <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                    <span id="navCartBadge" class="absolute -top-0.5 -right-0.5 bg-[#ff3b30] text-white text-[10px] font-semibold min-w-[16px] h-4 px-1 rounded-full flex items-center justify-center leading-none">{{ array_sum(array_column(session('cart', []), 'quantity')) }}</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="px-4 pt-4 pb-28">

        <!-- Product Image -->
        <div class="rounded-2xl overflow-hidden bg-white dark:bg-[#1c1e2d] mb-4 shadow-sm shadow-black/[0.04] dark:shadow-black/20">
            <img src="{{ $product->product_photo ? 'https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/' . $product->product_photo : asset('frontends/assets/img/logo.png') }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover">
        </div>

        <!-- Product Info Card -->
        <div class="rounded-2xl bg-white dark:bg-[#1c1e2d] p-5 mb-4 shadow-sm shadow-black/[0.04] dark:shadow-black/20">
            <div class="text-[11px] font-medium text-[#8e8e93] uppercase tracking-wider mb-2">{{ $product->category->name ?? '' }} {{ $product->subCategory->name ? '/ ' . $product->subCategory->name : '' }}</div>
            <h1 class="text-[19px] font-semibold text-gray-900 dark:text-white mb-2 leading-snug">{{ $product->name }}</h1>
            <div class="text-[22px] font-bold text-[#007aff] dark:text-[#60a5fa] mb-4">${{ number_format($product->price, 2) }}</div>

            <div class="text-[13px] text-[#636366] dark:text-[#98989d] leading-relaxed space-y-1">
                <div><span class="font-medium text-gray-900 dark:text-white">SKU:</span> {{ $product->number ?? 'N/A' }}</div>
                @if($product->proEngine)
                    <div><span class="font-medium text-gray-900 dark:text-white">Engine:</span> {{ $product->proEngine->name }}</div>
                    <div><span class="font-medium text-gray-900 dark:text-white">Part Number:</span> {{ $product->proEngine->part_number ?? 'N/A' }}</div>
                @endif
            </div>
        </div>

        <!-- Description Card -->
        @if($product->description)
            <div class="rounded-2xl bg-white dark:bg-[#1c1e2d] p-5 mb-4 shadow-sm shadow-black/[0.04] dark:shadow-black/20">
                <div class="text-[13px] font-semibold text-gray-900 dark:text-white mb-2">Description</div>
                <div class="text-[14px] leading-relaxed text-[#636366] dark:text-[#98989d]">{!! $product->description !!}</div>
            </div>
        @endif

        <!-- Add to Cart Button -->
        <button class="pwa-detail-btn w-full py-3.5 bg-[#007aff] hover:bg-[#0066d6] dark:bg-[#0a84ff] dark:hover:bg-[#0077ed] text-white border-none rounded-2xl text-[16px] font-semibold cursor-pointer text-center transition-colors duration-200 active:scale-[0.98]" onclick="addToCart({{ $product->id }})">Add to Cart</button>

        <!-- Related Products -->
        @if($relatedProducts->count())
            <div class="mt-6">
                <div class="text-[17px] font-semibold text-gray-900 dark:text-white mb-3">Related Products</div>
                <div class="flex gap-3 overflow-x-auto pb-2 -mx-4 px-4 snap-x snap-mandatory scrollbar-hide">
                    @foreach($relatedProducts as $rp)
                        <a href="{{ route('pwa.product', $rp->id) }}" class="snap-start flex-shrink-0 w-[140px] rounded-2xl bg-white dark:bg-[#1c1e2d] overflow-hidden shadow-sm shadow-black/[0.04] dark:shadow-black/20 active:scale-[0.97] transition-transform duration-200">
                            <img src="{{ $rp->product_photo ? 'https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/' . $rp->product_photo : asset('frontends/assets/img/logo.png') }}" alt="{{ $rp->name }}" class="w-full aspect-square object-cover">
                            <div class="p-2.5">
                                <div class="text-[12px] font-medium text-gray-900 dark:text-white truncate">{{ $rp->name }}</div>
                                <div class="text-[13px] font-bold text-[#007aff] dark:text-[#60a5fa] mt-0.5">${{ number_format($rp->price, 2) }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </main>

    <!-- Bottom Nav -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white/90 dark:bg-[#1c1e2d]/90 backdrop-blur-xl border-t border-black/[0.06] dark:border-white/[0.08] z-50" style="padding-bottom: calc(6px + env(safe-area-inset-bottom, 0));">
        <div class="flex justify-around items-center py-1.5">
            <a href="{{ route('pwa.home') }}" class="nav-pill flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium text-[#8e8e93] transition-colors duration-200">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Home</span>
            </a>
            <a href="{{ route('pwa.cart') }}" class="nav-pill flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium text-[#8e8e93] transition-colors duration-200">
                <span class="relative">
                    <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                    <span id="cartBadge" class="absolute -top-1 -right-1.5 bg-[#ff3b30] text-white text-[9px] font-semibold min-w-[14px] h-3.5 px-0.5 rounded-full flex items-center justify-center leading-none">{{ array_sum(array_column(session('cart', []), 'quantity') ) }}</span>
                </span>
                <span>Cart</span>
            </a>
            <a href="{{ route('pwa.chat') }}" class="nav-pill flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium text-[#8e8e93] transition-colors duration-200">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                <span>Chat</span>
            </a>
            <a href="{{ route('pwa.wishlist') }}" class="nav-pill flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium text-[#8e8e93] transition-colors duration-200">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                <span>Wishlist</span>
            </a>
            <a href="{{ route('pwa.account') }}" class="nav-pill flex flex-col items-center gap-0.5 px-3 py-1 text-[10px] font-medium text-[#8e8e93] transition-colors duration-200">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span>Account</span>
            </a>
        </div>
    </nav>

    <!-- Theme Panel -->
    <div class="pwa-theme-panel fixed top-[52px] right-3 bg-white dark:bg-[#1c1e2d] rounded-2xl shadow-2xl shadow-black/20 py-2 z-[199] min-w-[180px] opacity-0 -translate-y-2.5 scale-95 pointer-events-none transition-all duration-300 ease-out border border-black/[0.06] dark:border-white/[0.08]" id="themePanel" style="margin-top: env(safe-area-inset-top, 0);">
        <div class="text-[11px] font-semibold text-[#8e8e93] uppercase tracking-wider px-4 pt-2 pb-1">Appearance</div>
        <div class="flex items-center gap-2.5 px-4 py-3 text-sm font-medium cursor-pointer active:bg-black/[0.04] dark:active:bg-white/[0.06] transition-colors duration-200 rounded-lg mx-2" onclick="pwaToggleTheme()">
            <span class="w-6 text-center" id="panelThemeIcon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
            </span>
            <span id="panelThemeLabel">Dark Mode</span>
        </div>
        <div class="flex items-center gap-2.5 px-4 py-3 text-sm font-medium cursor-pointer active:bg-black/[0.04] dark:active:bg-white/[0.06] transition-colors duration-200 rounded-lg mx-2" onclick="pwaToggleBlur()">
            <span class="w-6 text-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"/><circle cx="12" cy="12" r="4"/></svg>
            </span>
            <span id="panelBlurLabel">Blur On</span>
            <div class="ml-auto w-9 h-5 rounded-full bg-[#e5e5ea] dark:bg-[#3a3a3c] relative transition-colors duration-300" id="panelBlurDot">
                <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform duration-300"></div>
            </div>
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
                    btn.innerHTML = '<svg class="w-[22px] h-[22px]" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>';
                    badges.forEach(function(b) { if (b.id !== 'cartBadge') b.textContent = parseInt(b.textContent || 0) + 1; });
                } else if (res.status === 'removed') {
                    btn.classList.remove('active');
                    btn.innerHTML = '<svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>';
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
                    btn.innerHTML = '<svg class="w-[22px] h-[22px]" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>';
                }
            })
            .catch(() => {});
        })();

        function pwaShowSuccess(msg) {
            var t = document.createElement('div');
            t.style.cssText = 'position:fixed;bottom:80px;left:50%;transform:translateX(-50%);background:#34c759;color:#fff;padding:10px 24px;border-radius:12px;font-size:14px;font-weight:500;z-index:99999;opacity:0;transition:opacity 0.3s;box-shadow:0 4px 16px rgba(52,199,89,0.3);white-space:nowrap;font-family:-apple-system,BlinkMacSystemFont,sans-serif;';
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
