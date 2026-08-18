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
    <title>Contact — CM Auto</title>
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
        <div class="text-[17px] font-semibold text-[#0d1b3e] dark:text-white tracking-tight">Contact Us</div>
        <div class="w-[20px]"></div>
    </div>

    <!-- Content -->
    <div class="px-4 pt-3 pb-[90px]">

        <!-- Phone -->
        <a href="tel:+8550314866777" class="flex items-center gap-3.5 p-4 mb-2.5 rounded-2xl shadow-sm shadow-black/[0.04] dark:shadow-black/20 bg-white dark:bg-[#1c1e2d] active:bg-[#e5e5ea] dark:active:bg-white/5 transition-colors duration-150">
            <div class="w-[40px] h-[40px] rounded-[10px] bg-[#34c759] flex items-center justify-center flex-shrink-0">
                <svg class="w-[20px] h-[20px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-[11px] font-medium text-[#8e8e93] dark:text-gray-400 uppercase tracking-wider">Phone</div>
                <div class="text-[15px] font-medium text-[#0d1b3e] dark:text-white mt-0.5">+855 031 486 6777</div>
            </div>
            <svg class="w-[16px] h-[16px] text-[#c7c7cc] dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        </a>

        <!-- Email -->
        <a href="mailto:the.c.m.auto@gmail.com" class="flex items-center gap-3.5 p-4 mb-2.5 rounded-2xl shadow-sm shadow-black/[0.04] dark:shadow-black/20 bg-white dark:bg-[#1c1e2d] active:bg-[#e5e5ea] dark:active:bg-white/5 transition-colors duration-150">
            <div class="w-[40px] h-[40px] rounded-[10px] bg-[#007aff] flex items-center justify-center flex-shrink-0">
                <svg class="w-[20px] h-[20px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-[11px] font-medium text-[#8e8e93] dark:text-gray-400 uppercase tracking-wider">Email</div>
                <div class="text-[15px] font-medium text-[#0d1b3e] dark:text-white mt-0.5 truncate">the.c.m.auto@gmail.com</div>
            </div>
            <svg class="w-[16px] h-[16px] text-[#c7c7cc] dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        </a>

        <!-- Address -->
        <div class="flex items-center gap-3.5 p-4 mb-2.5 rounded-2xl shadow-sm shadow-black/[0.04] dark:shadow-black/20 bg-white dark:bg-[#1c1e2d]">
            <div class="w-[40px] h-[40px] rounded-[10px] bg-[#ff9500] flex items-center justify-center flex-shrink-0">
                <svg class="w-[20px] h-[20px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-[11px] font-medium text-[#8e8e93] dark:text-gray-400 uppercase tracking-wider">Address</div>
                <div class="text-[15px] font-medium text-[#0d1b3e] dark:text-white mt-0.5">Phnom Penh, Cambodia</div>
            </div>
        </div>

        <!-- Working Hours -->
        <div class="flex items-center gap-3.5 p-4 mb-2.5 rounded-2xl shadow-sm shadow-black/[0.04] dark:shadow-black/20 bg-white dark:bg-[#1c1e2d]">
            <div class="w-[40px] h-[40px] rounded-[10px] bg-[#af52de] flex items-center justify-center flex-shrink-0">
                <svg class="w-[20px] h-[20px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-[11px] font-medium text-[#8e8e93] dark:text-gray-400 uppercase tracking-wider">Working Hours</div>
                <div class="text-[15px] font-medium text-[#0d1b3e] dark:text-white mt-0.5">24/7 Hotline Support</div>
            </div>
        </div>

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
            <a href="{{ route('pwa.wishlist') }}" class="nav-pill flex flex-col items-center gap-[2px] px-3 py-1 text-[10px] font-medium text-[#8e8e93] dark:text-gray-500">
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
</body>
</html>
