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
    <title>{{ $product->name }} — CM Auto</title>
    <link rel="stylesheet" href="{{ asset('build/pwa.css') }}?v={{ file_exists(public_path('build/pwa.css')) ? filemtime(public_path('build/pwa.css')) : '1.0' }}">
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
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#f2f2f7] dark:bg-[#0f1123] text-gray-900 dark:text-gray-200 font-sans antialiased">

    @php
        $images = [];
        if (!empty($product->product_photo)) {
            $images[] = 'https://cdn.cmautoservic.com/' . $product->product_photo;
        }
        if ($product->productImage && $product->productImage->count() > 0) {
            foreach ($product->productImage as $img) {
                $imgUrl = $img->full_url ?? ($img->path ? 'https://cdn.cmautoservic.com/' . $img->path : null);
                if ($imgUrl && !in_array($imgUrl, $images)) {
                    $images[] = $imgUrl;
                }
            }
        }
        if (empty($images)) {
            $images[] = asset('frontends/assets/img/logo.png');
        }
    @endphp

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

        <!-- Product Image & Gallery -->
        <div class="rounded-2xl overflow-hidden bg-white dark:bg-[#1c1e2d] mb-4 shadow-sm shadow-black/[0.04] dark:shadow-black/20 relative">
            @if(($product->status ?? 0) == 1)
                <span class="absolute top-3 left-3 px-3 py-1 bg-red-600/95 backdrop-blur-sm text-white font-extrabold text-xs rounded-lg z-10 shadow-lg tracking-wider">🚫 អស់ស្តុក</span>
            @endif

            <!-- Main Display Image Container -->
            <div class="relative cursor-pointer aspect-square bg-gray-50 dark:bg-[#151829] overflow-hidden flex items-center justify-center group" onclick="openZoomModal(currentImageIndex)">
                <img id="mainProductImg" src="{{ $images[0] }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-all duration-300 {{ ($product->status ?? 0) == 1 ? 'grayscale opacity-80' : '' }}">
                
                <!-- Preview Button Badge -->
                <button type="button" onclick="event.stopPropagation(); openZoomModal(currentImageIndex);" class="absolute bottom-3 right-3 bg-black/60 hover:bg-black/80 backdrop-blur-md text-white px-3 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-1.5 shadow-lg active:scale-95 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Zoom & Preview</span>
                </button>
            </div>

            <!-- Thumbnails Gallery -->
            @if(count($images) > 1)
                <div class="flex gap-2 p-3 overflow-x-auto bg-gray-50/50 dark:bg-[#151829]/50 border-t border-gray-100 dark:border-white/[0.06] scrollbar-hide">
                    @foreach($images as $idx => $imgUrl)
                        <button type="button" onclick="selectImage({{ $idx }})" class="thumb-btn flex-shrink-0 w-14 h-14 rounded-xl overflow-hidden border-2 transition-all duration-200 {{ $idx === 0 ? 'border-[#007aff] dark:border-[#60a5fa] scale-105' : 'border-transparent opacity-70 hover:opacity-100' }}" data-index="{{ $idx }}">
                            <img src="{{ $imgUrl }}" class="w-full h-full object-cover" alt="thumb">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Info Card -->
        <div class="rounded-2xl bg-white dark:bg-[#1c1e2d] p-5 mb-4 shadow-sm shadow-black/[0.04] dark:shadow-black/20">
            <div class="flex justify-between items-center mb-2">
                <div class="text-[11px] font-medium text-[#8e8e93] uppercase tracking-wider">{{ $product->category->name ?? '' }} {{ $product->subCategory->name ? '/ ' . $product->subCategory->name : '' }}</div>
                @if(($product->status ?? 0) == 1)
                    <span class="px-2.5 py-0.5 bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400 text-[11px] font-bold rounded-md">🚫 អស់ស្តុក</span>
                @else
                    <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400 text-[11px] font-bold rounded-md">✓ មានស្តុក</span>
                @endif
            </div>
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

        <!-- Quantity & Add to Cart Section -->
        <div class="space-y-3 mb-4">
            @if(($product->status ?? 0) != 1)
                <!-- Quantity Selector -->
                <div class="flex items-center justify-between bg-white dark:bg-[#1c1e2d] p-3 px-4 rounded-2xl shadow-sm shadow-black/[0.04] dark:shadow-black/20">
                    <span class="text-[14px] font-semibold text-gray-800 dark:text-gray-200">បរិមាណ (Quantity)</span>
                    <div class="flex items-center gap-3 bg-gray-100 dark:bg-[#252838] p-1.5 rounded-xl">
                        <button type="button" onclick="changeQty(-1)" class="w-8 h-8 rounded-lg bg-white dark:bg-[#1c1e2d] text-gray-800 dark:text-white flex items-center justify-center font-bold text-lg shadow-sm active:scale-95 transition-transform">&minus;</button>
                        <input type="number" id="detailQtyInput" value="1" min="1" max="99" class="w-9 text-center font-bold text-base bg-transparent border-none outline-none text-gray-900 dark:text-white" readonly>
                        <button type="button" onclick="changeQty(1)" class="w-8 h-8 rounded-lg bg-[#007aff] dark:bg-[#0a84ff] text-white flex items-center justify-center font-bold text-lg shadow-sm active:scale-95 transition-transform">&plus;</button>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <button class="pwa-detail-btn w-full py-3.5 bg-[#007aff] hover:bg-[#0066d6] dark:bg-[#0a84ff] dark:hover:bg-[#0077ed] text-white border-none rounded-2xl text-[16px] font-semibold cursor-pointer text-center transition-all duration-200 active:scale-[0.98] shadow-lg shadow-blue-500/20 flex items-center justify-center gap-2" onclick="addToCart({{ $product->id }})">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                    <span>Add to Cart</span>
                </button>
            @else
                <button class="pwa-detail-btn w-full py-3.5 bg-gray-400 dark:bg-gray-600 text-white border-none rounded-2xl text-[16px] font-bold cursor-not-allowed text-center opacity-80" disabled>🚫 អស់ស្តុក (Out of Stock)</button>
            @endif
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count())
            <div class="mt-6">
                <div class="text-[17px] font-semibold text-gray-900 dark:text-white mb-3">Related Products</div>
                <div class="flex gap-3 overflow-x-auto pb-2 -mx-4 px-4 snap-x snap-mandatory scrollbar-hide">
                    @foreach($relatedProducts as $rp)
                        <a href="{{ route('pwa.product', $rp->id) }}" class="snap-start flex-shrink-0 w-[140px] rounded-2xl bg-white dark:bg-[#1c1e2d] overflow-hidden shadow-sm shadow-black/[0.04] dark:shadow-black/20 active:scale-[0.97] transition-transform duration-200 relative">
                            @if(($rp->status ?? 0) == 1)
                                <span class="absolute top-1.5 left-1.5 px-1.5 py-0.5 bg-red-600/90 text-white font-bold text-[9px] rounded z-10">🚫 អស់ស្តុក</span>
                            @endif
                            <img src="{{ $rp->product_photo ? 'https://cdn.cmautoservic.com/' . $rp->product_photo : asset('frontends/assets/img/logo.png') }}" alt="{{ $rp->name }}" class="w-full aspect-square object-cover {{ ($rp->status ?? 0) == 1 ? 'grayscale opacity-75' : '' }}">
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

    @include('pwa.partials.footer_nav', ['activeTab' => 'home'])

    <!-- Fullscreen Image Preview & Zoom Modal -->
    <div id="pwaZoomModal" onclick="if(event.target === this || event.target.id === 'zoomCanvasContainer' || event.target.id === 'zoomImgWrapper') closeZoomModal();" class="fixed inset-0 z-[99999] bg-black/95 backdrop-blur-2xl hidden flex flex-col justify-between transition-opacity duration-300 opacity-0 select-none">
        <!-- Top Bar Controls -->
        <div class="px-4 py-3 flex items-center justify-between text-white z-20 bg-gradient-to-b from-black/80 to-transparent" style="padding-top: max(14px, env(safe-area-inset-top, 14px));">
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-white/10 text-white/90 backdrop-blur-md" id="zoomImgCounter">1 / 1</span>
            </div>
            
            <!-- Zoom In, Zoom Out, Reset, Close Buttons -->
            <div class="flex items-center gap-2">
                <button type="button" onclick="event.stopPropagation(); zoomOutModal();" title="Zoom Out (-)" class="w-9 h-9 rounded-full bg-white/15 active:bg-white/35 text-white flex items-center justify-center backdrop-blur-md transition-all active:scale-90 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </button>
                <button type="button" onclick="event.stopPropagation(); zoomInModal();" title="Zoom In (+)" class="w-9 h-9 rounded-full bg-white/15 active:bg-white/35 text-white flex items-center justify-center backdrop-blur-md transition-all active:scale-90 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </button>
                <button type="button" onclick="event.stopPropagation(); resetZoomModal();" title="Reset Zoom" class="w-9 h-9 rounded-full bg-white/15 active:bg-white/35 text-white flex items-center justify-center backdrop-blur-md text-xs font-bold transition-all active:scale-90 shadow-md">
                    1:1
                </button>
                <button type="button" onclick="closeZoomModal()" title="Close Preview" class="w-9 h-9 rounded-full bg-white/25 active:bg-white/45 text-white flex items-center justify-center backdrop-blur-md transition-all active:scale-90 ml-1 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Main Preview Image Canvas -->
        <div class="flex-1 relative flex items-center justify-center p-2 overflow-hidden" id="zoomCanvasContainer">
            <!-- Prev Button -->
            <button type="button" id="zoomPrevBtn" onclick="event.stopPropagation(); prevZoomImage();" class="absolute left-3 z-20 w-11 h-11 rounded-full bg-black/50 text-white flex items-center justify-center backdrop-blur-md border border-white/10 active:scale-95 transition-transform hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 19l-7-7 7-7"/></svg>
            </button>

            <!-- Image Container -->
            <div id="zoomImgWrapper" class="w-full h-full flex items-center justify-center overflow-auto p-4">
                <img id="zoomModalImg" src="" alt="Preview" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl transition-transform duration-200 cursor-pointer">
            </div>

            <!-- Next Button -->
            <button type="button" id="zoomNextBtn" onclick="event.stopPropagation(); nextZoomImage();" class="absolute right-3 z-20 w-11 h-11 rounded-full bg-black/50 text-white flex items-center justify-center backdrop-blur-md border border-white/10 active:scale-95 transition-transform hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

        <!-- Bottom Thumbnails -->
        <div class="px-4 py-3 bg-gradient-to-t from-black/80 to-transparent z-20 flex justify-center gap-2 overflow-x-auto scrollbar-hide" id="zoomModalThumbs" style="padding-bottom: max(14px, env(safe-area-inset-bottom, 14px));">
            <!-- Rendered dynamically -->
        </div>
    </div>

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
        const productImages = @json($images);
        let currentImageIndex = 0;
        let modalScale = 1;

        function selectImage(index) {
            if (index < 0 || index >= productImages.length) return;
            currentImageIndex = index;
            const mainImg = document.getElementById('mainProductImg');
            if (mainImg) {
                mainImg.style.opacity = '0.4';
                setTimeout(() => {
                    mainImg.src = productImages[index];
                    mainImg.style.opacity = '1';
                }, 100);
            }
            document.querySelectorAll('.thumb-btn').forEach((btn, i) => {
                if (i === index) {
                    btn.classList.add('border-[#007aff]', 'dark:border-[#60a5fa]', 'scale-105');
                    btn.classList.remove('border-transparent', 'opacity-70');
                } else {
                    btn.classList.remove('border-[#007aff]', 'dark:border-[#60a5fa]', 'scale-105');
                    btn.classList.add('border-transparent', 'opacity-70');
                }
            });
        }

        function changeQty(delta) {
            const qtyInput = document.getElementById('detailQtyInput');
            if (!qtyInput) return;
            let val = parseInt(qtyInput.value) || 1;
            val = Math.max(1, Math.min(99, val + delta));
            qtyInput.value = val;
        }

        // Modal Zoom Logic
        function applyModalZoom() {
            const zoomImg = document.getElementById('zoomModalImg');
            if (zoomImg) {
                zoomImg.style.transform = `scale(${modalScale})`;
            }
        }

        function zoomInModal() {
            modalScale = Math.min(3.5, modalScale + 0.5);
            applyModalZoom();
        }

        function zoomOutModal() {
            modalScale = Math.max(1, modalScale - 0.5);
            applyModalZoom();
        }

        function resetZoomModal() {
            modalScale = 1;
            applyModalZoom();
        }

        function openZoomModal(index) {
            currentImageIndex = index || 0;
            const modal = document.getElementById('pwaZoomModal');
            const zoomImg = document.getElementById('zoomModalImg');
            if (!modal || !zoomImg) return;

            resetZoomModal();
            updateModalContent();

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
            });
        }

        function updateModalContent() {
            const zoomImg = document.getElementById('zoomModalImg');
            const counter = document.getElementById('zoomImgCounter');
            const prevBtn = document.getElementById('zoomPrevBtn');
            const nextBtn = document.getElementById('zoomNextBtn');
            const thumbsContainer = document.getElementById('zoomModalThumbs');

            if (zoomImg) zoomImg.src = productImages[currentImageIndex];
            if (counter) counter.textContent = `${currentImageIndex + 1} / ${productImages.length}`;

            if (productImages.length > 1) {
                if (prevBtn) prevBtn.classList.remove('hidden');
                if (nextBtn) nextBtn.classList.remove('hidden');
                if (thumbsContainer) {
                    thumbsContainer.innerHTML = productImages.map((src, i) => `
                        <button type="button" onclick="event.stopPropagation(); selectZoomModalImage(${i})" class="w-12 h-12 rounded-xl overflow-hidden border-2 transition-all flex-shrink-0 ${i === currentImageIndex ? 'border-blue-500 scale-105 opacity-100' : 'border-transparent opacity-50'}">
                            <img src="${src}" class="w-full h-full object-cover">
                        </button>
                    `).join('');
                }
            } else {
                if (prevBtn) prevBtn.classList.add('hidden');
                if (nextBtn) nextBtn.classList.add('hidden');
                if (thumbsContainer) thumbsContainer.innerHTML = '';
            }
        }

        function selectZoomModalImage(i) {
            if (i < 0 || i >= productImages.length) return;
            currentImageIndex = i;
            resetZoomModal();
            selectImage(i);
            updateModalContent();
        }

        function prevZoomImage() {
            let nextIdx = (currentImageIndex - 1 + productImages.length) % productImages.length;
            selectZoomModalImage(nextIdx);
        }

        function nextZoomImage() {
            let nextIdx = (currentImageIndex + 1) % productImages.length;
            selectZoomModalImage(nextIdx);
        }

        function closeZoomModal() {
            const modal = document.getElementById('pwaZoomModal');
            if (!modal) return;
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
                resetZoomModal();
            }, 200);
        }

        // Double tap or click on preview image to toggle zoom
        (function initModalTapToZoom() {
            const zoomImg = document.getElementById('zoomModalImg');
            if (!zoomImg) return;
            let lastTap = 0;
            zoomImg.addEventListener('click', function(e) {
                e.stopPropagation();
                const now = Date.now();
                if (now - lastTap < 300) {
                    if (modalScale > 1) {
                        resetZoomModal();
                    } else {
                        modalScale = 2;
                        applyModalZoom();
                    }
                }
                lastTap = now;
            });
        })();

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeZoomModal();
        });

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
            var qtyInput = document.getElementById('detailQtyInput');
            var qty = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
            var btn = document.querySelector('.pwa-detail-btn');
            if (btn) { btn.textContent = 'Adding...'; btn.disabled = true; }

            fetch('{{ route("pwa.cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: 'id=' + id + '&quantity=' + qty
            })
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success') {
                    if (btn) btn.innerHTML = '<span>Added ✓</span>';
                    
                    var cartBadges = document.querySelectorAll('#navCartBadge, #cartBadge, .navCartBadge');
                    cartBadges.forEach(function(b) {
                        b.textContent = res.count;
                        b.classList.remove('hidden');
                        b.style.display = '';
                    });

                    pwaShowSuccess('Added to cart!');
                    setTimeout(function() {
                        if (btn) {
                            btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg><span>Add to Cart</span>';
                            btn.disabled = false;
                        }
                    }, 1500);
                } else {
                    if (btn) { btn.textContent = 'Add to Cart'; btn.disabled = false; }
                    if (typeof pwaHandleError === 'function') pwaHandleError(res.message || 'Failed to add to cart.');
                }
            })
            .catch((err) => {
                console.error('Add to Cart Error:', err);
                if (btn) { btn.textContent = 'Add to Cart'; btn.disabled = false; }
                if (typeof pwaHandleError === 'function') pwaHandleError('Failed to add to cart. Please try again.');
            });
        }
    </script>
</body>
</html>
