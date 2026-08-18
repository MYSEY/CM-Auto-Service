@extends('layouts.frontend.layouts')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

<style>
    .product_page_bg {
        background: #f8fafc;
        padding: 35px 0 60px 0;
    }
    .product_details {
        background: #ffffff;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        border: 1px solid #e2e8f0;
    }
    .main-image-box {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        overflow: hidden;
        position: relative;
        text-align: center;
        padding: 15px;
    }
    .main-image-box img {
        width: 100%;
        height: 380px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .thumb-gallery {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        overflow-x: auto;
        padding-bottom: 5px;
    }
    .thumb-item {
        width: 76px;
        height: 76px;
        border-radius: 8px;
        border: 2px solid #e2e8f0;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
        background: #ffffff;
    }
    .thumb-item.active, .thumb-item:hover {
        border-color: #17005e;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(23, 0, 94, 0.15);
    }
    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-type-badge {
        display: inline-block;
        background: rgba(23, 0, 94, 0.08);
        color: #17005e;
        font-weight: 700;
        font-size: 12px;
        padding: 4px 14px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .product_d_right h3 {
        font-weight: 800;
        color: #0f172a;
        line-height: 1.35;
        font-size: 24px;
        margin-bottom: 8px;
    }
    .engine-title {
        color: #17005e;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 6px;
    }
    .part-number-pill {
        display: inline-flex;
        align-items: center;
        background: #f1f5f9;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
        padding: 5px 14px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        margin-bottom: 18px;
    }
    .detail-price-box {
        display: flex;
        align-items: baseline;
        gap: 16px;
        margin-bottom: 22px;
    }
    .detail-current-price {
        font-size: 34px;
        font-weight: 800;
        color: #17005e;
    }
    .sku-tag {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }
    .qty-container {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 15px;
        margin-bottom: 25px;
    }
    .qty-btn-group {
        display: flex;
        align-items: center;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        background: #ffffff;
    }
    .qty-btn {
        width: 40px;
        height: 42px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
        font-weight: 700;
        color: #334155;
        user-select: none;
        transition: background 0.2s;
    }
    .qty-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .qty-input {
        width: 50px;
        height: 42px;
        text-align: center;
        border: none;
        outline: none;
        font-weight: 700;
        font-size: 15px;
        color: #0f172a;
    }
    .btn-detail-add-cart {
        background: linear-gradient(135deg, #17005e 0%, #2c0099 100%);
        color: #ffffff !important;
        padding: 0 28px;
        height: 44px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(23, 0, 94, 0.25);
    }
    .btn-detail-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(23, 0, 94, 0.35);
    }
    .btn-detail-wishlist {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        border: 2px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-detail-wishlist:hover, .btn-detail-wishlist.active {
        border-color: #ff3547;
        background: #ffe4e6;
        color: #ff3547;
    }
    .social-contact-wrapper {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }
    .social-contact-wrapper p {
        font-weight: 700;
        font-size: 13px;
        color: #475569;
        margin-bottom: 10px;
    }
    .social-icons-list {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .social-icon-btn {
        transition: transform 0.22s ease, filter 0.22s ease;
        display: inline-block;
    }
    .social-icon-btn:hover {
        transform: translateY(-3px) scale(1.1);
        filter: drop-shadow(0 6px 12px rgba(0,0,0,0.15));
    }
    .product_d_info {
        margin-top: 35px;
    }
    .info-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
        overflow: hidden;
    }
    .info-nav-tabs {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 0 16px;
    }
    .info-nav-tabs .nav-link {
        border: none !important;
        padding: 14px 24px !important;
        font-weight: 700 !important;
        font-size: 14px !important;
        color: #64748b !important;
        background: transparent !important;
        border-bottom: 3px solid transparent !important;
        transition: all 0.2s ease;
    }
    .info-nav-tabs .nav-link.active {
        color: #17005e !important;
        border-bottom-color: #17005e !important;
    }
    .section_title_custom {
        margin-top: 40px;
        margin-bottom: 20px;
        font-weight: 800;
        font-size: 20px;
        color: #0f172a;
        position: relative;
        padding-left: 12px;
        border-left: 4px solid #17005e;
    }
</style>

<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>Product Details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product_page_bg">
    <div class="container">
        <div class="product_details">
            <div class="row">
                <!-- Product Gallery Images -->
                <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
                    @php
                        $cdnBase = 'https://cdn.cmautoservic.com/';
                        $mainPhoto = $productDetail->product_photo ? $cdnBase . $productDetail->product_photo : asset('images/no-image.png');
                    @endphp
                    <div class="main-image-box" style="position: relative;">
                        @if(($productDetail->status ?? 0) == 1)
                            <span class="out-of-stock-badge" style="position: absolute; top: 14px; left: 14px; z-index: 20; background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: #fff; font-weight: 800; font-size: 12px; padding: 5px 12px; border-radius: 6px; box-shadow: 0 4px 12px rgba(220,38,38,0.4);"><i class="fa fa-ban mr-1"></i> អស់ស្តុក</span>
                        @endif
                        <a href="{{ $mainPhoto }}" data-fancybox="gallery" id="mainFancyLink" data-caption="{{ $productDetail->category->name ?? '' }} {{ $productDetail->subCategory->name ?? '' }}">
                            <img id="mainDetailImage" src="{{ $mainPhoto }}" alt="{{ $productDetail->category->name ?? '' }}" style="{{ ($productDetail->status ?? 0) == 1 ? 'filter: grayscale(0.25);' : '' }}">
                        </a>
                    </div>

                    @if($productDetail->productImage && $productDetail->productImage->count() > 0)
                        <div class="thumb-gallery">
                            <div class="thumb-item active" data-image="{{ $mainPhoto }}">
                                <img src="{{ $mainPhoto }}" alt="Main Thumb">
                            </div>
                            @foreach($productDetail->productImage as $img)
                                @php $imgPath = $cdnBase . $img->path; @endphp
                                <div class="thumb-item" data-image="{{ $imgPath }}">
                                    <img src="{{ $imgPath }}" alt="Thumb {{ $loop->iteration }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Details Information -->
                <div class="col-lg-7 col-md-6">
                    <div class="product_d_right pl-lg-3">
                        <span class="product-type-badge">{{ $productDetail->productType->name ?? 'Parts' }}</span>
                        @if(($productDetail->status ?? 0) == 1)
                            <span class="badge bg-danger text-white ml-2 p-2" style="font-size: 12px; border-radius: 6px;"><i class="fa fa-ban mr-1"></i> អស់ស្តុក</span>
                        @else
                            <span class="badge bg-success text-white ml-2 p-2" style="font-size: 12px; border-radius: 6px;"><i class="fa fa-check-circle mr-1"></i> មានស្តុក</span>
                        @endif

                        <h3>
                            {{ $productDetail->category->name ?? '' }} 
                            {{ $productDetail->subCategory->name ?? '' }} 
                            {{ $productDetail->year ?? '' }}
                        </h3>

                        @if($productDetail->proEngine?->name)
                            <div class="engine-title"><i class="fa fa-cogs mr-1"></i> {{ $productDetail->proEngine->name }}</div>
                        @endif

                        @if($productDetail->proEngine?->part_number)
                            <div class="part-number-pill">
                                <span>Part Number: <strong>{{ $productDetail->proEngine->part_number }}</strong></span>
                            </div>
                        @endif

                        <div class="detail-price-box">
                            <span class="detail-current-price">${{ number_format($productDetail->price, 2) }}</span>
                            @if($productDetail->number)
                                <span class="sku-tag">SKU: {{ $productDetail->number }}</span>
                            @endif
                        </div>

                        @if($productDetail->description)
                            <div class="text-secondary small mb-4 leading-relaxed" style="max-height: 120px; overflow: hidden;">
                                {!! Str::limit(strip_tags($productDetail->description), 260) !!}
                            </div>
                        @endif

                        <div class="quantity-wrapper">
                            <label class="font-weight-bold text-dark mb-1" style="font-size: 13px;">Quantity:</label>
                            <div class="qty-container">
                                <div class="qty-btn-group">
                                    <div class="qty-btn dec">-</div>
                                    <input type="number" min="1" max="100" value="1" class="qty-input" id="detailQtyInput">
                                    <div class="qty-btn inc">+</div>
                                </div>
                                <button class="btn-detail-add-cart addToCartDetail" type="button" data-id="{{ $productDetail->id }}">
                                    <i class="icon-shopping-bag"></i> Add to Cart
                                </button>
                                <button class="btn-detail-wishlist toggle-wishlist" type="button" data-id="{{ $productDetail->id }}" title="Add to Wishlist">
                                    <i class="icon-heart"></i>
                                </button>
                            </div>
                        </div>

                        <div class="social-contact-wrapper">
                            <p>Contact Us via:</p>
                            <div class="social-icons-list">
                                <a href="https://www.facebook.com/C.M.Auto.77/" target="_blank" class="social-icon-btn">
                                    <img src="{{ asset('frontends/assets/img/icon/facebook.png') }}" onerror="this.onerror=null;this.src='/images/products/facebook.png';" width="38" alt="Facebook">
                                </a>
                                <a href="https://t.me/CMAUTO" target="_blank" class="social-icon-btn">
                                    <img src="{{ asset('frontends/assets/img/icon/telegram.png') }}" onerror="this.onerror=null;this.src='/images/products/telegram.png';" width="38" alt="Telegram">
                                </a>
                                <a href="https://wa.me/qr/PLBWAXBSGCKPG1" target="_blank" class="social-icon-btn">
                                    <img src="{{ asset('frontends/assets/img/icon/whatsapp.png') }}" onerror="this.onerror=null;this.src='/images/products/whatapp.png';" width="38" alt="WhatsApp">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description & Specification Tabs -->
        <div class="product_d_info">
            <div class="info-card">
                <div class="info-nav-tabs">
                    <ul class="nav nav-tabs border-0" id="productTab">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#descTab" type="button">Description</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#specTab" type="button">Specification</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content p-4">
                    <div class="tab-pane fade show active" id="descTab">
                        <div class="text-secondary leading-relaxed">
                            {!! $productDetail->description ?: '<p class="text-muted italic mb-0">No description available for this item.</p>' !!}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="specTab">
                        <table class="table table-bordered table-striped mb-0">
                            <tbody>
                                <tr><th class="bg-light" width="30%">Engine Model</th><td>{{ $productDetail->proEngine->name ?? '—' }}</td></tr>
                                <tr><th class="bg-light">Part Number</th><td>{{ $productDetail->proEngine->part_number ?? '—' }}</td></tr>
                                <tr><th class="bg-light">Year</th><td>{{ $productDetail->year ?? '—' }}</td></tr>
                                <tr><th class="bg-light">Category</th><td>{{ $productDetail->category->name ?? '—' }}</td></tr>
                                <tr><th class="bg-light">Sub-Category</th><td>{{ $productDetail->subCategory->name ?? '—' }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="related_products_wrapper">
                <h3 class="section_title_custom">Related Products</h3>
                <div class="product-grid-container">
                    @foreach($relatedProducts as $item)
                        @include('frontends.product', ['item' => $item])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
$(document).ready(function() {
    // Quantity + / - buttons
    $(document).on('click', '.qty-btn', function() {
        let input = $('#detailQtyInput');
        let val = parseInt(input.val()) || 1;
        if ($(this).hasClass('inc')) {
            input.val(val + 1);
        } else if (val > 1) {
            input.val(val - 1);
        }
    });

    // Image thumbnail click selector
    $(document).on('click', '.thumb-item', function() {
        let newSrc = $(this).data('image');
        $('#mainDetailImage').attr('src', newSrc);
        $('#mainFancyLink').attr('href', newSrc);
        $('.thumb-item').removeClass('active');
        $(this).addClass('active');
    });

    // Fancybox initialization
    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind("[data-fancybox='gallery']", {
            Hash: false,
            Thumbs: { autoStart: true }
        });
    }

    // Add to Cart from detail page handler
    $(document).on('click', '.addToCartDetail', function(e) {
        e.preventDefault();
        let btn = $(this);
        let id = btn.data('id');
        let qty = $('#detailQtyInput').val() || 1;

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');

        $.ajax({
            url: "{{ route('addToCart.Detail') }}",
            type: "POST",
            data: {
                id: id,
                qty: qty,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                btn.prop('disabled', false).html('<i class="icon-shopping-bag"></i> Add to Cart');
                if (res.status === 'success') {
                    $('.cart_count').text(res.count);
                    if (res.total) {
                        $('.cart_price').html(`$${parseFloat(res.total).toFixed(2)} <i class="ion-ios-arrow-down"></i>`);
                    }
                    alert('Product added to cart!');
                } else {
                    alert(res.message || 'Could not add to cart.');
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="icon-shopping-bag"></i> Add to Cart');
                alert('Error adding product to cart.');
            }
        });
    });
});
</script>
@endsection
