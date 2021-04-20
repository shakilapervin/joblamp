<?php

namespace App\Http\Controllers\Admin;

use App\Charge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */
    public function index(){
        return view('admin.dashboard.dashboard');
    }
    /*
    |--------------------------------------------------------------------------
    | Edit Charge
    |--------------------------------------------------------------------------
    */
    public function editCharge(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $charge = Charge::latest('id')->first();
        return view('admin.charge.edit',compact('charge'));
    }
    /*
    |--------------------------------------------------------------------------
    | update Charge
    |--------------------------------------------------------------------------
    */
    public function updateCharge(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $charge = Charge::latest('id')->first();
        $charge->withdraw_charge = $request->withdraw_charge;
        $charge->customer_charge = $request->customer_charge;
        $charge->worker_charge = $request->worker_charge;
        $charge->promote = $request->promote;
        $charge->save();
        return redirect()->back()->with('success','Successfully Updated');
    }
}
