<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

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
        // 1. Validation
        $request->validate([
            'name' => 'required|string|max:100',
            // 'description' => 'nullable|string|max:200',
            // 'slug' => 'nullable|string|max:100|unique:product_categories,slug',
            'is_active' => 'nullable|in:0,1',
        ]);
        // 💡 ចាប់ផ្ដើម Database Transaction
        DB::beginTransaction();

        try {
            // 2. Prepare Data (Generate Slug)
            $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

            // ពិនិត្យមើល slug ថាមាននៅ បើមាន គឺបន្ថែម timestamp
            if (ProductCategory::where('slug', $slug)->exists()) {
                 $slug = $slug . '-' . time();
            }
            // 3. Create Record
            ProductCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => $slug,
                'is_active' => $request->is_active ?? 1,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            Toastr::success('Create Category successfully.','Success');
            return redirect('admins/category');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create Category fail','Error');
            return redirect()->back();
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
    public function update(Request $request, string $id)
    {
        try{
            $data = $request->all();
            $data['name']   = $request->name;
            $data['description']    = $request->description;
            $data['slug']    = $request->slug;
            $data['is_active']  = $request->is_active;
            $data['updated_by'] = Auth::user()->id;
            $category = ProductCategory::find($request->id);
            $category->update($data);
            DB::commit();
            Toastr::success('Updated category successfully.','Success');
            return redirect('admins/category');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated Category fail','Error');
            return redirect()->back();
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
}
