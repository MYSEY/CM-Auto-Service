@extends('layouts.frontend.layouts')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

    <style>
        /* Professional E-commerce Styling */
        .product_page_bg { background: #f4f7f6; padding: 40px 0; }
        .product_details { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .product_d_right h3 { font-weight: 700; color: #222; line-height: 1.3; font-size: 26px; margin-bottom: 10px; }
        .current_price { font-size: 32px; font-weight: 800; color: #d9121f; }

        /* Improved Quantity Input */
        .qty-container { display: flex; align-items: center; margin-bottom: 25px; }
        .qty-btn {
            width: 45px; height: 45px; border: 1px solid #e1e1e1; background: #fff;
            display: flex; align-items: center; justify-content: center; cursor: pointer;
            transition: 0.2s; font-size: 20px; color: #555;
        }
        .qty-btn:hover { background: #222; color: #fff; border-color: #222; }
        .qty-input {
            width: 60px; height: 45px; text-align: center; border: 1px solid #e1e1e1;
            border-left: 0; border-right: 0; outline: none; font-weight: 700; font-size: 16px;
        }

        .btn-add-cart {
            background: #222; color: #fff; padding: 0 40px; height: 45px; border: none;
            font-weight: 600; text-transform: uppercase; transition: 0.3s; margin-left: 15px;
        }
        .btn-add-cart:hover { background: #d9121f; color: #fff; transform: translateY(-2px); }

        /* Thumbnails Styling */
        .elevatezoom-gallery { border: 2px solid transparent; transition: 0.3s; border-radius: 4px; overflow: hidden; }
        .elevatezoom-gallery.active { border-color: #d9121f; }

        /* Related Products Section */
        .section_title { margin-bottom: 30px; position: relative; }
        .section_title h2 { font-weight: 700; font-size: 22px; text-transform: uppercase; }
        .section_title::after { content: ""; width: 50px; height: 3px; background: #d9121f; position: absolute; bottom: -8px; left: 0; }
        .single_product { background: #fff; transition: 0.3s; border-radius: 8px; overflow: hidden; height: 100%; }
        .single_product:hover { box-shadow: 0 10px 25px rgba(0,0,0,0.1); transform: translateY(-5px); }

        .hover-effect {
        transition: transform 0.2s ease-in-out;
        display: inline-block;
    }
        .priduct_social .hover-effect {
                transition: all 0.3s ease;
                display: inline-block;
            }

            .priduct_social .hover-effect:hover {
                transform: scale(1.15); /* រីកធំបន្តិចពេលដាក់ Mouse លើ */
                filter: drop-shadow(0px 4px 8px rgba(0,0,0,0.2)); /* បន្ថែមស្រមោលតិចៗ */
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
                <div class="col-lg-5 col-md-6">
                    <div class="product-details-tab">
                        <div id="img-1" class="zoomWrapper border rounded bg-white overflow-hidden">
                            @php
                                $mainImage = $productDetail->product_photo ? $r2Url . $productDetail->product_photo : asset('images/no-image.png');
                            @endphp
                            <a href="{{ $mainImage }}" data-fancybox="gallery" data-caption="{{ $productDetail->name }}">
                                <img id="zoom1" src="{{ $mainImage }}" alt="{{ $productDetail->name }}" style="width: 100%; height: 450px; object-fit: contain;">
                            </a>
                        </div>
                        <div class="single-zoom-thumb mt-3">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                @if($productDetail->productImage && $productDetail->productImage->count() > 0)
                                    @foreach($productDetail->productImage as $image)
                                        <li>
                                            <a href="{{ $r2Url . $image->path }}"
                                               class="elevatezoom-gallery {{ $loop->first ? 'active' : '' }}"
                                               data-fancybox="gallery"
                                               data-image="{{ $r2Url . $image->path }}">
                                                <img src="{{ $r2Url . $image->path }}" alt="thumbnail" style="height: 80px; width: 100%; object-fit: cover;">
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-md-6">
                    <div class="product_d_right pl-md-4">
                        <div class="mb-2">
                            <span class="badge badge-dark p-2 px-3">{{ $productDetail->productType->name ?? 'Standard' }}</span>
                        </div>

                        <h3>{{ $productDetail->category->name ?? '' }} {{ $productDetail->subCategory->name ?? '' }} {{ $productDetail->year ?? '' }}</h3>
                        <div class="text-primary h4 font-weight-bold">{{ $productDetail->proEngine->name ?? '' }}</div>
                        <p class="text-muted small mb-4">Part Number: <strong>{{ $productDetail->proEngine->part_number ?? 'N/A' }}</strong></p>

                        <div class="price_box mb-4">
                            <span class="current_price">${{ number_format($productDetail->price, 2) }}</span>
                            <span class="ml-3 text-secondary">SKU: {{ $productDetail->number ?? 'N/A' }}</span>
                        </div>

                        <div class="product_desc mb-4 border-bottom pb-4 text-secondary">
                            {!! Str::limit(strip_tags($productDetail->description), 280) !!}
                        </div>

                        <div class="product_variant quantity">
                            <label class="font-weight-bold mb-2">Quantity:</label>
                            <div class="qty-container">
                                <div class="qty-btn dec">-</div>
                                <input type="number" min="1" max="100" value="1" class="qty-input">
                                <div class="qty-btn inc">+</div>
                                <button class="btn btn-add-cart addToCart" type="button" data-id="{{ $productDetail->id }}">
                                    <i class="fa fa-shopping-cart mr-2"></i> Add to Cart
                                </button>
                            </div>
                        </div>

                        <div class="priduct_social mt-5 pt-4 border-top">
                            <p class="mb-3 font-weight-bold" style="color: #444;">Contact via:</p>

                            <div class="d-flex align-items-center" style="gap: 20px;">

                                <a href="https://www.facebook.com/C.M.Auto.77/" target="_blank" class="hover-effect">
                                    <img src="/images/products/facebook.png" width="42" alt="Facebook">
                                </a>

                                <a href="https://t.me/CMAUTO" target="_blank" class="hover-effect">
                                    <img src="/images/products/telegram.png" width="42" alt="Telegram">
                                </a>

                                <a href="https://wa.me/qr/PLBWAXBSGCKPG1" target="_blank" class="hover-effect">
                                    <img src="/images/products/whatapp.png" width="42" alt="WhatsApp">
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product_d_info mt-5">
            <div class="product_d_inner border rounded bg-white overflow-hidden">
                <div class="product_info_button border-bottom bg-light">
                    <ul class="nav nav-tabs border-0" id="productTab">
                        <li class="nav-item">
                            <button class="nav-link active border-0 py-3 px-5 font-weight-bold" data-bs-toggle="tab" data-bs-target="#info">Description</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link border-0 py-3 px-5 font-weight-bold" data-bs-toggle="tab" data-bs-target="#sheet">Specification</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content p-4">
                    <div class="tab-pane fade show active" id="info">
                        {!! $productDetail->description ?: '<p class="text-muted italic">No description provided.</p>' !!}
                    </div>
                    <div class="tab-pane fade" id="sheet">
                        <table class="table table-bordered table-striped">
                            <tr><th class="bg-light" width="30%">Engine Model</th><td>{{ $productDetail->proEngine->name ?? '—' }}</td></tr>
                            <tr><th class="bg-light">Part Number</th><td>{{ $productDetail->proEngine->part_number ?? '—' }}</td></tr>
                            <tr><th class="bg-light">Year</th><td>{{ $productDetail->year ?? '—' }}</td></tr>
                            <tr><th class="bg-light">Category</th><td>{{ $productDetail->category->name ?? '—' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="related_products mt-5 mb-5">
                <div class="section_title mb-4">
                    <h2 class="h4 font-weight-bold" style="border-left: 4px solid #d9121f; padding-left: 15px;">Related Products</h2>
                </div>
                <div class="row">
                    @foreach($relatedProducts as $item)
                        @php $itemImg = $item->product_photo ? $r2Url . $item->product_photo : asset('images/no-image.png'); @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6 col-6 mb-4">
                            <article class="single_product border p-3 text-center bg-white shadow-sm h-100">
                                <div class="product_thumb" style="height: 180px;">
                                    {{-- កែត្រង់នេះ --}}
                                    <a href="{{ route('productDetail', ['id' => $item->id]) }}">
                                        <img src="{{ $itemImg }}" alt="{{ $item->name }}" style="height: 100%; width: 100%; object-fit: contain;">
                                    </a>
                                </div>
                                <div class="product_content mt-3">
                                    <h4 class="h6 mb-2" style="height: 40px; overflow: hidden;">
                                        {{-- កែត្រង់នេះ --}}
                                        <a href="{{ route('productDetail', ['id' => $item->id]) }}" class="text-dark font-weight-bold text-decoration-none">{{ Str::limit($item->name, 45) }}</a>
                                    </h4>
                                    <div class="price_box mb-3">
                                        <span class="text-danger font-weight-bold" style="font-size: 18px;">${{ number_format($item->price, 2) }}</span>
                                    </div>
                                    {{-- កែត្រង់នេះ --}}
                                    <a href="{{ route('productDetail', ['id' => $item->id]) }}" class="btn btn-sm btn-outline-dark btn-block rounded-0">View Detail</a>
                                </div>
                            </article>
                        </div>
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
        $(function () {
            /**
             * 1. លក្ខណៈបច្ចេកទេសប៊ូតុងបង្កើន/បន្ថយចំនួន (Quantity)
             */
            $(document).on('click', '.qty-btn', function() {
                var $input = $(this).parent().find('.qty-input');
                var val = parseInt($input.val());
                if ($(this).hasClass('inc')) {
                    $input.val(val + 1);
                } else if (val > 1) {
                    $input.val(val - 1);
                }
            });

            /**
             * 2. កំណត់ដំណើរការ Fancybox (សម្រាប់ចុចមើលរូបភាពធំ)
             */
            Fancybox.bind("[data-fancybox='gallery']", {
                Hash: false,
                Thumbs: { autoStart: true },
                Toolbar: {
                    display: {
                        left: ["infobar"],
                        middle: [],
                        right: ["iterateZoom", "slideshow", "fullScreen", "download", "thumbs", "close"],
                    }
                }
            });

            /**
             * 3. មុខងារ AJAX បន្ថែមផលិតផលទៅក្នុងកន្ត្រក (Add to Cart)
             */
            $(document).on('click', '.addToCart', function (e) {
                e.preventDefault();
                const btn = $(this);
                const id = btn.data('id');
                const qty = $('.qty-input').val() || 1;

                // បង្ហាញ Loading នៅលើប៊ូតុង
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

                $.ajax({
                    url: "{{ route('addToCart.Detail') }}",
                    type: "POST",
                    data: {
                        id: id,
                        qty: qty,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        btn.prop('disabled', false).html('<i class="fa fa-shopping-cart mr-2"></i> Add to Cart');
                        if (res.status === 'success') {
                            // បច្ចុប្បន្នភាពចំនួនក្នុងកន្ត្រកលើ Header
                            $('.cart_count').text(res.count);
                            if(res.total) {
                                $('.cart_price').html(`$${parseFloat(res.total).toFixed(2)} <i class="ion-ios-arrow-down"></i>`);
                            }

                            // បង្ហាញការជូនដំណឹងស្អាតជាងមុន (Optional: ប្រើ SweetAlert2 បើមាន)
                            alert('ជោគជ័យ: ផលិតផលត្រូវបានបញ្ចូលទៅក្នុងកន្ត្រក!');
                        }
                    },
                    error: function () {
                        btn.prop('disabled', false).html('<i class="fa fa-shopping-cart mr-2"></i> Add to Cart');
                        alert('មានបញ្ហាបច្ចេកទេស! សូមព្យាយាមម្តងទៀត ឬ Refresh ទំព័រនេះ។');
                    }
                });
            });

            /**
             * 4. ប្តូររូបភាពធំនៅពេលចុចលើរូបភាពតូចៗ (Thumbnails)
             */
            $(document).on('click', '.elevatezoom-gallery', function(e) {
                e.preventDefault();
                var newImg = $(this).data('image');

                // ប្តូរ src របស់រូបភាពមេ
                $('#zoom1').attr('src', newImg);

                // ប្តូរ Link របស់ Fancybox ឱ្យត្រូវតាមរូបភាពថ្មី
                $('#zoom1').parent().attr('href', newImg);

                // បន្ថែម Class active លើរូបភាពដែលបានចុច
                $('.elevatezoom-gallery').removeClass('active');
                $(this).addClass('active');
            });

            /**
             * 5. មុខងារ Slide សម្រាប់ផលិតផលពាក់ព័ន្ធ (Related Products)
             * កូដនេះនឹងដំនើរការលុះត្រាតែអ្នកប្រើ Class 'product_carousel' និង 'owl-carousel' ក្នុង HTML
             */
            if ($('.product_carousel').length > 0) {
                $('.product_carousel').owlCarousel({
                    loop: false,
                    margin: 20,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    responsive: {
                        0: { items: 1 },
                        480: { items: 2 },
                        768: { items: 3 },
                        1200: { items: 4 }
                    },
                    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
                });
            }
        });
    </script>
@endsection
