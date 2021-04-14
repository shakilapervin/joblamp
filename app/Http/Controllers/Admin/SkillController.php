<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Skill;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Skills
    |--------------------------------------------------------------------------
    */
    public function index(){
        $skills = Skill::all();
        return view('admin.skill.index',compact('skills'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create Skill
    |--------------------------------------------------------------------------
    */
    public function create(){
        return view('admin.skill.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store Skill
    |--------------------------------------------------------------------------
    */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'name' => $request->name
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
        $skill = Skill::where('id',$id)->first();
        return view('admin.skill.edit',compact('skill'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Skill
    |--------------------------------------------------------------------------
    */
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $skill = Skill::where('id',$request->id)->first();
        $skill->name = $request->name;
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
        Skill::where('id',$id)->delete();
        return redirect()->back()->with('success', __('Successfully Deleted!'));
    }
}
