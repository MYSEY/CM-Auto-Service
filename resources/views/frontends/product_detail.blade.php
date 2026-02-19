@extends('layouts.frontend.layouts')

@section('content')

    <!-- Breadcrumbs area start -->
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
    <!-- Breadcrumbs area end -->

    <div class="product_page_bg">
        <div class="container">

            <!-- Product details start -->
            <div class="product_details">
                <div class="row">

                    <!-- Product images + gallery -->
                    <div class="col-lg-5 col-md-6">
                        <div class="product-details-tab">

                            <!-- Main zoomed image -->
                            <div id="img-1" class="zoomWrapper single-zoom">
                                <a href="#">
                                    <img id="zoom1"
                                         src="{{ $productDetail->photo_url }}"
                                         data-zoom-image="{{ $productDetail->photo_url }}"
                                         alt="{{ $productDetail->name ?? 'Product image' }}">
                                </a>
                            </div>

                            <!-- Thumbnail gallery -->
                            <div class="single-zoom-thumb">
                                <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                    @foreach($productDetail->productImage as $key => $image)
                                        <li>
                                            <a href="#"
                                               class="elevatezoom-gallery {{ $loop->first ? 'active' : '' }}"
                                               data-image="{{ $image->full_url }}"
                                               data-zoom-image="{{ $image->full_url }}">
                                                <img src="{{ $image->full_url }}" alt="thumbnail {{ $loop->iteration }}">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>

                    <!-- Product information + form -->
                    <div class="col-lg-7 col-md-6">
                        <div class="product_d_right">

                            <form>

                                <div class="product_rating">
                                    {{ $productDetail->productType->name ?? '—' }}
                                </div>

                                <h3>
                                    {{ $productDetail->category->name ?? '' }}
                                    {{ $productDetail->subCategory->name ?? '' }}
                                    {{ $productDetail->year ?? '' }}
                                    <p>{{ $productDetail->proEngine->name ?? '' }}</p>
                                    {{ $productDetail->proEngine->part_number ?? '' }}
                                </h3>

                                <div class="price_box">
                                    <span class="current_price">
                                        ${{ number_format($productDetail->price, 2) }}
                                        {{ $productDetail->number ?? '' }}
                                    </span>
                                </div>

                                <div class="product_desc">
                                    <p>{!! $productDetail->description !!}</p>
                                </div>

                                <div class="product_variant quantity">
                                    <label>Quantity</label>
                                    <input type="number" min="1" max="100" value="1" class="qty-input">
                                    <button class="button addToCart"
                                            type="button"
                                            data-id="{{ $productDetail->id }}">
                                        Add to Cart
                                    </button>
                                </div>

                            </form>

                            <!-- Social share icons -->
                            <div class="priduct_social">
                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/C.M.Auto.77/" target="_blank" class="Facebook">
                                            <img src="/images/products/facebook.png" alt="Facebook" width="50" height="40">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://t.me/CMAUTO" target="_blank" class="telegram">
                                            <img src="/images/products/telegram.png" alt="Telegram" width="50" height="50">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://wa.me/qr/PLBWAXBSGCKPG1" target="_blank" class="WhatsApp">
                                            <img src="/images/products/whatapp.png" alt="WhatsApp" width="50" height="50">
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- Product details end -->

            <!-- Product info tabs start -->
            <div class="product_d_info">
                <div class="row">
                    <div class="col-12">
                        <div class="product_d_inner">

                            <div class="product_info_button">
                                <ul class="nav nav-tabs" id="productTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab"
                                                data-bs-target="#info" type="button" role="tab" aria-controls="info"
                                                aria-selected="true">Description</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="sheet-tab" data-bs-toggle="tab"
                                                data-bs-target="#sheet" type="button" role="tab" aria-controls="sheet"
                                                aria-selected="false">Specification</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                                                data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews"
                                                aria-selected="false">Reviews (1)</button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content" id="productTabContent">

                                <!-- Description tab -->
                                <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                                    <div class="product_info_content">
                                        {!! $productDetail->description !!}

                                        <!-- You can also keep fallback lorem if description is empty -->
                                        @if(empty(trim(strip_tags($productDetail->description))))
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Specification tab -->
                                <div class="tab-pane fade" id="sheet" role="tabpanel" aria-labelledby="sheet-tab">
                                    <div class="product_d_table">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td class="first_child">Engine</td>
                                                <td>{{ $productDetail->proEngine->name ?? '—' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="first_child">Part Number</td>
                                                <td>{{ $productDetail->proEngine->part_number ?? '—' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="first_child">Year</td>
                                                <td>{{ $productDetail->year ?? '—' }}</td>
                                            </tr>
                                            <!-- Add more dynamic rows if you have specification data -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="product_info_content">
                                        <p>Additional specification description can go here...</p>
                                    </div>
                                </div>

                                <!-- Reviews tab -->
                                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                    <div class="reviews_wrapper">
                                        <h2>1 review for {{ $productDetail->name ?? 'this product' }}</h2>

                                        <!-- Example static review – replace with @foreach later -->
                                        <div class="reviews_comment_box">
                                            <div class="comment_text">
                                                <div class="reviews_meta">
                                                    <div class="product_rating">
                                                        <ul>
                                                            <li><i class="ion-android-star"></i></li>
                                                            <li><i class="ion-android-star"></i></li>
                                                            <li><i class="ion-android-star"></i></li>
                                                            <li><i class="ion-android-star-outline"></i></li>
                                                            <li><i class="ion-android-star-outline"></i></li>
                                                        </ul>
                                                    </div>
                                                    <p><strong>Admin</strong> – September 12, 2022</p>
                                                    <span>roadthemes</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Review form -->
                                        <div class="comment_title">
                                            <h2>Add a review</h2>
                                            <p>Your email address will not be published. Required fields are marked *</p>
                                        </div>

                                        <form class="product_review_form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="review_comment">Your review *</label>
                                                    <textarea name="comment" id="review_comment" required></textarea>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <label for="author">Name *</label>
                                                    <input id="author" type="text" required>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <label for="email">Email *</label>
                                                    <input id="email" type="email" required>
                                                </div>
                                            </div>
                                            <button type="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Product info tabs end -->

        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function () {

            // Add to cart AJAX
            $(document).on('click', '.addToCart', function (e) {
                e.preventDefault();

                const btn = $(this);
                const id = btn.data('id');
                const qty = $('.qty-input').val() || 1;

                $.ajax({
                    url: "{{ route('addToCart.Detail') }}",
                    type: "POST",
                    data: {
                        id: id,
                        qty: qty,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if (res.status === 'success') {
                            $('.cart_count').text(res.count);
                            $('.cart_price').html(`$${res.total.toFixed(2)} <i class="ion-ios-arrow-down"></i>`);
                            // Optional: show success toast / message
                        } else {
                            alert(res.message || 'Failed to add to cart');
                        }
                    },
                    error: function () {
                        alert('Something went wrong! Please try again.');
                    }
                });
            });

        });
    </script>
@endsection
