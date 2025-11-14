<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Validation\Rule;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductSubCategoryRequest;

class ProductSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ProductSubCategory::with('category')->get();
        return view('backend.sub_category.index', compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::selectRaw('MIN(id) as id, name')->groupBy('name')->orderBy('name')->get();
        // Pass the data to the view using compact()
        return view('backend.sub_category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductSubCategoryRequest $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = Auth::id();
            ProductSubCategory::create($data);
            DB::commit();
            Toastr::success('Create Sub Category successfully.','Success');
            return redirect('admins/sub-category');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create Sub Category fail','Error');
            return redirect()->back();
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
            $data = ProductSubCategory::findOrFail($id);
            $categories = ProductCategory::selectRaw('MIN(id) as id, name')->groupBy('name')->orderBy('name')->get();
            return view('backend.sub_category.edit', compact('categories', 'data'));
        } catch (\Exception $e) {
            Toastr::error('Sub-Category not found or an error occurred.','Error');
            return redirect()->back();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['product_category_id']   = $request->product_category_id;
            $data['name']    = $request->name;
            $data['serial_number']    = $request->serial_number;
            $data['description']    = $request->description;
            $data['is_active']    = $request->is_active;
            $data['updated_by'] = Auth::user()->id;
            $subCategory = ProductSubCategory::find($id);
            $subCategory->update($data);
            DB::commit();
            Toastr::success('Product Sub Category updated successfully!', 'Success');
            return redirect('admins/sub-category');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Update Product Sub-Category fail.','Error');
            return redirect()->back()->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
   {
        try{
            $data = ProductSubCategory::find($id);
            $data->delete();
            return response()->json(['mg'=>'success'], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
