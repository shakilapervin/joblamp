<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\JobCategory;
use App\JobSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobSubCategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Job Sub Categories
    |--------------------------------------------------------------------------
    */
    public function categories(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $categories = JobSubCategory::all();
        return view('admin.job-sub-category.index',compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | Add New Job Sub Categories
    |--------------------------------------------------------------------------
    */
    public function add(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $categories = JobCategory::where('status',1)->get();
        return view('admin.job-sub-category.create',compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | Save Job Sub Category
    |--------------------------------------------------------------------------
    */
    public function store(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'parent_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        );

        $status = JobSubCategory::create($data);
        if ($status){
            return redirect('admin-job-subcategories')->with('success', __('Successfully Added!'));
        }else{
            return redirect('admin-job-subcategories')->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Job Sub Category Form
    |--------------------------------------------------------------------------
    */
    public function edit($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $categories = JobCategory::where('status',1)->get();
        $details = JobSubCategory::where('id',$id)->first();
        return view('admin.job-sub-category.edit', compact('categories','details'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Job Sub Category
    |--------------------------------------------------------------------------
    */
    public function update(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'parent_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $category = JobSubCategory::where('id',$request->id)->first();
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->status = $request->status;
        $category->save();
        return redirect('/admin-edit-job.subcategory/'.$request->id)->with('success',__('Category Updated'));
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Job Sub Category
    |--------------------------------------------------------------------------
    */
    public function delete($id){
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
