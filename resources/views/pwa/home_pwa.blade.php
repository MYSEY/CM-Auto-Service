<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#0d1b3e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="CM Auto">
    <link rel="manifest" href="{{ asset('pwa/manifest.json') }}">
    {{-- <link rel="apple-touch-icon" href="{{ asset('frontends/assets/img/logo.png') }}"> --}}
    <link rel="apple-touch-icon" href="{{ asset('frontends/assets/img/favicon.png') }}">
    <title>CM Auto Service</title>
    <link rel="stylesheet" href="{{ asset('build/pwa.css') }}?v={{ file_exists(public_path('build/pwa.css')) ? filemtime(public_path('build/pwa.css')) : '1.0' }}">
    <style>
        *, *::before, *::after {
            -webkit-tap-highlight-color: transparent;
        }
        .ios-header {
            background: linear-gradient(135deg, #0f2444 0%, #1b3a6b 50%, #2d5aa0 100%);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
        }
        .dark .ios-header {
            background: linear-gradient(135deg, #0a0e1a 0%, #0f1123 50%, #151829 100%);
        }
        .nav-pill {
            position: relative;
        }
        .nav-pill.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 2px;
            border-radius: 1px;
            background: #0d1b3e;
        }
        .dark .nav-pill.active::before {
            background: #60a5fa;
        }
        .ios-search-container {
            background: linear-gradient(135deg, #0f2444 0%, #1b3a6b 50%, #2d5aa0 100%);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
        }
        .dark .ios-search-container {
            background: linear-gradient(135deg, #0a0e1a 0%, #0f1123 50%, #151829 100%);
        }
        .ios-bottom-nav {
            background: rgba(255,255,255,0.90);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .dark .ios-bottom-nav {
            background: rgba(28,30,45,0.90);
        }
        .ios-quick-action {
            transition: transform 0.15s ease;
        }
        .ios-quick-action:active {
            transform: scale(0.93);
        }
        .ios-card {
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
        }
        .dark .ios-card {
            box-shadow: 0 1px 3px rgba(0,0,0,0.2), 0 1px 2px rgba(0,0,0,0.15);
        }
        .ios-tab-item {
            position: relative;
            transition: color 0.2s ease;
        }
        .ios-tab-item::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            border-radius: 1px;
            background: transparent;
            transition: background 0.2s ease;
        }
        .ios-tab-item.active::after {
            background: #0d1b3e;
        }
        .dark .ios-tab-item.active::after {
            background: #60a5fa;
        }
        .ios-theme-panel {
            background: rgba(255,255,255,0.96);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
        }
        .dark .ios-theme-panel {
            background: rgba(28,30,45,0.96);
        }
        .ios-theme-panel.show, .pwa-theme-panel.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }
        .ios-toggle-track {
            transition: background-color 0.3s ease;
        }
        .ios-toggle-thumb {
            transition: transform 0.3s ease;
        }
        @keyframes ios-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .ios-spinning {
            animation: ios-spin 0.8s linear infinite;
        }

    </style>
</head>
<body class="bg-[#f2f2f7] dark:bg-[#0f1123] text-gray-900 dark:text-gray-200 font-sans antialiased">

    <!-- iOS Header -->
    <header class="ios-header sticky top-0 z-50 border-b border-white/10" style="padding-top: env(safe-area-inset-top, 0);">
        <div class="flex items-center justify-between px-4 py-3">
            <a href="{{ route('pwa.home') }}" class="flex items-center gap-2">
                <img src="{{ $company->company_logo ?? asset('frontends/assets/img/logo.png') }}" alt="CM Auto" class="h-8">
            </a>
            <div class="flex items-center gap-1">
                <button type="button" id="pwaRefreshBtn" onclick="pwaRefreshData()" title="Refresh"
                    class="w-9 h-9 flex items-center justify-center rounded-full text-white active:bg-white/10 transition-colors">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"/>
                        <polyline points="1 20 1 14 7 14"/>
                        <path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>
                    </svg>
                </button>
                <button type="button" onclick="pwaTogglePanel()" id="floatThemeBtn" title="Theme"
                    class="w-9 h-9 flex items-center justify-center rounded-full text-white active:bg-white/10 transition-colors">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
                    </svg>
                </button>
                <a href="{{ route('pwa.wishlist') }}" class="w-9 h-9 flex items-center justify-center rounded-full text-white active:bg-white/10 transition-colors relative">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] font-semibold px-1 py-0 rounded-full min-w-[15px] text-center leading-[15px]" id="wishBadge">{{ $wishlistCount ?? 0 }}</span>
                </a>
                <a href="{{ route('pwa.cart') }}" class="w-9 h-9 flex items-center justify-center rounded-full text-white active:bg-white/10 transition-colors relative">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] font-semibold px-1 py-0 rounded-full min-w-[15px] text-center leading-[15px]" id="cartBadge">{{ array_sum(array_column(session('cart', []), 'quantity')) }}</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Search Bar -->
    <div class="ios-search-container sticky top-[52px] z-40 px-4 py-2.5 border-b border-white/10" style="top: calc(52px + env(safe-area-inset-top, 0));">
        <div class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl bg-white/15 border border-white/20 focus-within:bg-white/25 focus-within:border-white/30 focus-within:shadow-sm transition-all duration-200">
            <svg class="flex-shrink-0 text-white/60 w-[17px] h-[17px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="pwaSearchInput" name="keyword" placeholder="Search parts, ECU, tools..." autocomplete="off"
                class="flex-1 bg-transparent border-none outline-none text-[15px] text-white placeholder-white/50">
            <button type="button" id="pwaSearchClear"
                class="hidden flex-shrink-0 w-[18px] h-[18px] rounded-full bg-white/30 text-white text-[11px] leading-[18px] text-center cursor-pointer p-0 border-none">&times;</button>
        </div>
        <div id="pwaSearchLoading" class="hidden pt-2">
            <div class="w-5 h-5 border-2 border-white/20 border-t-white rounded-full animate-spin mx-auto"></div>
        </div>
    </div>

    <!-- Content -->
    <div class="pwa-content pb-[90px]">

        <!-- Quick Actions -->
        <div class="px-4 pt-4 pb-2">
            <div class="grid grid-cols-4 gap-2.5">
                <a href="{{ route('pwa.cart') }}" class="ios-quick-action flex flex-col items-center gap-2 py-3 px-1">
                    <div class="w-12 h-12 rounded-2xl ios-quick-icon-cart flex items-center justify-center shadow-sm shadow-blue-500/25">
                        <svg class="w-[20px] h-[20px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-medium text-gray-700 dark:text-gray-300">Cart</span>
                </a>
                <a href="{{ route('pwa.wishlist') }}" class="ios-quick-action flex flex-col items-center gap-2 py-3 px-1">
                    <div class="w-12 h-12 rounded-2xl ios-quick-icon-wishlist flex items-center justify-center shadow-sm shadow-rose-500/25">
                        <svg class="w-[20px] h-[20px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-medium text-gray-700 dark:text-gray-300">Wishlist</span>
                </a>
                <a href="{{ route('pwa.contact') }}" class="ios-quick-action flex flex-col items-center gap-2 py-3 px-1">
                    <div class="w-12 h-12 rounded-2xl ios-quick-icon-contact flex items-center justify-center shadow-sm shadow-emerald-500/25">
                        <svg class="w-[20px] h-[20px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-medium text-gray-700 dark:text-gray-300">Contact</span>
                </a>
                <a href="{{ route('pwa.account') }}" class="ios-quick-action flex flex-col items-center gap-2 py-3 px-1">
                    <div class="w-12 h-12 rounded-2xl ios-quick-icon-account flex items-center justify-center shadow-sm shadow-amber-500/25">
                        <svg class="w-[20px] h-[20px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-medium text-gray-700 dark:text-gray-300">Account</span>
                </a>
            </div>
        </div>

        <!-- Banner -->
        <div class="px-4 py-2">
            <div class="ios-card ios-banner-card overflow-hidden text-white p-5 relative">
                <div class="absolute -top-12 -right-12 w-40 h-40 bg-white/[0.06] rounded-full"></div>
                <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-white/[0.04] rounded-full"></div>
                <div class="relative z-10">
                    <h2 class="text-[17px] font-semibold mb-1 text-white">CM Auto Service</h2>
                    <p class="text-[13px] text-white/80 mb-3.5">ECU, Auto Parts & Online Programming</p>
                    <a href="{{ route('pwa.contact') }}"
                        class="ios-banner-btn inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-[13px] font-semibold active:opacity-90 transition-opacity">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>

        <!-- Service Video -->
        <div class="px-4 py-2">
            <div class="ios-card overflow-hidden bg-white dark:bg-[#1c1e2d] border border-gray-200/60 dark:border-white/[0.06]">
                <div class="flex items-center justify-between px-4 pt-3.5 pb-2">
                    <h3 class="text-[15px] font-semibold text-[#0d1b3e] dark:text-white">Our Services</h3>
                    <span class="text-[11px] text-[#8e8e93] dark:text-gray-500 font-medium">Watch</span>
                </div>
                <div class="relative mx-3 mb-3 rounded-xl overflow-hidden bg-black aspect-square" id="videoWrapper">
                    <video id="pwaServiceVideo"
                        class="w-full h-full object-cover"
                        playsinline webkit-playsinline preload="metadata"
                        autoplay muted loop
                        controls
                        poster="https://cdn.cmautoservic.com/CM_Thumnail.png">
                        <source src="https://cdn.cmautoservic.com/CM_Final_For_Fackbook.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="px-4 pt-2">
            <div class="ios-card bg-white dark:bg-white/[0.05] border border-gray-200/60 dark:border-white/[0.06] px-1 py-1 overflow-x-auto no-scrollbar" id="pwaTabs">
                <div class="flex gap-0.5 min-w-max">
                    <a href="{{ route('pwa.search') }}"
                        class="ios-tab-item active px-4 py-2 text-[13px] font-medium rounded-lg text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-white/[0.08] whitespace-nowrap transition-all duration-200"
                        data-url="{{ route('pwa.search') }}">All</a>
                    @foreach($productType as $type)
                        <a href="{{ route('pwa.search', ['type' => $type->id]) }}"
                            class="ios-tab-item px-4 py-2 text-[13px] font-medium rounded-lg text-gray-500 dark:text-gray-400 whitespace-nowrap transition-all duration-200"
                            data-url="{{ route('pwa.search', ['type' => $type->id]) }}">{{ $type->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="px-4 py-3" id="pwaProducts">
            @include('pwa.partials.product_grid', ['products' => $products])
        </div>
    </div>

    <!-- Theme Panel -->
    <div class="ios-theme-panel fixed top-[60px] right-3 rounded-2xl shadow-2xl shadow-black/20 py-1.5 z-[199] min-w-[190px] opacity-0 -translate-y-2.5 scale-95 pointer-events-none transition-all duration-300 ease-out border border-gray-200/60 dark:border-white/[0.08]"
        id="themePanel" style="top: calc(60px + env(safe-area-inset-top, 0));">
        <div class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider px-4 pt-2 pb-1.5">Appearance</div>
        <div class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium cursor-pointer active:bg-gray-100 dark:active:bg-white/5 transition-colors duration-200 rounded-lg mx-1" onclick="pwaToggleTheme()">
            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" id="panelThemeIcon">
                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
            </svg>
            <span id="panelThemeLabel">Dark Mode</span>
        </div>
        <div class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium cursor-pointer active:bg-gray-100 dark:active:bg-white/5 transition-colors duration-200 rounded-lg mx-1" onclick="pwaToggleBlur()">
            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"/>
                <circle cx="12" cy="12" r="4"/>
            </svg>
            <span id="panelBlurLabel">Blur On</span>
            <div class="ml-auto w-10 h-[22px] rounded-full bg-gray-300 dark:bg-gray-600 relative transition-colors duration-300 ios-toggle-track" id="panelBlurDot">
                <div class="absolute top-[2px] left-[2px] w-[18px] h-[18px] rounded-full bg-white shadow-sm transition-transform duration-300 ios-toggle-thumb"></div>
            </div>
        </div>
    </div>

    @include('pwa.partials.footer_nav', ['activeTab' => 'home'])

    <script src="{{ asset('pwa/error-handler.js') }}"></script>
    <script src="{{ asset('pwa/pwa-connectivity.js') }}"></script>
    <script src="{{ asset('pwa/pwa-theme.js') }}"></script>
    <script src="{{ asset('pwa/push-notification.js') }}"></script>
    <script src="{{ asset('pwa/pwa.js') }}"></script>
    <script>
        function pwaRefreshData() {
            var btn = document.getElementById('pwaRefreshBtn');
            if (btn) {
                var svg = btn.querySelector('svg');
                if (svg) svg.classList.add('ios-spinning');
            }
            location.reload();
        }

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
                var wishBadge = document.getElementById('wishBadge');
                var navWishBadge = document.getElementById('navWishBadge');
                if (res.status === 'added') {
                    btn.classList.add('active');
                    btn.innerHTML = '&#10084;';
                    if (wishBadge) wishBadge.textContent = parseInt(wishBadge.textContent || 0) + 1;
                    if (navWishBadge) navWishBadge.textContent = parseInt(navWishBadge.textContent || 0) + 1;
                } else if (res.status === 'removed') {
                    btn.classList.remove('active');
                    btn.innerHTML = '&#9825;';
                    if (wishBadge) wishBadge.textContent = Math.max(0, parseInt(wishBadge.textContent || 0) - 1);
                    if (navWishBadge) navWishBadge.textContent = Math.max(0, parseInt(navWishBadge.textContent || 0) - 1);
                }
            })
            .catch(() => {
                if (typeof pwaHandleError === 'function') pwaHandleError('Failed to update wishlist.');
            });
        }

        function checkWishlist() {
            document.querySelectorAll('.pwa-wishlist-btn').forEach(function(btn) {
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
            });
        }
        checkWishlist();

        const searchInput = document.getElementById('pwaSearchInput');
        const searchClear = document.getElementById('pwaSearchClear');
        const searchLoading = document.getElementById('pwaSearchLoading');
        const pwaProducts = document.getElementById('pwaProducts');
        const pwaTabs = document.getElementById('pwaTabs');
        let searchTimer = null;
        let currentKeyword = '';
        let currentTabUrl = '{{ route("pwa.search") }}';

        function handleSearchInput() {
            currentKeyword = searchInput.value.trim();
            searchClear.style.display = currentKeyword ? 'flex' : 'none';
            clearTimeout(searchTimer);

            if (currentKeyword.length === 0) {
                searchLoading.style.display = 'none';
                searchProducts(buildSearchUrl());
                return;
            }

            searchLoading.style.display = 'block';
            searchTimer = setTimeout(function() {
                searchProducts(buildSearchUrl());
            }, 350);
        }

        if (searchInput) {
            searchInput.addEventListener('input', handleSearchInput);
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    handleSearchInput();
                }
            });
        }

        if (searchClear) {
            searchClear.addEventListener('click', function() {
                searchInput.value = '';
                currentKeyword = '';
                searchClear.style.display = 'none';
                searchLoading.style.display = 'none';
                searchProducts(buildSearchUrl());
            });
        }

        if (pwaTabs) {
            pwaTabs.addEventListener('click', function(e) {
                e.preventDefault();
                const tab = e.target.closest('.ios-tab-item');
                if (!tab) return;
                pwaTabs.querySelectorAll('.ios-tab-item').forEach(function(t) {
                    t.classList.remove('active');
                    t.classList.remove('bg-gray-100', 'dark:bg-white/[0.08]');
                    t.classList.add('text-gray-500', 'dark:text-gray-400');
                });
                tab.classList.add('active');
                tab.classList.add('bg-gray-100', 'dark:bg-white/[0.08]');
                tab.classList.remove('text-gray-500', 'dark:text-gray-400');
                tab.classList.add('text-gray-900', 'dark:text-gray-100');
                currentTabUrl = tab.getAttribute('data-url');
                currentKeyword = searchInput ? searchInput.value.trim() : '';
                searchProducts(buildSearchUrl());
            });
        }

        document.addEventListener('click', function(e) {
            const pageLink = e.target.closest('.pwa-pagination-wrap a');
            if (pageLink) {
                e.preventDefault();
                searchProducts(pageLink.href);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        function buildSearchUrl() {
            try {
                let base = currentTabUrl || '{{ route("pwa.search") }}';
                let urlObj = new URL(base, window.location.origin);
                if (currentKeyword) {
                    urlObj.searchParams.set('keyword', currentKeyword);
                } else {
                    urlObj.searchParams.delete('keyword');
                }
                urlObj.searchParams.delete('page');
                return urlObj.toString();
            } catch(e) {
                let separator = currentTabUrl.includes('?') ? '&' : '?';
                return currentKeyword ? currentTabUrl + separator + 'keyword=' + encodeURIComponent(currentKeyword) : currentTabUrl;
            }
        }

        function searchProducts(url) {
            if (typeof pwaIsOffline === 'function' && pwaIsOffline()) {
                if (typeof pwaHandleError === 'function') pwaHandleError('You are offline. Please check your connection.');
                return;
            }
            if (searchLoading) searchLoading.style.display = 'block';
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(r => {
                if (!r.ok) throw new Error('HTTP error ' + r.status);
                return r.json();
            })
            .then(data => {
                if (searchLoading) searchLoading.style.display = 'none';
                if (pwaProducts && data && data.html) {
                    pwaProducts.innerHTML = data.html;
                    if (typeof checkWishlist === 'function') checkWishlist();
                }
            })
            .catch(err => {
                if (searchLoading) searchLoading.style.display = 'none';
                console.error('PWA Search Error:', err);
                if (typeof pwaHandleError === 'function') pwaHandleError('Search failed. Please try again.');
            });
        }

        function pwaShowSuccess(msg) {
            var t = document.createElement('div');
            t.style.cssText = 'position:fixed;bottom:90px;left:50%;transform:translateX(-50%);background:#34c759;color:#fff;padding:10px 24px;border-radius:14px;font-size:13px;font-weight:500;z-index:99999;opacity:0;transition:opacity 0.3s;box-shadow:0 4px 16px rgba(52,199,89,0.3);white-space:nowrap;backdrop-filter:blur(10px);';
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
            var btn = document.querySelector('.pwa-add-cart[onclick*="addToCart(' + id + ')"]');
            if (btn) { btn.textContent = 'Adding...'; btn.disabled = true; }
            fetch('{{ route("pwa.cart.add") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: 'id=' + id
            })
            .then(r => r.json())
            .then(res => {
                if (btn) { btn.textContent = 'Added ✓'; }
                if (res.status === 'success') {
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
                if (res.status === 'success') {
                    document.getElementById('cartBadge').textContent = res.count;
                    document.getElementById('navCartBadge').textContent = res.count;
                    location.reload();
                }
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
                if (res.status === 'success') {
                    document.getElementById('cartBadge').textContent = res.count;
                    document.getElementById('navCartBadge').textContent = res.count;
                    location.reload();
                }
            })
            .catch(() => {
                if (typeof pwaHandleError === 'function') pwaHandleError('Failed to remove item. Please try again.');
            });
        }
    </script>
</body>
</html>
