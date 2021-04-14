<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Login Form
    |--------------------------------------------------------------------------
    */
    public function loginForm(){
        if (!empty(Auth::user())){
            if (Auth::user()->is_admin == 1){
                return redirect('admin-dashboard');
            }
        }
        return view('admin.auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Check Login Credential
    |--------------------------------------------------------------------------
    */
    public function checkLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = User::where('email',$request->email)->first();
        if(!empty($user)){
            if ($user->is_admin == 1){
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    return redirect('admin-dashboard');
                } else {
                    return redirect()->back()->with('error', __('Email and password did\'t match!'));
                }
            }else{
                return redirect()->back()->with('error', __('Sorry you are not admin'));
            }
        }else{
            return redirect()->back()->with('error', __('Sorry you are not admin'));
        }
    }
}
