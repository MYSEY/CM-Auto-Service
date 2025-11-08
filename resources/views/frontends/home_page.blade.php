@extends('layouts.frontend.layouts')
<style>
/* ប្រើ dark theme សម្រាប់ទំព័រទាំងមូល */
body {
    background-color: #121212;
    color: #e0e0e0;
    font-family: Arial, sans-serif;
    padding: 20px;
}

.file-list-container {
    /* កែសម្រួល: យក max-width ចេញ ឬកំណត់ជា 100% សម្រាប់ Full Width */
    max-width: 100%;
    margin: 0 auto;
}

/* Header Utility (DTC OFF) */
.header-utility {
    text-align: center;
    padding: 15px;
    margin-bottom: 20px;
    background-color: #333;
    border-radius: 5px;
    border-bottom: 3px solid #E60000; /* ពណ៌ក្រហម */
}

.dtc-off-link {
    color: #E60000;
    font-size: 1.2em;
    font-weight: bold;
    text-decoration: none;
}

.dtc-off-link:hover {
    color: #fff;
}

/* Controls Section: ត្រូវតែមាន 100% width */
.file-list-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    background-color: #1e1e1e;
    padding: 10px;
    border-radius: 5px;
    /* បញ្ជាក់ 100% width */
    width: 100%;
}

.controls-left, .controls-center, .controls-right {
    display: flex;
    align-items: center;
}

.icon-button {
    color: #e0e0e0;
    padding: 5px 8px;
    margin-right: 5px;
    cursor: pointer;
    border: 1px solid #333;
    border-radius: 3px;
    background-color: #333;
}

.icon-button:hover {
    background-color: #555;
}

.showing {
    margin: 0 5px 0 10px;
}

.dropdown {
    background-color: #333;
    color: #e0e0e0;
    border: 1px solid #555;
    padding: 5px;
    border-radius: 3px;
    cursor: pointer;
}

/* Pagination */
.pagination .page-link {
    color: #e0e0e0;
    padding: 5px 10px;
    text-decoration: none;
    margin: 0 2px;
    border-radius: 3px;
}

.pagination .page-link.active {
    background-color: #E60000;
    color: #fff;
    font-weight: bold;
}

.pagination .page-link:hover:not(.active) {
    background-color: #333;
}

.bottom-pagination {
    margin-top: 20px;
    text-align: center;
}

/* Search Section: ត្រូវតែមាន 100% width */
.search-section {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    /* បញ្ជាក់ 100% width */
    width: 100%;
}

.original-files-text {
    font-size: 1.2em;
    font-weight: bold;
    color: #E60000;
    margin-right: 20px;
}

.search-box-wrapper {
    display: flex;
    /* ត្រូវតែ flex-grow: 1 ដើម្បីឲ្យវាពេញ width ដែលនៅសល់ */
    flex-grow: 1;
    /* យក max-width ចេញ ព្រោះយើងចង់ឲ្យវាពេញ */
    max-width: none;
}

.search-input {
    flex-grow: 1;
    padding: 10px 15px;
    border: none;
    border-radius: 5px 0 0 5px;
    background-color: #333;
    color: #e0e0e0;
}

.search-input::placeholder {
    color: #888;
}

.search-button {
    background-color: #E60000;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
}

.search-button:hover {
    background-color: #cc0000;
}

/* File Table */
.file-table {
    /* កែសម្រួល: ត្រូវតែមាន 100% width */
    width: 100%;
    border-collapse: collapse;
    background-color: #1e1e1e;
    border-radius: 5px;
    overflow: hidden;
}

.file-table th {
    background-color: #333;
    color: #E60000;
    padding: 12px 15px;
    text-align: left;
    font-size: 0.9em;
    text-transform: uppercase;
}

.file-table td {
    padding: 15px;
    border-top: 1px solid #2a2a2a;
}

.file-table tbody tr:hover {
    background-color: #2a2a2a;
}

.file-details {
    display: flex;
    flex-direction: column;
}

.sub-detail {
    font-size: 0.8em;
    color: #888;
    margin-top: 5px;
}

.cart-button {
    background: none;
    border: none;
    color: #E60000;
    font-size: 1.2em;
    cursor: pointer;
    padding: 5px;
    transition: color 0.2s;
}

