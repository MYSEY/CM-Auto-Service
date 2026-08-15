<div class="cart_close">
    <div class="cart_text"><h3>cart</h3></div>
    <div class="mini_cart_close"><a href="javascript:void(0)"><i class="icon-x"></i></a></div>
</div>
@if(!empty($cart) && count($cart) > 0)
    @foreach($cart as $productId => $item)
    <div class="cart_item">
        <div class="cart_img">
            <a href="#"><img src="{{ $item['image'] ? 'https://cdn.cmautoservic.com/' . $item['image'] : asset('frontends/assets/img/product/product1.jpg') }}" alt=""></a>
        </div>
        <div class="cart_info">
            <a href="#">{{ $item['name'] }}</a>
            <p>Qty: {{ $item['quantity'] }} X <span>${{ number_format($item['price'], 2) }}</span></p>
        </div>
        <div class="cart_remove">
            <a href="javascript:void(0)" class="removeCart" data-id="{{ $productId }}"><i class="ion-android-close"></i></a>
        </div>
    </div>
    @endforeach
    <div class="mini_cart_table">
        <div class="cart_total">
            <span>Sub total:</span>
            <span class="price">${{ number_format($totalPrice, 2) }}</span>
        </div>
        <div class="cart_total mt-10">
            <span>Total:</span>
            <span class="price">${{ number_format($totalPrice, 2) }}</span>
        </div>
    </div>
@else
    <p class="text-center mt-3">Cart is empty</p>
@endif
<div class="mini_cart_footer">
    <div class="cart_button"><a href="{{ url('cart') }}">View cart</a></div>
    <div class="cart_button"><a class="active" href="{{ url('checkout') }}">Checkout</a></div>
</div>