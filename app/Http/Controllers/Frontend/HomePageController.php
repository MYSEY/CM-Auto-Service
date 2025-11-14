<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Slider;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function index(){
        $company = Company::first();
        $product = Product::with(['category','subCategory'])->paginate(10);
        $category = ProductCategory::all();
        $productType = ProductType::all();
        return view('frontends.home_page',compact('company','product','category','productType'));
    }
    public function showLoginForm(){
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

        {
        // 1. Fetch main sliders (type 'main' and status '1' for published)
        $mainSliders = Slider::where('type', 'main')
                             ->where('status', 1)
                             ->orderBy('id', 'desc')
                             ->get();

        // 2. Fetch other types of sliders/data if needed (example)
        $bannerSliders = Slider::where('type', 'banner')
                               ->where('status', 2)
                               ->orderBy('id', 'asc')
                               ->get();

        // 3. Return the view, compacting the data
        return view('frontends.home_page', compact('mainSliders', 'bannerSliders'));
        // ត្រូវប្តូរ 'frontend.home.index' ទៅជាឈ្មោះ View របស់អ្នក
    }

    // ... other methods

        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $product = $query->paginate(9);
        return view('frontends.home_page',compact('company','product','category','productType'));
    }
}
