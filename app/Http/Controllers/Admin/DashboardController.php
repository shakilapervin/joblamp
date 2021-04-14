<?php

namespace App\Http\Controllers\Admin;

use App\Charge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
        $charge = Charge::latest('id')->first();
        return view('admin.charge.edit',compact('charge'));
    }
    /*
    |--------------------------------------------------------------------------
    | update Charge
    |--------------------------------------------------------------------------
    */
    public function updateCharge(Request $request){
        $charge = Charge::latest('id')->first();
        $charge->withdraw_charge = $request->withdraw_charge;
        $charge->customer_charge = $request->customer_charge;
        $charge->worker_charge = $request->worker_charge;
        $charge->promote = $request->promote;
        $charge->save();
        return redirect()->back()->with('success','Successfully Updated');
    }
}
