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
            'title_en' => 'required',
            'title_es' => 'required',
            'title_fr' => 'required',
            'title_de' => 'required',
            'title_ro' => 'required',
            'title_pt' => 'required',
            'description_en' => 'required',
            'description_es' => 'required',
            'description_fr' => 'required',
            'description_de' => 'required',
            'description_ro' => 'required',
            'description_pt' => 'required',
            'number_of_jobs' => 'required',
            'default_price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'title_en' => $request->title_en,
            'title_es' => $request->title_es,
            'title_fr' => $request->title_fr,
            'title_de' => $request->title_de,
            'title_ro' => $request->title_ro,
            'title_pt' => $request->title_pt,
            'description_en' => $request->description_en,
            'description_es' => $request->description_es,
            'description_fr' => $request->description_fr,
            'description_de' => $request->description_de,
            'description_ro' => $request->description_ro,
            'description_pt' => $request->description_pt,
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
        $features_en = $request->feature_en;
        $features_es = $request->feature_es;
        $features_fr = $request->feature_fr;
        $features_de = $request->feature_de;
        $features_ro = $request->feature_ro;
        $features_pt = $request->feature_pt;
        if (!empty($features_en)) {
            for ($i = 0, $n = count($features_en); $i < $n; $i++){
                $featureData = array(
                    'content_en' => $features_en[$i],
                    'content_es' => $features_es[$i],
                    'content_fr' => $features_fr[$i],
                    'content_de' => $features_de[$i],
                    'content_ro' => $features_ro[$i],
                    'content_pt' => $features_pt[$i],
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
        $features = SubscriptionPlanFeature::where('plan_id',$id)->get();
        return view('admin.subscription-plan.edit', compact('plan','prices','features'));
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
            'title_en' => 'required',
            'title_es' => 'required',
            'title_fr' => 'required',
            'title_de' => 'required',
            'title_ro' => 'required',
            'title_pt' => 'required',
            'description_en' => 'required',
            'description_es' => 'required',
            'description_fr' => 'required',
            'description_de' => 'required',
            'description_ro' => 'required',
            'description_pt' => 'required',
            'number_of_jobs' => 'required',
            'default_price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'title_en' => $request->title_en,
            'title_es' => $request->title_es,
            'title_fr' => $request->title_fr,
            'title_de' => $request->title_de,
            'title_ro' => $request->title_ro,
            'title_pt' => $request->title_pt,
            'description_en' => $request->description_en,
            'description_es' => $request->description_es,
            'description_fr' => $request->description_fr,
            'description_de' => $request->description_de,
            'description_ro' => $request->description_ro,
            'description_pt' => $request->description_pt,
            'default_price' => $request->default_price,
            'recommended' => $request->recommended,
            'number_of_jobs' => $request->number_of_jobs,
        );
        $plan = SubscriptionPlan::where('id',$request->id)->update($data);
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

        SubscriptionPlanFeature::where('plan_id',$request->id)->delete();
        $features_en = $request->feature_en;
        $features_es = $request->feature_es;
        $features_fr = $request->feature_fr;
        $features_de = $request->feature_de;
        $features_ro = $request->feature_ro;
        $features_pt = $request->feature_pt;
        if (!empty($features_en)) {
            for ($i = 0, $n = count($features_en); $i < $n; $i++){
                $featureData = array(
                    'content_en' => $features_en[$i],
                    'content_es' => $features_es[$i],
                    'content_fr' => $features_fr[$i],
                    'content_de' => $features_de[$i],
                    'content_ro' => $features_ro[$i],
                    'content_pt' => $features_pt[$i],
                    'plan_id' => $request->id,
                );
                SubscriptionPlanFeature::create($featureData);
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
