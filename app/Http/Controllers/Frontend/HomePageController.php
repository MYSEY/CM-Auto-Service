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
        $dataProduct = Product::with(['category','subCategory'])->get();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();
        return view('frontends.home_page',compact('company','product','category','productType','dataProduct'));
    }
    public function showLoginForm(){
        $company = Company::first();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();
        return view('frontends.login',compact('company','category','productType'));
    }
    public function productDetail(Request $request){
        $productDetail = Product::with(['productImage','productType','category','subCategory'])->where('id',$request->id)->first();
        $company = Company::first();
        $category = ProductCategory::with('subCategory')->get();
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
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();
        $product = $query->paginate(9);
        return view('frontends.home_page',compact('company','product','category','productType'));
    }
    public function filter($id){
        $product = Product::with(['productImage'])->where('product_type_id',$id)->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
       return view('frontends.ecu_soft',compact('product','company','category','productType'));
    }
    public function subCategoryFilter(Request $request)
    {
        $subCategoryId = $request->sub_category_id;
        $product = Product::where('sub_category_id', $subCategoryId)->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        return view('frontends.home_page',compact('product','company','category','productType'));

    }
}
