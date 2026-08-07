<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPageOptions = [10, 30, 50, 100];
        $perPage = $request->input('per_page', 10);
        $data = ProductCategory::orderBy('id', 'desc')->paginate($perPage)->withQueryString();
        return view('backend.category.index',compact('data', 'perPage', 'perPageOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         DB::beginTransaction();
        try {
            // Handle single product photo
            $filename = null;
            if ($request->hasFile('category_photo')) {
                $image = $request->file('category_photo');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/category'), $filename);
            }
            $data = $request->all();
            $data['slug']=Str::slug($request->name,'-');
            $data['category_photo']=$filename;
            $data['created_by'] = Auth::id();
            // Create product
            $product = ProductCategory::create($data);

            // Handle gallery images
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $galleryName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/category/gallery'), $galleryName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path_name'  => $galleryName,
                        'path'       => 'images/category/gallery/' . $galleryName,
                    ]);
                }
            }
            DB::commit();
            Toastr::success('Product created successfully!', 'Success');
            return redirect('admins/category');
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

        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $data = ProductCategory::find($id);
            return view('backend/category.edit',compact('data'));
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $category)
    {
        // 1. 🛡️ Validation មុនពេលចាប់ផ្តើមប្រតិបត្តិការ
        // គួរតែមានកូដ Validation នៅទីនេះ ឬប្រើ FormRequest
        $request->validate([
            'name'           => 'required|string|max:255',
            'slug'           => 'required|string|max:255|unique:product_categories,slug,' . $category->id,
            'description'    => 'nullable|string',
            'is_active'      => 'required|in:0,1',
            'category_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $photoPath = 'images/category';

        DB::beginTransaction();
        try {
            // 2. 🖼️ គ្រប់គ្រងរូបភាពថ្មី
            $filename = null;
            if ($request->hasFile('category_photo')) {

                // 🔴 CRITICAL FIX 1: លុបរូបភាពចាស់ចេញពី Server
                if ($category->category_photo) {
                    $oldPhotoPath = public_path($photoPath . '/' . $category->category_photo);
                    if (File::exists($oldPhotoPath)) {
                        File::delete($oldPhotoPath);
                    }
                }

                // Upload រូបភាពថ្មី
                $image = $request->file('category_photo');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path($photoPath), $filename);
            }

            // 3. 💾 ត្រៀមទិន្នន័យដោយសុវត្ថិភាព
            // ❌ (កូដចាស់ប្រើ $request->all(); បង្កហានិភ័យ)
            // 🟢 FIX: ប្រើ $request->only() ដើម្បីការពារ Mass Assignment
            $data = $request->only(['name', 'description', 'slug', 'is_active']);

            // បន្ថែម fields ទៅក្នុង $data array
            $data['updated_by'] = Auth::id(); // ប្រើ Auth::id()

            // 🟢 CRITICAL FIX 2: បញ្ចូលឈ្មោះឯកសារថ្មីទៅក្នុង $data ប្រសិនបើមានការ Upload
            if ($filename) {
                $data['category_photo'] = $filename;
            }

            // ❌ កូដគ្រោះថ្នាក់ដែលត្រូវបានដកចេញ៖ ProductImage::where('product_id', $category->id)->delete();

            // ❌ កូដដែលស្ទួនត្រូវបានដកចេញ៖ $category = ProductCategory::find($request->id);
            // ប្រើ $category ដែលបានមកពី Route Model Binding

            // 4. ✍️ Update ទិន្នន័យ
            $category->update($data);

            DB::commit();
            Toastr::success('Updated category successfully.','Success');
            return redirect('admins/category');

        } catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated Category fail','Error');
            return redirect()->back()->withInput();
        }
    }

        /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $data = ProductCategory::find($id);
            $data->delete();
            return response()->json(['mg'=>'success'], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }


    public function deletePhoto($id)
    {
        $product = ProductCategory::findOrFail($id);
        $photoPath = public_path('images/products/' . $product->category_photo);

        if (File::exists($photoPath) && $product->category_photo) {
            File::delete($photoPath);
        }

        $product->category_photo = null;
        $product->save();

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Main photo removed successfully.'
        ]);
    }

}
