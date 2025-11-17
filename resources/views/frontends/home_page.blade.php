@extends('layouts.frontend.layouts')

@section('content')
    <section class="slider_section mb-80">
        <div class="slider_area slider_carousel owl-carousel">
            {{-- Slider 1: The JS below will read the data-bgimg attribute and set the background-image CSS. --}}
            <div class="single_slider d-flex align-items-center" data-bgimg="{{asset('frontends/assets/img/slider/slide-1.jpg')}}">
               <div class="container">
                   <div class="row">
                       <div class="col-12">
                           <div class="slider_content">
                               <h1>Big sale off <span>Accessories Fidanza</span></h1>
                               <p>Exclusive Offer -30% Off This Week</p>
                           </div>
                       </div>
                   </div>
               </div>
            </div>
            {{-- Slider 2 --}}
            <div class="single_slider d-flex align-items-center" data-bgimg="{{asset('frontends/assets/img/slider/slide-2.jpg')}}">
                 <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="slider_content center">
                                <h1>Accessories  <span>all kinds of tractor trailer</span></h1>
                                <p>Exclusive Offer -30% Off This Week</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Slider 3 --}}
            <div class="single_slider d-flex align-items-center" data-bgimg="{{asset('frontends/assets/img/slider/slide-3.jpg')}}">
                 <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="slider_content">
                                <h1>High-end <span>New car interior</span> </h1>
                                <p>Exclusive Offer -20% Off This Week</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="categories_product_area mb-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="categories_product_inner categories_column7 owl-carousel">
                        @foreach($category as $key => $value)
                            <div class="single_categories_product">
                                <div class="categories_product_thumb">
                                    {{-- Assuming you have a category_photo attribute on your category object --}}
                                    <a href="#"><img src="{{asset('images/categories/' . $value->category_photo)}}" alt="{{ $value->name }}"></a>
                                </div>
                                <div class="categories_product_content">
                                    <h4><a href="#"> {{ $value->name }}</a></h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="home_section_bg">
        <div class="product_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section_title">
                            <h2><span>our</span> Products</h2>
                            <p>Consectetuer sociis mauris eu augue velit pulvinar ullamcorper in ac mauris ac vel, interdum sed malesuada curae sit amet non nec quis arcu massa. </p>
                        </div>
                        <div class="product_tab_btn">
                            <ul class="nav" role="tablist" id="nav-tab">
                                <li>
                                    <a class="active" data-bs-toggle="tab" href="#Sellers" role="tab" aria-controls="Sellers" aria-selected="true">
                                        All
                                    </a>
                                </li>
                                @foreach($productType as $key => $type)
                                    <li>
                                        <a data-bs-toggle="tab" href="#{{ Str::slug($type->name) }}" role="tab" aria-controls="{{ Str::slug($type->name) }}" aria-selected="false">
                                            {{ $type->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="tab-content">
                    {{-- Tab សម្រាប់ All Products (ប្រើ Grid - លុប Carousel ចោល) --}}
                    <div class="tab-pane fade show active" id="Sellers" role="tabpanel">
                        <div class="row">
                            {{-- **កែសម្រួល៖ ប្តូរ Class ពី product_carousel ទៅ product-grid-container** --}}
                            <div class="product-grid-container">
                                @foreach($product as $key => $item)
                                    <div>
                                        <div class="product-card product_items">
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product-image-wrapper product_thumb">
                                                        <a class="primary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                                                            <img src="{{ asset('images/products/' . $item->product_photo) }}" alt="{{ $item->category->name }}">
                                                        </a>
                                                        <a class="secondary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                                                            <img src="{{ asset('images/products/' . $item->product_photo) }}" alt="{{ $item->category->name }}">
                                                        </a>
                                                    </div>
                                                    <div class="product_content">
                                                        <div class="product_content_inner">
                                                            <p class="category"><a href="#">Parts</a></p>
                                                            <p class="category"><a href="#">{{$item->productType->name}}</a></p>
                                                            <h4 class="product-name"><a href="{{ url('frontend/product/detail',$item->id) }}">{{ $item->category->name }} {{ $item->subCategory->name }} {{ $item->subCategory->serial_number }} </a></h4>
                                                            <div class="product_rating">
                                                                {{--  <ul>
                                                                    <li><i class="ion-android-star-outline"></i></li>
                                                                    <li><i class="ion-android-star-outline"></i></li>
                                                                    <li><i class="ion-android-star-outline"></i></li>
                                                                    <li><i class="ion-android-star-outline"></i></li>
                                                                    <li><i class="ion-android-star-outline"></i></li>
                                                                </ul>  --}}
                                                            </div>
                                                            <div class="price_box">
                                                                <span class="current_price price-original"> ${{ number_format($item->price,2) }} {{$item->number}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart addToCart" data-id="{{ $item->id }}">
                                                                    <a href="javascript:void(0)" title="Add to cart">Add to cart</a>
                                                                </li>
                                                                {{-- <li class="wishlist"><a href="wishlist.html"  title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                                                <li class="compare"><a href="compare.html" title="Add to Compare"><i class="icon-rotate-cw"></i></a></li> --}}
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </figure>
                                            </article>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Tab សម្រាប់តាម Product Type (ប្រើ Grid) --}}
                    @foreach($productType as $key => $type)
                        <div class="tab-pane fade" id="{{ Str::slug($type->name) }}" role="tabpanel">
                            <div class="row">
                                <div class="product-grid-container">
                                    {{-- Use $product->where() method to filter by product_type_id --}}
                                    @foreach($product->where('product_type_id', $type->id) as $item)
                                        <div>
                                            <div class="product-card product_items">
                                                <article class="single_product">
                                                    <figure>
                                                        <div class="product-image-wrapper product_thumb">
                                                            <a class="primary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                                                                <img src="{{ asset('images/products/' . $item->product_photo) }}" alt="{{ $item->category->name }}">
                                                            </a>
                                                            <a class="secondary_img" href="{{ url('frontend/product/detail',$item->id) }}">
                                                                <img src="{{ asset('images/products/' . $item->product_photo) }}" alt="{{ $item->category->name }}">
                                                            </a>
                                                        </div>
                                                        <div class="product_content">
                                                            <div class="product_content_inner">
                                                                <p class="category"><a href="#">Parts</a></p>
                                                                <p class="category"><a href="#">{{$item->productType->name}}</a></p>
                                                                <h4 class="product-name"><a href="{{ url('frontend/product/detail',$item->id) }}">{{ $item->category->name }} {{ $item->subCategory->name }} {{ $item->subCategory->serial_number }} {{ $item->year }}</a></h4>
                                                                <div class="product_rating">
                                                                    {{--  <ul>
                                                                        <li><i class="ion-android-star-outline"></i></li>
                                                                        <li><i class="ion-android-star-outline"></i></li>
                                                                        <li><i class="ion-android-star-outline"></i></li>
                                                                        <li><i class="ion-android-star-outline"></i></li>
                                                                        <li><i class="ion-android-star-outline"></i></li>
                                                                    </ul>  --}}
                                                                </div>
                                                                <div class="price_box">
                                                                    <span class="current_price price-original">${{ number_format($item->price,2) }} {{$item->number}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="action_links">
                                                                <ul>
                                                                    <li class="add_to_cart addToCart" data-id="{{ $item->id }}">
                                                                        <a href="javascript:void(0)" title="Add to cart">Add to cart</a>
                                                                    </li>
                                                                    {{-- <li class="wishlist"><a href="wishlist.html"  title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                                                    <li class="compare"><a href="compare.html" title="Add to Compare"><i class="icon-rotate-cw"></i></a></li> --}}
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </figure>
                                                </article>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="brand_area">
        <div class="container">
            <div class="col-12">
                <div class="brand_container owl-carousel ">
                    {{-- Loop simplified to show 8 brands using the naming convention brand1.jpg to brand8.jpg --}}
                    @for ($i = 1; $i <= 8; $i += 2)
                        <div class="brand_list">
                            <div class="single_brand">
                                <a href="#"><img src="{{asset('frontends/assets/img/brand/brand'.$i.'.jpg')}}" alt="Brand {{ $i }}"></a>
                            </div>
                            @if($i + 1 <= 8)
                                <div class="single_brand">
                                    <a href="#"><img src="{{asset('frontends/assets/img/brand/brand'.($i+1).'.jpg')}}" alt="Brand {{ $i+1 }}"></a>
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <div class="newsletter_area">
        <div class="container">
            <div class="newsletter_inner">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="newsletter_container">
                            <h3>Follow Us</h3>
                            <p>We make consolidating, marketing and tracking your social media website easy.</p>
                            <div class="footer_social">
                                <ul>
                                    <li><a class="facebook" href="https://www.facebook.com/C.M.Auto.77/"><i class="icon-facebook"></i></a></li>
                                    <li>
                                        <a class="telegram" href="https://t.me/CMAUTO">
                                            {{-- Assuming this Telegram icon is linked via storage --}}
                                            <img src="{{ asset('storage/companys/telegram.png') }}" alt="Telegram" width="50" height="50" style="display: block; margin: 0 auto;">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="newsletter_container">
                            <h3>Newsletter Now</h3>
                            <p>Join 60.000+ subscribers and get a new discount coupon on every Wednesday.</p>
                            <div class="subscribe_form">
                                <form id="mc-form" class="mc-form footer-newsletter" >
                                    <input id="mc-email" type="email" autocomplete="off" placeholder="Enter you email address here..." />
                                    <button id="mc-submit">Subscribe</button>
                                </form>
                                <div class="mailchimp-alerts text-centre">
                                    <div class="mailchimp-submitting"></div><div class="mailchimp-success"></div><div class="mailchimp-error"></div></div></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-7">
                        <div class="newsletter_container col_3">
                            <h3>GET THE APP</h3>
                            <p>CM Auto Service App is now available on Google Play & App Store. Get it now.</p>
                            <div class="app_img">
                                <ul>
                                    <li><a href="#"><img src="{{asset('frontends/assets/img/icon/icon-app.jpg')}}" alt=""></a></li>
                                    <li><a href="#"><img src="{{asset('frontends/assets/img/icon/icon1-app.jpg')}}" alt=""></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--
    IMPORTANT: The script below must be placed after the content section
    (either here or in your master layout's @push('scripts') section)
    for jQuery to be available.
--}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    /*
        FUNCTION 1: FIXES THE SLIDER BACKGROUND IMAGE ISSUE
        This function finds all elements with 'data-bgimg' and applies the image path
        as a CSS background-image property.
    */
    function dataBackgroundImage() {
        $('[data-bgimg]').each(function () {
            var bgImgUrl = $(this).data('bgimg');
            $(this).css({
                'background-image': 'url(' + bgImgUrl + ')',
            });
        });
    }

    // Run the background image function when the window finishes loading
    $(window).on('load', function () {
        dataBackgroundImage();
    });

    /* FUNCTION 2: ORIGINAL ADD TO CART LOGIC
        Uses AJAX to handle adding products to the cart based on the data-id attribute.
    */
    $(function(){
        $(document).on('click', '.addToCart', function () {
            let id = $(this).data('id');
            // Prevent default action (like navigating to cart.html)
            event.preventDefault();

            $.ajax({
                url: "{{ route('addToCart') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (res) {
                    if (res.status === 'success') {
                        // Update cart count and price in the header (assuming these elements exist)
                        $('.cart_count').text(res.count);
                        $('.cart_price').html(`$${res.total.toFixed(2)} <i class="ion-ios-arrow-down"></i>`);
                        alert('Product added to cart successfully!');
                    } else {
                        alert(res.message || 'Failed to add product to cart!');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert('Something went wrong!');
                }
            });
        });
        $(document).on('click', '#cartIcon', function () {
            $('.mini_cart').toggleClass('open');
            loadMiniCart(); // Load items each time user opens mini cart
        });
    });
    function loadMiniCart() {
        $.ajax({
            url: "{{ route('loadMiniCart') }}",
            type: "GET",
            success: function (res) {
                $('.mini_cart_inner').html(res);
            }
        });
    }
</script>

