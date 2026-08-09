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
    <title>Login — CM Auto</title>
    <link rel="stylesheet" href="{{ asset('pwa/pwa.css') }}">
    <style>
        .pwa-login-card { background: var(--card); border-radius: var(--radius); padding: 32px 20px; margin-top: 40px; box-shadow: var(--shadow); text-align: center; }
        .pwa-login-logo { width: 72px; height: 72px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px; }
        .pwa-login-title { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .pwa-login-subtitle { font-size: 13px; color: var(--text-light); margin-bottom: 24px; }
        .pwa-form-group { margin-bottom: 16px; text-align: left; }
        .pwa-form-label { display: block; font-size: 13px; font-weight: 500; color: var(--text-light); margin-bottom: 6px; }
        .pwa-form-input { width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--radius); background: var(--bg); color: var(--text); font-size: 14px; outline: none; transition: border-color 0.2s; box-sizing: border-box; }
        .pwa-form-input:focus { border-color: var(--primary); }
        .pwa-form-btn { width: 100%; padding: 14px; border: none; border-radius: var(--radius); background: var(--primary); color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; transition: opacity 0.2s; }
        .pwa-form-btn:active { opacity: 0.8; }
        .pwa-form-btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .pwa-error-msg { background: #e74c3c; color: #fff; padding: 10px 16px; border-radius: var(--radius); font-size: 13px; margin-bottom: 16px; display: none; }
        .pwa-login-footer { margin-top: 20px; font-size: 13px; color: var(--text-light); }
        .pwa-login-footer a { color: var(--primary); text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>
    <div class="pwa-header">
        <a href="{{ route('pwa.account') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;font-size:13px;color:#fff;font-weight:500;">&#8592; Back</a>
        <div class="pwa-header-icons">
            <button type="button" class="pwa-refresh-btn" onclick="pwaTogglePanel()" id="floatThemeBtn" title="Theme">&#9881;</button>
            <button type="button" class="pwa-refresh-btn" onclick="location.reload()" title="Refresh">&#8635;</button>
        </div>
    </div>

    <div class="pwa-content" style="padding: 16px;">
        <div class="pwa-login-card">
            <div class="pwa-login-logo">&#128100;</div>
            <div class="pwa-login-title">Welcome Back</div>
            <div class="pwa-login-subtitle">Login to your account</div>

            <div class="pwa-error-msg" id="loginError"></div>

            <form id="loginForm" onsubmit="return doLogin(event)">
                <div class="pwa-form-group">
                    <label class="pwa-form-label">Email</label>
                    <input type="email" class="pwa-form-input" id="loginEmail" placeholder="Enter your email" required autocomplete="email">
                </div>
                <div class="pwa-form-group">
                    <label class="pwa-form-label">Password</label>
                    <input type="password" class="pwa-form-input" id="loginPassword" placeholder="Enter your password" required autocomplete="current-password">
                </div>
                <button type="submit" class="pwa-form-btn" id="loginBtn">Login</button>
            </form>

            <div class="pwa-login-footer">
                <a href="{{ route('pwa.contact') }}">Need help? Contact us</a>
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
    <script src="{{ asset('pwa/pwa.js') }}"></script>
    <script>
        function doLogin(e) {
            e.preventDefault();
            var btn = document.getElementById('loginBtn');
            var errorEl = document.getElementById('loginError');
            errorEl.style.display = 'none';
            btn.disabled = true;
            btn.textContent = 'Logging in...';

            fetch('{{ route("pwa.login.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'email=' + encodeURIComponent(document.getElementById('loginEmail').value) +
                      '&password=' + encodeURIComponent(document.getElementById('loginPassword').value)
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Login';
                if (res.status === 'success') {
                    window.location.href = res.redirect || '{{ route("pwa.account") }}';
                } else {
                    errorEl.textContent = res.message || 'Login failed. Please try again.';
                    errorEl.style.display = 'block';
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.textContent = 'Login';
                errorEl.textContent = 'Network error. Please try again.';
                errorEl.style.display = 'block';
            });
            return false;
        }
    </script>
</body>
</html>
