<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    //this method will show admin login page/screen
    public function index(){
        return view('admin.adminLogin');
    }
    // This method will authenticate admin user
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            //only add guard name
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                if(Auth::guard('admin')->user()->role != "admin"){
                    Auth::guard('admin')->logout(); //autometice create session k delete kore dilam
                    return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page');
                }
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin.login')->with('error', 'Either email or password is incorrect');
            }
        } else {
            return redirect()->route('admin.login')->withInput()->withErrors($validator);
        }
    }
    //this method will logout admin user
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
