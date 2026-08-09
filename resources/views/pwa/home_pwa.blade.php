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
    <title>CM Auto Service</title>
    <link rel="stylesheet" href="{{ asset('pwa/pwa.css') }}">
</head>
<body>
    <!-- Header -->
    <div class="pwa-header">
        <a href="{{ route('pwa.home') }}">
            <img src="{{ $company->company_logo ?? asset('frontends/assets/img/logo.png') }}" alt="CM Auto" class="logo">
        </a>
        <div class="pwa-header-icons">
            <button type="button" id="pwaRefreshBtn" class="pwa-refresh-btn" onclick="pwaRefreshData()" title="Refresh">&#8635;</button>
            <button type="button" class="pwa-refresh-btn" onclick="pwaTogglePanel()" id="floatThemeBtn" title="Theme">&#9881;</button>
            <a href="{{ route('pwa.wishlist') }}">
                &#9825;
                <span class="pwa-badge" id="wishBadge">{{ $wishlistCount ?? 0 }}</span>
            </a>
            <a href="{{ route('pwa.cart') }}">
                &#128722;
                <span class="pwa-badge" id="cartBadge">{{ array_sum(array_column(session('cart', []), 'quantity')) }}</span>
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="pwa-search">
        <div class="pwa-search-box">
            <svg class="pwa-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" id="pwaSearchInput" name="keyword" placeholder="Search parts, ECU, tools..." autocomplete="off">
            <button type="button" id="pwaSearchClear" class="pwa-search-clear" style="display:none;">&times;</button>
        </div>
        <div id="pwaSearchLoading" class="pwa-search-loading" style="display:none;">
            <div class="pwa-spinner" style="width:20px;height:20px;border-width:2px;margin:0 auto;"></div>
        </div>
    </div>

    <div class="pwa-content">
        <!-- Quick Actions -->
        <div class="pwa-quick">
            <a href="{{ route('pwa.cart') }}" class="pwa-quick-item">
                <div class="pwa-quick-icon blue">&#128722;</div>
                <span>Cart</span>
            </a>
            <a href="{{ route('pwa.wishlist') }}" class="pwa-quick-item">
                <div class="pwa-quick-icon red">&#9825;</div>
                <span>Wishlist</span>
            </a>
            <a href="{{ route('pwa.contact') }}" class="pwa-quick-item">
                <div class="pwa-quick-icon green">&#128222;</div>
                <span>Contact</span>
            </a>
            <a href="{{ route('pwa.account') }}" class="pwa-quick-item">
                <div class="pwa-quick-icon orange">&#128100;</div>
                <span>Account</span>
            </a>
        </div>

        <!-- Banner -->
        <div class="pwa-banner">
            <h2>CM Auto Service</h2>
            <p>ECU, Auto Parts & Online Programming</p>
            <a href="{{ route('pwa.contact') }}" class="pwa-banner-btn">Contact Us</a>
        </div>

    <!-- Tabs -->
    <div class="pwa-tabs" id="pwaTabs">
        <a href="{{ route('pwa.home') }}" class="pwa-tab active" data-url="{{ route('pwa.home') }}">All</a>
        @foreach($productType as $type)
            <a href="{{ route('pwa.search', ['type' => $type->id]) }}" class="pwa-tab" data-url="{{ route('pwa.search', ['type' => $type->id]) }}">{{ $type->name }}</a>
        @endforeach
    </div>

    <!-- Products -->
    <div class="pwa-products" id="pwaProducts">
        @include('pwa.partials.product_grid', ['products' => $products])
    </div>
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

    <!-- Bottom Navigation -->
    <div class="pwa-bottom-nav">
        <a href="{{ route('pwa.home') }}" class="pwa-nav-item active">
            <span class="nav-icon">&#127968;</span>
            <span>Home</span>
        </a>
        <a href="{{ route('pwa.cart') }}" class="pwa-nav-item">
            <span class="nav-badge">
                <span class="nav-icon">&#128722;</span>
                <span class="badge" id="navCartBadge">{{ array_sum(array_column(session('cart', []), 'quantity')) }}</span>
            </span>
            <span>Cart</span>
        </a>
        <a href="{{ route('pwa.chat') }}" class="pwa-nav-item">
            <span class="nav-icon">&#128172;</span>
            <span>Chat</span>
        </a>
        <a href="{{ route('pwa.wishlist') }}" class="pwa-nav-item">
            <span class="nav-badge">
                <span class="nav-icon">&#9825;</span>
                <span class="badge" id="navWishBadge">{{ $wishlistCount ?? 0 }}</span>
            </span>
            <span>Wishlist</span>
        </a>
        <a href="{{ route('pwa.account') }}" class="pwa-nav-item">
            <span class="nav-icon">&#128100;</span>
            <span>Account</span>
        </a>
    </div>

    <script src="{{ asset('pwa/error-handler.js') }}"></script>
    <script src="{{ asset('pwa/pwa-connectivity.js') }}"></script>
    <script src="{{ asset('pwa/pwa-theme.js') }}"></script>
    <script src="{{ asset('pwa/push-notification.js') }}"></script>
    <script src="{{ asset('pwa/pwa.js') }}"></script>
    <script>
        function pwaRefreshData() {
            var btn = document.getElementById('pwaRefreshBtn');
            if (btn) btn.classList.add('spinning');
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
        let currentTabUrl = '{{ route("pwa.home") }}';

        // Live Search - keyup
        searchInput.addEventListener('keyup', function(e) {
            currentKeyword = this.value.trim();
            searchClear.style.display = currentKeyword ? 'block' : 'none';
            clearTimeout(searchTimer);

            if (currentKeyword.length === 0) {
                searchLoading.style.display = 'none';
                searchProducts(currentTabUrl);
                return;
            }

            searchLoading.style.display = 'block';
            searchTimer = setTimeout(function() {
                searchProducts(buildSearchUrl());
            }, 400);
        });

        // Clear search
        searchClear.addEventListener('click', function() {
            searchInput.value = '';
            currentKeyword = '';
            searchClear.style.display = 'none';
            searchLoading.style.display = 'none';
            searchProducts(currentTabUrl);
        });

        // Tab click
        pwaTabs.addEventListener('click', function(e) {
            e.preventDefault();
            const tab = e.target.closest('.pwa-tab');
            if (!tab) return;
            pwaTabs.querySelectorAll('.pwa-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            currentTabUrl = tab.getAttribute('data-url');
            currentKeyword = '';
            searchInput.value = '';
            searchClear.style.display = 'none';
            searchProducts(currentTabUrl);
        });

        // Pagination click (delegated)
        document.addEventListener('click', function(e) {
            const pageLink = e.target.closest('.pwa-pagination-wrap a');
            if (pageLink) {
                e.preventDefault();
                searchProducts(pageLink.href);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        function buildSearchUrl() {
            let url = currentTabUrl;
            if (currentKeyword) {
                const separator = url.includes('?') ? '&' : '?';
                url = '{{ route("pwa.search") }}' + separator + 'keyword=' + encodeURIComponent(currentKeyword);
            }
            return url;
        }

        function searchProducts(url) {
            if (typeof pwaIsOffline === 'function' && pwaIsOffline()) {
                if (typeof pwaHandleError === 'function') pwaHandleError('You are offline. Please check your connection.');
                return;
            }
            searchLoading.style.display = 'block';
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(data => {
                    searchLoading.style.display = 'none';
                    pwaProducts.innerHTML = data.html;
                })
                .catch(() => {
                    searchLoading.style.display = 'none';
                    if (typeof pwaHandleError === 'function') pwaHandleError('Search failed. Please try again.');
                });
        }

        function pwaShowSuccess(msg) {
            var t = document.createElement('div');
            t.className = 'pwa-success-toast';
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