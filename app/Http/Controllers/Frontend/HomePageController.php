<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class HomePageController extends Controller
{
    public function index(){
        $company = Company::first();
        $product = Product::all();
        return view('frontends.home_page',compact('company','product'));
    }

    public function logins(){
        $company = Company::first();
        return view('frontends.login',compact('company'));
    }
}
