<?php

namespace App\Http\Controllers\Admin;
use App\Country;
use App\Http\Controllers\Controller;

use App\SubscriptionPlan;
use App\SubscriptionPlanFeature;
use App\SubscriptionPlanPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Subscription Plans
    |--------------------------------------------------------------------------
    */
    public function index(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $plans = SubscriptionPlan::all();
        return view('admin.subscription-plan.index',compact('plans'));
    }

    /*
    |--------------------------------------------------------------------------
    | Add New Subscription Plans
    |--------------------------------------------------------------------------
    */
    public function add(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $countries = Country::all();
        return view('admin.subscription-plan.create',compact('countries'));
    }

    /*
    |--------------------------------------------------------------------------
    | Save Subscription Plans
    |--------------------------------------------------------------------------
    */
    public function save(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'number_of_jobs' => 'required',
            'default_price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'title' => $request->title,
            'description' => $request->description,
            'default_price' => $request->default_price,
            'recommended' => $request->recommended,
            'number_of_jobs' => $request->number_of_jobs,
        );

        $id = SubscriptionPlan::insertGetId($data);
        $countries = $request->country_id;
        $prices = $request->price;
        if (!empty($countries)) {
            for ($i = 0, $n = count($countries); $i < $n; $i++){
                $country_id = $countries[$i];
                $price = $prices[$i];
                $planPrice = array(
                    'country_id' => $country_id,
                    'price' => $price,
                    'plan_id' => $id,
                );
                SubscriptionPlanPrice::create($planPrice);
            }
        }
        $features = $request->feature;
        if (!empty($features)) {
            for ($i = 0, $n = count($features); $i < $n; $i++){
                $content = $features[$i];
                $featureData = array(
                    'content' => $content,
                    'plan_id' => $id,
                );
                SubscriptionPlanFeature::create($featureData);
            }
        }
        return redirect('admin-subscription-plans')->with('success', __('Successfully Added!'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Subscription Plans Form
    |--------------------------------------------------------------------------
    */
    public function edit($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $plan = SubscriptionPlan::where('id',$id)->first();
        $prices = SubscriptionPlanPrice::where('plan_id',$id)->get();
        return view('admin.subscription-plan.edit', compact('plan','prices'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Subscription Plans
    |--------------------------------------------------------------------------
    */
    public function update(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'default_price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $plan = SubscriptionPlan::where('id',$request->id)->first();
        $plan->title = $request->title;
        $plan->default_price = $request->default_price;
        $plan->description = $request->description;
        $plan->recommended = $request->recommended;
        $plan->status = $request->status;
        $plan->save();
        SubscriptionPlanPrice::where('plan_id',$request->id)->delete();

        $countries = $request->country_id;
        $prices = $request->price;
        if (!empty($countries)) {
            for ($i = 0, $n = count($countries); $i < $n; $i++){
                $country_id = $countries[$i];
                $price = $prices[$i];
                $planPrice = array(
                    'country_id' => $country_id,
                    'price' => $price,
                    'plan_id' => $request->id,
                );
                SubscriptionPlanPrice::create($planPrice);
            }
        }

        return redirect('/admin-edit-subscription-plan/'.$request->id)->with('success',__('Plan Updated'));
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Subscription Plans
    |--------------------------------------------------------------------------
    */
    public function delete($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $status = SubscriptionPlan::where('id',$id)->delete();
        SubscriptionPlanPrice::where('plan_id',$id)->delete();
        if ($status){
            return redirect('admin-subscription-plans')->with('success', __('Deleted!'));
        }else{
            return redirect('admin-subscription-plans')->with('error', __('Error!'));
        }
    }
}
