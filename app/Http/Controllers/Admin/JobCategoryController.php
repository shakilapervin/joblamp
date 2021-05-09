<?php

namespace App\Http\Controllers\Admin;
use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\JobCategory;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobCategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Job Categories
    |--------------------------------------------------------------------------
    */
    public function jobCategories(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $categories = JobCategory::all();
        return view('admin.job-category.index',compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | Add New Job Categories
    |--------------------------------------------------------------------------
    */
    public function addJobCategoryForm(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.job-category.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Save Job Category
    |--------------------------------------------------------------------------
    */
    public function saveJobCategory(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'name_en' => 'required',
            'name_es' => 'required',
            'name_fr' => 'required',
            'name_ro' => 'required',
            'name_de' => 'required',
            'name_pt' => 'required',
            'description_en' => 'required',
            'description_es' => 'required',
            'description_fr' => 'required',
            'description_de' => 'required',
            'description_ro' => 'required',
            'description_pt' => 'required',
            'icon' => 'required',
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
            'name_ro' => $request->name_ro,
            'name_de' => $request->name_de,
            'name_pt' => $request->name_pt,
            'description_en' => $request->description_en,
            'description_es' => $request->description_es,
            'description_fr' => $request->description_fr,
            'description_de' => $request->description_de,
            'description_ro' => $request->description_ro,
            'description_pt' => $request->description_pt,
            'icon' => $request->icon
        );

        $status = JobCategory::create($data);
        if ($status){
            return redirect('admin-job-categories')->with('success', __('Successfully Added!'));
        }else{
            return redirect('admin-job-categories')->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Job Category Form
    |--------------------------------------------------------------------------
    */
    public function editJobCategoryForm($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $category = JobCategory::where('id',$id)->first();
        return view('admin.job-category.edit', compact('category'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Job Category
    |--------------------------------------------------------------------------
    */
    public function updateJobCategory(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'name_en' => 'required',
            'name_es' => 'required',
            'name_fr' => 'required',
            'name_ro' => 'required',
            'name_de' => 'required',
            'name_pt' => 'required',
            'description_en' => 'required',
            'description_es' => 'required',
            'description_fr' => 'required',
            'description_de' => 'required',
            'description_ro' => 'required',
            'description_pt' => 'required',
            'icon' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $category = JobCategory::where('id',$request->id)->first();
        $category->name_en = $request->name_en;
        $category->name_es = $request->name_es;
        $category->name_fr = $request->name_fr;
        $category->name_ro = $request->name_ro;
        $category->name_de = $request->name_de;
        $category->name_pt = $request->name_pt;

        $category->description_en = $request->description_en;
        $category->description_es = $request->description_es;
        $category->description_fr = $request->description_fr;
        $category->description_de = $request->description_de;
        $category->description_ro = $request->description_ro;
        $category->description_pt = $request->description_pt;
        $category->icon = $request->icon;
        $category->status = $request->status;
        $category->save();
        return redirect('/admin-edit-job.category/'.$request->id)->with('success',__('Category Updated'));
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Job Category
    |--------------------------------------------------------------------------
    */
    public function deleteJobCategory($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $status = JobCategory::where('id',$id)->delete();
        if ($status){
            return redirect('admin-customers')->with('success', __('Deleted!'));
        }else{
            return redirect('admin-customers')->with('error', __('Error!'));
        }
    }
}
