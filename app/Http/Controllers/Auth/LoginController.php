<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Company;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function login(Request $request){
        try {
            $user = User::where('user_name', $request->user_name)->first();
            if (!$user) {
                Toastr::error('Invalid UserName or Password.', 'Error');
                return redirect('logins');
            }

            if ($user->is_active != 1) {
                Toastr::error('Your account has been disabled.', 'Error');
                return redirect('logins');
            }

            if (Auth::attempt(['user_name' => $request->user_name, 'password' => $request->password])) {
                Toastr::success('Login successfully.', 'Success');
                return redirect('admins/dashboard');
            } else {
                Toastr::error('Wrong UserName or Password.', 'Error');
                return redirect('logins');
            }
        } catch(\Exception $e) {
            Toastr::error('Wrong UserName or Password.', 'Error');
            return redirect()->back();
        }
    }
    public function logoutForm(Request $request) {
        Auth::logout();
        Session::flush(); // ✅ Clears all session data completely
        return redirect('logins');
    }
}
