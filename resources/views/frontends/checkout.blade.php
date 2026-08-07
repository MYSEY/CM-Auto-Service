@extends('layouts.frontend.layouts')
@section('content')
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="/">home</a></li>
                        <li>checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="checkout_area">
    <div class="container">
        <form action="{{ route('checkout.place') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="checkout_form">
                        <h3>Billing Details</h3>
                        <div class="row">
                            <div class="col-lg-6 mb-20">
                                <label>First Name <span>*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name', Auth::user()->name ?? '') }}" required>
                            </div>
                            <div class="col-lg-6 mb-20">
                                <label>Last Name <span>*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" required>
                            </div>
                            <div class="col-12 mb-20">
                                <label>Company Name</label>
                                <input type="text" name="company_name" value="{{ old('company_name') }}">
                            </div>
                            <div class="col-12 mb-20">
                                <label>Country <span>*</span></label>
                                <select name="country" required>
                                    <option value="">Select a country</option>
                                    <option value="KH" {{ old('country') == 'KH' ? 'selected' : '' }}>Cambodia</option>
                                    <option value="TH" {{ old('country') == 'TH' ? 'selected' : '' }}>Thailand</option>
                                    <option value="VN" {{ old('country') == 'VN' ? 'selected' : '' }}>Vietnam</option>
                                </select>
                            </div>
                            <div class="col-12 mb-20">
                                <label>Street Address <span>*</span></label>
                                <input type="text" name="address" placeholder="House number and street name" value="{{ old('address') }}" required>
                            </div>
                            <div class="col-12 mb-20">
                                <label>City <span>*</span></label>
                                <input type="text" name="city" value="{{ old('city') }}" required>
                            </div>
                            <div class="col-lg-6 mb-20">
                                <label>State / Province <span>*</span></label>
                                <input type="text" name="state" value="{{ old('state') }}" required>
                            </div>
                            <div class="col-lg-6 mb-20">
                                <label>Postcode / ZIP <span>*</span></label>
                                <input type="text" name="postcode" value="{{ old('postcode') }}" required>
                            </div>
                            <div class="col-lg-6 mb-20">
                                <label>Phone <span>*</span></label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-lg-6 mb-20">
                                <label>Email Address <span>*</span></label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                            </div>
                            <div class="col-12 mb-20">
                                <label>Order Notes</label>
                                <textarea name="notes" placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="order_box">
                        <h3>Your Order</h3>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $productId => $item)
                                    <tr>
                                        <td>{{ $item['name'] }} <strong> × {{ $item['quantity'] }}</strong></td>
                                        <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td>${{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping</td>
                                        <td>Free shipping</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td><strong>${{ number_format($total, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment_method">
                            <div class="panel_default">
                                <label><input type="radio" name="payment_method" value="bank_transfer" checked> Direct Bank Transfer</label>
                                <div class="panel_body">
                                    <p>Make your payment directly into our bank account. Your order will be shipped after payment is verified.</p>
                                </div>
                            </div>
                            <div class="panel_default">
                                <label><input type="radio" name="payment_method" value="cod"> Cash on Delivery</label>
                            </div>
                            <div class="panel_default">
                                <label><input type="radio" name="payment_method" value="paypal"> PayPal</label>
                                <div class="panel_body">
                                    <p>Pay via PayPal; you can pay with your credit card if you don't have a PayPal account.</p>
                                </div>
                            </div>
                            <div class="order_button mt-20">
                                <button type="submit">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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