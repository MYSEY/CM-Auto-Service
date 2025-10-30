<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            if ($request->hasFile('profile')) {
                // Handle uploaded file
                $image = $request->file('profile');
                $ext = $image->getClientOriginalExtension();
                $imageName = time() . rand(1, 100) . "." . $ext;
                $fileContents = file_get_contents($image->getRealPath());
                $s3FullPath = 'public/users/profiles/' . $imageName;
            } else{
                $full_path ='';
            }

            User::create([
                'role_id'  => $request->role_id,
                'branch_default'  => $request->branch_default,
                'profile'  => $full_path,
                'name'  => $request->name,
                'email'  => $request->email,
                'password'  => Hash::make($request->password),
                'sex'  => $request->sex,
                'date_of_birth'  => Carbon::createFromDate($request->date_of_birth)->format('Y-m-d'),
                'created_by'  => Auth::user()->id,
            ]);
            // if ($user) {
            //     foreach ($request->branches as $value) {
            //         UserBranch::create([
            //             'user_id'  => $user->id,
            //             'branch_id'  => $value,
            //             'created_by'  => Auth::user()->id,
            //         ]);
            //     }
            // }
            // $roleName = Role::find($request->role_id)->name;
            // $user->assignRole($roleName);
            DB::commit();
            Toastr::success('Create Users successfully.','Success');
            return redirect('admins/users');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Create Users fail','Error');
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
    public function destroy(string $id)
    {
        //
    }
}
