<?php

namespace App\Http\Controllers\Backend;

use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductTypeRequest;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductType::all();
        return view('backend.product_types.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('backend.product_types.creat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductTypeRequest $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = Auth::id();
            // Create product
            ProductType::create($data);
            DB::commit();
            Toastr::success('Product type created successfully!', 'Success');
            return redirect('admins/product-type');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Product type creation failed: ' . $e->getMessage(), 'Error');
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
        try{
            $data = ProductType::find($id);
            return view('backend.product_types.edit',compact('data'));
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create Users fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductType $productType)
    {
        DB::beginTransaction();
        try {
            $productType->update([
                'name'        => $request->name,
                'description' => $request->description,
                'updated_by'  => Auth::id(),
            ]);
            DB::commit();
            Toastr::success('Product type updated successfully!', 'Success');
            return redirect()->route('product-type.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Product type update failed: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id)
    {
        try{
            $data = ProductType::find($id);
            $data->delete();
            return response()->json(['mg'=>'success'], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
