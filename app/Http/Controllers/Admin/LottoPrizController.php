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
            'title_en' => 'required',
            'title_es' => 'required',
            'title_fr' => 'required',
            'title_de' => 'required',
            'title_pt' => 'required',
            'title_ro' => 'required',
            'details_en' => 'required',
            'details_es' => 'required',
            'details_fr' => 'required',
            'details_de' => 'required',
            'details_pt' => 'required',
            'details_ro' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'title_en' => $request->title_en,
            'title_es' => $request->title_es,
            'title_fr' => $request->title_fr,
            'title_de' => $request->title_de,
            'title_pt' => $request->title_pt,
            'title_ro' => $request->title_ro,
            'details_en' => $request->details_en,
            'details_es' => $request->details_es,
            'details_fr' => $request->details_fr,
            'details_de' => $request->details_de,
            'details_pt' => $request->details_pt,
            'details_ro' => $request->details_ro,
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
            'title_en' => 'required',
            'title_es' => 'required',
            'title_fr' => 'required',
            'title_de' => 'required',
            'title_pt' => 'required',
            'title_ro' => 'required',
            'details_en' => 'required',
            'details_es' => 'required',
            'details_fr' => 'required',
            'details_de' => 'required',
            'details_pt' => 'required',
            'details_ro' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $prize = LottoPriz::where('id',$request->id)->first();
        $prize->title_en = $request->title_en;
        $prize->title_es = $request->title_es;
        $prize->title_fr = $request->title_fr;
        $prize->title_de = $request->title_de;
        $prize->title_pt = $request->title_pt;
        $prize->title_ro = $request->title_ro;
        $prize->details_en = $request->details_en;
        $prize->details_es = $request->details_es;
        $prize->details_fr = $request->details_fr;
        $prize->details_de = $request->details_de;
        $prize->details_pt = $request->details_pt;
        $prize->details_ro = $request->details_ro;
        $prize->status = $request->status;
        $prize->save();
        return redirect()->route('admin.lotto.prizes')->with('success',__('Successfully Added!'));
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
