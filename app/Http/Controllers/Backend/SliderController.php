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
    /**
     * Display a listing of the resource.
     */



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
        $types = ['main', 'banner', 'small'];
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
            'type' => 'required|in:main,banner,small',
            'link' => 'nullable|url|max:255',
        ]);

        // 💡 ចាប់ផ្ដើម Database Transaction
        DB::beginTransaction();

        try {
            $imagePath = null; // Initialize variable

        if ($request->hasFile('image_slider')) {
            $imageFile = $request->file('image_slider');
            $imagePath = $imageFile->store('images/sliders', 'public');
                }$imagePath = null; // Initialize variable

                if ($request->hasFile('image_slider')) {
                    $imageFile = $request->file('image_slider');
                    $imagePath = $imageFile->store('images/sliders', 'public');
                    }
                    // 2. Create the Slider record in the database
                    Slider::create([
                        'title' => $request->title,
                        'image_slider' => $imagePath, // Use the generated filename
                        'type' => $request->type,
                        'link' => $request->link,
                        'status' => 1, // Default status to Publish (assuming 1 = Publish)
                        'created_by' => Auth::id(),
                    ]);

                    // 3. Commit the transaction and return success
                    DB::commit();
                    // Adjust the route name if needed. Using 'admins.slider.index' is conventional.
                    // If your route is 'admins/slide', you should use that URL in the redirect.
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
        try{
        $data = Slider::find($id);

        if (!$data) {
            return response()->json(['msg' => 'error', 'message' => 'Slider not found.'], 404);
        }

        // ប្រើ forceDelete() ដើម្បីលុប Record ទាំងស្រុង និងធ្វើឲ្យ Model Event ដំណើរការ
        $data->forceDelete();

        return response()->json(['msg' => 'success'], 200);

    } catch(\Exception $e){

        return response()->json(['msg' => 'error', 'error' => $e->getMessage()], 500);
    }
}

public function changeStatus(Request $request, $id)
    {
        // 1. ពិនិត្យមើល Status ដែលផ្ញើមក
        $newStatus = $request->input('status');

        // 2. ស្វែងរក Slider ដោយ ID
        $slider = Slider::find($id);

        // 3. ពិនិត្យមើលថាតើ Slider មានឬអត់
        if (!$slider) {
            return response()->json(['msg' => 'error', 'message' => 'Slider not found.'], 404);
        }

        try {
            // 4. Update Status នៅក្នុង Database
            $slider->status = $newStatus;
            $slider->save();

            // 5. ត្រឡប់ Success Response ទៅ AJAX
            return response()->json([
                'msg' => 'success',
                'status' => (int)$newStatus, // ត្រឡប់ status ថ្មីវិញផង
                'message' => 'Slider status updated successfully.'
            ], 200);

        } catch (\Exception $e) {

            return response()->json(['msg' => 'error', 'message' => 'Failed to update status.'], 500);
        }
    }
}

