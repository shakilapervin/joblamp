<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

use App\Job;
use App\JobApplication;
use App\JobDeliveryData;
use App\Rating;
use App\User;
use App\UserJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
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
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
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
            $feedback = Rating::where('job_id',$jobId)->where('user_id',Auth::user()->id)->first();
            if ($rating->count() > 0) {
                $rated = true;
            }
            return view('frontend.job.service-provider-manage', compact('job','jobId','rated','receiver','feedback'));
        } else {
            return redirect('')->home();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Mark Job As Completed
    |--------------------------------------------------------------------------
    */
    public function markJobComleted(Request $request)
    {
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
        $validator = Validator::make($request->all(), [
            'delivery_text' => 'required',
            'delivery_file' => 'mimes:jpg,jpeg,png,bmp,tiff,pdf,zip,psd,ai'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $jobId = $request->job_id;
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
                if ($request->hasFile('delivery_file')){
                    $deliveryFile = $request->file('delivery_file')->store('job-delivery-file');
                    $deliveryData = array(
                        'job_id' => $jobId,
                        'delivery_text' => $request->delivery_text,
                        'delivery_file' => $deliveryFile,
                    );
                    JobDeliveryData::create($deliveryData);
                }else{
                    $deliveryData = array(
                        'job_id' => $jobId,
                        'delivery_text' => $request->delivery_text
                    );
                    JobDeliveryData::create($deliveryData);
                }
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
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
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
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
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
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
        $user = Auth::user();
        $jobs = UserJob::with('jobDetails')->where('service_provider_id',$user->id)->where('status','delivered')->get();
        return view('frontend.freelancer.delivered-jobs',compact('jobs'));
    }

    /*
    |--------------------------------------------------------------------------
    | Completed Jobs
    |--------------------------------------------------------------------------
    */
    public function completedJobs(){
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
        $user = Auth::user();
        $jobs = UserJob::with('jobDetails')->where('service_provider_id',$user->id)->where('status','completed')->get();
        return view('frontend.freelancer.completed-jobs',compact('jobs'));
    }
}
