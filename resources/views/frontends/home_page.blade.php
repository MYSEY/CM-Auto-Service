@extends('layouts.frontend.layouts')
@section('content')
    <!--slider area start-->
    <section class="slider_section mb-80">
        <div class="slider_area slider_carousel owl-carousel">
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
            <div class="single_slider d-flex align-items-center" data-bgimg="{{asset('frontends/assets/img/slider/slide-2.jpg')}}">
                <div class="container">
                   <div class="row">
                       <div class="col-12">
                           <div class="slider_content center">
                                <h1>Accessories  <span>all kinds of tractor trailer</span></h1>
                                <p>Exclusive Offer -30% Off This Week</p>
                            </div>
                       </div>
                   </div>
               </div>
            </div>
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
    <!--slider area end-->

    <!--Categories product area start-->
    <div class="categories_product_area mb-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="categories_product_inner categories_column7 owl-carousel">
                        @foreach($category as $key => $value)
                            <div class="single_categories_product">
                                <div class="categories_product_thumb">
                                    <a href="#"><img src="{{asset('frontends/assets/img/s-product/category1.jpg')}}" alt=""></a>
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
    <!--Categories product area end-->

    <!--home section bg area start-->
    <div class="home_section_bg">
        <!--product area start-->
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
                    <div class="tab-pane fade show active" id="Sellers" role="tabpanel">
                        <div class="row">
                            <div class="product_carousel product_column5 owl-carousel">
                                @foreach($product as $key => $item)
                                    <div class="col-lg-3">
                                        <div class="product_items">
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a class="primary_img" href="{{ url('frontend/product/detail',$item->id) }}"><img src="{{ asset('images/products/' . $item->product_photo) }}" alt=""></a>
                                                        <a class="secondary_img" href="{{ url('frontend/product/detail',$item->id) }}"><img src="{{ asset('images/products/' . $item->product_photo) }}" alt=""></a>
                                                    </div>
                                                    <div class="product_content">
                                                        <div class="product_content_inner">
                                                            <p class="manufacture_product"><a href="#">Parts</a></p>
                                                            <p class="manufacture_product"><a href="#">{{$item->productType->name}}</a></p>
                                                            <h4 class="product_name"><a href="{{ url('frontend/product/detail',$item->id) }}">{{ $item->category->name }} {{ $item->subCategory->name }} {{ $item->subCategory->serial_number }} {{ $item->year }}</a></h4>
                                                            <div class="product_rating">
                                                            <ul>
                                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                            </ul>
                                                            </div>
                                                            <div class="price_box">
                                                                <span class="old_price">$320.00</span>
                                                                <span class="current_price">$120.00</span>
                                                            </div>
                                                        </div>
                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to cart</a></li>
                                                                <li class="wishlist"><a href="wishlist.html"  title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                                                <li class="compare"><a href="compare.html" title="Add to Compare"><i class="icon-rotate-cw"></i></a></li>
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
                    @foreach($productType as $key => $type)
                        <div class="tab-pane fade" id="{{ Str::slug($type->name) }}" role="tabpanel">
                            <div class="row">
                                <div class="product_carousel product_column5 owl-carousel">
                                    @foreach($product->where('product_type_id', $type->id) as $item)
                                        <div class="col-lg-3">
                                            <div class="product_items">
                                                <article class="single_product">
                                                    <figure>
                                                        <div class="product_thumb">
                                                            <a class="primary_img" href="{{ url('frontend/product/detail',$item->id) }}"><img src="{{ asset('images/products/' . $item->product_photo) }}" alt=""></a>
                                                            <a class="secondary_img" href="{{ url('frontend/product/detail',$item->id) }}"><img src="{{ asset('images/products/' . $item->product_photo) }}" alt=""></a>
                                                        </div>
                                                        <div class="product_content">
                                                            <div class="product_content_inner">
                                                                <p class="manufacture_product"><a href="#">Parts</a></p>
                                                                <p class="manufacture_product"><a href="#">{{$item->productType->name}}</a></p>
                                                                <h4 class="product_name"><a href="{{ url('frontend/product/detail',$item->id) }}">{{ $item->category->name }} {{ $item->subCategory->name }} {{ $item->subCategory->serial_number }} {{ $item->year }}</a></h4>
                                                                <div class="product_rating">
                                                                <ul>
                                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                                </ul>
                                                                </div>
                                                                <div class="price_box">
                                                                    <span class="old_price">$320.00</span>
                                                                    <span class="current_price">$120.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="action_links">
                                                                <ul>
                                                                    <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to cart</a></li>
                                                                    <li class="wishlist"><a href="wishlist.html"  title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                                                    <li class="compare"><a href="compare.html" title="Add to Compare"><i class="icon-rotate-cw"></i></a></li>
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
        <!--product area end-->
    </div>
    <!--home section bg area end-->

    <!--brand area start-->
    <div class="brand_area">
        <div class="container">
            <div class="col-12">
                <div class="brand_container owl-carousel ">
                    <div class="brand_list">
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand1.jpg')}}" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand2.jpg')}}" alt=""></a>
                        </div>
                    </div>
                    <div class="brand_list">
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand3.jpg')}}" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand4.jpg')}}" alt=""></a>
                        </div>
                    </div>
                    <div class="brand_list">
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand5.jpg')}}" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand6.jpg')}}" alt=""></a>
                        </div>
                    </div>
                    <div class="brand_list">
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand7.jpg')}}" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand8.jpg')}}" alt=""></a>
                        </div>
                    </div>
                     <div class="brand_list">
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand1.jpg')}}" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand2.jpg')}}" alt=""></a>
                        </div>
                    </div>
                    <div class="brand_list">
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand3.jpg')}}" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand4.jpg')}}" alt=""></a>
                        </div>
                    </div>
                    <div class="brand_list">
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand5.jpg')}}" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="{{asset('frontends/assets/img/brand/brand6.jpg')}}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--brand area end-->

    <!--newsletter area start-->
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
                                   <li><a class="twitter" href="https://t.me/CMAUTO"><i class="icon-twitter2"></i></a></li>
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
                                <!-- mailchimp-alerts Start -->
                                <div class="mailchimp-alerts text-centre">
                                    <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                                    <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                                    <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                                </div><!-- mailchimp-alerts end -->
                            </div>
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
    <!--newsletter area end-->
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function(){
        $(document).on('click', '.addToCart', function () {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('addToCart') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (res) {
                    if (res.status === 'success') {
                        $('.cart_count').text(res.count);
                        $('.cart_price').html(`$${res.total.toFixed(2)} <i class="ion-ios-arrow-down"></i>`);
                    } else {
                        alert(res.message);
                    }
                },
                error: function () {
                    alert('Something went wrong!');
                }
            });
        });
    });
</script>
