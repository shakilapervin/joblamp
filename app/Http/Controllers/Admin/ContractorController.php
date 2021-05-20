<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Country;
use App\LottoUser;
use App\State;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Image;
class ContractorController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Contractors
    |--------------------------------------------------------------------------
    */
    public function index(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $contractors = User::where('user_type','service_provider')->get();
        return view('admin.contractor.index',compact('contractors'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Customer Status
    |--------------------------------------------------------------------------
    */
    public function updateStatus($id,$status){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $contractor = User::where('id',$id)->first();
        $contractor->status = $status;
        $contractor->save();
        if ($status == 'active'){
            return redirect('admin-contractors')->with('success','Approved');
        }else{
            return redirect('admin-contractors')->with('error','Rejected');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Contractor Form
    |--------------------------------------------------------------------------
    */
    public function edit($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $customer = User::where('id',$id)->first();
        $countries = Country::where('status',1)->get();
        $states = State::where('status',1)->get();
        $cities = City::where('status',1)->get();
        return view('admin.contractor.edit', compact('countries','customer','states','cities'));
    }


    /*
    |--------------------------------------------------------------------------
    | Update Contractor
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
            'pincode' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'mobile_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = User::where('id',$request->id)->first();
        if ($request->hasFile('profile_pic')){
            $photo = $request->file('profile_pic');
            $photoName = uniqid().'.'.$photo->extension();
            $dPath = public_path('/uploads/profile/avatar/');
            $img = Image::make($photo->path());
            $img->resize(470,570,function ($constraint){
                $constraint->aspectRatio();
            })->save($dPath.$photoName);
            $photoName = 'uploads/products/thumbnail/'.$photoName;

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->pincode = $request->pincode;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->address_line_1 = $request->address_line_1;
            $user->address_line_2 = $request->address_line_2;
            $user->mobile_number = $request->mobile_number;
            $user->profile_pic = $request->$photoName;
            $user->save();
            return redirect('/admin-edit-contractor/'.$request->id)->with('success',__('Profile Updated'));
        }else{
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->pincode = $request->pincode;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->address_line_1 = $request->address_line_1;
            $user->address_line_2 = $request->address_line_2;
            $user->mobile_number = $request->mobile_number;
            $user->save();
            return redirect('/admin-edit-contractor/'.$request->id)->with('success',__('Profile Updated'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Customer
    |--------------------------------------------------------------------------
    */
    public function delete($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $status = User::where('id',$id)->delete();
        if ($status){
            return redirect('admin-contractors')->with('success', __('Deleted!'));
        }else{
            return redirect('admin-contractors')->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Lotto Users
    |--------------------------------------------------------------------------
    */
    public function lottoUsers(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $contractors = LottoUser::with('user')->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get();
        return view('admin.lotto.index',compact('contractors'));
    }
}
