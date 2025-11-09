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
                                <li>
                                    <a data-bs-toggle="tab" href="#Featured" role="tab" aria-controls="Featured" aria-selected="false">
                                        Featured Products
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tab" href="#Arrivals" role="tab" aria-controls="Arrivals" aria-selected="false">
                                       New Arrivals
                                    </a>
                                </li>
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
                                                        {{-- <div class="label_product">
                                                            <span class="label_sale">-56%</span>
                                                        </div> --}}
                                                        {{-- <div class="quick_button">
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                        </div> --}}
                                                    </div>
                                                    <div class="product_content">
                                                        <div class="product_content_inner">
                                                            <p class="manufacture_product"><a href="#">Parts</a></p>
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
                    <div class="tab-pane fade" id="Featured" role="tabpanel">
                        <div class="row">
                            <div class="product_carousel product_column5 owl-carousel">
                               <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product7.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product8.jpg" alt=""></a>

                                                    <div class="label_product">
                                                        <span class="label_new">new</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Ras Neque Metus</a></h4>
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
                                                            <span class="old_price">$430.00</span>
                                                            <span class="current_price">$220.00</span>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product9.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product10.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-56%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Mauris Vel Tellus</a></h4>
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
                                                            <span class="old_price">$420.00</span>
                                                            <span class="current_price">$180.00</span>
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
                               <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product11.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product12.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-48%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Donec Non Est</a></h4>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product1.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product2.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-52%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Cas Meque Metus</a></h4>
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
                                                            <span class="old_price">$420.00</span>
                                                            <span class="current_price">$180.00</span>
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
                               <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product1.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product2.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-56%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Nunc Neque Eros</a></h4>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product1.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product2.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_new">new</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Mauris Vel Tellus</a></h4>
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
                                                            <span class="old_price">$420.00</span>
                                                            <span class="current_price">$180.00</span>
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
                               <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product3.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product4.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-52%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Lorem Ipsum Lec</a></h4>
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
                                                            <span class="old_price">$310.00</span>
                                                            <span class="current_price">$110.00</span>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product5.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product6.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-45%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Proin Lectus Ipsum</a></h4>
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
                                                            <span class="old_price">$350.00</span>
                                                            <span class="current_price">$190.00</span>
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
                               <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product3.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product4.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_new">new</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Letraset Sheets</a></h4>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product5.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product6.jpg" alt=""></a>

                                                    <div class="label_product">
                                                        <span class="label_sale">-56%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Etiam Gravida</a></h4>
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
                                                            <span class="old_price">$420.00</span>
                                                            <span class="current_price">$180.00</span>
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
                               <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product7.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product8.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-52%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Nunc Neque Eros</a></h4>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product9.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product10.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-44%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Cas Meque Metus</a></h4>
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
                                                            <span class="old_price">$420.00</span>
                                                            <span class="current_price">$180.00</span>
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
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Arrivals" role="tabpanel">
                        <div class="row">
                            <div class="product_carousel product_column5 owl-carousel">
                              <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product7.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product8.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-52%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Nunc Neque Eros</a></h4>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product9.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product10.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-44%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Cas Meque Metus</a></h4>
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
                                                            <span class="old_price">$420.00</span>
                                                            <span class="current_price">$180.00</span>
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
                               <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product3.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product4.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-52%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Lorem Ipsum Lec</a></h4>
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
                                                            <span class="old_price">$310.00</span>
                                                            <span class="current_price">$110.00</span>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product5.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product6.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-45%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Proin Lectus Ipsum</a></h4>
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
                                                            <span class="old_price">$350.00</span>
                                                            <span class="current_price">$190.00</span>
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
                               <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product7.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product8.jpg" alt=""></a>

                                                    <div class="label_product">
                                                        <span class="label_new">new</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Ras Neque Metus</a></h4>
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
                                                            <span class="old_price">$430.00</span>
                                                            <span class="current_price">$220.00</span>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product9.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product10.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-56%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Mauris Vel Tellus</a></h4>
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
                                                            <span class="old_price">$420.00</span>
                                                            <span class="current_price">$180.00</span>
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
                               <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product11.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product12.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-48%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Donec Non Est</a></h4>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product1.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product2.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-52%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Cas Meque Metus</a></h4>
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
                                                            <span class="old_price">$420.00</span>
                                                            <span class="current_price">$180.00</span>
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
                               <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product1.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product2.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_sale">-56%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Nunc Neque Eros</a></h4>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product1.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product2.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_new">new</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Mauris Vel Tellus</a></h4>
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
                                                            <span class="old_price">$420.00</span>
                                                            <span class="current_price">$180.00</span>
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
                               <div class="col-lg-3">
                                   <div class="product_items">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product3.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product4.jpg" alt=""></a>
                                                    <div class="label_product">
                                                        <span class="label_new">new</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Letraset Sheets</a></h4>
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
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="product-details.html"><img src="assets/img/product/product5.jpg" alt=""></a>
                                                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product6.jpg" alt=""></a>

                                                    <div class="label_product">
                                                        <span class="label_sale">-56%</span>
                                                    </div>
                                                    <div class="quick_button">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product_content">
                                                    <div class="product_content_inner">
                                                        <p class="manufacture_product"><a href="#">Parts</a></p>
                                                        <h4 class="product_name"><a href="product-details.html">Etiam Gravida</a></h4>
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
                                                            <span class="old_price">$420.00</span>
                                                            <span class="current_price">$180.00</span>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--product area end-->
    </div>
    <!--home section bg area end-->




    <!--shop  area start-->
    {{-- <div class="shop_fullwidth">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shop_toolbar_wrapper">
                        <div class="shop_toolbar_btn">
                            <button data-role="grid_4" type="button"  class="active btn-grid-4" data-bs-toggle="tooltip" title="4"></button>
                            <button data-role="grid_3" type="button" class=" btn-grid-3" data-bs-toggle="tooltip" title="3"></button>
                            <button data-role="grid_list" type="button"  class="btn-list" data-bs-toggle="tooltip" title="List"></button>
                        </div>
                        <div class=" niceselect_option">
                            <form class="select_option" action="#">
                                <select name="orderby" id="short">
                                    <option selected value="1">Sort by average rating</option>
                                    <option  value="2">Sort by popularity</option>
                                    <option value="3">Sort by newness</option>
                                    <option value="4">Sort by price: low to high</option>
                                    <option value="5">Sort by price: high to low</option>
                                    <option value="6">Product Name: Z</option>
                                </select>
                            </form>
                        </div>
                        <div class="page_amount">
                            <p>Showing {{ $product->firstItem() }} - {{ $product->lastItem() }} of {{ $product->total() }} results</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table_desc wishlist">
                                <div class="cart_page">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>File name</th>
                                                <th class="product_total">Add To Cart</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product as $key => $item)
                                                <tr>
                                                    <td><a href="{{ url('frontend/product/detail',$item->id) }}">{{ $item->category->name }} {{ $item->subCategory->name }} {{ $item->subCategory->serial_number }} {{ $item->year }}</a></td>
                                                    <td class="product_total">
                                                        <button class="btn btn-sm btn-primary addToCart" data-id="{{ $item->id }}">
                                                            <i class="icon-shopping-bag2"></i> Add To Cart
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="shop_toolbar t_bottom">
                        <div class="pagination">
                            <ul>
                                @if ($product->onFirstPage())
                                    <li class="disabled"><span><<</span></li>
                                @else
                                    <li><a href="{{ $product->previousPageUrl() }}"><</a></li>
                                @endif

                                @foreach ($product->getUrlRange(1, $product->lastPage()) as $page => $url)
                                    @if ($page == $product->currentPage())
                                        <li class="current">{{ $page }}</li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                @if ($product->hasMorePages())
                                    <li class="next"><a href="{{ $product->nextPageUrl() }}">next</a></li>
                                    <li><a href="{{ $product->url($product->lastPage()) }}">>></a></li>
                                @else
                                    <li class="disabled"><span>next</span></li>
                                    <li class="disabled"><span>>></span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!--shop  area end-->

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
                                   {{-- <li><a class="rss" href="#"><i class="icon-rss"></i></a></li>
                                   <li><a class="youtube" href="#"><i class="icon-youtube"></i></a></li>
                                   <li><a class="google" href="#"><i class="icon-google"></i></a></li>
                                   <li><a class="instagram2" href="#"><i class="icon-instagram2"></i></a></li> --}}
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
