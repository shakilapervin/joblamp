<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Country;
use App\State;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Country
    |--------------------------------------------------------------------------
    */
    public function country(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $countries = Country::all();
        return view('admin.location.country.index',compact('countries'));
    }

    /*
    |--------------------------------------------------------------------------
    | Add Country Form
    |--------------------------------------------------------------------------
    */
    public function addCountry(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.location.country.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Save Country
    |--------------------------------------------------------------------------
    */
    public function saveCountry(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'name' => $request->name
        );
        $status = Country::create($data);
        if ($status){
            return redirect('admin-country')->with('success', __('Successfully Added!'));
        }else{
            return redirect('admin-country')->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Country Form
    |--------------------------------------------------------------------------
    */
    public function editCountryForm($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $country = Country::find($id);
        return view('admin.location.country.edit', compact('country'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Country
    |--------------------------------------------------------------------------
    */
    public function updateCountry(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $country = Country::find($request->id);
        $country->name = $request->name;
        $country->status = $request->status;
        $status = $country->save();
        if ($status){
            return redirect('admin-edit-country/'.$request->id)->with('success', __('Updated!'));
        }else{
            return redirect('admin-edit-country/'.$request->id)->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Country
    |--------------------------------------------------------------------------
    */
    public function deleteCountry($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $status = Country::where('id',$id)->delete();
        if ($status){
            return redirect('admin-country')->with('success', __('Deleted!'));
        }else{
            return redirect('admin-country')->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | All States
    |--------------------------------------------------------------------------
    */
    public function states(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $states = State::with('countryName')->get();
        return view('admin.location.state.index',compact('states'));
    }

    /*
    |--------------------------------------------------------------------------
    | Add State Form
    |--------------------------------------------------------------------------
    */
    public function addState(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $countries = Country::all();
        return view('admin.location.state.create',compact('countries'));
    }

    /*
    |--------------------------------------------------------------------------
    | Save State
    |--------------------------------------------------------------------------
    */
    public function saveState(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'name' => $request->name,
            'country_id' => $request->country_id
        );
        $status = State::create($data);
        if ($status){
            return redirect('admin-states')->with('success', __('Successfully Added!'));
        }else{
            return redirect('admin-states')->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit State Form
    |--------------------------------------------------------------------------
    */
    public function editStateForm($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $countries = Country::all();
        $state = State::with('countryName')->where('id',$id)->first();
        return view('admin.location.state.edit', compact('countries','state'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update State
    |--------------------------------------------------------------------------
    */
    public function updateState(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $state = State::find($request->id);
        $state->name = $request->name;
        $state->country_id = $request->country_id;
        $state->status = $request->status;
        $status = $state->save();
        if ($status){
            return redirect('admin-edit-state/'.$request->id)->with('success', __('Updated!'));
        }else{
            return redirect('admin-edit-state/'.$request->id)->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete State
    |--------------------------------------------------------------------------
    */
    public function deleteState($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $status = State::where('id',$id)->delete();
        if ($status){
            return redirect('admin-states')->with('success', __('Deleted!'));
        }else{
            return redirect('admin-states')->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | All Cities
    |--------------------------------------------------------------------------
    */
    public function cities(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $cities = City::with('countryName')->with('stateName')->get();
        return view('admin.location.city.index',compact('cities'));
    }

    /*
    |--------------------------------------------------------------------------
    | Add City Form
    |--------------------------------------------------------------------------
    */
    public function addCity(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $countries = Country::all();
        $states = State::all();
        return view('admin.location.city.create',compact('countries','states'));
    }

    /*
    |--------------------------------------------------------------------------
    | Save State
    |--------------------------------------------------------------------------
    */
    public function saveCity(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = array(
            'name' => $request->name,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
        );
        $status = City::create($data);
        if ($status){
            return redirect('admin-cities')->with('success', __('Successfully Added!'));
        }else{
            return redirect('admin-cities')->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit City Form
    |--------------------------------------------------------------------------
    */
    public function editCityForm($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $countries = Country::all();
        $states = State::all();
        $city = City::with('countryName')->with('stateName')->where('id',$id)->first();
        return view('admin.location.city.edit', compact('countries','states','city'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update City
    |--------------------------------------------------------------------------
    */
    public function updateCity(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $city = City::find($request->id);
        $city->name = $request->name;
        $city->country_id = $request->country_id;
        $city->state_id = $request->state_id;
        $city->status = $request->status;
        $status = $city->save();
        if ($status){
            return redirect('admin-edit-city/'.$request->id)->with('success', __('Updated!'));
        }else{
            return redirect('admin-edit-city/'.$request->id)->with('error', __('Error!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete City
    |--------------------------------------------------------------------------
    */
    public function deleteCity($id){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $status = City::where('id',$id)->delete();
        if ($status){
            return redirect('admin-states')->with('success', __('Deleted!'));
        }else{
            return redirect('admin-states')->with('error', __('Error!'));
        }
    }
}
