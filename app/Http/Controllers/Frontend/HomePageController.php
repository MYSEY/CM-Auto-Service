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
        return view('layouts.frontend.layouts',compact('company','product'));
    }
}
