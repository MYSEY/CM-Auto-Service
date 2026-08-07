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
    <title>Contact — CM Auto</title>
    <link rel="stylesheet" href="{{ asset('pwa/pwa.css') }}">
    <style>
        .pwa-contact-card { padding: 20px; background: var(--card); border-radius: var(--radius); margin-bottom: 12px; box-shadow: var(--shadow); }
        .pwa-contact-item { display: flex; align-items: center; gap: 12px; padding: 14px 0; border-bottom: 1px solid var(--border); }
        .pwa-contact-item:last-child { border-bottom: none; }
        .pwa-contact-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #fff; flex-shrink: 0; }
        .pwa-contact-icon.blue { background: var(--info); }
        .pwa-contact-icon.green { background: var(--success); }
        .pwa-contact-icon.orange { background: var(--warning); }
        .pwa-contact-icon.red { background: var(--accent); }
        .pwa-contact-label { font-size: 11px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; }
        .pwa-contact-value { font-size: 14px; font-weight: 500; margin-top: 2px; }
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
        <h2 class="pwa-section-title">Contact Us</h2>
        <div class="pwa-contact-card">
            <div class="pwa-contact-item">
                <div class="pwa-contact-icon blue">&#128222;</div>
                <div>
                    <div class="pwa-contact-label">Phone</div>
                    <div class="pwa-contact-value"><a href="tel:+8550314866777">+855 031 486 6777</a></div>
                </div>
            </div>
            <div class="pwa-contact-item">
                <div class="pwa-contact-icon red">&#9993;</div>
                <div>
                    <div class="pwa-contact-label">Email</div>
                    <div class="pwa-contact-value"><a href="mailto:the.c.m.auto@gmail.com">the.c.m.auto@gmail.com</a></div>
                </div>
            </div>
            <div class="pwa-contact-item">
                <div class="pwa-contact-icon green">&#128205;</div>
                <div>
                    <div class="pwa-contact-label">Address</div>
                    <div class="pwa-contact-value">Phnom Penh, Cambodia</div>
                </div>
            </div>
            <div class="pwa-contact-item">
                <div class="pwa-contact-icon orange">&#128337;</div>
                <div>
                    <div class="pwa-contact-label">Working Hours</div>
                    <div class="pwa-contact-value">24/7 Hotline Support</div>
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
</body>
</html>
