<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Privacy Policy Page
    |--------------------------------------------------------------------------
    */
    public function privacyPolicy(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $content = Page::where('page_name','privacy_policy')->first();
        return view('admin.page.privacy-policy',compact('content'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Privacy Policy Page
    |--------------------------------------------------------------------------
    */
    public function updatePrivacyPolicy(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'content_en' => 'required',
            'content_es' => 'required',
            'content_fr' => 'required',
            'content_de' => 'required',
            'content_ro' => 'required',
            'content_pt' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $page = Page::where('page_name','privacy_policy')->first();
        $page->content_en = $request->content_en;
        $page->content_es = $request->content_es;
        $page->content_fr = $request->content_fr;
        $page->content_de = $request->content_de;
        $page->content_ro = $request->content_ro;
        $page->content_pt = $request->content_pt;
        $page->save();
        return redirect()->back()->with('success',__('Successfully Updated!'));
    }

    /*
    |--------------------------------------------------------------------------
    | Terms Conditions Page
    |--------------------------------------------------------------------------
    */
    public function termsConditions(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $content = Page::where('page_name','terms_conditions')->first();
        return view('admin.page.terms-conditions',compact('content'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Terms Conditions Page
    |--------------------------------------------------------------------------
    */
    public function updateTermsConditions(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'content_en' => 'required',
            'content_es' => 'required',
            'content_fr' => 'required',
            'content_de' => 'required',
            'content_ro' => 'required',
            'content_pt' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $page = Page::where('page_name','terms_conditions')->first();
        $page->content_en = $request->content_en;
        $page->content_es = $request->content_es;
        $page->content_fr = $request->content_fr;
        $page->content_de = $request->content_de;
        $page->content_ro = $request->content_ro;
        $page->content_pt = $request->content_pt;
        $page->save();
        return redirect()->back()->with('success',__('Successfully Updated!'));
    }

    /*
    |--------------------------------------------------------------------------
    | About Us Page
    |--------------------------------------------------------------------------
    */
    public function aboutUs(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $content = Page::where('page_name','about_us')->first();
        return view('admin.page.about-us',compact('content'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update About Us Page
    |--------------------------------------------------------------------------
    */
    public function updateAboutUs(Request $request){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        $validator = Validator::make($request->all(), [
            'content_en' => 'required',
            'content_es' => 'required',
            'content_fr' => 'required',
            'content_de' => 'required',
            'content_ro' => 'required',
            'content_pt' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $page = Page::where('page_name','about_us')->first();
        $page->content_en = $request->content_en;
        $page->content_es = $request->content_es;
        $page->content_fr = $request->content_fr;
        $page->content_de = $request->content_de;
        $page->content_ro = $request->content_ro;
        $page->content_pt = $request->content_pt;
        $page->save();
        return redirect()->back()->with('success',__('Successfully Updated!'));
    }
}
