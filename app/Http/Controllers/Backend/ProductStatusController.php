<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\ProductStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductStatusRequest;

class ProductStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductStatus::all();
        return view('backend.product_status.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('backend.product_status.creat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStatusRequest $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = Auth::id();
            // Create product
            ProductStatus::create($data);
            DB::commit();
            Toastr::success('Product status created successfully!', 'Success');
            return redirect('admins/product-status');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Product status creation failed: ' . $e->getMessage(), 'Error');
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
            $data = ProductStatus::find($id);
            return view('backend.product_status.edit',compact('data'));
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create Users fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductStatus $productStatus)
    {
       try {
            // Update product details
            $productStatus->update([
                'name'             => $request->name,
                'description'      => $request->description,
                'updated_by'       => Auth::id(),
            ]);
            DB::commit();
            Toastr::success('Product status update successfully!', 'Success');
            return redirect('admins/product-status');
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Product status update failed: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductStatus $productStatus)
    {
        try{
            $productStatus->delete();
            return response()->json(['mg'=>'success'], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
