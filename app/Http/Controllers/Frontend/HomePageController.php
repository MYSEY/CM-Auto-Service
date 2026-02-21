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
        $productAll = Product::with(['category','subCategory','productType'])->orderByRaw("CAST(SUBSTRING(number, 3) AS UNSIGNED) ASC")->paginate(24, ['*'], 'page_all')->appends(['tab' => 'all']);
        // $productAll = Product::with(['category','subCategory','productType'])->paginate(24, ['*'], 'page_all')->appends(['tab' => 'all']);
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->orderByRaw("CAST(SUBSTRING(number, 3) AS UNSIGNED) ASC")->orderBy('id', 'asc')->paginate(24, ['*'], $pageName)->appends(['tab' => $slug]);
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
                $products = Product::with(['category','subCategory','productType'])->where('product_type_id', $selected->id)->orderByRaw("CAST(SUBSTRING(number, 3) AS UNSIGNED) ASC")->orderBy('id', 'asc')->paginate(24, ['*'], $pageName)->appends(['tab' => $tab]);
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

    public function productDetail(Request $request) {
        // ១. ទាញយកព័ត៌មាន Product Detail

        $productDetail = Product::with(['productImage','productType','category','subCategory','proEngine'])->where('id',$request->id)->firstOrFail();

        // ២. បន្ថែមបន្ទាត់នេះ៖ ទាញយកផលិតផលដែលមាន Category ដូចគ្នា (Related Products)
        $relatedProducts = Product::where('category_id', $productDetail->category_id)
                                    ->where('id', '!=', $productDetail->id) // មិនយកខ្លួនឯង
                                    ->take(8) // យកតែ ៨ គ្រាប់
                                    ->get();

        $company = Company::first();
        $category = ProductCategory::with('subCategory')->get();
        $productType = ProductType::all();
        $slider = Slider::all();

        // បង្កើត Pagination សម្រាប់ Tab ផ្សេងៗ (ទុកតាមកូដដើមរបស់អ្នក)
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])
                ->where('product_type_id', $type->id)
                ->orderByRaw("CAST(SUBSTRING(number, 3) AS UNSIGNED) ASC")
                ->orderBy('id', 'asc')
                ->paginate(24, ['*'], $pageName)
                ->appends(['tab' => $slug]);
        }

        $r2Url = "https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/";

        // ៣. កុំភ្លេចបោះ 'relatedProducts' ទៅក្នុង compact ខាងក្រោមនេះ
        return view('frontends.product_detail', compact(
            'productDetail',
            'company',
            'category',
            'productType',
            'slider',
            'productsByType',
            'r2Url',
            'relatedProducts' // <--- ត្រូវតែមានពាក្យនេះ
        ));
    }

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
        $productAll = $query->orderBy('number','desc')->paginate(24)->appends($request->except('page'));
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
        $productAll = Product::with(['productImage'])->where('product_type_id',$id)->orderByRaw("CAST(SUBSTRING(number, 3) AS UNSIGNED) ASC")->orderBy('id', 'asc')->paginate(9);
        $company = Company::first();
        $category = ProductCategory::all();
        $productType = ProductType::all();
        $slider = Slider::all();
        $activeTab = $request->get('tab', 'all');
        $productsByType = [];
        foreach ($productType as $type) {
            $slug = Str::slug($type->name);
            $pageName = 'page_' . $slug;
            $productsByType[$type->id] = Product::with(['category','subCategory','productType'])->where('product_type_id', $type->id)->orderByRaw("CAST(SUBSTRING(number, 3) AS UNSIGNED) ASC")->orderBy('id', 'asc')->paginate(24, ['*'], $pageName)->appends(['tab' => $slug]);              // keep tab param when paginating
        }
       return view('frontends.ecu_soft',compact('productAll','company','category','productType','slider','activeTab','productsByType'));
    }
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

        $products = $query->orderByRaw("CAST(SUBSTRING(number, 3) AS UNSIGNED) ASC")->orderBy('id', 'asc')->paginate(24)->appends($request->only(['category_id','sub_category_id','engine_id']));

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
    public function frontendSearchProduct(Request $request)
    {
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
        $productAll = $query->orderByRaw("CAST(SUBSTRING(number, 3) AS UNSIGNED) ASC")->orderBy('id', 'asc')->paginate(24)->appends($request->all());
        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontends.product_list', [
                    'products' => $productAll
                ])->render()
            ]);
        }
    }
}
