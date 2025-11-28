<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CM Auto Service</title>
    <meta name="description" content="CM Auto Service Cambodia — ECU Sell, Original & Tuning Files, Online Programming, Auto Diagnostic, Auto Parts & Repair With 24/7 Hotline Support.">
    <meta property="og:title" content="CM Auto Service — Auto Parts & ECU Programming">
    <meta property="og:description" content="ECU Sell, Original & Tuning Files, Online Programming, Auto Diagnostic & Spare Parts. Fast and professional service with 24/7 Hotline.">
    <meta property="og:url" content="https://cmautoservic.com">
    <meta property="og:image" content="https://cmautoservic.com/frontends/assets/img/logo.png">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="CM Auto Service">

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "CM Auto Service",
            "url": "https://cmautoservic.com",
            "logo": "https://cmautoservic.com/frontends/assets/img/logo.png",
            "contactPoint": [{
                "@type": "ContactPoint",
                "telephone": "+855 0314866777",
                "contactType": "Customer Support"
            }]
        }
    </script>

    <link rel="icon" href="https://cmautoservic.com/frontends/assets/img/logo.png">
    <!-- Favicon -->
    <link rel="icon" href="{{asset('frontends/assets/img/logo.png')}}">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{asset('frontends/assets/css/plugins.css')}}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('frontends/assets/css/style.css?v=20250101')}}">
    {{--  <link rel="stylesheet" href="style.css?v=20250101">  --}}
    <link rel="stylesheet" href="{{asset('frontends/assets/css/cm.css')}}">
    {{-- toastr --}}
    <link rel="stylesheet" media="screen, print" href="{{asset('backends/css/notifications/toastr/toastr.css')}}">
    <style>
        /* first level dropdown */
        .sub_menu {
            display: none;
            position: absolute;
            background: white;
            z-index: 999;
        }
        li:hover > .sub_menu {
            display: block;
        }

        /* second level dropdown (subcategory) */
        .has_sub {
            position: relative;
        }
        .sub_sub_menu1 {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            background: white;
            padding: 24px 30px;
        }
        .has_sub:hover > .sub_sub_menu1 {
            display: block;
        }
        .sub_sub_menu2 {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            background: white;
            padding: 30px 30px;
        }
        .has_sub:hover > .sub_sub_menu2 {
            display: block;
        }
    </style>
</head>

