<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use Illuminate\Http\Request;
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
        $data = Product::all();
        return view('backend.products.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.products.creat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequesStore $request)
    {
        dd($request->all());
        if($request->hasFile('product_photo')) {
            $image = $request->file('product_photo');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images/products'), $filename);
        }
        try {
            Product::create([
                'status_id'     => $request->status_id,
                'category_id'   => $request->category_id,
                'sub_category_id'   => $request->sub_category_id,
                'name'          => $request->name,
                'description'   => $request->description,
                'product_photo' => $filename,
                'content'       => $request->content,
                'price'         => $request->price,
                'discount_price'=> $request->discount_price,
                'created_by'    => Auth::user()->id,
            ]);
            DB::commit();
            Toastr::success('Products Created Successfully!','Success');
            return redirect('admins/product');
        } catch (\Exception $exp) {
            DB::rollback();
            Toastr::error('Products Created fail','Error');
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
        try{
            $product->delete();
            return response()->json(['mg'=>'success'], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
