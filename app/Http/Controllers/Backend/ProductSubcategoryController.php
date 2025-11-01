<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class ProductSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $data = ProductSubCategory::all();
         $category = ProductCategory::find(1);
        return view('backend.sub_category.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retrieve the necessary data (ID and Name) for the dropdown
        $categories = ProductCategory::all(['id', 'name']);

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
        {
        try{
            $data = ProductSubCategory::find($id);

                // Retrieve the necessary data (ID and Name) for the dropdown
            $categories = ProductCategory::all(['id', 'name']);
                return view('backend/sub_category.edit',compact('data','categories'));
            }catch(\Exception $e){
                return response()->json(['error'=>$e->getMessage()]);
            }
    }
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
    public function destroy(string $id)
    {
        //
    }
}
