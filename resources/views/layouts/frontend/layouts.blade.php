<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CM Auto Service</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS
    ========================= -->

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{asset('frontends/assets/css/plugins.css')}}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('frontends/assets/css/style.css')}}">

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
                            <p><i class="icon-phone-call" aria-hidden="true"></i> <span>Call us: <a href="tel:0314866777">0314866777</a></span></p>
                        </div>
                        <div class="header_account">
                            <ul>
                                <li class="language"><a href="#"><img src="{{asset('frontends/assets/img/logo/language.png')}}" alt=""> english <i class="ion-chevron-down"></i></a>
                                    <ul class="dropdown_language">
                                        <li><a href="#">English</a></li>
                                        <li><a href="#">Germany</a></li>
                                        <li><a href="#">Japanese</a></li>
                                    </ul>
                                </li>
                                <li class="currency"><a href="#">USD <i class="ion-chevron-down"></i></a>
                                    <ul class="dropdown_currency">
                                        <li><a href="#">EUR – Euro</a></li>
                                        <li><a href="#">GBP – British Pound</a></li>
                                        <li><a href="#">INR – India Rupee</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="header_top_links">
                            <ul>
                                <li><a href="cart.html">Shopping Cart</a></li>
                                <li><a href="checkout.html">Checkout</a></li>
                            </ul>
                        </div>
                        <div class="search_container">
                            <form action="#">
                               <div class="hover_category">
                                    <select class="select_option" name="select" id="categori1">
                                        <option selected value="1">All Categories</option>
                                        <option value="2">file service</option>
                                    </select>
                               </div>
                                <div class="search_box">
                                    <input placeholder="Search product..." type="text">
                                    <button type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        <div id="menu" class="text-left ">
                            <ul class="offcanvas_main_menu">
                                class="menu-item-has-children active">
                                    <a href="/">Home</a>
                                    <ul class="sub-menu">
                                        <li><a href="index.html">Home 1</a></li>
                                        <li><a href="index-2.html">Home 2</a></li>
                                        <li><a href="index-3.html">Home 3</a></li>
                                        <li><a href="index-4.html">Home 4</a></li>
                                    </ul>

                                <li class="menu-item-has-children">
                                    <a href="#">Shop</a>
                                    <ul class="sub-menu">
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="my-account.html">my account</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="{{url('about-as')}}">About Us</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="{{url('contact')}}"> Contact Us</a>
                                </li>
                            </ul>
                        </div>
                        <div class="offcanvas_footer">
                            <span><a href="#"><i class="fa fa-envelope-o"></i> info@yourdomain.com</a></span>
                            <ul>
                                <li class="facebook"><a href="https://www.facebook.com/C.M.Auto.77/"><i class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="https://t.me/CMAUTO"><i class="fa fa-twitter"></i></a></li>
                                {{-- <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li> --}}
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
                                    <li class="language"><a href="#"><img src="{{asset('frontends/assets/img/logo/language.png')}}" alt=""> english <i class="ion-chevron-down"></i></a>
                                        <ul class="dropdown_language">
                                            <li><a href="#">English</a></li>
                                            <li><a href="#">Germany</a></li>
                                            <li><a href="#">Japanese</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-7">
                            <div class="header_top_links text-right">
                                <ul>
                                    {{--  <li><a href="login.html">Register</a></li>  --}}
                                    <li><a href="{{ url('logins') }}">login</a></li>
                                    <li><a href="cart.html">Shopping Cart</a></li>
                                    <li><a href="checkout.html">Checkout</a></li>
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
                                <a href="index.html"><img src="{{$company->company_logo}}" alt=""></a>
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
                                        <a href="javascript:void(0)">
                                            <i class="icon-shopping-bag2"></i>
                                            <span class="cart_price">$152.00 <i class="ion-ios-arrow-down"></i></span>
                                            <span class="cart_count">2</span>
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
                                                <div class="cart_item">
                                                   <div class="cart_img">
                                                       <a href="#"><img src="{{asset('frontends/assets/img/s-product/product.jpg')}}" alt=""></a>
                                                   </div>
                                                    <div class="cart_info">
                                                        <a href="#">Fusce Aliquam</a>
                                                        <p>Qty: 1 X <span> $60.00 </span></p>
                                                    </div>
                                                    <div class="cart_remove">
                                                        <a href="#"><i class="ion-android-close"></i></a>
                                                    </div>
                                                </div>
                                                <div class="cart_item">
                                                   <div class="cart_img">
                                                       <a href="#"><img src="{{asset('frontends/assets/img/s-product/product2.jpg')}}" alt=""></a>
                                                   </div>
                                                    <div class="cart_info">
                                                        <a href="#">Ras Neque Metus</a>
                                                         <p>Qty: 1 X <span> $60.00 </span></p>
                                                    </div>
                                                    <div class="cart_remove">
                                                        <a href="#"><i class="ion-android-close"></i></a>
                                                    </div>
                                                </div>

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
                                                    <a href="cart.html">View cart</a>
                                                </div>
                                                <div class="cart_button">
                                                    <a class="active" href="checkout.html">Checkout</a>
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
                        <div class=" col-lg-3">
                            <div class="categories_menu">
                                <div class="categories_title">
                                    <h2 class="categori_toggle">ALL CATEGORIES</h2>
                                </div>
                                <div class="categories_menu_toggle">
                                    <ul>
                                        <li class="menu_item_children"><a href="#">Brake Parts <i class="fa fa-angle-right"></i></a>
                                            <ul class="categories_mega_menu">
                                                <li class="menu_item_children"><a href="#">Dresses</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="">Sweater</a></li>
                                                        <li><a href="">Evening</a></li>
                                                        <li><a href="">Day</a></li>
                                                        <li><a href="">Sports</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu_item_children"><a href="#">Handbags</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="">Shoulder</a></li>
                                                        <li><a href="">Satchels</a></li>
                                                        <li><a href="">kids</a></li>
                                                        <li><a href="">coats</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu_item_children"><a href="#">shoes</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="">Ankle Boots</a></li>
                                                        <li><a href="">Clog sandals </a></li>
                                                        <li><a href="">run</a></li>
                                                        <li><a href="">Books</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu_item_children"><a href="#">Clothing</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="">Coats  Jackets </a></li>
                                                        <li><a href="">Raincoats</a></li>
                                                        <li><a href="">Jackets</a></li>
                                                        <li><a href="">T-shirts</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu_item_children"><a href="#"> Wheels & Tires  <i class="fa fa-angle-right"></i></a>
                                            <ul class="categories_mega_menu column_3">
                                                <li class="menu_item_children"><a href="#">Chair</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="">Dining room</a></li>
                                                        <li><a href="">bedroom</a></li>
                                                        <li><a href=""> Home & Office</a></li>
                                                        <li><a href="">living room</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu_item_children"><a href="#">Lighting</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="">Ceiling Lighting</a></li>
                                                        <li><a href="">Wall Lighting</a></li>
                                                        <li><a href="">Outdoor Lighting</a></li>
                                                        <li><a href="">Smart Lighting</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu_item_children"><a href="#">Sofa</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="">Fabric Sofas</a></li>
                                                        <li><a href="">Leather Sofas</a></li>
                                                        <li><a href="">Corner Sofas</a></li>
                                                        <li><a href="">Sofa Beds</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu_item_children"><a href="#"> Furnitured & Decor <i class="fa fa-angle-right"></i></a>
                                            <ul class="categories_mega_menu column_2">
                                                <li class="menu_item_children"><a href="#">Brake Tools</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="">Driveshafts</a></li>
                                                        <li><a href="">Spools</a></li>
                                                        <li><a href="">Diesel </a></li>
                                                        <li><a href="">Gasoline</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu_item_children"><a href="#">Emergency Brake</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="">Dolls for Girls</a></li>
                                                        <li><a href="">Girls' Learning Toys</a></li>
                                                        <li><a href="">Arts and Crafts for Girls</a></li>
                                                        <li><a href="">Video Games for Girls</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="menu_item_children"><a href="#"> Turbo System <i class="fa fa-angle-right"></i></a>
                                            <ul class="categories_mega_menu column_2">
                                                <li class="menu_item_children"><a href="#">Check Trousers</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="">Building</a></li>
                                                        <li><a href="">Electronics</a></li>
                                                        <li><a href="">action figures </a></li>
                                                        <li><a href="">specialty & boutique toy</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu_item_children"><a href="#">Calculators</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="">Dolls for Girls</a></li>
                                                        <li><a href="">Girls' Learning Toys</a></li>
                                                        <li><a href="">Arts and Crafts for Girls</a></li>
                                                        <li><a href="">Video Games for Girls</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="#"> Lighting</a></li>
                                        <li><a href="#"> Accessories</a></li>
                                        <li><a href="#">Body Parts</a></li>
                                        <li><a href="#">Networking</a></li>
                                        <li><a href="#">Perfomance Filters</a></li>
                                        <li><a href="#"> Engine Parts</a></li>
                                        <li class="hidden"><a href="shop-left-sidebar.html">New Sofas</a></li>
                                        <li class="hidden"><a href="shop-left-sidebar.html">Sleight Sofas</a></li>
                                        <li><a href="#" id="more-btn"><i class="fa fa-plus" aria-hidden="true"></i> More Categories</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="main_menu menu_position text-left">
                                <nav>
                                    <ul>
                                        <li>
                                            <a class="active" href="/">home<i class=""></i></a>
                                        </li>
                                        <li>
                                            <a class="active" href="javascript:void(0)">Ecu Soft<i class="fa fa-angle-down"></i></a>
                                            <ul class="sub_menu">
                                                @foreach($productType as $value)
                                                    <li>
                                                        <a href="{{ url('frontend/product/filter',$value->id) }}">{{ $value->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li><a href="{{url('about-as')}}">About Us</a></li>
                                        <li><a href="{{url('frontend-contact')}}"> Contact Us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="call_support text-right">
                                <p><i class="icon-phone-call" aria-hidden="true"></i> <span>Call us:  <a href="tel:0314866777">0314866777</a></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header bottom end-->
        </div>
    </header>
    <!--header area end-->

    <!--top tags area start-->
    {{-- <div class="top_tags_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tags_content">
                        <ul>
                            <li><span>Top Tags:</span></li>
                            <li><a href="#">Wheels & Tires</a></li>
                            <li><a href="#">Lighting & lamp</a></li>
                            <li><a href="#">Body Parts</a></li>
                            <li><a href="#">Smart Devices</a></li>
                            <li><a href="#">Devices</a></li>
                            <li><a href="#">Repair Parts</a></li>
                            <li><a href="#">Car Engine</a></li>
                            <li><a href="#">Accessories</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

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
                                <p>We are a team of designers and developers that create high quality HTML Template, Woocommerce, Shopify Theme.</p>
                                <p>Your address goes here.. <br> demo@example.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                       <div class="footer_col_container">
                            <div class="widgets_container widget_menu">
                                <h3>Information</h3>
                                <div class="footer_menu">
                                    <ul>
                                        <li><a href="{{url('about-as')}}">About Us</a></li>
                                        <li><a href="#">New products</a></li>
                                        <li><a href="#">Best sales</a></li>
                                        <li><a href="my-account.html">My Account</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="widgets_container widget_menu">
                                <h3>Customer Service</h3>
                                <div class="footer_menu">
                                    <ul>
                                        <li><a href="my-account.html">My Account</a></li>
                                        <li><a href="cart.html">Shopping Cart</a></li>
                                        <li><a href="wishlist.html">Wish List</a></li>
                                        <li><a href="#">Prices drop</a></li>
                                        <li><a href="#">Order History</a></li>
                                        <li><a href="#">International Orders</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="widgets_container widget_menu">
                                <h3>My Account</h3>
                                <div class="footer_menu">
                                    <ul>
                                        <li><a href="my-account.html">My Account</a></li>
                                    </ul>
                                </div>
                            </div>
                            {{-- <div class="widgets_container widget_menu">
                                <h3>Extras</h3>
                                <div class="footer_menu">
                                    <ul>
                                        <li><a href="#">Brands</a></li>
                                        <li><a href="#">Gift Certificates</a></li>
                                        <li><a href="#">Affiliate</a></li>
                                        <li><a href="#">Specials</a></li>
                                        <li><a href="wishlist.html">Wish List</a></li>
                                        <li><a href="#">Newsletter</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="widgets_container widget_menu">
                                <h3>Payment & Methods</h3>
                                <div class="footer_menu">
                                    <ul>
                                        <li><a href="#">Payment Methods</a></li>
                                        <li><a href="my-account.html">My Account</a></li>
                                        <li><a href="#">View All Amazing Deals</a></li>
                                        <li><a href="#">Locations We Ship To</a></li>
                                        <li><a href="#">FAQs</a></li>
                                        <li><a href="#">Estimated Delivery Time</a></li>
                                    </ul>
                                </div>
                            </div> --}}
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
                    {{-- <div class="col-lg-6 col-md-6">
                       <div class="footer_payment text-right">
                            <img src="{{asset('frontends/assets/img/icon/payment.png')}}" alt="">
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </footer>
    <!--footer area end-->

    <!-- modal area start-->
    <div class="modal fade" id="modal_box" tabindex="-1" role="dialog"  aria-hidden="true">
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
    </div>
    <!-- modal area end-->
    <!-- Plugins JS -->
    <script src="{{asset('frontends/assets/js/plugins.js')}}"></script>
    <!-- Main JS -->
    <script src="{{asset('frontends/assets/js/main.js')}}"></script>
</body>
</html>
