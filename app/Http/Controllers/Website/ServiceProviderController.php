<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

use App\Job;
use App\JobApplication;
use App\Rating;
use App\User;
use App\UserJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mail;
use Illuminate\Support\Facades\Auth;

class ServiceProviderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Manage Job
    |--------------------------------------------------------------------------
    */
    public function manageJob($jobId)
    {
        try {
            $jobId = decrypt($jobId);
        } catch (\RuntimeException $e) {
            return redirect('');
        }
        if (Auth::user()->user_type == 'service_provider') {
            $job = UserJob::where('service_provider_id', Auth::user()->id)
                ->where('job_id', $jobId)
                ->first();
            $receiver = User::where('id',$job->customer_id)->first();
            $rated = false;
            $rating = Rating::where('job_id',$jobId)->where('user_id','!=',Auth::user()->id)->get();
            if ($rating->count() > 0) {
                $rated = true;
            }
            return view('frontend.job.service-provider-manage', compact('job','jobId','rated','receiver'));
        } else {
            return redirect('')->home();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Mark Job As Completed
    |--------------------------------------------------------------------------
    */
    public function markJobComleted($jobId)
    {
        try {
            $jobId = decrypt($jobId);
        } catch (\RuntimeException $e) {
            return redirect('');
        }
        if (Auth::user()->user_type == 'service_provider') {
            $userJob = UserJob::where('job_id',$jobId)->where('service_provider_id',Auth::user()->id)->first();
            if (!empty($userJob)) {
                $userJob->status = 'delivered';
                $userJob->save();
                $job = Job::with('creatorDetails')->where('id',$jobId)->first();
                $job->status = 'delivered';
                $job->save();
                $application = JobApplication::where('job_id',$jobId)->where('candidate_id',Auth::user()->id)->first();
                $application->status = 'delivered';
                $application->save();

                $headers = array(
                    'Authorization: key=' . env('FIREBASE_API_KEY'),
                    'Content-Type: application/json'
                );
                $msg = array(
                    'title' => 'Job Submitted',
                    'body' => "Service provider submitted job",
                );

                $fields = array(
                    'registration_ids' => $job->creatorDetails->device_token,
                    'notification' => $msg,
                    'data' => "Service provider submitted job"
                );
                try {
                    Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send',$fields);
                }catch (\Exception $e){

                }

                $mailData = array();
                $mailAddress = $job->creatorDetails->email;
                try{
                    Mail::send('mail.application-submitted', $mailData, function ($message) use ($mailAddress) {
                        $message->to($mailAddress)->subject('Job Submitted');
                        $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
                    });
                }catch(\Exception $e){

                }
                return redirect()->back()->with('success',__('Job successfully mark as completed.'));
            }else{
                return redirect('')->home();
            }
        } else {
            return redirect('')->home();
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Applied Jobs
    |--------------------------------------------------------------------------
    */
    public function appliedJobs(){
        $user = Auth::user();
        $jobs = JobApplication::where('candidate_id',$user->id)->where('status','applied')->get();
        return view('frontend.freelancer.applied-jobs',compact('jobs'));
    }
    /*
    |--------------------------------------------------------------------------
    | Active Jobs
    |--------------------------------------------------------------------------
    */
    public function activeJobs(){
        $user = Auth::user();
        $jobs = UserJob::with('jobDetails')->where('service_provider_id',$user->id)->where('status','opened')->get();
        return view('frontend.freelancer.active-jobs',compact('jobs'));
    }
    /*
    |--------------------------------------------------------------------------
    | Delivered Jobs
    |--------------------------------------------------------------------------
    */
    public function deliveredJobs(){
        $user = Auth::user();
        $jobs = UserJob::with('jobDetails')->where('service_provider_id',$user->id)->where('status','delivered')->get();
        return view('frontend.freelancer.delivered-jobs',compact('jobs'));
    }
}
