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
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();
        $proEngine = Engine::all();
        $slider = Slider::all();

        // $productAll = Product::with(['category','subCategory','productType'])->paginate(24, ['*'], 'page_all')->appends(['tab' => 'all']); // ensure tab is kept in links
        // $productsByType = [];
        // foreach ($productType as $type) {
        //     $slug = Str::slug($type->name);
        //     $pageName = 'page_' . $slug;
        //     $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(24, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
        // }
        // $activeTab = $request->get('tab', 'all');

        $productAll = Product::with(['category','subCategory','productType'])->paginate(64, ['*'], 'page_all')->appends(['tab' => 'all']);

        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(24, ['*'], $pageName)->appends(['tab' => $slug]);
        }

        $activeTab = $request->get('tab', 'all');
        if ($request->ajax()) {
            $tab = $request->get('tab', 'all');

            if ($tab === 'all') {
                $products = Product::with(['category','subCategory','productType'])->paginate(24, ['*'], 'page_all')->appends(['tab' => 'all']);
            } else {
                $selected = $productType->firstWhere(fn($row) => Str::slug($row->name) === $tab);
                if (!$selected) {
                    return response()->json(['html' => '']);
                }

                $pageName = 'page_' . $tab;
                $products = Product::with(['category','subCategory','productType'])->where('product_type_id', $selected->id)->paginate(24, ['*'], $pageName)->appends(['tab' => $tab]);
            }

            return response()->json([
                'html' => view('frontends.product_list', compact('products', 'tab'))->render()
            ]);
        }

        return view('frontends.home_page',compact('company','productAll','category','productType','proEngine','slider','productsByType','activeTab'));
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
    // public function categoryFilter(Request $request){
    //     // Build query
    //     $query = Product::query()->with('category','subCategory');
    //     // ✅ Filter by category
    //     if ($request->filled('category_id')) {
    //         $query->where('category_id', $request->category_id);
    //     }

    //     if ($request->filled('serial_number')) {
    //         $query->whereHas('subCategory', function ($q) use ($request) {
    //             $q->where('serial_number', $request->serial_number);
    //         });
    //     }
    //     // ✅ Optional: Filter by keyword (search name or description)
    //     if ($request->filled('keyword')) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('name', 'like', '%' . $request->keyword . '%')
    //             ->orWhere('description', 'like', '%' . $request->keyword . '%');
    //         });
    //     }
    //     $productAll = $query->paginate(12);

    //     $company = Company::first();
    //     $category = ProductCategory::with('subCategory')->get();
    //     $productType = ProductType::all();
    //     $slider = Slider::all();
    //     $activeTab = $request->get('tab', 'all');
    //     $productsByType = [];
    //     foreach ($productType as $type) {
    //         $slug = Str::slug($type->name);
    //         $pageName = 'page_' . $slug;
    //         $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(24, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
    //     }
    //     return view('frontends.home_page',compact('company','productAll','category','productType','slider','activeTab','productsByType'));
    // }
    public function categoryFilter(Request $request)
    {
        $query = Product::query()->with('category','subCategory');
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('serial_number')) {
            $query->whereHas('subCategory', fn($q) =>
                $q->where('serial_number', $request->serial_number)
            );
        }
        $productAll = $query->paginate(12)->appends($request->except('page'));
        // Return only HTML for AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontends.product_list', [
                    'products' => $productAll,
                    'tab' => 'all'
                ])->render()
            ]);
        }
        // Normal load (first time)
        $company = Company::first();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();
        $slider = Slider::all();
        return view('frontends.home_page', compact(
            'company','productAll','category','productType','slider'
        ));
    }

    public function filter($id,Request $request){
        $productAll = Product::with(['productImage'])->where('product_type_id',$id)->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        $activeTab = $request->get('tab', 'all');
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(2, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
        }
       return view('frontends.ecu_soft',compact('productAll','company','category','productType','slider','activeTab','productsByType'));
    }
    // public function productCategoryFilter(Request $request)
    // {
    //     $productAll = Product::where('category_id', $request->category_id)->paginate(12);
    //     $company = Company::first();
    //     $category = ProductCategory::all();
    //     $productType = ProductType::all();
    //     $slider = Slider::all();
    //     $activeTab = $request->get('tab', 'all');
    //     $productsByType = [];
    //     foreach ($productType as $type) {
    //         $slug = Str::slug($type->name);
    //         $pageName = 'page_' . $slug;
    //         $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(24, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
    //     }
    //     return view('frontends.home_page',compact('productAll','company','category','productType','slider','activeTab','productsByType'));
    // }
    // public function subCategoryFilter(Request $request)
    // {
    //     $subCategoryId = $request->sub_category_id;
    //     $productAll = Product::where('sub_category_id', $subCategoryId)->paginate(12);
    //     $company = Company::first();
    //     $category = ProductCategory::all();
    //     $productType = ProductType::all();
    //     $slider = Slider::all();
    //     $activeTab = $request->get('tab', 'all');
    //     $productsByType = [];
    //     foreach ($productType as $type) {
    //         $slug = Str::slug($type->name);
    //         $pageName = 'page_' . $slug;
    //         $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(24, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
    //     }
    //     return view('frontends.home_page',compact('productAll','company','category','productType','slider','activeTab','productsByType'));
    // }
    // public function engineFilter(Request $request)
    // {
    //     $productAll = Product::where('engine_id', $request->engine_id)->paginate(12);
    //     $company = Company::first();
    //     $category = ProductCategory::all();
    //     $productType = ProductType::all();
    //     $slider = Slider::all();
    //     $activeTab = $request->get('tab', 'all');
    //     return view('frontends.home_page',compact('productAll','company','category','productType','slider','activeTab'));
    // }
    public function ajaxFilterProducts(Request $request)
    {
        $query = Product::query();

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->sub_category_id) {
            $query->where('sub_category_id', $request->sub_category_id);
        }
        if ($request->engine_id) {
            $query->where('engine_id', $request->engine_id);
        }

        $products = $query->paginate(12)->appends($request->only(['category_id','sub_category_id','engine_id']));

        return view('frontends.product_list', compact('products'))->render();
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
    // public function frontendSearchProduct(Request $request){
    //     $selectedFilters = [
    //         'category_id' => $request->category_id,
    //         'sub_category_id' => $request->sub_category,
    //         'engine_id' => $request->engine_id,
    //     ];
    //     $query = Product::query();
    //     if ($request->category_id) {
    //         $query->where('category_id', $request->category_id);
    //     }
    //     if ($request->sub_category) {
    //         $query->where('sub_category_id', $request->sub_category);
    //     }
    //     if ($request->engine_id) {
    //         $query->where('engine_id', $request->engine_id);
    //     }
    //     $productAll = $query->paginate(12);
    //     $company = Company::first();
    //     $category = ProductCategory::all();
    //     $productType = ProductType::all();
    //     $slider = Slider::all();
    //     $activeTab = $request->get('tab', 'all');
    //     $productsByType = [];
    //     foreach ($productType as $type) {
    //         $slug = Str::slug($type->name);
    //         $pageName = 'page_' . $slug;
    //         $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(24, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
    //     }
    //     return view('frontends.home_page', compact('productAll', 'company', 'category', 'productType', 'selectedFilters', 'slider','productsByType','activeTab'));
    // }
    public function frontendSearchProduct(Request $request)
    {
        $tab = strtolower($request->tab ?? 'all');
        $query = Product::query()->with(['category','subCategory','proEngine']);
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('price', 'LIKE', "%$keyword%")
                ->orWhere('number', 'LIKE', "%$keyword%")
                ->orWhere('year', 'LIKE', "%$keyword%");
               // 🔥 Search in Category Name
                $q->orWhereHas('category', function($cat) use ($keyword) {
                    $cat->where('name', 'LIKE', "%$keyword%");
                });

                // 🔥 Search in Sub Category Name
                $q->orWhereHas('subCategory', function($sub) use ($keyword) {
                    $sub->where('name', 'LIKE', "%$keyword%");
                });

                // 🔥 Search in Engine Name
                $q->orWhereHas('proEngine', function($engine) use ($keyword) {
                    $engine->where('name', 'LIKE', "%$keyword%");
                });
            });
        }
        if ($tab !== 'all') {
            $productType = ProductType::where('name', $request->tab)->first();
            if ($productType) {
                $query->where('product_type_id', $productType->id);
            }
        }
        $productAll = $query->paginate(24)->appends($request->all());
        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontends.product_list', [
                    'products' => $productAll
                ])->render()
            ]);
        }
        $selectedFilters = [
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category,
            'engine_id' => $request->engine_id,
        ];

        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        $activeTab = $request->get('tab', 'all');
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->paginate(24, ['*'], $pageName)->appends(['tab' => $slug]);
        }

        return view('frontends.home_page', compact(
            'productAll','company','category','productType','selectedFilters','slider','productsByType','activeTab'
        ));
    }
}
