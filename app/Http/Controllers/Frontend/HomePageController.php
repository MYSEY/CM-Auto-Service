<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Models\ProductType;

class HomePageController extends Controller
{
    public function index(){
        $company = Company::first();
        $product = Product::all();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        return view('frontends.home_page',compact('company','product','category','productType'));
    }

    public function logins(){
        $company = Company::first();
        $category = ProductCategory::all();
        return view('frontends.login',compact('company','category'));
    }
    public function productDetail(Request $request){
        $productDetail = Product::with(['productImage','proStatus'])->where('id',$request->id)->first();
        $company = Company::first();
        $category = ProductCategory::all();
        $product = Product::all();
       return view('frontends.product_detail',compact('product','productDetail','company','category'));
    }
    public function categoryFilter(Request $request){
        // Build query
        $query = Product::query()->with('category','subCategory');
        // ✅ Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('serial_number')) {
            $query->whereHas('subCategory', function ($q) use ($request) {
                $q->where('serial_number', $request->serial_number);
            });
        }
        // ✅ Optional: Filter by keyword (search name or description)
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }
        $company = Company::first();
        $category = ProductCategory::all();
        $product = $query->get();
        return view('frontends.home_page',compact('company','product','category'));
    }
}
