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
    <title>Account — CM Auto</title>
    <link rel="stylesheet" href="{{ asset('pwa/pwa.css') }}">
    <style>
        .pwa-account-header { text-align: center; padding: 24px 16px; background: var(--card); border-radius: var(--radius); margin-bottom: 12px; box-shadow: var(--shadow); }
        .pwa-account-avatar { width: 64px; height: 64px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 12px; }
        .pwa-account-name { font-size: 18px; font-weight: 600; }
        .pwa-account-email { font-size: 13px; color: var(--text-light); margin-top: 4px; }
        .pwa-account-menu { background: var(--card); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); }
        .pwa-account-item { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border-bottom: 1px solid var(--border); font-size: 14px; cursor: pointer; }
        .pwa-account-item:last-child { border-bottom: none; }
        .pwa-account-item:active { background: var(--bg); }
        .pwa-account-item-icon { font-size: 18px; width: 24px; text-align: center; }
        .pwa-account-item-arrow { margin-left: auto; color: var(--text-light); }
        .pwa-section-title { font-size: 16px; font-weight: 600; margin-bottom: 12px; color: var(--primary); padding: 0 16px; }
    </style>
</head>
<body>
    <div class="pwa-header">
        <a href="{{ route('pwa.home') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;font-size:13px;color:#fff;font-weight:500;">&#8592; Back</a>
        <div class="pwa-header-icons">
            <button type="button" class="pwa-refresh-btn" onclick="pwaTogglePanel()" id="floatThemeBtn" title="Theme">&#9881;</button>
            <button type="button" class="pwa-refresh-btn" onclick="location.reload()" title="Refresh">&#8635;</button>
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
        <div class="pwa-account-header">
            <div class="pwa-account-avatar">{{ substr($user->name, 0, 1) }}</div>
            <div class="pwa-account-name">{{ $user->name }}</div>
            <div class="pwa-account-email">{{ $user->email }}</div>
        </div>

        <div class="pwa-account-menu">
            <a href="{{ route('pwa.profile') }}" class="pwa-account-item">
                <span class="pwa-account-item-icon">&#128100;</span>
                <span>Profile</span>
                <span class="pwa-account-item-arrow">&#8250;</span>
            </a>
            <a href="{{ route('pwa.wishlist') }}" class="pwa-account-item">
                <span class="pwa-account-item-icon">&#9825;</span>
                <span>Wishlist</span>
                <span class="pwa-account-item-arrow">&#8250;</span>
            </a>
            <a href="{{ route('pwa.contact') }}" class="pwa-account-item">
                <span class="pwa-account-item-icon">&#128222;</span>
                <span>Support</span>
                <span class="pwa-account-item-arrow">&#8250;</span>
            </a>
            <div class="pwa-account-item" onclick="togglePushNotification()" id="pushToggleItem">
                <span class="pwa-account-item-icon">&#128276;</span>
                <span>Push Notifications</span>
                <span class="push-toggle-label" id="pushStatusLabel">Off</span>
            </div>
        </div>

        <div class="pwa-theme-section">
            <div class="pwa-theme-title">Appearance</div>
            <div class="pwa-theme-card">
                <div class="pwa-theme-item" id="themeToggle" onclick="pwaToggleTheme()">
                    <div class="pwa-theme-left">
                        <span class="pwa-theme-icon theme-icon">&#9790;</span>
                        <span class="pwa-theme-label">Dark Mode</span>
                    </div>
                    <div class="pwa-theme-right">
                        <span class="pwa-theme-arrow">&#8250;</span>
                    </div>
                </div>
                <div class="pwa-theme-item" id="blurToggle" onclick="pwaToggleBlur()">
                    <div class="pwa-theme-left">
                        <span class="pwa-theme-icon">&#128171;</span>
                        <span class="pwa-theme-label">Blur On</span>
                    </div>
                    <div class="pwa-theme-right">
                        <div class="blur-dot"></div>
                    </div>
                </div>
            </div>
        </div>
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
        <a href="{{ route('pwa.account') }}" class="pwa-nav-item active">
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
    <script src="{{ asset('pwa/push-notification.js') }}"></script>
    <script src="{{ asset('pwa/pwa.js') }}"></script>
    <script>
        function togglePushNotification() {
            if (PushNotification.isSubscribed()) {
                PushNotification.unsubscribe().then(function() {
                    document.getElementById('pushStatusLabel').textContent = 'Off';
                });
            } else {
                PushNotification.subscribe().then(function(success) {
                    if (success) {
                        document.getElementById('pushStatusLabel').textContent = 'On';
                    }
                });
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            PushNotification.isSubscribed().then(function(subscribed) {
                document.getElementById('pushStatusLabel').textContent = subscribed ? 'On' : 'Off';
            });
        });
    </script>
</body>
</html>
