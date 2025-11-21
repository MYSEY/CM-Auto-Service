<?php

namespace App\Http\Controllers\Backend;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function index()
    {
        $data = Slider::all();
        return view('backend.slider.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.slider.creat');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image_slider' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
        ]);
        DB::beginTransaction();
        try {
            if ($request->hasFile('image_slider')) {
                $image = $request->file('image_slider');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/sliders'), $filename);
            }
            Slider::create([
                'title' => $request->title,
                'image_slider' => $filename,
                'status' => 1,
                'created_by' => Auth::id(),
            ]);
            DB::commit();
            Toastr::success('Create Slider successfully.', 'Success');
            return redirect('admins/slide');
        } catch (\Exception $e) {
            // 4. Rollback the transaction on error
            DB::rollback();
            Toastr::error('Create Slider fail', 'Error');
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
            $data = Slider::find($id);
            return view('backend.slider.edit',compact('data'));
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create Users fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image_slider' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional on update
        ]);
        DB::beginTransaction();
        try {
            $slider = Slider::findOrFail($id);
            $filename = $slider->image_slider; // Keep old image by default
            // Update image only if new file uploaded
            if ($request->hasFile('image_slider')) {
                $image = $request->file('image_slider');
                $newFilename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/sliders'), $newFilename);
                // Remove old image
                if ($slider->image_slider && file_exists(public_path('images/sliders/' . $slider->image_slider))) {
                    unlink(public_path('images/sliders/' . $slider->image_slider));
                }
                $filename = $newFilename; // update DB filename
            }
            $slider->update([
                'title' => $request->title,
                'image_slider' => $filename,
                'updated_by' => Auth::id(),
            ]);
            DB::commit();
            Toastr::success('Update Slider successfully.', 'Success');
            return redirect('admins/slide');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Update Slider fail', 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $data = Slider::find($id);
            if (!$data) {
                return response()->json(['msg' => 'error', 'message' => 'Slider not found.'], 404);
            }
            $data->forceDelete();
            return response()->json(['msg' => 'success'], 200);
        } catch(\Exception $e){
            return response()->json(['msg' => 'error', 'error' => $e->getMessage()], 500);
        }
    }

    public function changeStatus(Request $request, $id)
    {
        $newStatus = $request->input('status');
        $slider = Slider::find($id);
        if (!$slider) {
            return response()->json(['msg' => 'error', 'message' => 'Slider not found.'], 404);
        }
        try {
            $slider->status = $newStatus;
            $slider->save();
            return response()->json([
                'msg' => 'success',
                'status' => (int)$newStatus,
                'message' => 'Slider status updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'message' => 'Failed to update status.'], 500);
        }
    }
}
