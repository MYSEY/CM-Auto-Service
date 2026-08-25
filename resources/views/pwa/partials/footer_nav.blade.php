@php
    $currentRoute = Route::currentRouteName();
    $activeTab = $activeTab ?? match($currentRoute) {
        'pwa.home', 'pwa.search', 'pwa.product' => 'home',
        'pwa.cart' => 'cart',
        'pwa.chat' => 'chat',
        'pwa.wishlist' => 'wishlist',
        'pwa.account', 'pwa.profile', 'pwa.login' => 'account',
        'pwa.contact' => 'contact',
        default => 'home'
    };
    $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
    $wishCount = $wishlistCount ?? 0;
@endphp

<!-- PWA Unified Bottom Navigation Footer -->
<nav class="pwa-footer-nav ios-bottom-nav fixed bottom-0 left-0 right-0 z-[100] bg-white/95 dark:bg-[#1c1e2d]/95 backdrop-blur-xl border-t border-gray-200/70 dark:border-white/[0.08] shadow-[0_-2px_12px_rgba(0,0,0,0.06)] transition-colors duration-300"
     style="padding-bottom: max(12px, calc(8px + env(safe-area-inset-bottom, 0px))); touch-action: manipulation; -webkit-tap-highlight-color: transparent;">
    <div class="max-w-lg mx-auto flex justify-between items-stretch h-[54px]">

        {{-- Home Tab --}}
        <a href="{{ route('pwa.home') }}"
           class="nav-pill flex-1 flex flex-col items-center justify-center gap-0.5 py-1 text-[10px] font-medium transition-colors duration-150 select-none cursor-pointer active:opacity-70 {{ $activeTab === 'home' ? 'active text-[#0d1b3e] dark:text-[#60a5fa] font-semibold' : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400' }}">
            <svg class="w-[22px] h-[22px] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <span class="pointer-events-none leading-none mt-0.5">Home</span>
        </a>

        {{-- Cart Tab --}}
        <a href="{{ route('pwa.cart') }}"
           class="nav-pill flex-1 flex flex-col items-center justify-center gap-0.5 py-1 text-[10px] font-medium transition-colors duration-150 select-none cursor-pointer active:opacity-70 {{ $activeTab === 'cart' ? 'active text-[#0d1b3e] dark:text-[#60a5fa] font-semibold' : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400' }}">
            <div class="relative pointer-events-none flex items-center justify-center">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                </svg>
                <span class="absolute -top-1.5 -right-2.5 bg-red-500 text-white text-[9px] font-bold min-w-[16px] h-4 px-1 rounded-full flex items-center justify-center leading-none shadow-sm {{ $cartCount > 0 ? '' : 'hidden' }}" id="navCartBadge">{{ $cartCount }}</span>
            </div>
            <span class="pointer-events-none leading-none mt-0.5">Cart</span>
        </a>

        {{-- Chat Tab --}}
        <a href="{{ route('pwa.chat') }}"
           class="nav-pill flex-1 flex flex-col items-center justify-center gap-0.5 py-1 text-[10px] font-medium transition-colors duration-150 select-none cursor-pointer active:opacity-70 {{ $activeTab === 'chat' ? 'active text-[#0d1b3e] dark:text-[#60a5fa] font-semibold' : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400' }}">
            <svg class="w-[22px] h-[22px] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
            </svg>
            <span class="pointer-events-none leading-none mt-0.5">Chat</span>
        </a>

        {{-- Wishlist Tab --}}
        <a href="{{ route('pwa.wishlist') }}"
           class="nav-pill flex-1 flex flex-col items-center justify-center gap-0.5 py-1 text-[10px] font-medium transition-colors duration-150 select-none cursor-pointer active:opacity-70 {{ $activeTab === 'wishlist' ? 'active text-[#0d1b3e] dark:text-[#60a5fa] font-semibold' : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400' }}">
            <div class="relative pointer-events-none flex items-center justify-center">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                </svg>
                <span class="absolute -top-1.5 -right-2.5 bg-red-500 text-white text-[9px] font-bold min-w-[16px] h-4 px-1 rounded-full flex items-center justify-center leading-none shadow-sm {{ $wishCount > 0 ? '' : 'hidden' }}" id="navWishBadge">{{ $wishCount }}</span>
            </div>
            <span class="pointer-events-none leading-none mt-0.5">Wishlist</span>
        </a>

        {{-- Account Tab --}}
        <a href="{{ route('pwa.account') }}"
           class="nav-pill flex-1 flex flex-col items-center justify-center gap-0.5 py-1 text-[10px] font-medium transition-colors duration-150 select-none cursor-pointer active:opacity-70 {{ $activeTab === 'account' ? 'active text-[#0d1b3e] dark:text-[#60a5fa] font-semibold' : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400' }}">
            <svg class="w-[22px] h-[22px] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <span class="pointer-events-none leading-none mt-0.5">Account</span>
        </a>

    </div>
</nav>
