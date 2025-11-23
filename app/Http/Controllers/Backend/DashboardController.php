<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $productType = ProductType::withCount('products')->get();
        return view('backend.dashboard.index',compact('productType'));
    }
}
