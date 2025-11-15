<?php

namespace App\Http\Controllers\Backend;

use App\Models\Engine;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class EngineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Engine::with('subCategory')->get();
        return view('backend.engines.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subCategory = ProductSubCategory::all();
        return view('backend.engines.create',compact('subCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = Auth::id();
            $data['slug']=Str::slug($request->name,'-');
            Engine::create($data);
            DB::commit();
            Toastr::success('Create Engine successfully.','Success');
            return redirect('admins/engine');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create Engine fail','Error');
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
            $data = Engine::findOrFail($id);
            $subCategory = ProductSubCategory::all();
            return view('backend.engines.edit', compact('subCategory', 'data'));
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
        try {
            $data = $request->all();
            $data['sub_category_id']   = $request->sub_category_id;
            $data['name']    = $request->name;
            $data['updated_by'] = Auth::user()->id;
            $engine = Engine::find($id);
            $engine->update($data);
            DB::commit();
            Toastr::success('Product Engine updated successfully!', 'Success');
            return redirect('admins/engine');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Update Product Engine fail.','Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $data = Engine::find($id);
            $data->delete();
            return response()->json(['mg'=>'success'], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
