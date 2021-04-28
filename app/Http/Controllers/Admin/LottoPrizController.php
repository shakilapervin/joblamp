<?php

namespace App\Http\Controllers\Admin;

use App\LottoPriz;
use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LottoPrizController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Prizes
    |--------------------------------------------------------------------------
    */
    public function index(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $prizes = LottoPriz::all();
        return view('admin.prize.index',compact('prizes'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create Prize
    |--------------------------------------------------------------------------
    */
    public function create(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.prize.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store Prize
    |--------------------------------------------------------------------------
    */
    public function store(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'details' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'title' => $request->title,
            'details' => $request->details,
        );
        LottoPriz::create($data);
        return redirect()->route('admin.lotto.prizes')->with('success',__('Successfully Added!'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Prize
    |--------------------------------------------------------------------------
    */
    public function edit($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $prize = LottoPriz::where('id',$id)->first();
        return view('admin.prize.edit',compact('prize'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Prize
    |--------------------------------------------------------------------------
    */
    public function update(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'details' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $prize = LottoPriz::where('id',$request->id)->first();
        $prize->title = $request->title;
        $prize->details = $request->details;
        $prize->status = $request->status;
        $prize->save();
        return redirect()->route('admin.banners')->with('success',__('Successfully Added!'));
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Prize
    |--------------------------------------------------------------------------
    */
    public function delete($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        LottoPriz::where('id',$id)->delete();
        return redirect()->back()->with('success', __('Successfully Deleted!'));
    }
}
