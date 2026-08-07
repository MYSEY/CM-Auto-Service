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
                        <li>orders</li>
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
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <h3>Orders</h3>
                @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $order->details->count() }} item(s)</td>
                                <td>${{ number_format($order->details->sum('sub_total'), 2) }}</td>
                                <td><a href="{{ route('account.order.detail', $order->id) }}" class="view">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $orders->links() }}
                @else
                <div class="text-center py-5">
                    <p>You have no orders yet.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Start Shopping</a>
                </div>
                @endif
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