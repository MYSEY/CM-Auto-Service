<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequesStore;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with(['category','subCategory','proStatus'])->get();
        return view('backend.products.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = ProductCategory::all();
        return view('backend.products.creat',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequesStore $request)
    {
        DB::beginTransaction();
        try {
            // Handle single product photo
            $filename = null;
            if ($request->hasFile('product_photo')) {
                $image = $request->file('product_photo');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $filename);
            }
            $data = $request->all();
            $data['slug']=Str::slug($request->name,'-');
            $data['product_photo']=$filename;
            $data['created_by'] = Auth::id();
            // Create product
            $product = Product::create($data);

            // Handle gallery images
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $galleryName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/products/gallery'), $galleryName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path_name'  => $galleryName,
                        'path'       => 'images/products/gallery/' . $galleryName,
                    ]);
                }
            }

            DB::commit();
            Toastr::success('Product created successfully!', 'Success');
            return redirect('admins/product');

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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

            // Delete related gallery images if relation exists
            if ($product->images && $product->images->count() > 0) {
                foreach ($product->images as $image) {
                    $imagePath = public_path($image->path);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $image->delete();
                }
            }

            // Delete the product itself
            $product->delete();
            return response()->json(['mg'=>'success'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'mg' => 'error',
                'error' => $e->getMessage()
            ], 500);
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
}
