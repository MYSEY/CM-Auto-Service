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
    <title>Profile — CM Auto</title>
    <link rel="stylesheet" href="{{ asset('pwa/pwa.css') }}">
    <style>
        .pwa-profile-card { background: var(--card); border-radius: var(--radius); padding: 24px 16px; margin-bottom: 12px; box-shadow: var(--shadow); }
        .pwa-profile-avatar { width: 72px; height: 72px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 16px; }
        .pwa-profile-name { font-size: 18px; font-weight: 600; text-align: center; margin-bottom: 4px; }
        .pwa-profile-email { font-size: 13px; color: var(--text-light); text-align: center; }
        .pwa-form-group { margin-bottom: 16px; }
        .pwa-form-label { display: block; font-size: 13px; font-weight: 500; color: var(--text-light); margin-bottom: 6px; }
        .pwa-form-input { width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--radius); background: var(--bg); color: var(--text); font-size: 14px; outline: none; transition: border-color 0.2s; }
        .pwa-form-input:focus { border-color: var(--primary); }
        .pwa-form-btn { width: 100%; padding: 14px; border: none; border-radius: var(--radius); background: var(--primary); color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; transition: opacity 0.2s; }
        .pwa-form-btn:active { opacity: 0.8; }
        .pwa-form-btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .pwa-section-title { font-size: 16px; font-weight: 600; margin-bottom: 12px; color: var(--primary); padding: 0 16px; }
        .pwa-success-msg { background: #27ae60; color: #fff; padding: 10px 16px; border-radius: var(--radius); font-size: 13px; margin-bottom: 12px; display: none; }
        .pwa-error-msg { background: #e74c3c; color: #fff; padding: 10px 16px; border-radius: var(--radius); font-size: 13px; margin-bottom: 12px; display: none; }
    </style>
</head>
<body>
    <div class="pwa-header">
        <a href="{{ route('pwa.account') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;font-size:13px;color:#fff;font-weight:500;">&#8592; Back</a>
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
        <div class="pwa-profile-card">
            <div class="pwa-profile-avatar">{{ substr($user->name, 0, 1) }}</div>
            <div class="pwa-profile-name">{{ $user->name }}</div>
            <div class="pwa-profile-email">{{ $user->email }}</div>
        </div>

        <div class="pwa-success-msg" id="profileSuccess">Profile updated successfully!</div>
        <div class="pwa-error-msg" id="profileError"></div>

        <div class="pwa-section-title">Edit Profile</div>
        <div class="pwa-profile-card">
            <form id="profileForm" onsubmit="return saveProfile(event)">
                <div class="pwa-form-group">
                    <label class="pwa-form-label">Name</label>
                    <input type="text" class="pwa-form-input" id="profileName" value="{{ $user->name }}" required>
                </div>
                <div class="pwa-form-group">
                    <label class="pwa-form-label">Email</label>
                    <input type="email" class="pwa-form-input" id="profileEmail" value="{{ $user->email }}" required>
                </div>
                <button type="submit" class="pwa-form-btn" id="profileSaveBtn">Save Changes</button>
            </form>
        </div>

        <div class="pwa-section-title">Change Password</div>
        <div class="pwa-profile-card">
            <form id="passwordForm" onsubmit="return changePassword(event)">
                <div class="pwa-form-group">
                    <label class="pwa-form-label">Current Password</label>
                    <input type="password" class="pwa-form-input" id="currentPassword" required>
                </div>
                <div class="pwa-form-group">
                    <label class="pwa-form-label">New Password</label>
                    <input type="password" class="pwa-form-input" id="newPassword" required minlength="6">
                </div>
                <div class="pwa-form-group">
                    <label class="pwa-form-label">Confirm New Password</label>
                    <input type="password" class="pwa-form-input" id="confirmPassword" required minlength="6">
                </div>
                <button type="submit" class="pwa-form-btn" id="passwordSaveBtn">Change Password</button>
            </form>
        </div>

        <div style="height: 16px;"></div>
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
    <script src="{{ asset('pwa/push-notification.js') }}"></script>
    <script src="{{ asset('pwa/pwa.js') }}"></script>
    <script>
        function showMsg(id, msg) {
            var el = document.getElementById(id);
            el.textContent = msg;
            el.style.display = 'block';
            setTimeout(function() { el.style.display = 'none'; }, 3000);
        }

        function saveProfile(e) {
            e.preventDefault();
            var btn = document.getElementById('profileSaveBtn');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            fetch('{{ route("pwa.profile.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'name=' + encodeURIComponent(document.getElementById('profileName').value) +
                      '&email=' + encodeURIComponent(document.getElementById('profileEmail').value)
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Save Changes';
                if (res.status === 'success') {
                    showMsg('profileSuccess', 'Profile updated successfully!');
                    document.querySelector('.pwa-profile-name').textContent = document.getElementById('profileName').value;
                    document.querySelector('.pwa-profile-email').textContent = document.getElementById('profileEmail').value;
                    document.querySelector('.pwa-profile-avatar').textContent = document.getElementById('profileName').value.charAt(0).toUpperCase();
                } else {
                    showMsg('profileError', res.message || 'Failed to update profile.');
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.textContent = 'Save Changes';
                showMsg('profileError', 'Network error. Please try again.');
            });
            return false;
        }

        function changePassword(e) {
            e.preventDefault();
            var newPass = document.getElementById('newPassword').value;
            var confirmPass = document.getElementById('confirmPassword').value;

            if (newPass !== confirmPass) {
                showMsg('profileError', 'New passwords do not match.');
                return false;
            }

            var btn = document.getElementById('passwordSaveBtn');
            btn.disabled = true;
            btn.textContent = 'Changing...';

            fetch('{{ route("pwa.profile.password") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'current_password=' + encodeURIComponent(document.getElementById('currentPassword').value) +
                      '&new_password=' + encodeURIComponent(newPass)
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.textContent = 'Change Password';
                if (res.status === 'success') {
                    showMsg('profileSuccess', 'Password changed successfully!');
                    document.getElementById('passwordForm').reset();
                } else {
                    showMsg('profileError', res.message || 'Failed to change password.');
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.textContent = 'Change Password';
                showMsg('profileError', 'Network error. Please try again.');
            });
            return false;
        }
    </script>
</body>
</html>