.cart-button:hover {
    color: #fff;
}
</style>
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
                                <a class="button" href="{{url('shop')}}">shopping now <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
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
                                <a class="button" href="{{url('shop')}}">shopping now <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
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
                                <a class="button" href="{{url('shop')}}">shopping now <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                            </div>
                       </div>
                   </div>
               </div>
            </div>
        </div>
    </section>
    <!--slider area end-->

  <!--banner area start-->
    <div class="banner_area mb-80">
        <div class="container">
           <div class="row">
               {{--  <div class="col-12">
                   <div class="welcome_title">
                       <h3>WELCOME TO CM Auto Service</h3>
                       <h2>CUSTOM <span>SHOPPING STORE ONLINE</span></h2>
                       <p>Designer Accessories. Locally Designed. Globally Crafted.</p>
                   </div>
               </div>  --}}
           </div>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/bg/banner1.jpg')}}" alt=""></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/bg/banner2.jpg')}}" alt=""></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/bg/banner3.jpg')}}" alt=""></a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!--banner area end-->

    <!--Categories product area start-->
    <div class="categories_product_area mb-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="categories_product_inner categories_column7 owl-carousel">
                        <div class="single_categories_product">
                            <div class="categories_product_thumb">
                                <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/s-product/category1.jpg')}}" alt=""></a>
                            </div>
                            <div class="categories_product_content">
                                <h4><a href="{{url('shop')}}"> Body Parts</a></h4>
                            </div>
                        </div>
                        <div class="single_categories_product">
                            <div class="categories_product_thumb">
                                <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/s-product/category2.jpg')}}" alt=""></a>
                            </div>
                            <div class="categories_product_content">
                                <h4><a href="{{url('shop')}}"> Car engine</a></h4>
                            </div>
                        </div>
                        <div class="single_categories_product">
                            <div class="categories_product_thumb">
                                <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/s-product/category3.jpg')}}" alt=""></a>
                            </div>
                            <div class="categories_product_content">
                                <h4><a href="{{url('shop')}}"> Interiors</a></h4>
                            </div>
                        </div>
                        <div class="single_categories_product">
                            <div class="categories_product_thumb">
                                <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/s-product/category4.jpg')}}" alt=""></a>
                            </div>
                            <div class="categories_product_content">
                                <h4><a href="{{url('shop')}}"> Lighting & lamp</a></h4>
                            </div>
                        </div>
                        <div class="single_categories_product">
                            <div class="categories_product_thumb">
                                <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/s-product/category5.jpg')}}" alt=""></a>
                            </div>
                            <div class="categories_product_content">
                                <h4><a href="{{url('shop')}}"> Repair Parts</a></h4>
                            </div>
                        </div>
                        <div class="single_categories_product">
                            <div class="categories_product_thumb">
                                <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/s-product/category6.jpg')}}" alt=""></a>
                            </div>
                            <div class="categories_product_content">
                            <h4><a href="{{url('shop')}}"> Smart Devices</a></h4>
                            </div>
                        </div>
                        <div class="single_categories_product">
                            <div class="categories_product_thumb">
                                <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/s-product/category7.jpg')}}" alt=""></a>
                            </div>
                            <div class="categories_product_content">
                                <h4><a href="{{url('shop')}}"> Wheels & Tires</a></h4>
                            </div>
                        </div>
                        <div class="single_categories_product">
                        <div class="categories_product_thumb">
                            <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/s-product/category3.jpg')}}" alt=""></a>
                        </div>
                            <div class="categories_product_content">
                                <h4><a href="{{url('shop')}}"> Smart Devices</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Categories product area end-->

    <!--home section bg area start-->
   <div class="file-list-container">

    <div class="file-list-controls">
        <div class="controls-left">
            <span class="icon-button"><i class="fa fa-th-list"></i></span>
            <span class="icon-button"><i class="fa fa-list"></i></span>
            <span class="showing">Showing</span>
            <select class="dropdown">
                <option value="15">15</option>
            </select>
        </div>
        <div class="controls-center">
            <div class="pagination">
                <a href="#" class="page-link active">1</a>
                <a href="#" class="page-link">2</a>
                <a href="#" class="page-link">Next ›</a>
            </div>
        </div>
        <div class="controls-right">
            <span>Pages 1 of X</span>
        </div>
    </div>

    <div class="search-section">
        <span class="original-files-text">>> ORIGINAL FILES</span>
        <div class="search-box-wrapper">
            <input type="text" placeholder="Search in Original Files" class="search-input">
            <button class="search-button"><i class="fa fa-search"></i></button>
        </div>
    </div>

    <div class="table-responsive-wrapper">
        <table class="file-table">
            <thead>
                <tr>
                    <th>File name</th>
                    <th>Price / Discount</th>
                    <th>Add To Cart</th>
                </tr>
            </thead>
            <tbody>
                {{-- ចាប់ផ្តើម Loop ចូលក្នុង table rows --}}
                @foreach($product as $key => $item)
                    <tr>
                        <td>
                            <div class="file-details">
                                {{-- ធាតុ File Name --}}
                                <a href="{{ url('frontend/product/detail',$item->id) }}" class="product_name_link">
                                    {{ $item->name }}
                                </a>
                                {{-- ធាតុ Sub-detail អាចជា description ឬ flash info --}}
                                <span class="sub-detail">
                                    Price: ${{ number_format($item->price,2) }} | Discount: ${{ number_format($item->discount_price,2) }}
                                </span>
                            </div>
                        </td>
                        <td class="price-cell">
                            {{-- ធាតុតម្លៃ --}}
                            <div class="price_box">
                                {{-- តម្លៃដើម --}}
                                <span class="old_price">${{ number_format($item->price,2) }}</span>
                                {{-- តម្លៃបញ្ចុះ --}}
                                <span class="current_price">${{ number_format($item->price - $item->discount_price,2) }}</span>
                            </div>
                        </td>
                        <td class="cart-cell">
                            {{-- ធាតុ Add to Cart --}}
                            <button class="cart-button" title="Add to cart">
                                <i class="fa fa-shopping-cart"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                {{-- បញ្ចប់ Loop --}}
            </tbody>
        </table>
    </div>

    <div class="bottom-pagination">
        <div class="pagination">
            <a href="#" class="page-link active">1</a>
            <a href="#" class="page-link">2</a>
            <a href="#" class="page-link">3</a>
            <a href="#" class="page-link">4</a>
            <a href="#" class="page-link">5</a>
            <a href="#" class="page-link">Next ›</a>
        </div>
    </div>
