<?php

namespace App\Http\Controllers\Backend;

use App\Models\Shop;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ShopRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class BackendShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Shop::all();
        return view('backend.shops.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provice = DB::table('tb_province')->get();
        return view('backend.shops.creat',compact('provice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShopRequest $request)
    {
        try {
            // Handle single product photo
            $filename = null;
            if ($request->hasFile('logo_company')) {
                $image = $request->file('logo_company');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/logo_company'), $filename);
            }
            $data = $request->all();
            $data['slug']=Str::slug($request->name,'-');
            $data['logo_company']=$filename;
            $data['created_by'] = Auth::id();
            // Create product
            Shop::create($data);
            DB::commit();
            Toastr::success('Product created successfully!', 'Success');
            return redirect('admins/shops');
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
    public function destroy(string $id)
    {
        //
    }
}
