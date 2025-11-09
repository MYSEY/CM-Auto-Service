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
        $product = Product::with(['category','subCategory'])->paginate(10);
        $category = ProductCategory::all();
        $productType = ProductType::all();
        return view('frontends.home_page',compact('company','product','category','productType'));
    }
    public function logins(){
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        return view('frontends.login',compact('company','category','productType'));
    }
    public function productDetail(Request $request){
        $productDetail = Product::with(['productImage','productType','category','subCategory'])->where('id',$request->id)->first();
        $company = Company::first();
        $category = ProductCategory::all();
        $product = Product::paginate(9);
        $productType = ProductType::all();
       return view('frontends.product_detail',compact('product','productDetail','company','category','productType'));
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
        $productType = ProductType::all();
        $product = $query->paginate(9);
        return view('frontends.home_page',compact('company','product','category','productType'));
    }
}
