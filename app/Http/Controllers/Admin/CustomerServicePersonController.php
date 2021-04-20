<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerServicePersonController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Customer Service Person
    |--------------------------------------------------------------------------
    */
    public function index(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $users = User::where('user_type','cs_person')->get();
        return view('admin.cs-person.index',compact('users'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create Customer Service Person
    |--------------------------------------------------------------------------
    */
    public function create(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.cs-person.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Save Customer Service Person
    |--------------------------------------------------------------------------
    */
    public function store(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'email' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'user_type' => 'cs_person',
            'status' => 'active',
            'password' => Hash::make($request->password),
        );

        $status = User::create($data);
        if ($status){
            return redirect('admin-cs-persons')->with('success', __('Successfully Added!'));
        }else{
            return redirect('admin-cs-persons')->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Customer Service Person
    |--------------------------------------------------------------------------
    */
    public function edit($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $user = User::where('id',$id)->first();
        return view('admin.cs-person.edit',compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Customer Service Person
    |--------------------------------------------------------------------------
    */
    public function update(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = User::where('id',$request->id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->status = $request->status;
        if (!empty($request->email)){
            $user->email = $request->email;
        }
        if (!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $status = $user->save();
        if ($status){
            return redirect()->back()->with('success', __('Successfully Updated!'));
        }else{
            return redirect()->back()->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Customer Service Person
    |--------------------------------------------------------------------------
    */
    public function delete($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        User::where('id',$id)->delete();
        return redirect()->back()->with('success', __('Successfully Deleted!'));
    }
}