<body>
    <!--header area start-->
    <!--offcanvas menu area start-->
    <div class="off_canvars_overlay">

    </div>
    <div class="offcanvas_menu">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="canvas_open">
                        <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                    </div>
                    <div class="offcanvas_menu_wrapper">
                        <div class="canvas_close">
                            <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                        </div>
                        <div class="call_support">
                            <p><i class="icon-phone-call" aria-hidden="true"></i> <span>Call us: <a href="tel:+8550314866777">+8550314866777</a></span></p>
                        </div>
                        <div class="header_account">
                            <ul>
                                <li class="language"><a href="#"><img src="{{asset('frontends/assets/img/logo/language.png')}}" alt=""> english <i class="ion-chevron-down"></i></a>
                                    <ul class="dropdown_language">
                                        <li><a href="javascript:void(0)">English</a></li>
                                        <li><a href="javascript:void(0)">Khmer</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="header_top_links">
                            <ul>
                                <li><a href="{{ url('logins') }}">login</a></li>
                                <li><a href="javascript:void(0)">Shopping Cart</a></li>
                                <li><a href="javascript:void(0)">Checkout</a></li>
                            </ul>
                        </div>
                        <div id="menu" class="text-left">
                            <ul class="offcanvas_main_menu">
                                <li class="menu-item-has-children active">
                                    <a href="#">Home</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="{{url('contact')}}"> Contact Us</a>
                                </li>
                            </ul>
                        </div>

                        <div class="offcanvas_footer">
                            <span><a href="javascript:void(0)"><i class="fa fa-envelope-o"></i> the.c.m.auto@gmail.com</a></span>
                            <ul>
                                <li class="facebook"><a href="https://www.facebook.com/C.M.Auto.77/"><i class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="https://t.me/CMAUTO"><i class="fa fa-twitter"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--offcanvas menu area end-->

    <header>
        <div class="main_header">
            <!--header top start-->
            <div class="header_top">
               <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-5">
                            <div class="header_account">
                                <ul>
                                    <li class="language"><a href="javascript:void(0)"><img src="{{asset('frontends/assets/img/logo/language.png')}}" alt=""> english <i class="ion-chevron-down"></i></a>
                                        <ul class="dropdown_language">
                                            <li><a href="javascript:void(0)">English</a></li>
                                            <li><a href="javascript:void(0)">Khmer</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-7">
                            <div class="header_top_links text-right">
                                <ul>
                                    <li><a href="{{ url('logins') }}">login</a></li>
                                    <li><a href="javascript:void(0)">Shopping Cart</a></li>
                                    <li><a href="javascript:void(0)">Checkout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header top start-->

            <!--header middel start-->
            <div class="header_middle">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                            <div class="logo">
                                <a href="/"><img src="{{$company->company_logo}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-6 col-sm-6 col-6">
                            <div class="header_right_box">
                                <div class="search_container">
                                    <form action="{{url('category/filter')}}" method="GET">
                                        @csrf
                                       <div class="hover_category">
                                            <select class="select_option" name="category_id" id="category_id">
                                                <option selected value="">All Categories</option>
                                                @foreach($category as $cat)
                                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="search_box">
                                            <input placeholder="Search product..." type="text" name="serial_number" id="serial_number">
                                            <button type="submit" id="btnSearch">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="header_configure_area">
                                    <div class="header_wishlist">
                                        <a href="wishlist.html"><i class="icon-heart"></i>
                                            <span class="wishlist_count">3</span>
                                        </a>
                                    </div>
                                    <div class="mini_cart_wrapper">
                                        <a href="javascript:void(0)" id="cartIcon">
                                            <i class="icon-shopping-bag2"></i>
                                            <span class="cart_price">$0.00 <i class="ion-ios-arrow-down"></i></span>
                                            <span class="cart_count">0</span>
                                        </a>
                                        <!--mini cart-->
                                        <div class="mini_cart">
                                            <div class="mini_cart_inner">
                                                <div class="cart_close">
                                                    <div class="cart_text">
                                                        <h3>cart</h3>
                                                    </div>
                                                    <div class="mini_cart_close">
                                                        <a href="javascript:void(0)"><i class="icon-x"></i></a>
                                                    </div>
                                                </div>
                                                @if(!empty($cart) && count($cart) > 0)
                                                    @foreach ($cart as $item)
                                                    <div class="cart_item">
                                                        <div class="cart_img">
                                                            <a href="#"><img src="{{ asset($item['image']) }}" alt=""></a>
                                                        </div>
                                                        <div class="cart_info">
                                                            <a href="#">{{ $item['name'] }}</a>
                                                            <p>Qty: {{ $item['quantity'] }} X <span>${{ number_format($item['price'],2) }}</span></p>
                                                        </div>
                                                        <div class="cart_remove">
                                                            <a href="javascript:void(0)" class="removeCart" data-id="{{ $item['id'] }}">
                                                                <i class="ion-android-close"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @else
                                                    <p class="text-center mt-3">Cart is empty</p>
                                                @endif

                                                <div class="mini_cart_table">
                                                    <div class="cart_total">
                                                        <span>Sub total:</span>
                                                        <span class="price">$138.00</span>
                                                    </div>
                                                    <div class="cart_total mt-10">
                                                        <span>total:</span>
                                                        <span class="price">$138.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mini_cart_footer">
                                               <div class="cart_button">
                                                    <a href="javascript:void(0)">View cart</a>
                                                </div>
                                                <div class="cart_button">
                                                    <a class="active" href="javascript:void(0)">Checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--mini cart end-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header middel end-->

            <!--header bottom satrt-->
            <div class="header_bottom sticky-header">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-2">
                            {{--  <div class="categories_menu">
                                <div class="categories_title active">
                                    <h2 class="categori_toggle">ALL CATEGORIES</h2>
                                </div>
                                <div class="categories_menu_toggle">
                                    @foreach($category as $cat)
                                        <ul>
                                            <li class="menu_item_children">
                                                <a href="#">{{$cat->name}} <i class="fa fa-angle-right"></i><span class="expand"></span></a>
                                                <ul class="categories_mega_menu column_2">
                                                    @foreach($cat->subCategory as $sub)
                                                        <li>
                                                            <li class="menu_item_children"><a href="#">{{$sub->name}}<span class="expand"></span></a></li>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>  --}}
                        </div>
                        <div class="col-lg-6">
                            <div class="main_menu menu_position text-nowrap">
                                <nav>
                                    <ul>
                                        <li>
                                            <a class="active" href="/">home<i class=""></i></a>
                                        </li>
                                        {{-- <li>
                                            <a class="active" href="javascript:void(0)">Ecu Soft<i class="fa fa-angle-down"></i></a>
                                            <ul class="sub_menu">
                                                @foreach($productType as $value)
                                                    <li>
                                                        <a href="{{ url('frontend/product/filter',$value->id) }}">{{ $value->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li> --}}

                                        @foreach ($productType as $type)
                                            <li>
                                                <a class="active" href="javascript:void(0)">
                                                    {{ $type->name }} <i class="fa fa-angle-down"></i>
                                                </a>
                                                @php
                                                    $categories = $type->products->pluck('category')->unique('id');
                                                @endphp
                                                @foreach ($categories as $category)
                                                    @if ($category)
                                                        <ul class="sub_menu">
                                                            <li class="has_sub">
                                                                <a href="{{ route('product.category.filter', ['category_id' => $category->id]) }}">
                                                                    {{ $category->name }} <i class="fa fa-angle-right"></i>
                                                                </a>
                                                                @if($category->subCategory->count() > 0)
                                                                    <ul class="sub_sub_menu1">
                                                                        @foreach($category->subCategory as $sub)
                                                                            <li class="has_sub">
                                                                                <a href="{{ route('product.suc-category.filter', ['sub_category_id' => $sub->id]) }}">
                                                                                    {{ $sub->name }} <i class="fa fa-angle-right"></i>
                                                                                </a>
                                                                                @if($sub->engine->count() > 0)
                                                                                    <ul class="sub_sub_menu2">
                                                                                        @foreach($sub->engine as $eng)
                                                                                            <li>
                                                                                                <a href="{{ route('product.engine.filter', ['engine_id' => $eng->id]) }}">
                                                                                                    {{ $eng->name }}
                                                                                                </a>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @endif
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    @endif
                                                @endforeach
                                            </li>
                                        @endforeach
                                        {{-- @foreach($productType as $value)
                                            <li>
                                                <a href="{{ url('frontend/product/filter',$value->id) }}">{{ $value->name }}</a>
                                            </li>
                                        @endforeach --}}
                                        <li><a href="{{url('frontend-contact')}}"> Contact Us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <div class="col-lg-4" style="text-align: center;">
                            <div class="call_support">
                                <p><i class="icon-phone-call" aria-hidden="true"></i> <span>Call us:  <a href="tel:+8550314866777">+8550314866777</a></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header bottom end-->
        </div>
    </header>
    <!--header area end-->

    <!--top tags area end-->
    @yield('content')

    <!--footer area start-->
    <footer class="footer_widgets">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="widgets_container">
                            <h3>CONTACT INFO</h3>
                            <div class="footer_contact">
                               <div class="footer_contact_inner">
                                    <div class="contact_icone">
                                        <img src="{{asset('frontends/assets/img/icon/icon-phone.png')}}" alt="">
                                    </div>
                                    <div class="contact_text">
                                        <p>Hotline Free 24/24: <br> <strong><a href="tel:0314866777">0314866777</a> </strong></p>
                                    </div>
                                </div>
                                <p>Your address goes here.. <br> the.c.m.auto@gmail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                       <div class="footer_col_container">
                            <div class="widgets_container widget_menu">
                                <h3>Information</h3>
                                <div class="footer_menu">
                                    <ul>
                                        <li><a href="{{url('frontend-contact')}}"> Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="widgets_container widget_menu">
                                <h3>Customer Service</h3>
                                <div class="footer_menu">
                                    <ul>
                                        @foreach($productType as $proType)
                                            <li><a href="javascript:void(0)">{{$proType->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="copyright_area">
                            <p>&copy; 2025 <a href="#" class="text-uppercase">CM Auto Service</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--footer area end-->

    <!-- modal area start-->
    {{-- <div class="modal fade" id="modal_box" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal_body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <div class="modal_tab">
                                    <div class="tab-content product-details-large">
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" >
                                            <div class="modal_tab_img">
                                                <a href="#"><img src="{{asset('frontends/assets/img/product/productbig1.jpg')}}" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="#"><img src="{{asset('frontends/assets/img/product/productbig2.jpg')}}" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="#"><img src="{{asset('frontends/assets/img/product/productbig3.jpg')}}" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab4" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="#"><img src="{{asset('frontends/assets/img/product/productbig4.jpg')}}" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal_tab_button">
                                        <ul class="nav product_navactive owl-carousel" role="tablist">
                                            <li>
                                                <a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false"><img src="{{asset('frontends/assets/img/product/product2.jpg')}}" alt=""></a>
                                            </li>
                                            <li>
                                                <a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><img src="{{asset('frontends/assets/img/product/product6.jpg')}}" alt=""></a>
                                            </li>
                                            <li>
                                               <a class="nav-link button_three" data-bs-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"><img src="{{asset('frontends/assets/img/product/product9.jpg')}}" alt=""></a>
                                            </li>
                                            <li>
                                               <a class="nav-link" data-bs-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false"><img src="{{asset('frontends/assets/img/product/product3.jpg')}}" alt=""></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-12">
                                <div class="modal_right">
                                    <div class="modal_title mb-10">
                                        <h2>Sit voluptatem rhoncus sem lectus</h2>
                                    </div>
                                    <div class="modal_price mb-10">
                                        <span class="new_price">$64.99</span>
                                        <span class="old_price" >$78.99</span>
                                    </div>
                                    <div class="modal_description mb-15">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum ad impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui nemo ipsum numquam, reiciendis maiores quidem aperiam, rerum vel recusandae </p>
                                    </div>
                                    <div class="variants_selects">
                                        <div class="variants_size">
                                           <h2>size</h2>
                                           <select class="select_option">
                                               <option selected value="1">s</option>
                                               <option value="1">m</option>
                                               <option value="1">l</option>
                                               <option value="1">xl</option>
                                               <option value="1">xxl</option>
                                           </select>
                                        </div>
                                        <div class="variants_color">
                                           <h2>color</h2>
                                           <select class="select_option">
                                               <option selected value="1">purple</option>
                                               <option value="1">violet</option>
                                               <option value="1">black</option>
                                               <option value="1">pink</option>
                                               <option value="1">orange</option>
                                           </select>
                                        </div>
                                        <div class="modal_add_to_cart">
                                            <form action="#">
                                                <input min="1" max="100" step="1" value="1" type="number">
                                                <button type="submit">add to cart</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal_social">
                                        <h2>Share this product</h2>
                                        <ul>
                                            <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                            <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- modal area end-->
    <!-- Plugins JS -->
    <script src="{{asset('frontends/assets/js/plugins.js')}}"></script>
    <!-- Main JS -->
    <script src="{{asset('frontends/assets/js/main.js')}}"></script>
    {{-- toastr --}}
    <script src="{{asset('backends/js/notifications/toastr/toastr.js')}}"></script>
    {!! Toastr::message() !!}
</body>
</html>
