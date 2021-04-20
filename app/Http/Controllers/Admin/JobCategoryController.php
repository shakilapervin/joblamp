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
            'name' => 'required',
            'description' => 'required',
            'icon' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'name' => $request->name,
            'description' => $request->description,
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
            'name' => 'required',
            'description' => 'required',
            'icon' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $category = JobCategory::where('id',$request->id)->first();
        $category->name = $request->name;
        $category->description = $request->description;
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
