@extends('layouts.frontend.layouts')
@section('content')
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="/">home</a></li>
                        <li>my account</li>
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
                        <li class="nav-item">
                            <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('account.orders') }}">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="account-tab" data-bs-toggle="tab" href="#account" role="tab">Account Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('wishlist') }}">Wishlist</a>
                        </li>
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
                <div class="tab-content account_content">
                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel">
                        <h3>Dashboard</h3>
                        <div class="dashboard_content">
                            <p>Hello <strong>{{ $user->name }}</strong></p>
                            <p>From your account dashboard you can view your <a href="{{ route('account.orders') }}">recent orders</a>, manage your <a href="#account">account details</a>, and view your <a href="{{ url('wishlist') }}">wishlist</a>.</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="account" role="tabpanel">
                        <h3>Account Details</h3>
                        <form action="{{ route('account.update') }}" method="POST" class="account_form">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <label>Display Name <span>*</span></label>
                                    <input type="text" name="name" value="{{ $user->name }}" required>
                                </div>
                                <div class="col-lg-12 mb-20">
                                    <label>Email Address <span>*</span></label>
                                    <input type="email" name="email" value="{{ $user->email }}" required>
                                </div>
                            </div>
                            <button type="submit" class="submit">Save Changes</button>
                        </form>
                    </div>
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