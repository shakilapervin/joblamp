<?php

namespace App\Http\Controllers\Api;

use App\Charge;
use App\City;
use App\Country;
use App\Job;
use App\JobApplication;
use App\JobCategory;
use App\Notification;
use App\Rating;
use App\Skill;
use App\Slider;
use App\State;
use App\User;
use App\UserChat;
use App\UserJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Image;

class ApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Registration
    |--------------------------------------------------------------------------
    */
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'mobile_number' => 'required|unique:users',
                'password' => 'required',
                'user_type' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'email' => 'required|unique:users',
            ]
        );
        if ($validator->fails()) {
            $status = false;
            $message = $validator->errors();
            return response()->json(compact('status', 'message'));
        }
        if ($request->user_type == 'service_provider') {
            $status = 3;
        } else {
            $status = 1;
        }
        $data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_number' => $request->mobile_number,
            'user_type' => $request->user_type,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'status' => $status,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'device_token' => $request->device_token,
        );
        $mailData = array(
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
        );
        $mailAddress = $request->email;
        try {
            Mail::send('mail.signup', $mailData, function ($message) use ($mailAddress) {
                $message->to($mailAddress)->subject('Welcome to Joblamp');
                $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
            });
        } catch (\Exception $e) {

        }
        $id = User::insertGetId($data);
        if ($id) {
            $status = true;
            $message = 'Successfully Registered';
            $data = DB::table('users')
                ->where('users.id', $id)
                ->first();
            return response()->json(compact('status', 'message', 'data'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | User Login
    |--------------------------------------------------------------------------
    */
    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required',
            'device_token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            DB::table('users')
                ->where('users.email', $request->email)
                ->update(['device_token' => $request->device_token]);
            $data = DB::table('users')
                ->where('users.email', $request->email)
                ->first();
            $status = true;
            return response()->json(compact('data', 'status'));
        } else {
            $status = false;
            $message = 'Login Credentials are not correct.';
            return response()->json(compact('status', 'message'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Country List
    |--------------------------------------------------------------------------
    */
    public function countryList()
    {
        $status = true;
        $data = Country::all();
        return response()->json(compact('status', 'data'));
    }

    /*
    |--------------------------------------------------------------------------
    | State List
    |--------------------------------------------------------------------------
    */
    public function stateList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $status = true;
        $data = State::where('country_id', $request->country_id)->get();
        return response()->json(compact('status', 'data'));
    }

    /*
    |--------------------------------------------------------------------------
    | City List
    |--------------------------------------------------------------------------
    */
    public function cityList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'state_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $status = true;
        $data = City::where('country_id', $request->country_id)->where('state_id', $request->state_id)->get();
        return response()->json(compact('status', 'data'));
    }

    /*
    |--------------------------------------------------------------------------
    | City List
    |--------------------------------------------------------------------------
    */
    public function categoryList()
    {
        $status = true;
        $categories = JobCategory::where('status', 1)->get();
        $data = array();
        foreach ($categories as $category) {
            $jobCount = DB::table('jobs')
                ->where('category', $category->id)
                ->where('status', 'opened')
                ->count();
            $data[] = array(
                'category_id' => $category->id,
                'name' => $category->name,
                'total_job' => $jobCount,
            );
        }
        return response()->json(compact('status', 'data'));
    }

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    public function profile(Request $request)
    {
        $status = true;
        $user = DB::table('users')
            ->select('users.*')
            ->where('users.id', $request->user_id)
            ->first();
        $skills = array();
        $userSkills = json_decode($user->skill);
        if (!empty($userSkills)) {
            foreach ($userSkills as $skill) {
                $skills[] = Skill::where('id', $skill)->first()->name;
            }
        }
        $data = array(
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'mobile_number' => $user->mobile_number,
            'address_line_1' => $user->address_line_1,
            'address_line_2' => $user->address_line_2,
            'city' => City::where('id', $user->city)->first()->name,
            'state' => State::where('id', $user->state)->first()->name,
            'country' => Country::where('id', $user->country)->first()->name,
            'rating' => calculateRating(Rating::where('user_id', $request->user_id)->get()),
            'skills' => $skills,
        );
        return response()->json(compact('status', 'data'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */
    public function editProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'pincode' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'mobile_number' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::where('id', $request->user_id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->pincode = $request->pincode;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->skill = $request->skill;
        $user->address_line_1 = $request->address_line_1;
        $user->address_line_2 = $request->address_line_2;
        $user->mobile_number = $request->mobile_number;
        if ($request->hasFile('profile_pic')) {
            $photo = $request->file('profile_pic');
            $photoName = uniqid() . '.' . $photo->extension();
            $dPath = storage_path('app/profile/');
            $img = Image::make($photo->path());
            $img->resize(470, 570, function ($constraint) {
                $constraint->aspectRatio();
            })->save($dPath . $photoName);
            $user->profile_pic = $photoName;
        }
        $success = $user->save();
        if ($success) {
            $status = true;
            $message = 'Successfully Updated';
            $data = DB::table('users')
                ->select('users.*', 'countries.name as country_name', DB::raw('sum(ratings.rating) / count(*) as userRating'), DB::raw('(sum(ratings.rating) / count(*)) + count(*) as score'))
                ->join('countries', 'countries.id', '=', 'users.country')
                ->join('ratings', 'ratings.user_id', '=', 'users.id')
                ->where('user_id', $request->user_id)
                ->groupBy('ratings.user_id')
                ->orderBy('score', 'desc')
                ->first();
            return response()->json(compact('status', 'data', 'message'));
        } else {
            $status = false;
            $message = 'Something went wrong.';
            return response()->json(compact('status', 'message'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Update Docs
    |--------------------------------------------------------------------------
    */
    public function updateDocs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'doc_1' => 'mimes:jpg,jpeg,png,bmp,tiff,pdf',
            'doc_2' => 'mimes:jpg,jpeg,png,bmp,tiff,pdf',
            'doc_3' => 'mimes:jpg,jpeg,png,bmp,tiff,pdf',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::where('id', $request->user_id)->first();
        if ($request->hasFile('doc_1')) {
            $user->doc_1 = $path = $request->file('doc_1')->store('documents');
        }
        if ($request->hasFile('doc_2')) {
            $user->doc_2 = $path = $request->file('doc_2')->store('documents');
        }
        if ($request->hasFile('doc_3')) {
            $user->doc_3 = $path = $request->file('doc_3')->store('documents');
        }
        $success = $user->save();
        if ($success) {
            $status = true;
            $message = 'Successfully Updated';
            $data = DB::table('users')
                ->select('users.doc_1', 'users.doc_2', 'users.doc_3')
                ->where('id', $request->user_id)
                ->first();
            return response()->json(compact('status', 'data', 'message'));
        } else {
            $status = false;
            $message = 'Something went wrong.';
            return response()->json(compact('status', 'message'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Job Applications
    |--------------------------------------------------------------------------
    */
    public function jobApplications(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $status = true;
        $candidates = DB::table('job_applications')
            ->select('job_applications.cover_letter',
                'job_applications.bid_amount',
                'job_applications.created_at',
                'users.first_name',
                'users.last_name',
                'users.id',
                'users.profile_pic',
                'countries.name as country_name'
            )
            ->join('users', 'users.id', '=', 'job_applications.candidate_id')
            ->join('countries', 'countries.id', '=', 'users.country')
            ->where('job_applications.job_id', $request->job_id)
            ->where('job_applications.status', 'applied')
            ->get();
        $data = array();
        foreach ($candidates as $row) {
            $data[] = array(
                'id' => $row->id,
                'first_name' => $row->first_name,
                'profile_pic' => $row->profile_pic,
                'last_name' => $row->last_name,
                'rating' => calculateRating(Rating::where('user_id', $row->id)->get()),
                'country' => $row->country_name,
                'cover_letter' => $row->cover_letter,
                'bid_amount' => $row->bid_amount,
                'created_date' => date('Y-m-d',strtotime($row->created_at)),
            );
        }
        return response()->json(compact('data', 'status'));
    }

    /*
    |--------------------------------------------------------------------------
    | Review List
    |--------------------------------------------------------------------------
    */
    public function reviewList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $status = true;
        $data = DB::table('ratings')
            ->select('ratings.feedback', 'ratings.rating', 'users.first_name', 'users.last_name')
            ->join('jobs', 'jobs.id', '=', 'ratings.job_id')
            ->join('users', 'users.id', '=', 'jobs.user_id')
            ->where('ratings.user_id', $request->user_id)
            ->get();
        return response()->json(compact('data', 'status'));
    }

    /*
    |--------------------------------------------------------------------------
    | Review List
    |--------------------------------------------------------------------------
    */
    public function jobDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $status = true;
        $has_applied = false;
        $applied = JobApplication::where('job_id',$request->job_id)->where('candidate_id',$request->user_id)->first();
        if (!empty($applied)){
            $has_applied = true;
        }
        $data = Job::with(array('categoryInfo','creatorDetails','jobCountry'))->where('id', $request->job_id)->first();
        return response()->json(compact('data', 'status','has_applied'));
    }

    /*
    |--------------------------------------------------------------------------
    | Post Job
    |--------------------------------------------------------------------------
    */
    public function postJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'category' => 'required',
            'fee_range_min' => 'required',
            'fee_range_max' => 'required',
            'service_provider_rating' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $data = array(
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'category' => $request->category,
            'fee_range_max' => $request->fee_range_max,
            'fee_range_min' => $request->fee_range_min,
            'service_provider_rating' => $request->service_provider_rating,
            'address' => $request->address,
            'city' => $request->city,
            'time' => date("H:i a"),
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pincode,
        );

        $success = Job::create($data);

        if ($success) {
            $status = true;
            $message = 'Successfully Saved';
            return response()->json(compact('data', 'status', 'message'));
        } else {
            $status = false;
            $message = 'Error';
            return response()->json(compact('data', 'status', 'message'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Forgot Password
    |--------------------------------------------------------------------------
    */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $email = $request->email;
        $password = rand(111111, 999999);
        $udata = DB::table('users')->where('email', $email)->first();
        if (!empty($udata)) {
            $pre_token = DB::table('password_resets')->where('email', $email)->first();
            if (!empty($pre_token)) {
                DB::table('password_resets')->where('email', $email)->delete();
            }
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $password
            ]);
            $status = true;
            $message = "Reset code sent!";
            $address = $email;
            $data = array(
                'password' => $password,
                'user_id' => $udata->id,
                'email' => $udata->email,
            );
            Mail::send('mail.forget-password', $data, function ($message) use ($address) {
                $message->to($address)->subject
                ('Password reset code');
                $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
            });
            return response()->json(compact('status', 'data', 'message'));
        } else {
            $status = false;
            $message = "Email is incorrect!";
            return response()->json(compact('status', 'message'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Check Password Reset Code
    |--------------------------------------------------------------------------
    */
    public function checkResetCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reset_code' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $code = $request->reset_code;
        $email = $request->email;
        $check = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $code)
            ->first();
        //if(!$check->isEmpty()){
        if (!empty($check)) {
            $status = true;
            $message = "Password changed!";
            return response()->json(compact('status', 'message'));
        } else {
            $status = false;
            $message = "Wrong code";
            return response()->json(compact('status', 'message'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Change Password by reset code
    |--------------------------------------------------------------------------
    */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $id = $request->user_id;
        $password = $request->password;
        $data2 = array(
            'password' => Hash::make($password)
        );
        DB::table('users')
            ->where('id', $id)
            ->update($data2);
        $status = true;
        $message = "Password changed!";
        return response()->json(compact('status', 'message'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Password
    |--------------------------------------------------------------------------
    */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = DB::table('users')
            ->where('users.email', $request->user_id)
            ->first();
        $credentials = array(
            'email' => $user->email,
            'password' => $request->old_password,
        );
        if (Auth::attempt($credentials)) {
            $status = true;
            $message = 'Password changed successfully.';
            $password = array(
                'password' => Hash::make($request->new_password)
            );
            DB::table('users')
                ->where('id', $request->user_id)
                ->update($password);
            return response()->json(compact('message', 'status'));
        } else {
            $status = false;
            $message = 'Old password is incorrect.';
            return response()->json(compact('status', 'message'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Customer Job list
    |--------------------------------------------------------------------------
    */
    public function customerJobList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $data = Job::with(array('categoryInfo'))->where('user_id', $request->user_id)->where('status', $request->status)->get();
        $status = true;
        return response()->json(compact('status', 'data'));
    }

    /*
    |--------------------------------------------------------------------------
    | Worker Job list
    |--------------------------------------------------------------------------
    */
    public function workerJobList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $data = JobApplication::where('job_applications.candidate_id', $request->user_id)
            ->select('jobs.*','users.first_name as creator_first_name','users.last_name as creator_last_name','users.profile_pic as picture','users.id as creator_id')
            ->join('jobs', 'jobs.id', 'job_applications.job_id')
            ->join('users', 'users.id', 'jobs.user_id')
            ->where('job_applications.status', $request->status)
            ->get();
        $status = true;
        return response()->json(compact('status', 'data'));
    }

    /*
    |--------------------------------------------------------------------------
    | Apply Job
    |--------------------------------------------------------------------------
    */
    public function applyJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cover_letter' => 'required',
            'bid_amount' => 'required',
            'applicant_id' => 'required',
            'job_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::where('id', $request->applicant_id)->first();
        $data = array(
            'job_id' => $request->job_id,
            'candidate_id' => $request->applicant_id,
            'cover_letter' => $request->cover_letter,
            'bid_amount' => $request->bid_amount,
        );
        $job = Job::with('creatorDetails')->where('id', $request->job_id)->first();
        if ($user->remain_job > 0 && $user->reamin_job != 'unlimited') {
            $user->decrement('remain_job', 1);
            JobApplication::create($data);
            $status = true;
            $message = 'Successfully Applied!';
            $mailData = array();
            $mailAddress = $job->creatorDetails->email;
            try {
                Mail::send('mail.application-submitted', $mailData, function ($message) use ($mailAddress) {
                    $message->to($mailAddress)->subject('A new candidate applied on your job');
                    $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
                });
            } catch (\Exception $e) {

            }
            $notification = array(
                'user_id' => $job->creatorDetails->id,
                'description' => 'A new candidate applied on your job',
            );
            Notification::create($notification);
            $headers = array(
                'Authorization: key=' . env('FIREBASE_API_KEY'),
                'Content-Type: application/json'
            );
            $msg = array(
                'title' => 'A new candidate applied on your job',
                'body' => "A new candidate applied on your job",
            );

            $fields = array(
                'registration_ids' => $job->creatorDetails->device_token,
                'notification' => $msg,
                'data' => "A new candidate applied on your job"
            );
            try {
                Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send', $fields);
            } catch (\Exception $e) {

            }
            return response()->json(compact('status', 'message'));
        } elseif ($user->reamin_job == 'unlimited') {
            JobApplication::create($data);
            $status = true;
            $message = 'Successfully Applied!';
            $mailData = array();
            $mailAddress = $job->creatorDetails->email;
            try {
                Mail::send('mail.application-submitted', $mailData, function ($message) use ($mailAddress) {
                    $message->to($mailAddress)->subject('A new candidate applied on your job');
                    $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
                });
            } catch (\Exception $e) {

            }
            $notification = array(
                'user_id' => $job->creatorDetails->id,
                'description' => 'A new candidate applied on your job',
            );
            Notification::create($notification);
            $headers = array(
                'Authorization: key=' . env('FIREBASE_API_KEY'),
                'Content-Type: application/json'
            );
            $msg = array(
                'title' => 'A new candidate applied on your job',
                'body' => "A new candidate applied on your job",
            );

            $fields = array(
                'registration_ids' => $job->creatorDetails->device_token,
                'notification' => $msg,
                'data' => "A new candidate applied on your job"
            );
            try {
                Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send', $fields);
            } catch (\Exception $e) {

            }
            return response()->json(compact('status', 'message'));
        } else {
            $status = false;
            $message = 'Your job application limit exceed! please subscribe our subscription plan';
            return response()->json(compact('status', 'message'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Submit Job
    |--------------------------------------------------------------------------
    */
    public function submitJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'job_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $userJob = UserJob::where('job_id', $request->job_id)->where('service_provider_id', $request->user_id)->first();
        $userJob->status = 'delivered';
        $userJob->save();
        $job = Job::with('creatorDetails')->where('id', $request->job_id)->first();
        $job->status = 'delivered';
        $job->save();
        $application = JobApplication::where('job_id', $request->job_id)->where('candidate_id', $request->user_id)->first();
        $application->status = 'delivered';
        $application->save();
        $status = true;
        $message = 'Successfully submitted!';
        $mailData = array();
        $mailAddress = $job->creatorDetails->email;
        try {
            Mail::send('mail.application-submitted', $mailData, function ($message) use ($mailAddress) {
                $message->to($mailAddress)->subject('Job Submitted');
                $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
            });
        } catch (\Exception $e) {

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
        $notification = array(
            'user_id' => $job->creatorDetails->id,
            'description' => 'Service provider submitted job',
        );
        Notification::create($notification);
        try {
            Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send', $fields);
        } catch (\Exception $e) {

        }
        return response()->json(compact('status', 'message'));
    }

    /*
    |--------------------------------------------------------------------------
    | Rate User
    |--------------------------------------------------------------------------
    */
    public function rateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'job_id' => 'required',
            'applicant_id' => 'required',
            'rating' => 'required',
            'notes' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $data = array(
            'job_id' => $request->job_id,
            'rating' => $request->rating,
            'feedback' => $request->notes,
            'user_id' => $request->applicant_id,
        );
        Rating::create($data);
        $status = true;
        $message = 'Successfully rated!';
        $user = User::where('id', $request->applicant_id)->first();

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
            Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send', $fields);
        } catch (\Exception $e) {

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
        return response()->json(compact('status', 'message'));
    }

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_text' => 'required|min:2',
            'search_by' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $keyword = $request->search_text;
        $by = $request->search_by;
        if ($by == 'job') {
            $data = Job::with('creatorDetails')->where('status', 'opened')->orderBy('id', 'desc')->where('title', 'like', '%' . $keyword . '%')->get();
            return response()->json(compact('data'));
        } else {
            $data = array();
            $users = User::where('first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $keyword . '%')
                    ->orderBy('promotion_expire','desc')
                    ->get();
            if (!empty($users)) {
                foreach ($users as $user) {
                    $skills = array();
                    $userSkills = json_decode($user->skill);
                    if (!empty($userSkills)) {
                        foreach ($userSkills as $skill) {
                            $skills[] = Skill::where('id', $skill)->first()->name;
                        }
                    }
                    $data[] = array(
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'picture' => $user->profile_pic,
                        'email' => $user->email,
                        'mobile_number' => $user->mobile_number,
                        'address_line_1' => $user->address_line_1,
                        'address_line_2' => $user->address_line_2,
                        'city' => City::where('id', $user->city)->first()->name,
                        'state' => State::where('id', $user->state)->first()->name,
                        'country' => Country::where('id', $user->country)->first()->name,
                        'rating' => calculateRating(Rating::where('user_id', $request->user_id)->get()),
                        'skills' => $skills,
                    );
                }
                return response()->json(compact('data'));
            } else {
                $status = false;
                $message = 'No user found';
                return response()->json(compact('status', 'message'));
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Filter Job
    |--------------------------------------------------------------------------
    */
    public function filterJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'min_price' => 'required',
            'max_price' => 'required',
            'location' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $category = $request->category_id;
        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;
        $location = $request->location;
        $query = Job::with('creatorDetails')->where('status', 'opened')->orderBy('id', 'desc');
        if (!empty($location)) {
            $city = City::where('name', $location)->first();
            $query = $query->where('city', $city->id);
        }
        if (!empty($category)) {
            $query = $query->where('category', $category);
        }
        if (!empty($minPrice)) {
            $query = $query->where('fee_range_min','>=', $minPrice);
        }
        if (!empty($maxPrice)) {
            $query = $query->where('fee_range_max','>=', $maxPrice);
        }
        $data = $query->get();
        return response()->json(compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | Banner List
    |--------------------------------------------------------------------------
    */
    public function bannerList()
    {
        $banners = Slider::where('status','active')->get();
        $data = array();
        if (!empty($banners)){
            foreach ($banners as $banner){
                $data[] = array(
                    'title' => $banner->title,
                    'image' => asset('public/'.$banner->image),
                );
            }
            return response()->json(compact('data'));
        }else{
            $status = false;
            $message = 'No banners';
            return response()->json(compact('status','message'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Notification List
    |--------------------------------------------------------------------------
    */
    public function notificationList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $data = Notification::where('user_id',$request->user_id)->get();
        return response()->json(compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | Job Count
    |--------------------------------------------------------------------------
    */
    public function jobCount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $userType = User::where('id',$request->id)->first()->user_type;
        if ($userType == 'service_provider'){
            $completeJob = UserJob::where('service_provider_id', $request->user_id)
                ->where('status', 'completed')
                ->count();
            $currentJob = UserJob::where('service_provider_id', $request->user_id)
                ->where('status', 'opened')
                ->count();
            $appliedJob = JobApplication::where('candidate_id', $request->user_id)
                ->where('status', 'applied')
                ->count();
            $data = array(
                'completed' => $completeJob,
                'current' => $currentJob,
                'applied' => $appliedJob,
            );
        }else{
            $completeJob = Job::where('user_id', $request->user_id)
                ->where('status', 'completed')
                ->count();
            $currentJob = Job::where('user_id', $request->user_id)
                ->where('status', 'hired')
                ->count();
            $postedJob = UserJob::where('user_id', $request->user_id)
                ->where('status', 'opened')
                ->count();
            $data = array(
                'completed' => $completeJob,
                'current' => $currentJob,
                'posted' => $postedJob,
            );
        }
        return response()->json(compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | Top Rated Workers
    |--------------------------------------------------------------------------
    */
    public function topRatedWorkers()
    {
        $data = DB::table('users')
            ->select('users.id','users.first_name','users.last_name','users.profile_pic','countries.name as country_name',DB::raw('sum(ratings.rating) / count(*) as userRating'),DB::raw('(sum(ratings.rating) / count(*)) + count(*) as score'))
            ->join('countries','countries.id','=','users.country')
            ->join('ratings','ratings.user_id','=','users.id')
            ->where('user_type','service_provider')
            ->groupBy('ratings.user_id')
            ->orderBy('score','desc')
            ->limit(20)
            ->get();
        return response()->json(compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | All Job list
    |--------------------------------------------------------------------------
    */
    public function allJobList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $data = Job::with('creatorDetails')->where('status', $request->status)->get();
        $status = true;
        return response()->json(compact('status', 'data'));
    }

    /*
    |--------------------------------------------------------------------------
    | Chat list
    |--------------------------------------------------------------------------
    */
    public function chatList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $data = UserChat::with('receiver')->where('sender_id', $request->user_id)->orderBy('created_at', 'desc')->get();
        $status = true;
        return response()->json(compact('status', 'data'));
    }

    /*
    |--------------------------------------------------------------------------
    | Upload Chat File
    |--------------------------------------------------------------------------
    */
    public function saveChatFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpg,jpeg,png,bmp,tiff,pdf,zip,doc,docx,txt,svg,gif',
        ]);
        if ($validator->fails()) {
            $status = false;
            $error = 'Sorry This file is not allowed';
            return response()->json(compact('error','status'));
        }else{
            if ($request->hasFile('file')){
                $status = true;
                $file_name = $request->file('file')->store('message');
                return response()->json(compact('file_name','status'));
            }
        }
    }
}
