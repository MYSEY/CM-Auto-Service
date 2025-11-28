<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Engine;
use App\Models\Slider;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function index(Request $request){
        $company = Company::first();
        $dataProduct = Product::with(['category','subCategory'])->get();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();
        $proEngine = Engine::all();
        $slider = Slider::all();

        $productAll = Product::with(['category','subCategory','productType'])->paginate(24, ['*'], 'page_all')->appends(['tab' => 'all']); // ensure tab is kept in links
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(24, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
        }
        $activeTab = $request->get('tab', 'all');
        return view('frontends.home_page',compact('company','productAll','category','productType','dataProduct','proEngine','slider','productsByType','activeTab'));
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
        $productAll = Product::paginate(9);
        $productType = ProductType::all();
        $slider = Slider::all();
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(2, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
        }
       return view('frontends.product_detail',compact('productAll','productDetail','company','category','productType','slider','productsByType'));
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
        $productAll = $query->paginate(9);
        $slider = Slider::all();
        $activeTab ='';
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(2, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
        }
        return view('frontends.home_page',compact('company','productAll','category','productType','slider','activeTab','productsByType'));
    }
    public function filter($id){
        $productAll = Product::with(['productImage'])->where('product_type_id',$id)->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        $activeTab = '';
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(2, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
        }
       return view('frontends.ecu_soft',compact('productAll','company','category','productType','slider','activeTab','productsByType'));
    }
    public function productCategoryFilter(Request $request)
    {
        $productAll = Product::where('category_id', $request->category_id)->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        $activeTab ='';
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(2, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
        }
        return view('frontends.home_page',compact('productAll','company','category','productType','slider','activeTab','productsByType'));
    }
    public function subCategoryFilter(Request $request)
    {
        $subCategoryId = $request->sub_category_id;
        $productAll = Product::where('sub_category_id', $subCategoryId)->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        $activeTab ='';
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(2, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
        }
        return view('frontends.home_page',compact('productAll','company','category','productType','slider','activeTab','productsByType'));
    }
    public function engineFilter(Request $request)
    {
        $productAll = Product::where('engine_id', $request->engine_id)->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        return view('frontends.home_page',compact('productAll','company','category','productType','slider'));
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
        $productAll = $query->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        $activeTab ='';
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(2, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
        }
        return view('frontends.home_page', compact('productAll', 'company', 'category', 'productType', 'selectedFilters', 'slider','productsByType','activeTab'));
    }
}
