@extends('layouts.frontend.layouts')
@section('content')
 <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="index.html">home</a></li>
                            <li>My account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!-- customer login start -->
    <div class="login_page_bg">
        <div class="container">
            <div class="customer_login">
                <div class="row">
                   <!--login area start-->
                   <div class="col-md-4"></div>
                    <div class="col-lg-4 col-md-4">
                        <div class="account_form login">
                            <h2>login</h2>
                            <form method="POST" action="{{ url('login/submit') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <p>
                                    <label>Username <span>*</span></label>
                                    <input type="text" id="user_name" name="user_name" class="form-control @error('user_name') is-invalid @enderror" placeholder="" value="">
                                    @error('user_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </p>
                                <p>
                                    <label>Passwords <span>*</span></label>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="password" value="">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </p>
                                <div class="login_submit">
                                   <a href="#">Lost your password?</a>
                                    <label for="remember">
                                        <input id="remember" type="checkbox">
                                        Remember me
                                    </label>
                                    <button type="submit">login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--login area start-->
                </div>
            </div>
        </div>
    </div>
@endsection