</div>
        <!--product area end-->

        <!--banner area start-->
        <div class="banner_area mb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <figure class="single_banner">
                            <div class="banner_thumb">
                                <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/bg/banner4.jpg')}}" alt=""></a>
                            </div>
                        </figure>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <figure class="single_banner">
                            <div class="banner_thumb">
                                <a href="{{url('shop')}}"><img src="{{asset('frontends/assets/img/bg/banner5.jpg')}}" alt=""></a>
                            </div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        <!--banner area end-->

        <!--product area start-->
        <div class="product_area">
            <div class="container">
                <div class="row">
                    {{--  <div class="col-12">
                        <div class="section_title title_style2">
                           <div class="title_content">
                               <h2><span>OnSale</span> Products</h2>
                                <p>The highest discount products of CM Auto Service </p>
                            </div>
                        </div>
                    </div>  --}}
                </div>
                {{--  <div class="product_container">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="product_style_left">
                                <article class="single_product">
                                    <figure>
                                        <div class="product_thumb">
                                            <a class="primary_img" href="product-details.html"><img src="{{asset('frontends/assets/img/product/product7.jpg')}}" alt=""></a>
                                            <a class="secondary_img" href="product-details.html"><img src="{{asset('frontends/assets/img/product/product8.jpg')}}" alt=""></a>
                                            <div class="label_product">
                                                <span class="label_sale">-52%</span>
                                            </div>
                                        </div>
                                        <div class="product_content">
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
                                            <div class="product_desc">
                                                <p>Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc.</p>
                                            </div>
                                            <div class="action_links">
                                                <ul>
                                                    <li class="add_to_cart"><a href="cart.html" title="Add to cart">Add to cart</a></li>
                                                    <li class="quick_view"><a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-search"></i></a></li>
                                                    <li class="wishlist"><a href="wishlist.html"  title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                                    <li class="compare"><a href="compare.html" title="Add to Compare"><i class="icon-rotate-cw"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </figure>
                                </article>
                            </div>
                        </div>  --}}
                        <div class="col-lg-6 col-md-12">
                            <div class="product_style_right">
                                <div class="row">
                                    <div class="product_carousel product_column3 owl-carousel">
                                        @foreach($product as $key => $item)
                                            <div class="col-lg-3">
                                                <article class="single_product">
                                                    <figure>
                                                        <div class="product_thumb">
                                                            <a class="primary_img" href="{{ url('frontend/product/detail',$item->id) }}"><img src="{{ asset('images/products/' . $item->product_photo) }}" alt=""></a>
                                                            <a class="secondary_img" href="{{ url('frontend/product/detail',$item->id) }}"><img src="{{ asset('images/products/' . $item->product_photo) }}" alt=""></a>
                                                            <div class="label_product">
                                                                <span class="label_sale">90%</span>
                                                            </div>
                                                            <div class="quick_button">
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box"  title="quick view"><i class="icon-eye"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="product_content">
                                                            <div class="product_content_inner">
                                                                <p class="manufacture_product"><a href="#">Parts</a></p>
                                                                <h4 class="product_name"><a href="{{ url('frontend/product/detail',$item->id) }}">{{ $item->name }}</a></h4>
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
                                                                    <span class="old_price">${{ number_format($item->price,2) }}</span>
                                                                    <span class="current_price">${{ number_format($item->price - $item->discount_price,2) }}</span>
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
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
            </div>
        </div>
        <!--product area end-->

        <!--blog area start-->
        <div class="blog_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                       <div class="section_title title_style2">
                           <div class="title_content">
                               <h2><span>Latest</span>  Blog Posts</h2>
                                <p>The highest discount products of CM Auto Service </p>
                            </div>
                        </div>
                      </div>
                </div>
                <div class="row">
                    <div class="blog_container blog_column4 owl-carousel">
                        <div class="col-lg-3">
                            <article class="single_blog">
                                <figure>
                                    <div class="blog_thumb">
                                        <a href="blog-details.html"><img src="{{asset('frontends/assets/img/blog/blog1.jpg')}}" alt=""></a>
                                    </div>
                                    <figcaption class="blog_content">
                                        <h4><a href="blog-details.html">Aenean et nulla sociosqu ad litora torquent per</a></h4>
                                        <div class="post_meta">
                                            <p><a href="#">eCommerce</a> / 17 July</p>
                                        </div>
                                        <div class="post_desc">
                                            <p>Condimentum blandit est sed mollitia libero pharetra aenean ...</p>
                                        </div>
                                        <footer class="post_readmore">
                                            <a href="blog-details.html">Continue Reading</a>
                                        </footer>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                        <div class="col-lg-3">
                            <article class="single_blog">
                                <figure>
                                    <div class="blog_thumb">
                                        <a href="blog-details.html"><img src="{{asset('frontends/assets/img/blog/blog2.jpg')}}" alt=""></a>
                                    </div>
                                    <figcaption class="blog_content">
                                        <h4><a href="blog-details.html">Class aptent eum Fiction Molestie Consequat</a></h4>
                                        <div class="post_meta">
                                            <p><a href="#">eCommerce</a> / 17 July</p>
                                        </div>
                                        <div class="post_desc">
                                            <p>Condimentum blandit est sed mollitia libero pharetra aenean ...</p>
                                        </div>
                                        <footer class="post_readmore">
                                            <a href="blog-details.html">Continue Reading</a>
                                        </footer>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                        <div class="col-lg-3">
                            <article class="single_blog">
                                <figure>
                                    <div class="blog_thumb">
                                        <a href="blog-details.html"><img src="{{asset('frontends/assets/img/blog/blog3.jpg')}}" alt=""></a>
                                    </div>
                                    <figcaption class="blog_content">
                                        <h4><a href="blog-details.html">Coconut Lemon Bath & Shower Gel Juice</a></h4>
                                        <div class="post_meta">
                                            <p><a href="#">eCommerce</a> / 17 July</p>
                                        </div>
                                        <div class="post_desc">
                                            <p>Condimentum blandit est sed mollitia libero pharetra aenean ...</p>
                                        </div>
                                        <footer class="post_readmore">
                                            <a href="blog-details.html">Continue Reading</a>
                                        </footer>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                        <div class="col-lg-3">
                            <article class="single_blog">
                                <figure>
                                    <div class="blog_thumb">
                                        <a href="blog-details.html"><img src="frontends/assets/img/blog/blog4.jpg" alt=""></a>
                                    </div>
                                    <figcaption class="blog_content">
                                        <h4><a href="blog-details.html">Aenean et nulla sociosqu ad litora torquent per</a></h4>
                                        <div class="post_meta">
                                            <p><a href="#">eCommerce</a> / 17 July</p>
                                        </div>
                                        <div class="post_desc">
                                            <p>Condimentum blandit est sed mollitia libero pharetra aenean ...</p>
                                        </div>
                                        <footer class="post_readmore">
                                            <a href="blog-details.html">Continue Reading</a>
                                        </footer>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                        <div class="col-lg-3">
                            <article class="single_blog">
                                <figure>
                                    <div class="blog_thumb">
                                        <a href="blog-details.html"><img src="{{asset('frontends/assets/img/blog/blog2.jpg')}}" alt=""></a>
                                    </div>
                                    <figcaption class="blog_content">
                                        <h4><a href="blog-details.html">Class aptent eum Fiction Molestie Consequat</a></h4>
                                        <div class="post_meta">
                                            <p><a href="#">eCommerce</a> / 17 July</p>
                                        </div>
                                        <div class="post_desc">
                                            <p>Condimentum blandit est sed mollitia libero pharetra aenean ...</p>
                                        </div>
                                        <footer class="post_readmore">
                                            <a href="blog-details.html">Continue Reading</a>
                                        </footer>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--blog area end-->
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
