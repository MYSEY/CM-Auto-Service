@extends('layouts.frontend.layouts')
@section('content')
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="/">home</a></li>
                        <li>wishlist</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="shopping_cart_area">
    <div class="container">
        @if($wishlistItems->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="table_desc">
                    <div class="cart_page table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product_remove">Remove</th>
                                    <th class="product_thumb">Image</th>
                                    <th class="product_name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product_total">Add to Cart</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wishlistItems as $item)
                                <tr data-id="{{ $item->product_id }}">
                                    <td class="product_remove">
                                        <a href="javascript:void(0)" class="remove-wishlist" data-id="{{ $item->product_id }}"><i class="ion-android-close"></i></a>
                                    </td>
                                    <td class="product_thumb">
                                        <a href="{{ url('frontend/product/detail/' . $item->product_id) }}">
                                            <img src="{{ $item->product->photo_url }}" alt="{{ $item->product->name }}">
                                        </a>
                                    </td>
                                    <td class="product_name"><a href="{{ url('frontend/product/detail/' . $item->product_id) }}">{{ $item->product->name }}</a></td>
                                    <td class="product-price">${{ number_format($item->product->price, 2) }}</td>
                                    <td class="product_total">
                                        <a href="javascript:void(0)" class="addToCart" data-id="{{ $item->product_id }}">Add to cart</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="cart_button mt-3">
                    <a href="{{ url('/') }}">Continue Shopping</a>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <h3>Your wishlist is empty</h3>
                    <p class="mb-4">Add some products to your wishlist to see them here.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="brand_area">
    <div class="container">
        <div class="col-12">
            <div class="brand_container owl-carousel">
                @for ($i = 1; $i <= 8; $i += 2)
                    <div class="brand_list">
                        <div class="single_brand"><a href="#"><img src="{{asset('frontends/assets/img/brand/brand'.$i.'.jpg')}}" alt="Brand {{ $i }}"></a></div>
                        @if($i + 1 <= 8)
                            <div class="single_brand"><a href="#"><img src="{{asset('frontends/assets/img/brand/brand'.($i+1).'.jpg')}}" alt="Brand {{ $i+1 }}"></a></div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection