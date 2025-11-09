<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'product_category_id' => 'required|integer|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:product_sub_categories,serial_number',
            'description' => 'nullable|string|max:200',
            'is_active' => 'nullable|in:0,1',
        ]);
        // 💡 ចាប់ផ្ដើម Database Transaction
        DB::beginTransaction();

        try {
            ProductSubCategory::create([
                'product_category_id' => $validatedData['product_category_id'],
                'name' => $validatedData['name'],
                'serial_number' => $validatedData['serial_number'],
                'description' => $validatedData['description'],
                'is_active' => $request->is_active ?? 1,
                'created_by' => Auth::id(),
            ]);

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
            $productSubCategory = ProductSubCategory::findOrFail($id);
            $categories = ProductCategory::selectRaw('MIN(id) as id, name')->groupBy('name')->orderBy('name')->get();
            return view('backend.sub_category.edit', compact('categories', 'productSubCategory'));
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
       // 1. Find the specific ProductSubCategory instance
        $productSubCategory = ProductSubCategory::findOrFail($id);
        $oldName = $productSubCategory->name;

        // 2. Validation
        $validatedData = $request->validate([
            'product_category_id' => 'required|integer|exists:product_categories,id',
            'name' => 'required|string|max:255',
            // Use Rule::unique to ignore the current record's serial_number during validation
            'serial_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_sub_categories', 'serial_number')->ignore($productSubCategory->id),
            ],
            'description' => 'nullable|string|max:200',
            'is_active' => 'nullable|in:0,1',
        ]);

        // 💡 Start Database Transaction
        DB::beginTransaction();

        try {
            // 3. Prepare the data array
            $updateData = [
                'product_category_id' => $validatedData['product_category_id'],
                'name' => $validatedData['name'],
                'serial_number' => $validatedData['serial_number'],
                'description' => $validatedData['description'],
                // Since the form uses radio buttons, $request->is_active will always be present (0 or 1)
                'is_active' => $request->is_active,
                'updated_by' => Auth::id(), // Use updated_by for tracking changes
            ];

            // 4. Update the record
            $productSubCategory->update($updateData);

            DB::commit();
            Toastr::success('Product Sub-Category **' . $updateData['name'] . '** updated successfully.','Success');
            return redirect('admins/sub-category'); // Redirect to index route
        } catch (\Exception $e) {
            DB::rollback();
            // Log the error in a real application
            // \Log::error('Update error: ' . $e->getMessage());
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
