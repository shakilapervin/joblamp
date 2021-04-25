<?php

namespace App\Http\Controllers\Website;

use App\City;
use App\ContactSupport;
use App\Country;
use App\Http\Controllers\Controller;
use App\Job;
use App\JobApplication;
use App\JobCategory;
use App\Notification;
use App\Rating;
use App\Skill;
use App\Slider;
use App\State;
use App\SubscriptionPlan;
use App\User;
use App\UserJob;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\View\View;
use Mail;
class FrontendController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Change Language
    |--------------------------------------------------------------------------
    */
    public function changeLang(Request $request){
        $lang = $request->lang;
        \session()->forget('lang');
        \session()->put('lang',$lang);
        return redirect()->back();
    }
    /*
    |--------------------------------------------------------------------------
    | HomePage
    |--------------------------------------------------------------------------
    */
    public function index(){
        $banners = Slider::where('status','active')->get();
        $jobs = Job::where('status','opened')->limit(10)->get();
        $subscriptionPlans = SubscriptionPlan::with('features')->where('status','active')->get();
        $jobcategories = DB::table('job_categories')
            ->select('job_categories.*', DB::raw('count(*) as totalJob'))
            ->join('jobs','jobs.category','=','job_categories.id')
            ->where('job_categories.status',1)
            ->where('jobs.status','opened')
            ->groupBy('jobs.category')
            ->orderBy('totalJob','desc')
            ->get();
        $popularWorkers = DB::table('users')
            ->select('users.id','users.first_name','users.last_name','users.profile_pic','countries.name as country_name',DB::raw('sum(ratings.rating) / count(*) as userRating'),DB::raw('(sum(ratings.rating) / count(*)) + count(*) as score'))
            ->join('countries','countries.id','=','users.country')
            ->join('ratings','ratings.user_id','=','users.id')
            ->where('user_type','service_provider')
            ->groupBy('ratings.user_id')
            ->orderBy('score','desc')
            ->limit(20)
            ->get();
        return view('frontend.home.index',compact('jobs','jobcategories','popularWorkers','subscriptionPlans','banners'));
    }

    /*
    |--------------------------------------------------------------------------
    | Registration Form
    |--------------------------------------------------------------------------
    */
    public function registrationForm(){
        $countries = Country::where('status',1)->get();
        $states = State::where('status',1)->get();
        $cities = City::where('status',1)->get();
        return view('frontend.auth.register',compact('countries','states','cities'));
    }

    /*
    |--------------------------------------------------------------------------
    | Save Registration Data
    |--------------------------------------------------------------------------
    */
    public function registerUser(Request $request){

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required|unique:users',
            'password' => 'required',
            'user_type' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'email' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->user_type == 'service_provider'){
            $status = 3;
        }else{
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
        );

        $success = User::create($data);
        $data = array(
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
        );
        $mailAddress = $request->email;
        try{
            Mail::send('mail.signup', $data, function ($message) use ($mailAddress) {
                $message->to($mailAddress)->subject('Welcome to Joblamp');
                $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
            });
        }catch(\Exception $e){

        }
        if ($success){
            return redirect('user-login')->with('success',__('Successfully Registered!'));
        }else{
            return redirect()->back()->with('error',__('An error occurred, Please try again!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Login Form
    |--------------------------------------------------------------------------
    */
    public function loginForm(){
        if (Auth::user()) {
            return redirect('/dashboard');
        }else{
            return view('frontend.auth.login');
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Check Login Credential
    |--------------------------------------------------------------------------
    */
    public function checkLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('dashboard');
        } else {
            return redirect()->back()->with('error', __('Email and password did\'t match!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Check Login Credential From Checkout
    |--------------------------------------------------------------------------
    */
    public function checkLoginSubscription(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->back();
        } else {
            return redirect()->back()->with('error', __('Email and password did\'t match!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    public function userLogout(Request $request){
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Logout
    |--------------------------------------------------------------------------
    */
    public function adminLogout(Request $request){
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/admin/login');
    }
    protected function guard()
    {
        return Auth::guard();
    }

    /*
    |--------------------------------------------------------------------------
    | User Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard(){
        $user = Auth::user();
        $notifications = Notification::where('user_id',$user->id)->get();
        if ($user->user_type == 'customer'){
            $notHiredJobs = Job::where('user_id',$user->id)->where('status','opened')->get();
            $hiredJobs = Job::where('user_id',$user->id)->where('status','hired')->get();
            $deliveredJobs = Job::where('user_id',$user->id)->where('status','delivered')->get();
            $completedJobs = Job::where('user_id',$user->id)->where('status','completed')->get();
            $ratings = Rating::where('user_id',$user->id)->count();
            $totalJob = Job::where('user_id',$user->id)->count();
            return view('frontend.dashboard.customer-dashboard',compact('user','notHiredJobs','hiredJobs','deliveredJobs','completedJobs','ratings','totalJob','notifications'));
        }else{
            $jobs = Job::where('status','opened')->orderBy('id','desc')->limit(4)->get();
            $jobsApplied = JobApplication::where('candidate_id',$user->id)->where('status','applied')->get();
            $activeJobs = UserJob::with('jobDetails')->where('service_provider_id',$user->id)->where('status','opened')->get();
            $deliveredJobs = UserJob::with('jobDetails')->where('service_provider_id',$user->id)->where('status','delivered')->get();
            $completedJobs = UserJob::with('jobDetails')->where('service_provider_id',$user->id)->where('status','completed')->get();
            $ratings = Rating::where('user_id',$user->id)->count();
            return  view('frontend.dashboard.service-provider-dashboard',compact('user','jobsApplied','activeJobs','deliveredJobs','completedJobs','jobs','ratings','notifications'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | User Profile
    |--------------------------------------------------------------------------
    */

    public function myProfile(){
        $id = Auth::id();
        $user = User::where('id',$id)->first();
        return  view('frontend.profile.profile',compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | User Public Profile
    |--------------------------------------------------------------------------
    */

    public function publicProfile($id){
        try {
            $id = decrypt($id);
        } catch(\RuntimeException $e) {
            return redirect('');
        }
        $user = DB::table('users')
            ->select('users.id','users.first_name','users.last_name','users.profile_pic','users.skill','countries.name as country_name',DB::raw('sum(ratings.rating) / count(*) as userRating'),DB::raw('(sum(ratings.rating) / count(*)) + count(*) as score'))
            ->join('countries','countries.id','=','users.country')
            ->join('ratings','ratings.user_id','=','users.id')
            ->where('users.id',$id)
            ->groupBy('ratings.user_id')
            ->orderBy('score','desc')
            ->first();
        $jobDone = UserJob::where('service_provider_id',$id)->count();
        $userFeedbacks = DB::table('ratings')
            ->select('ratings.created_at','jobs.user_id','users.first_name','users.last_name','ratings.rating','ratings.feedback')
            ->join('jobs','jobs.id','=','ratings.job_id')
            ->join('users','users.id','=','jobs.user_id')
            ->where('ratings.user_id',$id)
            ->get();
        return  view('frontend.profile.public',compact('user','userFeedbacks','jobDone'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Profile From
    |--------------------------------------------------------------------------
    */

    public function editprofileForm(){
        $user = Auth::user();
        $countries = Country::where('status', 1)->get();
        $states = State::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $skills = Skill::where('status', 'active')->get();
        return  view('frontend.profile.edit-profile',compact('user', 'countries','states','cities','skills'));
    }

    /*
    |--------------------------------------------------------------------------
    | Job Post Form
    |--------------------------------------------------------------------------
    */

    public function jobPostForm(){
        if (Auth::user()->user_type == 'customer'){
            $jobCategories = JobCategory::where('status',1)->get();
            $countries = Country::where('status',1)->get();
            $states = State::where('status',1)->get();
            $cities = City::where('status',1)->get();
            return  view('frontend.job.create',compact('jobCategories','countries','states','cities'));
        }else{
            return redirect('/');
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Save Job Data
    |--------------------------------------------------------------------------
    */
    public function saveJob(Request $request){

        if (Auth::user()->user_type == 'customer'){
            $validator = Validator::make($request->all(), [
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
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = array(
                'user_id' => Auth::user()->id,
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

            if ($success){
                return redirect('post-job')->with('success',__('Successfully Posted!'));
            }else{
                return redirect()->back()->with('error',__('An error occurred, Please try again!'));
            }
        }else{
            return redirect('')->home();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Job List
    |--------------------------------------------------------------------------
    */

    public function jobList(Request $request){
        $noJob = false;
        $location = $request->location;
        $keyword = $request->keyword;
        $category_id = $request->category_id;
        $query = Job::with('creatorDetails')->where('status','opened')->orderBy('id','desc');

        if (!empty($location)){
            $city = City::where('name',$location)->first();
            if (!empty($city)){
                $query = $query->where('city',$city->id);
            }else{
                $noJob = true;
            }
        }

        if (!empty($keyword)){
            $job = $query->where('title','like','%'.$keyword.'%')->get();
            if (!empty($job)){
                $query = $query->where('title','like','%'.$keyword.'%');
            }else{
                $noJob = true;
            }
        }

        if (!empty($category_id)){
            $cat = $query->where('category',$category_id)->get();
            if (!empty($cat)){
                $query = $query->where('category',$category_id);
            }else{
                $noJob = true;
            }
        }

        $jobs = $query->get();

        $jobCategories = JobCategory::where('status',1)->get();
        return  view('frontend.job.list',compact('jobs','jobCategories','noJob','location','keyword','category_id'));

    }

    /*
    |--------------------------------------------------------------------------
    | Get State List By Country
    |--------------------------------------------------------------------------
    */

    public function getStates(Request $request){
        $states = State::where('country_id', $request->country)->get();
        $user = Auth::user();
        $for = $request->for;
        return  view('frontend.partials.states',compact('user','states','for'));
    }

    /*
    |--------------------------------------------------------------------------
    | Get City List By Country and State
    |--------------------------------------------------------------------------
    */

    public function getCities(Request $request){
        $cities = City::where('country_id', $request->country)->where('state_id', $request->state)->get();
        $user = Auth::user();
        $for = $request->for;
        return  view('frontend.partials.cities',compact('user','cities','for'));
    }

    /*
    |--------------------------------------------------------------------------
    | Get State List By Country for admin
    |--------------------------------------------------------------------------
    */

    public function adminGetStates(Request $request){
        $states = State::where('country_id', $request->country)->get();
        return  view('admin.partials.states',compact('states'));
    }

    /*
    |--------------------------------------------------------------------------
    | Get City List By Country and State for admin
    |--------------------------------------------------------------------------
    */

    public function adminGetCities(Request $request){
        $cities = City::where('country_id', $request->country)->where('state_id', $request->state)->get();
        return  view('admin.partials.cities',compact('cities'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address_line_1' => 'required',
            'mobile_number' => 'required',
            'doc_1' => 'mimes:jpg,jpeg,png,bmp,tiff,pdf',
            'doc_2' => 'mimes:jpg,jpeg,png,bmp,tiff,pdf',
            'doc_3' => 'mimes:jpg,jpeg,png,bmp,tiff,pdf',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = User::where('id',$request->id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->pincode = $request->pincode;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->address_line_1 = $request->address_line_1;
        $user->address_line_2 = $request->address_line_2;
        $user->mobile_number = $request->mobile_number;
        if ($request->hasFile('profile_pic')){
            $photo = $request->file('profile_pic');
            $photoName = uniqid().'.'.$photo->extension();
            $dPath = storage_path('app/profile/');
            $img = Image::make($photo->path());
            $img->resize(470,570,function ($constraint){
                $constraint->aspectRatio();
            })->save($dPath.$photoName);
            $user->profile_pic = $photoName;
        }
        if ($request->hasFile('doc_1')){
            $user->doc_1 = $request->file('doc_1')->store('documents');
        }
        if ($request->hasFile('doc_2')){
            $user->doc_2 = $request->file('doc_2')->store('documents');
        }
        if ($request->hasFile('doc_3')){
            $user->doc_3 = $request->file('doc_3')->store('documents');
        }
        $skills = array();
        if ($request->has('skills') && count($request->skills) > 0) {
            foreach ($request->skills as $key => $no) {
                array_push($skills, $no);
            }
            $user->skill = $skills;
        }
        $user->save();
        return redirect('/edit-profile')->with('success',__('Profile Updated'));
    }

    /*
    |--------------------------------------------------------------------------
    | Job Details
    |--------------------------------------------------------------------------
    */
    public function jobDetails($id){
        try {
            $id = decrypt($id);
        } catch(\RuntimeException $e) {
            return redirect('');
        }
        $job = Job::where('id',$id)->first();
        if ($job){
            $similarJobs = Job::where('category',$job->category)->whereNotIn('id',array($id))->where('status','opened')->limit(2)->get();
            return view('frontend.job.single',compact('job','similarJobs'));
        }else{
            return redirect('');
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Apply Job
    |--------------------------------------------------------------------------
    */
    public function applyJob(Request $request){
        $id = Auth::id();
        $user = User::where('id',$id)->first();
        if ($user->user_type == 'service_provider'){
            $validator = Validator::make($request->all(), [
                'cover_letter' => 'required',
                'bid_amount' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $data = array(
                'job_id' => decrypt($request->id),
                'candidate_id' => decrypt($request->candidate_id),
                'cover_letter' => $request->cover_letter,
                'bid_amount' => $request->bid_amount,
            );
            $job = Job::with('creatorDetails')->where('id',decrypt($request->id))->first();
            if ($user->remain_job > 0 && $user->reamin_job != 'unlimited') {
                $user->decrement('remain_job',1);
                $status = JobApplication::create($data);

                if ($status){
                    $mailData = array();

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
                        Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send',$fields);
                    }catch (\Exception $e){

                    }
                    $mailAddress = $job->creatorDetails->email;
                    try{
                        Mail::send('mail.application-submitted', $mailData, function ($message) use ($mailAddress) {
                            $message->to($mailAddress)->subject('A new candidate applied on your job');
                            $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
                        });
                    }catch(\Exception $e){

                    }
                    $notification = array(
                        'user_id' => $job->creatorDetails->id,
                        'description' => 'A new candidate applied on your job',
                    );
                    Notification::create($notification);
                    return redirect()->back()->with('success',__('Successfully Applied!'));
                }else{
                    return redirect()->back()->with('error',__('Error try again!'));
                }
            }elseif ($user->reamin_job == 'unlimited'){
                $status = JobApplication::create($data);
                if ($status){
                    $data = array();

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
                        Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send',$fields);
                    }catch (\Exception $e){

                    }
                    $mailAddress = $job->creatorDetails->email;
                    try{
                        Mail::send('mail.application-submitted', $data, function ($message) use ($mailAddress) {
                            $message->to($mailAddress)->subject('A new candidate applied on your job');
                            $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
                        });
                    }catch(\Exception $e){

                    }
                    $notification = array(
                        'user_id' => $job->creatorDetails->id,
                        'description' => 'A new candidate applied on your job',
                    );
                    Notification::create($notification);
                    return redirect()->back()->with('success',__('Successfully Applied!'));
                }else{
                    return redirect()->back()->with('error',__('Error try again!'));
                }
            }else{
                Session::put('jobData',$data);
                return redirect('job-apply/checkout');
            }
        }else{
            return redirect('');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Subscription Checkout Page
    |--------------------------------------------------------------------------
    */
    public function subscriptionCheckout($id)
    {
        try {
            $id = decrypt($id);
        } catch (\RuntimeException $e) {
            return redirect('');
        }
        $plan = SubscriptionPlan::where('id', $id)->first();
        return view('frontend.checkout.checkout-subscription', compact('plan'));
    }

    /*
    |--------------------------------------------------------------------------
    | Free Subscription Confirm
    |--------------------------------------------------------------------------
    */
    public function subscriptionConfirm($id){
        try {
            $id = decrypt($id);
        } catch (\RuntimeException $e) {
            return redirect('');
        }
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        $date = Carbon::now();
        $expiryDate = $date->addDay(30);
        $user->plan_id = $id;
        $user->plan_expiry_date = $expiryDate;
        $user->remain_job = 0;
        $user->save();
        return redirect('dashboard')->with('success', __('Successfully Subscribed'));
    }
    /*
    |--------------------------------------------------------------------------
    | Free Subscription Confirm
    |--------------------------------------------------------------------------
    */
    public function jobApplyCheckout(){
        $data = Session::get('jobData');
        if (!empty($data)) {
            return view('frontend.checkout.checkout-job-application');
        }else{
            return redirect('dashboard');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Remove Doc
    |--------------------------------------------------------------------------
    */
    public function removeDoc(Request $request){
        $user = User::where('id',$request->user_id)->first();
        $doc = $request->doc;
        if ($doc == 1){
            $user->doc_1 ='';
            $user->save();
        }elseif ($doc == 2){
            $user->doc_2 ='';
            $user->save();
        }else{
            $user->doc_3 ='';
            $user->save();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Task Worker List
    |--------------------------------------------------------------------------
    */

    public function taskWorkerList(Request $request){
        $query = User::with('userRating')
            ->select('users.*','countries.name as country_name')
            ->join('countries','countries.id','=','users.country')
            ->where('users.user_type','service_provider');
        if (!empty($request->keyword)){
            $query->where('first_name','like','%'.$request->keyword.'%');
            $query->orWhere('last_name','like','%'.$request->keyword.'%');
        }
        $workers = $query->orderBy('promotion_expire','desc')
            ->paginate(27);
        return view('frontend.freelancer.list',compact('workers'));
    }

    /*
    |--------------------------------------------------------------------------
    | Contact Page
    |--------------------------------------------------------------------------
    */

    public function contactPage(){
        return view('frontend.pages.contact');
    }

    /*
    |--------------------------------------------------------------------------
    | Submit Contact Form
    |--------------------------------------------------------------------------
    */

    public function submitContactForm(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'type' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'description' => $request->description,
        );
        ContactSupport::create($data);
        return redirect()->back()->with('success',__('Your message successfully submitted.'));
    }

}
