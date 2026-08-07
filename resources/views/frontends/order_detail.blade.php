@extends('layouts.frontend.layouts')
@section('content')
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="/">home</a></li>
                        <li><a href="{{ route('account.index') }}">my account</a></li>
                        <li><a href="{{ route('account.orders') }}">orders</a></li>
                        <li>order #{{ $order->id }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="account_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="dashboard_menu">
                    <ul class="nav flex-column" role="tablist">
                        <li class="nav-item"><a class="nav-link" href="{{ route('account.index') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link active">Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('account.index') }}#account">Account Details</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('wishlist') }}">Wishlist</a></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link" style="background:none;border:none;text-align:left;width:100%">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 col-md-12">
                <h3>Order #{{ $order->id }}</h3>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                <p><strong>Status:</strong>
                    @if($order->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($order->status == 'completed')
                        <span class="badge bg-success">Completed</span>
                    @elseif($order->status == 'cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                    @else
                        <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                    @endif
                </p>

                <div class="table-responsive mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->details as $detail)
                            <tr>
                                <td>
                                    <a href="{{ url('frontend/product/detail/' . $detail->product_id) }}">
                                        {{ $detail->product->name ?? 'Product #' . $detail->product_id }}
                                    </a>
                                </td>
                                <td>${{ number_format($detail->price, 2) }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>${{ number_format($detail->sub_total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><strong>Grand Total</strong></td>
                                <td><strong>${{ number_format($order->details->sum('sub_total'), 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-3">
                    <a href="{{ route('account.orders') }}" class="btn btn-primary">Back to Orders</a>
                </div>
            </div>
        </div>
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