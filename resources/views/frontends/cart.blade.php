@extends('layouts.frontend.layouts')
@section('content')
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="/">home</a></li>
                        <li>shopping cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="shopping_cart_area">
    <div class="container">
        @if(!empty($cart) && count($cart) > 0)
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
                                    <th class="product_quantity">Quantity</th>
                                    <th class="product_total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $productId => $item)
                                <tr data-product-id="{{ $productId }}">
                                    <td class="product_remove">
                                        <a href="javascript:void(0)" class="remove-item" data-id="{{ $productId }}"><i class="ion-android-close"></i></a>
                                    </td>
                                    <td class="product_thumb">
                                        <a href="#"><img src="{{ $item['image'] ? 'https://cdn.cmautoservic.com/' . $item['image'] : asset('frontends/assets/img/product/product1.jpg') }}" alt="{{ $item['name'] }}"></a>
                                    </td>
                                    <td class="product_name"><a href="#">{{ $item['name'] }}</a></td>
                                    <td class="product-price">${{ number_format($item['price'], 2) }}</td>
                                    <td class="product_quantity">
                                        <div class="quantity">
                                            <div class="cart_plus_minus">
                                                <input type="number" min="1" value="{{ $item['quantity'] }}" class="cart-qty-input" data-id="{{ $productId }}" data-price="{{ $item['price'] }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product_total"><span class="item-total">${{ number_format($item['price'] * $item['quantity'], 2) }}</span></td>
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
                <div class="coupon_code_right d-flex justify-content-end">
                    <div class="coupon_code">
                        <input type="text" placeholder="Coupon code...">
                        <button>Apply coupon</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-lg-5">
                <div class="cart_subtotal">
                    <div class="cart_subtotal_inner">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Sub Total</td>
                                    <td><span id="cartSubtotal">${{ number_format($subtotal, 2) }}</span></td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>Free</td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><span class="cart_subtotal_price" id="cartTotal">${{ number_format($total, 2) }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cart_button mt-3">
                    <a href="{{ url('/') }}">Continue Shopping</a>
                    <a href="{{ url('checkout') }}" class="active">Proceed to Checkout</a>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <h3>Your cart is empty</h3>
                    <p class="mb-4">Add some products to your cart to see them here.</p>
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