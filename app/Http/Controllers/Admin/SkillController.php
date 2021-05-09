<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Skill;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Skills
    |--------------------------------------------------------------------------
    */
    public function index(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $skills = Skill::all();
        return view('admin.skill.index',compact('skills'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create Skill
    |--------------------------------------------------------------------------
    */
    public function create(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.skill.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store Skill
    |--------------------------------------------------------------------------
    */
    public function store(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'name_en' => 'required',
            'name_es' => 'required',
            'name_fr' => 'required',
            'name_de' => 'required',
            'name_ro' => 'required',
            'name_pt' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'name_en' => $request->name_en,
            'name_es' => $request->name_es,
            'name_fr' => $request->name_fr,
            'name_de' => $request->name_de,
            'name_ro' => $request->name_ro,
            'name_pt' => $request->name_pt,
        );
        Skill::create($data);
        return redirect()->route('admin.skills')->with('success',__('Successfully Added!'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Skill
    |--------------------------------------------------------------------------
    */
    public function edit($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $skill = Skill::where('id',$id)->first();
        return view('admin.skill.edit',compact('skill'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Skill
    |--------------------------------------------------------------------------
    */
    public function update(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'name_en' => 'required',
            'name_es' => 'required',
            'name_fr' => 'required',
            'name_de' => 'required',
            'name_ro' => 'required',
            'name_pt' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $skill = Skill::where('id',$request->id)->first();
        $skill->name_en = $request->name_en;
        $skill->name_es = $request->name_es;
        $skill->name_fr = $request->name_fr;
        $skill->name_de = $request->name_de;
        $skill->name_ro = $request->name_ro;
        $skill->name_pt = $request->name_pt;
        $skill->status = $request->status;
        $skill->save();
        return redirect()->route('admin.skills')->with('success',__('Successfully Updated!'));
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Banner
    |--------------------------------------------------------------------------
    */
    public function delete($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        Skill::where('id',$id)->delete();
        return redirect()->back()->with('success', __('Successfully Deleted!'));
    }
}
