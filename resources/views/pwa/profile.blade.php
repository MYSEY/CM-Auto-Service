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
    <link rel="apple-touch-icon" href="{{ asset('frontends/assets/img/logo.png') }}">
    <title>Profile — CM Auto</title>
    <link rel="stylesheet" href="{{ asset('build/pwa.css') }}?v={{ filemtime(public_path('build/pwa.css')) }}">
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
        .ios-input {
            width: 100%; padding: 12px 14px; border: 1px solid #e5e5ea; border-radius: 12px;
            background: #f2f2f7; color: #1c1c1e; font-size: 15px; outline: none;
            transition: border-color 0.2s;
        }
        .dark .ios-input { border-color: #3a3a3c; background: rgba(255,255,255,0.06); color: #f2f2f7; }
        .ios-input:focus { border-color: #007aff; }
        .dark .ios-input:focus { border-color: #0a84ff; }
    </style>
</head>
<body class="bg-[#f2f2f7] dark:bg-[#0f1123] text-gray-900 dark:text-gray-200 font-sans antialiased">

    <!-- iOS Header -->
    <header class="ios-header sticky top-0 z-50 border-b border-black/[0.06] dark:border-white/[0.08]" style="padding-top: env(safe-area-inset-top, 0);">
        <div class="px-4 py-3 flex items-center justify-between">
            <a href="{{ route('pwa.account') }}" class="inline-flex items-center gap-1 text-[15px] font-medium text-[#0d1b3e] dark:text-blue-400">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2"><path d="M15 19l-7-7 7-7"/></svg>
                Back
            </a>
            <div class="flex gap-3 items-center">
                <button type="button" onclick="pwaTogglePanel()" id="floatThemeBtn" title="Theme" class="w-9 h-9 rounded-full flex items-center justify-center text-[#636366] dark:text-[#98989d] active:bg-black/[0.06] dark:active:bg-white/[0.08] transition-colors duration-200">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                </button>
                <button type="button" onclick="location.reload()" title="Refresh" class="w-9 h-9 rounded-full flex items-center justify-center text-[#636366] dark:text-[#98989d] active:bg-black/[0.06] dark:active:bg-white/[0.08] transition-colors duration-200">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M23 4v6h-6"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/></svg>
                </button>
                <a href="{{ route('pwa.cart') }}" class="relative w-9 h-9 rounded-full flex items-center justify-center text-[#636366] dark:text-[#98989d] active:bg-black/[0.06] dark:active:bg-white/[0.08] transition-colors duration-200">
                    <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                    <span class="absolute -top-0.5 -right-0.5 bg-[#ff3b30] text-white text-[10px] font-semibold min-w-[16px] h-4 px-1 rounded-full flex items-center justify-center leading-none">{{ array_sum(array_column(session('cart', []), 'quantity')) }}</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="px-4 pt-4 pb-28">

        <!-- Profile Card -->
        <div class="rounded-2xl bg-white dark:bg-[#1c1e2d] p-6 mb-4 shadow-sm shadow-black/[0.04] dark:shadow-black/20 text-center">
            <div class="pwa-profile-avatar w-[72px] h-[72px] rounded-full bg-[#007aff] dark:bg-[#0a84ff] text-white flex items-center justify-center text-[28px] font-semibold mx-auto mb-3">{{ substr($user->name, 0, 1) }}</div>
            <div class="text-[17px] font-semibold text-gray-900 dark:text-white mb-0.5 pwa-profile-name">{{ $user->name }}</div>
            <div class="text-[13px] text-[#8e8e93] pwa-profile-email">{{ $user->email }}</div>
        </div>

        <!-- Messages -->
        <div class="bg-[#34c759] text-white px-4 py-2.5 rounded-2xl text-[14px] mb-4 hidden shadow-sm shadow-[#34c759]/30" id="profileSuccess">Profile updated successfully!</div>
        <div class="bg-[#ff3b30] text-white px-4 py-2.5 rounded-2xl text-[14px] mb-4 hidden shadow-sm shadow-[#ff3b30]/30" id="profileError"></div>

        <!-- Edit Profile Section -->
        <div class="mb-4">
            <div class="text-[13px] font-medium text-[#8e8e93] uppercase tracking-wider px-1 mb-2">Edit Profile</div>
            <div class="rounded-2xl bg-white dark:bg-[#1c1e2d] p-5 shadow-sm shadow-black/[0.04] dark:shadow-black/20">
                <form id="profileForm" onsubmit="return saveProfile(event)">
                    <div class="mb-4">
                        <label class="block text-[13px] font-medium text-[#8e8e93] mb-1.5">Name</label>
                        <input type="text" class="ios-input" id="profileName" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-[13px] font-medium text-[#8e8e93] mb-1.5">Email</label>
                        <input type="email" class="ios-input" id="profileEmail" value="{{ $user->email }}" required>
                    </div>
                    <button type="submit" class="w-full py-3.5 border-none rounded-2xl bg-[#007aff] hover:bg-[#0066d6] dark:bg-[#0a84ff] dark:hover:bg-[#0077ed] text-white text-[16px] font-semibold cursor-pointer transition-colors duration-200 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed" id="profileSaveBtn">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- Change Password Section -->
        <div class="mb-4">
            <div class="text-[13px] font-medium text-[#8e8e93] uppercase tracking-wider px-1 mb-2">Change Password</div>
            <div class="rounded-2xl bg-white dark:bg-[#1c1e2d] p-5 shadow-sm shadow-black/[0.04] dark:shadow-black/20">
                <form id="passwordForm" onsubmit="return changePassword(event)">
                    <div class="mb-4">
                        <label class="block text-[13px] font-medium text-[#8e8e93] mb-1.5">Current Password</label>
                        <input type="password" class="ios-input" id="currentPassword" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-[13px] font-medium text-[#8e8e93] mb-1.5">New Password</label>
                        <input type="password" class="ios-input" id="newPassword" required minlength="6">
                    </div>
                    <div class="mb-4">
                        <label class="block text-[13px] font-medium text-[#8e8e93] mb-1.5">Confirm New Password</label>
                        <input type="password" class="ios-input" id="confirmPassword" required minlength="6">
                    </div>
                    <button type="submit" class="w-full py-3.5 border-none rounded-2xl bg-[#007aff] hover:bg-[#0066d6] dark:bg-[#0a84ff] dark:hover:bg-[#0077ed] text-white text-[16px] font-semibold cursor-pointer transition-colors duration-200 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed" id="passwordSaveBtn">Change Password</button>
                </form>
            </div>
        </div>
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
                    <span class="absolute -top-1 -right-1.5 bg-[#ff3b30] text-white text-[9px] font-semibold min-w-[14px] h-3.5 px-0.5 rounded-full flex items-center justify-center leading-none">{{ array_sum(array_column(session('cart', []), 'quantity')) }}</span>
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
