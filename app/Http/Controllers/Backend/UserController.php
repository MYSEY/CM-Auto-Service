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
        $data = User::all();
        return view('backend.users.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.users.creat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // DB::beginTransaction();
        try{
            if($request->hasFile('profile')) {
                $image = $request->file('profile');
                $filename = time().'.'.$image->getClientOriginalName();
                $image->move(public_path('users/profiles'), $filename);
            }else{
                $filename = '';
            }

            User::create([
                'role_id'  => $request->role_id,
                'profile'  => $filename,
                'name'  => $request->name,
                'user_name'  => $request->user_name,
                'email'  => $request->email,
                'password'  => Hash::make($request->password),
                'sex'  => $request->sex,
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
        try{
            $data = User::find($id);
            return view('backend.users.edit',compact('data'));
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
        try{
            if($request->hasFile('profile')) {
                $image = $request->file('profile');
                $filename = time().'.'.$image->getClientOriginalName();
                $image->move(public_path('users/profiles'), $filename);
            }else{
                $filename = $request->old_profile;
            }

            $data = $request->all();
            $data['profile']    = $filename;
            $data['user_name']   = $request->user_name;
            $data['name']    = $request->name;
            $data['role_id']    = $request->role_id;
            $data['email']  = $request->email;
            $data['password']   = $request->password == null ? $request->old_password : Hash::make($request->password);
            $data['updated_by'] = Auth::user()->id;
            $user = User::find($request->id);
            $user->update($data);
            // if ($user) {
            //     $user->update($data);
            //     // Find the role by ID and get its name
            //     $role = Role::find($request->role_id);
            //     if ($role) {
            //         $user->syncRoles($role->name); // Use the role name
            //     } else {
            //         Toastr::error('Updated Users fail','Error');
            //     }
            // }
            // if ($user) {
            //     UserBranch::where('user_id', $request->id)->delete();
            //     foreach ($request->branches as $value) {
            //         UserBranch::create([
            //             'user_id'  => $request->id,
            //             'branch_id'  => $value,
            //             'updated_by'  => Auth::user()->id,
            //         ]);
            //     }
            // }
            DB::commit();
            Toastr::success('Updated Users successfully.','Success');
            return redirect('admins/users');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated Users fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return response()->json(['mg'=>'success'], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
