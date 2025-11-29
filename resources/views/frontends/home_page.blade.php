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
                    <div class="categories_product_inner categories_column7 owl-carousel">
                        @foreach($category as $key => $value)
                            <div class="single_categories_product">
                                <div class="categories_product_thumb carousel-item active">
                                    <a href="#">
                                        <img class="d-block w-100" src="{{ asset('images/category/' . $value->category_photo) }}" alt="{{ $value->name }}">
                                    </a>
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
                        <div class="vehicle_lookup_area">
                            <div class="container">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-lg-10 col-md-12">
                                        <form class="vehicle_lookup_form d-flex justify-content-between align-items-center" method="GET" action="{{url('frontend/product/search')}}">
                                            @csrf
                                            <div class="single_select_box" style="flex: 1; margin-right: 15px;">
                                                <label for="selectCategory" style="font-weight: 600;">
                                                    <i class="ion-ios-arrow-forward" style="margin-right: 5px; color: #333;"></i> Select Category
                                                </label>
                                                <select name="category_id" id="selectCategory" class="form-control custom-select" style="border: 1px solid red; box-shadow: 0 0 0 1px red;">
                                                    <option value="">-- Select Category --</option>
                                                    @foreach ($category as $item)
                                                        <option value="{{ $item->id }}" {{ isset($selectedFilters['category_id']) && $selectedFilters['category_id'] == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="single_select_box" style="flex: 1; margin-right: 15px;">
                                                <label for="selectSubCategory" style="font-weight: 600;">
                                                    <i class="ion-ios-arrow-forward" style="margin-right: 5px; color: #333;"></i> Select Sub Category
                                                </label>
                                                <select name="sub_category" id="selectSubCategory" class="form-control custom-select sub_category" style="border: 1px solid #ccc; background-color: #ebebeb;">
                                                    <option value="">-- Select Sub Category --</option>
                                                </select>
                                            </div>

                                            <div class="single_select_box" style="flex: 1; margin-right: 15px;">
                                                <label for="selectEngine" style="font-weight: 600;">
                                                    <i class="ion-ios-arrow-forward" style="margin-right: 5px; color: #333;"></i> Select Engine
                                                </label>
                                                <select name="engine_id" id="selectEngine" class="form-control custom-select engine" style="border: 1px solid #ccc; background-color: #ebebeb;">
                                                    <option value="">-- Select Engine --</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary" style="margin-top: 25px; height: 40px; white-space: nowrap; padding: 0 20px;">
                                                Search
                                            </button>
                                        </form>
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
                                <div class="product-grid-container">
                                    @foreach($productAll as $item)
                                        @include('frontends.product', ['item' => $item])
                                    @endforeach
                                </div>
                                <div class="shop_toolbar t_bottom">
                                    <div class="pagination">
                                        <ul>
                                            @if ($productAll->onFirstPage())
                                                <li class="disabled"><span><<</span></li>
                                            @else
                                                <li><a href="{{ $productAll->previousPageUrl() }}"><</a></li>
                                            @endif

                                            @foreach ($productAll->getUrlRange(1, $productAll->lastPage()) as $page => $url)
                                                @if ($page == $productAll->currentPage())
                                                    <li class="current">{{ $page }}</li>
                                                @else
                                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                                @endif
                                            @endforeach

                                            @if ($productAll->hasMorePages())
                                                <li class="next"><a href="{{ $productAll->nextPageUrl() }}">next</a></li>
                                                <li><a href="{{ $productAll->url($productAll->lastPage()) }}">>></a></li>
                                            @else
                                                <li class="disabled"><span>next</span></li>
                                                <li class="disabled"><span>>></span></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach($productType as $type)
                            @php $list = $productsByType[$type->id]; $slug = Str::slug($type->name); @endphp
                            <div class="tab-pane fade {{ $activeTab === $slug ? 'active' : '' }}" id="{{ $slug }}">
                                <div class="row">
                                    <div class="product-grid-container">
                                        @foreach($list as $item)
                                            @include('frontends.product', ['item' => $item])
                                        @endforeach
                                    </div>
                                    <div class="shop_toolbar t_bottom">
                                        <div class="pagination">
                                            <ul>
                                                @if ($productsByType[$type->id]->onFirstPage())
                                                    <li class="disabled"><span><<</span></li>
                                                @else
                                                    <li><a href="{{ $productsByType[$type->id]->previousPageUrl() }}"><</a></li>
                                                @endif

                                                @foreach ($productsByType[$type->id]->getUrlRange(1, $productsByType[$type->id]->lastPage()) as $page => $url)
                                                    @if ($page == $productsByType[$type->id]->currentPage())
                                                        <li class="current">{{ $page }}</li>
                                                    @else
                                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                                    @endif
                                                @endforeach

                                                @if ($productsByType[$type->id]->hasMorePages())
                                                    <li class="next"><a href="{{ $productsByType[$type->id]->nextPageUrl() }}">next</a></li>
                                                    <li><a href="{{ $productsByType[$type->id]->url($productsByType[$type->id]->lastPage()) }}">>></a></li>
                                                @else
                                                    <li class="disabled"><span>next</span></li>
                                                    <li class="disabled"><span>>></span></li>
                                                @endif
                                            </ul>
                                        </div>
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
                                        {{--  <i class="icon-facebook" style="font-size: 50px;"></i>  --}}
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
@endsection

{{-- ****************************************************** --}}
{{-- START: CHAT MESSENGER POP-UP (HTML & JS) --}}
{{-- ****************************************************** --}}

{{-- 1. CHAT BUTTON TRIGGER --}}
<button class="open-chat-button" onclick="toggleChatForm()">
    <i class="ion-chatbubbles" style="font-size: 24px;"></i>
    <span class="chat-badge">Online</span>
</button>

{{-- 2. CHAT POP-UP WINDOW --}}
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
            {{-- Social links inside the Chat Pop-up --}}
            <div class="footer_social">
               <ul class="social-links-row no-li-flex">
                    <a class="facebook" href="https://www.facebook.com/C.M.Auto.77/">
                         <img src="{{ asset('frontends/assets/img/facebook.png') }}" alt="Facebook" width="50" height="50">
                        {{--  <i class="icon-facebook" style="font-size: 50px;"></i>  --}}
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

{{-- 3. JAVASCRIPT --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // ----------------------------------------------------------------------
    // CHAT MESSENGER TOGGLE FUNCTION (Newly added)
    // ----------------------------------------------------------------------
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

    $(window).on('load', function () {
        dataBackgroundImage();
    });
    $(function(){
        document.addEventListener('DOMContentLoaded', function () {
            const params = new URLSearchParams(window.location.search);
            const tab = params.get('tab') || '{{ $activeTab ?? "all" }}';

            // Activate the tab (Bootstrap 5)
            const tabLink = document.querySelector(`#nav-tab a[href="#${tab}"]`);
            if (tabLink) {
                // Note: You must ensure 'bootstrap.Tab' is defined (Bootstrap JS is loaded)
                const bsTab = new bootstrap.Tab(tabLink);
                bsTab.show();
            }

            // When user switches tabs, update URL (so future pagination links include tab)
            document.querySelectorAll('#nav-tab a[data-tab]').forEach(a => {
                a.addEventListener('shown.bs.tab', function (e) {
                    const slug = e.target.getAttribute('data-tab');
                    const url = new URL(window.location);
                    url.searchParams.set('tab', slug);
                    history.replaceState(null, '', url.toString());
                });
            });
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
