<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\Engine;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage; // កុំភ្លេចថែមខាងលើនេះ

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::select(
                'products.*',
                'product_categories.name as category_name',
                'product_sub_categories.name as sub_category_name',
                'product_sub_categories.serial_number',
                'product_types.name as product_type_name',
                'engines.name as engine_name',
                'engines.part_number',
            )
            ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->leftJoin('product_sub_categories', 'products.sub_category_id', '=', 'product_sub_categories.id')
            ->leftJoin('product_types', 'products.product_type_id', '=', 'product_types.id')
            ->leftJoin('engines', 'products.engine_id', '=', 'engines.id');
            // 🔍 global search filter
            if ($request->name) {
                $query->where('name', 'like', "%{$request->name}%");
            }

            if ($request->product_type_id) {
                $query->where('products.product_type_id', $request->product_type_id);
            }
            if ($request->category_id) {
                $query->where('products.category_id', $request->category_id);
            }
            if ($request->sub_category_id) {
                $query->where('products.sub_category_id', $request->sub_category_id);
            }
            if ($request->engine_id) {
                $query->where('products.engine_id', $request->engine_id);
            }

            // --- បន្ថែម Order By នៅត្រង់នេះ ---
            $query->orderByRaw('LENGTH(products.number) ASC')
                ->orderByRaw("CAST(SUBSTRING(products.number, 3) AS UNSIGNED) ASC");

            $recordsTotal = Product::count();
            $recordsFiltered = $query->count();
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));
            $data = $query->skip($start)->take($limit)->get();
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
            ]);
        }
        $dataCategory = ProductCategory::all();
        $productTypes = ProductType::all();
        return view('backend.products.index',compact('dataCategory','productTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = ProductCategory::selectRaw('MIN(id) as id, name')->groupBy('name')->orderBy('name')->get();
        $productType = ProductType::all();
        return view('backend.products.creat',compact('category','productType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(request $request)
        {
        DB::beginTransaction();
        try {
            // Handle single product photo
            $filename = null;
            if ($request->hasFile('product_photo')) {
                $image = $request->file('product_photo');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // ✅ ប្តូរពី move() ទៅជា Storage R2
                Storage::disk('r2')->put($filename, file_get_contents($image));
            }

            $data = $request->all();
            // // បើ user មិនបានបំពេញ year ឱ្យវាដាក់ឆ្នាំបច្ចុប្បន្ន ឬ 0
            // $data['year'] = $request->year ?? date('Y');

            // ✅ generate slug
            $data['slug'] = Str::slug($request->name, '-');

            // ✅ photo
            $data['product_photo'] = $filename;

            // ✅ created by
            $data['created_by'] = Auth::id();

            // ✅ generate code
            $productType = ProductType::find($request->product_type_id);
            $category = ProductCategory::find($request->category_id);
            $subCategory = ProductSubCategory::find($request->sub_category_id);
            $engine = Engine::find($request->engine_id);

            $data['code'] = ($productType->name ?? '') . '-' .
                            ($category->name ?? '') . '-' .
                            ($subCategory->name ?? '') . '-' .
                            ($engine->name ?? '') . '-' .
                            $request->number;

            // Create product
            $product = Product::create($data);

            // Handle gallery images
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $galleryName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // ✅ ប្តូរពី move() ទៅជា Storage R2 (ដាក់ក្នុង folder gallery)
                    $galleryPath = 'gallery/' . $galleryName;
                    Storage::disk('r2')->put($galleryPath, file_get_contents($file));

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path_name'  => $galleryName,
                        'path'       => $galleryPath, // រក្សាទុក path សម្រាប់ហៅមកវិញ
                    ]);
                }
            }

            DB::commit();
            Toastr::success('Product created successfully!', 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Product creation failed: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = Product::with('productImage')->find($id);

            // បង្កើត URL សម្រាប់រូបភាព (បើប្រើ Public R2 URL)
            $r2Url = "https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/";
            $data->image_url = $data->product_photo ? $r2Url . $data->product_photo : null;

            $category = ProductCategory::selectRaw('MIN(id) as id, name')->groupBy('name')->orderBy('name')->get();
            $producttype = ProductType::all();
            $sub_category = ProductSubCategory::where('product_category_id', $data->category_id)->get();
            $engine = Engine::where('sub_category_id', $data->sub_category_id)->get();

            return view('backend.products.edit', compact('data', 'category', 'sub_category', 'producttype', 'engine'));
        } catch (\Exception $e) {
            Toastr::error('Something went wrong!', 'Error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        DB::beginTransaction();
        try {
            // --- Handle Main Product Photo (R2) ---
            if ($request->hasFile('product_photo')) {
                // លុបរូបចាស់ចេញពី R2 (បើមាន)
                if ($product->product_photo) {
                    Storage::disk('r2')->delete($product->product_photo);
                }

                $image = $request->file('product_photo');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Upload ទៅ R2
                Storage::disk('r2')->put($filename, file_get_contents($image));

                $product->product_photo = $filename;
            }

            // --- Generate Code Logic (Keep as your request) ---
            $productType = ProductType::find($request->product_type_id);
            $category = ProductCategory::find($request->category_id);
            $subCategory = ProductSubCategory::find($request->sub_category_id);
            $engine = Engine::find($request->engine_id);

            $code = ($productType->name ?? '') . '-' .
                    ($category->name ?? '') . '-' .
                    ($subCategory->name ?? '') . '-' .
                    ($engine->name ?? '') . '-' .
                    $request->number;

            // --- Update Product Details ---
            $product->update([
                'product_type_id'       => $request->product_type_id,
                'category_id'           => $request->category_id,
                'sub_category_id'       => $request->sub_category_id,
                'name'                  => $request->name,
                'slug'                  => Str::slug($request->name, '-'),
                'description'           => $request->description,
                'engine_id'             => $request->engine_id,
                'price'                 => $request->price,
                'year'                  => $request->year,
                'discount_price'        => $request->discount_price,
                'number'                => $request->number,
                'low_stock_qty_warning' => $request->low_stock_qty_warning,
                'delivery_note'         => $request->delivery_note,
                'code'                  => $code,
                'updated_by'            => Auth::id(),
                'product_photo'         => $product->product_photo, // រក្សាឈ្មោះ file ថ្មី
            ]);

            // --- Handle Gallery (R2) ---
            if ($request->hasFile('gallery')) {
                // លុប Gallery ចាស់ក្នុង DB និង R2 (បើចង់រក្សា Logic ចាស់ដែល delete រាល់ពេល update)
                $oldImages = ProductImage::where('product_id', $product->id)->get();
                foreach ($oldImages as $oldImg) {
                    Storage::disk('r2')->delete('gallery/' . $oldImg->path_name);
                }
                ProductImage::where('product_id', $product->id)->delete();

                foreach ($request->file('gallery') as $file) {
                    $galleryName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Upload ទៅ R2 ក្នុង Folder gallery
                    Storage::disk('r2')->put('gallery/' . $galleryName, file_get_contents($file));

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path_name'  => $galleryName,
                        'path'       => 'gallery/' . $galleryName, // រក្សាទុក path សម្រាប់ R2
                    ]);
                }
            }

            DB::commit();
            Toastr::success('Product updated successfully!', 'Success');
            return redirect('admins/product');

        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Product update failed: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            // Delete product main photo if exists
            if ($product->product_photo && file_exists(public_path('images/products/' . $product->product_photo))) {
                unlink(public_path('images/products/' . $product->product_photo));
            }

            // Delete related gallery images
            if ($product->images && $product->images->count() > 0) {
                foreach ($product->images as $image) {
                    $imagePath = public_path($image->path);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $image->delete();
                }
            }
            $product->delete();
            DB::commit();
            return response()->json(['mg' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['mg' => 'error', 'error' => $e->getMessage()], 500);
        }
    }
    public function onchangeCagegory(Request $request){
        try{
            $dataCategory = ProductSubCategory::where('product_category_id',$request->category_id)->get();
            return response()->json([
                'data'=>$dataCategory,
            ]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }

    public function onchangeSubCagegory(Request $request){
        try{
            $datasubCategory = Engine::where('sub_category_id',$request->sub_category_id)->get();
            return response()->json([
                'data'=>$datasubCategory,
            ]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
    public function changePublish(Request $request,$id){
        try {
            $product = Product::findOrFail($id);
            $product->publish = $request->publish;
            $product->save();
            return response()->json(['msg' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'error' => $e->getMessage()]);
        }
    }
    public function deletePhoto($id)
    {
        $product = Product::findOrFail($id);
        $photoPath = public_path('images/products/' . $product->product_photo);

        if (File::exists($photoPath) && $product->product_photo) {
            File::delete($photoPath);
        }

        $product->product_photo = null;
        $product->save();

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Main photo removed successfully.'
        ]);
    }

    public function deleteGalleryImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $imagePath = public_path('images/products/gallery/' . $image->path_name);

        if (File::exists($imagePath) && $image->path_name) {
            File::delete($imagePath);
        }

        $image->delete();

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Gallery image deleted successfully.'
        ]);
    }
}
