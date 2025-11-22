<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Engine;
use App\Models\Slider;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function index(){
        $company = Company::first();
        $product = Product::with(['category','subCategory'])->paginate(20);
        $dataProduct = Product::with(['category','subCategory'])->get();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();
        $proEngine = Engine::all();
        $slider = Slider::all();
        return view('frontends.home_page',compact('company','product','category','productType','dataProduct','proEngine','slider'));
    }
    public function showLoginForm(){
        $company = Company::first();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();
        $slider = Slider::all();
        return view('frontends.login',compact('company','category','productType','slider'));
    }
    public function productDetail(Request $request){
        $productDetail = Product::with(['productImage','productType','category','subCategory'])->where('id',$request->id)->first();
        $company = Company::first();
        $category = ProductCategory::with('subCategory')->get();
        $product = Product::paginate(9);
        $productType = ProductType::all();
        $slider = Slider::all();
       return view('frontends.product_detail',compact('product','productDetail','company','category','productType','slider'));
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
        $slider = Slider::all();
        return view('frontends.home_page',compact('company','product','category','productType','slider'));
    }
    public function filter($id){
        $product = Product::with(['productImage'])->where('product_type_id',$id)->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
       return view('frontends.ecu_soft',compact('product','company','category','productType','slider'));
    }
    public function productCategoryFilter(Request $request)
    {
        $product = Product::where('category_id', $request->category_id)->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        return view('frontends.home_page',compact('product','company','category','productType','slider'));
    }
    public function subCategoryFilter(Request $request)
    {
        $subCategoryId = $request->sub_category_id;
        $product = Product::where('sub_category_id', $subCategoryId)->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        return view('frontends.home_page',compact('product','company','category','productType','slider'));
    }
    public function engineFilter(Request $request)
    {
        $product = Product::where('engine_id', $request->engine_id)->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        return view('frontends.home_page',compact('product','company','category','productType','slider'));
    }
    public function frontendCategory(Request $request){
        try{
            $dataCategory = ProductSubCategory::where('product_category_id',$request->category_id)->get();
            return response()->json([
                'data'=>$dataCategory,
            ]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
    public function frontendSubCategory(Request $request){
        try{
            return response()->json([
                'data'=> Engine::where('sub_category_id',$request->sub_category_id)->get(),
            ]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
    public function frontendSearchProduct(Request $request){
        $selectedFilters = [
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category,
            'engine_id' => $request->engine_id,
        ];
        $query = Product::query();
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->sub_category) {
            $query->where('sub_category_id', $request->sub_category);
        }
        if ($request->engine_id) {
            $query->where('engine_id', $request->engine_id);
        }
        $product = $query->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        return view('frontends.home_page', compact('product', 'company', 'category', 'productType', 'selectedFilters', 'slider'));
    }
}
