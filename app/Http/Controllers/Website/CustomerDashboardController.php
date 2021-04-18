<?php

namespace App\Http\Controllers\Website;

use App\Charge;
use App\City;
use App\Country;
use App\Job;
use App\JobApplication;
use App\JobDispute;
use App\Notification;
use App\Rating;
use App\State;
use App\User;
use App\UserJob;
use App\UserTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Http;


class CustomerDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Job Applications List
    |--------------------------------------------------------------------------
    */
    public function jobApplications($id)
    {
        try {
            $id = decrypt($id);
        } catch (\RuntimeException $e) {
            return redirect('');
        }
        $job = Job::where('id', $id)->first();
        $applications = JobApplication::where('job_id', $id)->where('status', 'applied')->get();
        $jobStatus = false;
        if (UserJob::where('job_id', $id)->get()->count() > 0) {
            $jobStatus = true;
        }
        $jobId = $id;
        return view('frontend.job.applications', compact('job', 'applications', 'jobId', 'jobStatus'));
    }


    /*
    |--------------------------------------------------------------------------
    | Accept Job Application
    |--------------------------------------------------------------------------
    */
    public function acceptApplication($jobId, $serviceProviderId)
    {
        try {
            $jobId = decrypt($jobId);
        } catch (\RuntimeException $e) {
            return redirect('');
        }

        try {
            $serviceProviderId = decrypt($serviceProviderId);
        } catch (\RuntimeException $e) {
            return redirect('');
        }
        if (Auth::user()->user_type == 'customer') {
            $job = Job::where('id', $jobId)->first();
            if (!empty($job)) {
                $data = array(
                    'customer_id' => Auth::user()->id,
                    'service_provider_id' => $serviceProviderId,
                    'job_id' => $jobId,
                );

                $success = UserJob::create($data);

                $job->status = 'hired';
                $job->save();

                $application = JobApplication::where('job_id', $jobId)->where('candidate_id', $serviceProviderId)->first();
                $application->status = 'hired';
                $application->save();

                if ($success) {
                    return redirect()->back()->with('success', __('Job Application Accepted.'));
                } else {
                    return redirect()->back()->with('error', __('An error occurred, Please try again!'));
                }
            } else {
                return redirect('')->home();
            }

        } else {
            return redirect('')->home();
        }
    }

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
        if (Auth::user()->user_type == 'customer') {
            $receiver = UserJob::with('workerDetails')->where('job_id',$jobId)->first();
            $job = Job::with('creatorDetails')->where('user_id', Auth::user()->id)
                ->where('id', $jobId)
                ->first();
            $rated = false;
            $rating = Rating::where('job_id', $jobId)->where('user_id', '!=', Auth::user()->id)->get();
            if ($rating->count() > 0) {
                $rated = true;
            }
            return view('frontend.job.customer-manage', compact('job', 'jobId', 'rated','receiver'));
        } else {
            return redirect('')->home();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Approve Job Delivery
    |--------------------------------------------------------------------------
    */
    public function approveJobDelivery($jobId)
    {
        try {
            $jobId = decrypt($jobId);
        } catch (\RuntimeException $e) {
            return redirect('');
        }
        if (Auth::user()->user_type == 'customer') {
            $job = Job::where('id', $jobId)->where('user_id', Auth::user()->id)->first();
            if (!empty($job)) {
                $job->status = 'completed';
                $job->save();

                $userJob = UserJob::where('job_id', $jobId)->first();
                $userJob->status = 'completed';
                $userJob->save();

                $application = JobApplication::where('job_id', $jobId)->first();
                $application->status = 'completed';
                $application->save();
                $charge = Charge::latest('id')->first()->customer_charge;
                $credit = ($application->bid_amount*$charge)/100;
                UserTransaction::create(array(
                    'user_id' => $application->candidate_id,
                    'credit' => $application->bid_amount-$credit,
                ));
                return redirect()->back()->with('success', __('Job successfully mark as completed.'));
            } else {
                return redirect('')->home();
            }
        } else {
            return redirect('')->home();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Save Job Feedback
    |--------------------------------------------------------------------------
    */
    public function saveJobFeedback(Request $request)
    {
        try {
            $jobId = decrypt($request->job_id);
        } catch (\RuntimeException $e) {
            return redirect('');
        }

        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'rating' => 'required',
            'feedback' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::user()->user_type == 'customer') {
            $userId = UserJob::where('job_id', $jobId)->first()->service_provider_id;
            $data = array(
                'job_id' => $jobId,
                'rating' => $request->rating,
                'feedback' => $request->feedback,
                'user_id' => $userId,
            );
        } else {
            $userId = Job::where('id', $jobId)->first()->user_id;
            $data = array(
                'job_id' => $jobId,
                'rating' => $request->rating,
                'feedback' => $request->feedback,
                'user_id' => $userId,
            );
        }

        $success = Rating::create($data);
        $user = User::where('id', $userId)->first();
        if ($success) {
            $headers = array(
                'Authorization: key=' . env('FIREBASE_API_KEY'),
                'Content-Type: application/json'
            );
            $msg = array(
                'title' => 'Job Feedback Submitted',
                'body' => "Job owner provided $request->rating Star Rating",
            );

            $fields = array(
                'registration_ids' => $user->device_token,
                'notification' => $msg,
                'data' => "Job owner provided $request->rating Star Rating"
            );
            try {
                Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send',$fields);
            }catch (\Exception $e){

            }

            $mailData = array(
                'rating' => $request->rating
            );
            $mailAddress = $user->email;
            try {
                Mail::send('mail.rating', $mailData, function ($message) use ($mailAddress) {
                    $message->to($mailAddress)->subject('Job Feedback Submitted');
                    $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
                });
            } catch (\Exception $e) {

            }
            $notification = array(
                'user_id' => $user->id,
                'description' => 'Job Feedback Submitted',
            );
            Notification::create($notification);
            return redirect()->back()->with('success', __('Thanks for you feedback!'));
        } else {
            return redirect()->back()->with('error', __('An error occurred, Please try again!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Submit Dispute Request
    |--------------------------------------------------------------------------
    */
    public function disputeJobDelivery(Request $request)
    {
        try {
            $jobId = decrypt($request->id);
        } catch (\RuntimeException $e) {
            return redirect('');
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'reason' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::user()->user_type == 'customer') {
            $job = Job::where('id', $jobId)->where('user_id', Auth::user()->id)->first();
            if (!empty($job)) {
                $job->status = 'disputed';
                $job->save();
                $application = JobApplication::where('status', 'delivered')->where('job_id', $jobId)->first();
                $application->status = 'disputed';
                $application->save();
                $userJob = UserJob::where('job_id', $jobId)->where('service_provider_id', $application->candidate_id)->where('customer_id', Auth::user()->id)->first();
                $userJob->status = 'disputed';
                $userJob->save();
                $data = array(
                    'job_id' => $jobId,
                    'reason' => $request->reason,
                );
                $success = JobDispute::create($data);
                $user = User::where('id', $userJob->service_provider_id)->first();
                $headers = array(
                    'Authorization: key=' . env('FIREBASE_API_KEY'),
                    'Content-Type: application/json'
                );
                $msg = array(
                    'title' => 'Job disputed',
                    'body' => "Job owner open dispute on your job submission.",
                );

                $fields = array(
                    'registration_ids' => $user->device_token,
                    'notification' => $msg,
                    'data' => "Job owner open dispute on your job submission."
                );
                try {
                    Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send',$fields);
                }catch (\Exception $e){

                }

                $mailData = array();
                $mailAddress = $user->email;
                try {
                    Mail::send('mail.dispute', $mailData, function ($message) use ($mailAddress) {
                        $message->to($mailAddress)->subject('Job disputed');
                        $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
                    });
                } catch (\Exception $e) {

                }
                $notification = array(
                    'user_id' => $user->id,
                    'description' => 'Job disputed',
                );
                Notification::create($notification);

                if ($success) {
                    return redirect()->back()->with('success', __('Dispute submitted!'));
                } else {
                    return redirect()->back()->with('error', __('An error occurred, Please try again!'));
                }
            }

        } else {
            return redirect()->back()->with('error', __('Not allowed!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Posted Jobs
    |--------------------------------------------------------------------------
    */
    public function postedJobs()
    {
        $user = Auth::user();
        $jobs = Job::where('user_id', $user->id)->where('status', 'opened')->get();
        return view('frontend.customer.posted-jobs', compact('jobs'));
    }

    /*
    |--------------------------------------------------------------------------
    | Hired Jobs
    |--------------------------------------------------------------------------
    */
    public function hiredJobs()
    {
        $user = Auth::user();
        $jobs = Job::where('user_id', $user->id)->where('status', 'hired')->get();
        return view('frontend.customer.hired-jobs', compact('jobs'));
    }

    /*
    |--------------------------------------------------------------------------
    | Delivered Jobs
    |--------------------------------------------------------------------------
    */
    public function deliveredJobs()
    {
        $user = Auth::user();
        $jobs = Job::where('user_id', $user->id)->where('status', 'delivered')->get();
        return view('frontend.customer.delivered-jobs', compact('jobs'));
    }

    /*
    |--------------------------------------------------------------------------
    | Completed Jobs
    |--------------------------------------------------------------------------
    */
    public function completedJobs()
    {
        $user = Auth::user();
        $jobs = Job::where('user_id', $user->id)->where('status', 'completed')->get();
        return view('frontend.customer.completed-jobs', compact('jobs'));
    }
}
