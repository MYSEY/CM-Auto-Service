@extends('layouts.frontend.layouts')

@section('content')
    <section class="slider_section mb-80">
        <div class="slider_area slider_carousel owl-carousel">
            @foreach($slider as $slide)
                <div class="single_slider d-flex align-items-center" data-bgimg="{{ asset('images/sliders/' . $slide->image_slider) }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="slider_content">
                                    <h1>{{ $slide->title }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <div class="categories_product_area mb-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="slider-wrapper-css">
                        <div class="categories_product_inner slider-track-css">
                            @foreach($category as $key => $value)
                                <div class="single_categories_product slide-item-css">
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
                        <div class="vehicle_lookup_area">
                            <div class="container">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-lg-10 col-md-12">
                                        <input type="text" id="search_product" class="form-control" placeholder="Search product...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product_tab_btn" id="productTabContainer">
                        <ul class="nav" role="tablist" id="nav-tab">
                            <li>
                                <a class="active tab-link" data-bs-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true" data-tab-name="ALL">
                                    All
                                </a>
                            </li>
                            @foreach($productType as $key => $type)
                                <li>
                                    <a class="tab-link" data-bs-toggle="tab" href="#{{ Str::slug($type->name) }}" role="tab" aria-controls="{{ Str::slug($type->name) }}" aria-selected="false" data-tab-name="{{ $type->name }}">
                                        {{ $type->name }}
                                    </a>
                                </li>
                            @endforeach
                            <div class="sliding-underline" style="position: absolute; bottom: 0; height: 2px; background-color: red; transition: left 0.3s ease, width 0.3s ease;"></div>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show {{ $activeTab === 'all' ? 'active' : '' }}" id="all" role="tabpanel">
                            <div class="row">
                                <div id="productContent">
                                    @include('frontends.product_list', ['products' => $productAll])
                                </div>
                            </div>
                        </div>

                        @foreach($productType as $type)
                            @php $list = $productsByType[$type->id]; $slug = Str::slug($type->name); @endphp
                            <div class="tab-pane fade {{ $activeTab === $slug ? 'active' : '' }}" id="{{ $slug }}">
                                <div class="row">
                                    <div id="productContent_{{ $slug }}">
                                        @include('frontends.product_list', ['products' => $list, 'tab' => $slug])
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="brand_area">
        <div class="container">
            <div class="col-12">
                <div class="brand_container owl-carousel ">
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
                                <ul class="social-links-row no-li-flex">
                                    <a class="facebook" href="https://www.facebook.com/C.M.Auto.77/">
                                        <img src="{{ asset('frontends/assets/img/facebook.png') }}" alt="Facebook" width="50" height="50">
                                    </a>

                                    <a class="telegram" href="https://t.me/CMAUTO">
                                        <img src="{{ asset('frontends/assets/img/telegram.png') }}" alt="Telegram" width="50" height="50">
                                    </a>

                                    <a class="whatsapp" href="https://t.me/CMAUTO">
                                        <img src="{{ asset('frontends/assets/img/whatapp.png') }}" alt="WhatsApp" width="50" height="50">
                                    </a>
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
                                    <div class="mailchimp-submitting"></div>
                                    <div class="mailchimp-success"></div>
                                    <div class="mailchimp-error"></div>
                                </div>
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
</div>
<button class="open-chat-button" onclick="toggleChatForm()">
    <i class="ion-chatbubbles" style="font-size: 24px;"></i>
    <span class="chat-badge">Online</span>
</button>

<div class="chat-popup" id="myForm">
    <form action="/submit-chat-message" class="chat-form-container" method="POST">
        @csrf
        <div class="chat-header-style">
            <h3>Online Programming</h3>
            <button type="button" class="btn-close-chat" onclick="toggleChatForm()">
                &times;
            </button>
        </div>

        <div class="chat-body-style">
            <p>👋 Welcome</p>
            <div class="footer_social">
               <ul class="social-links-row no-li-flex">
                    <a class="facebook" href="https://www.facebook.com/C.M.Auto.77/">
                        <img src="{{ asset('frontends/assets/img/facebook.png') }}" alt="Facebook" width="50" height="50">
                    </a>

                    <a class="telegram" href="https://t.me/CMAUTO">
                        <img src="{{ asset('frontends/assets/img/telegram.png') }}" alt="Telegram" width="50" height="50">
                    </a>

                    <a class="whatsapp" href="https://t.me/CMAUTO">
                        <img src="{{ asset('frontends/assets/img/whatapp.png') }}" alt="WhatsApp" width="50" height="50">
                    </a>
                </ul>
            </div>
        </div>
    </form>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(window).on('load', function () {
        dataBackgroundImage();
    });
    $(function(){
        let timer = null;
        $("#search_product").on('keyup', function () {
            clearTimeout(timer);
            let keyword = $(this).val();

            timer = setTimeout(function () {

                $.ajax({
                    url: "{{ url('frontend/product/search') }}",
                    method: "GET",
                    data: {
                        keyword: keyword,
                        ajax: 4
                    },
                    success: function (response) {
                        // update all tabs
                        $("div[id^='productContent']").html(response.html);
                    }
                });

            }, 300);
        });

        loadProducts();
        // Click tab
        $('.tab-link').click(function (e) {
            e.preventDefault();
            let tab = $(this).attr('data-tab-name').toLowerCase();
            loadProducts("{{ route('products.index') }}?tab=" + tab);
        });
        // ... rest of your existing AJAX and jQuery functions ...
        $(document).on('click', '.addToCart', function () {
            let id = $(this).data('id');
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

        $(document).off("submit", ".vehicle_lookup_form").on("submit", ".vehicle_lookup_form", function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "{{ url('frontend/product/search') }}",
                method: "GET",
                data: formData + "&ajax=1",
                success: function(response) {
                    $("#productContent").html(response.html);
                }
            });
        });

        $(document).on('click', '#cartIcon', function () {
            $('.mini_cart').toggleClass('open');
            loadMiniCart();
        });
        $("#selectCategory").on('change',function(){
            var category_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ url('frontend-categorys') }}",
                data: {
                    category_id:category_id
                },
                dataType: "JSON",
                success: function (response) {
                    $(".sub_category").empty();
                    $(".sub_category").empty().append('<option value="">Please Select</option>');
                    $.each(response.data, function(index, item)
                    {
                        $(".sub_category").append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            });
        });
        $("#selectSubCategory").on('change',function(){
            var sub_category_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ url('frontend-sub-categorys') }}",
                data: {
                    sub_category_id:sub_category_id
                },
                dataType: "JSON",
                success: function (response) {
                    $(".engine").empty();
                    $(".engine").empty().append('<option value="">Please Select</option>');
                    $.each(response.data, function(index, item)
                    {
                        $(".engine").append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            });
        });
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let tab = new URL(url).searchParams.get('tab') || 'all';
            let container = tab === 'all' ? '#productContent' : '#productContent_' + tab;

            $.get(url, function(res) {
                $(container).html(res.html);
            });
        });
    });
    function loadProducts(url) {
        $.get(url, function(res) {
            $('#productContent').html(res.html);
        });
    }
    function loadMiniCart() {
        $.ajax({
            url: "{{ route('loadMiniCart') }}",
            type: "GET",
            success: function (res) {
                $('.mini_cart_inner').html(res);
            }
        });
    }
    function toggleChatForm() {
        var chatForm = document.getElementById("myForm");
        if (chatForm.style.display === "block") {
            chatForm.style.display = "none";
        } else {
            chatForm.style.display = "block";
        }
    }
    // ----------------------------------------------------------------------

    function dataBackgroundImage() {
        $('[data-bgimg]').each(function () {
            var bgImgUrl = $(this).data('bgimg');
            $(this).css({
                'background-image': 'url(' + bgImgUrl + ')',
            });
        });
    }
</script>
