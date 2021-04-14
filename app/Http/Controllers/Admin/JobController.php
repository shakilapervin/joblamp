<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Country;
use App\Job;
use App\JobCategory;
use App\JobDispute;
use App\State;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Image;

class JobController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Job List
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $date = $request->date;
        $status = $request->status;
        $noJob = false;

        $query = Job::with('creatorDetails')->with('categoryInfo');
        if (!empty($status)){
            $jobstatus = Job::where('status',$status)->get();
            if (!empty($jobstatus)){
                $query = $query->where('status',$status);
            }else{
                $noJob = true;
            }
        }

        if (!empty($date)){
            $jobdate = Job::whereDate('created_at',$date)->get();
            if (!empty($jobdate)){
                $query = $query->whereDate('created_at',$date);
            }else{
                $noJob = true;
            }
        }
        $jobs = $query->get();
        return view('admin.job.index', compact('jobs','noJob'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Job Form
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $countries = Country::where('status', 1)->get();
        $states = State::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $job = Job::where('id', $id)->first();
        $categories = JobCategory::where('status', 1)->get();
        return view('admin.job.edit', compact('countries', 'job', 'states', 'cities', 'categories'));
    }


    /*
    |--------------------------------------------------------------------------
    | Update Job
    |--------------------------------------------------------------------------
    */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'service_provider_rating' => 'required',
            'fee_range_min' => 'required',
            'fee_range_max' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $job = Job::where('id', $request->id)->first();
        $job->title = $request->title;
        $job->category = $request->category;
        $job->start_date = $request->start_date;
        $job->end_date = $request->end_date;
        $job->address = $request->address;
        $job->country = $request->country;
        $job->state = $request->state;
        $job->city = $request->city;
        $job->pincode = $request->pincode;
        $job->service_provider_rating = $request->service_provider_rating;
        $job->fee_range_min = $request->fee_range_min;
        $job->fee_range_max = $request->fee_range_max;
        $job->status = $request->status;
        $job->save();
        return redirect('/admin-edit-job/' . $request->id)->with('success', __('Job Updated'));

    }

    /*
    |--------------------------------------------------------------------------
    | Delete Job
    |--------------------------------------------------------------------------
    */
    public function delete($id)
    {
        $status = Job::where('id', $id)->delete();
        if ($status) {
            return redirect('admin-contractors')->with('success', __('Deleted!'));
        } else {
            return redirect('admin-contractors')->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Job Details View
    |--------------------------------------------------------------------------
    */
    public function jobDetails($id)
    {
        $countries = Country::where('status', 1)->get();
        $states = State::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $job = Job::where('id', $id)->first();
        $categories = JobCategory::where('status', 1)->get();
        return view('admin.job.view', compact('countries', 'job', 'states', 'cities', 'categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | All Disputed Jobs
    |--------------------------------------------------------------------------
    */
    public function disputedJobs(Request $request)
    {
        $jobs = Job::where('status','disputed')->get();
        return view('admin.job.dispute-index', compact('jobs'));
    }

    /*
    |--------------------------------------------------------------------------
    | Dispute Job Details View
    |--------------------------------------------------------------------------
    */
    public function disputJobDetails($id)
    {
        $job = Job::where('id', $id)->first();
        $dispute = JobDispute::where('job_id', $id)->first();
        return view('admin.job.dispute-view', compact('job','dispute'));
    }
}
