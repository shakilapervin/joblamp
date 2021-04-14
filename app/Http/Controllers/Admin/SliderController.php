<?php

namespace App\Http\Controllers\Admin;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Image;
class SliderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Banners
    |--------------------------------------------------------------------------
    */
    public function index(){
        $banners = Slider::all();
        return view('admin.banner.index',compact('banners'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create Banner
    |--------------------------------------------------------------------------
    */
    public function create(){
        return view('admin.banner.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store Banner
    |--------------------------------------------------------------------------
    */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $photo = $request->file('image');
        $photoName = 'banner-'.uniqid().'.'.$photo->extension();
        $dPath = storage_path('app/banner/');
        $img = Image::make($photo->path());
        $img->resize(1920,1080,function ($constraint){
            $constraint->aspectRatio();
        })->save($dPath.$photoName);
        $data = array(
            'title' => $request->title,
            'image' => 'banner/'.$photoName,
        );
        Slider::create($data);
        return redirect()->route('admin.banners')->with('success',__('Successfully Added!'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Banner
    |--------------------------------------------------------------------------
    */
    public function edit($id){
        $banner = Slider::where('id',$id)->first();
        return view('admin.banner.edit',compact('banner'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Banner
    |--------------------------------------------------------------------------
    */
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $banner = Slider::where('id',$request->id)->first();
        $banner->title = $request->title;
        if ($request->hasFile('image')){
            $photo = $request->file('image');
            $photoName = 'banner-'.uniqid().'.'.$photo->extension();
            $dPath = storage_path('app/banner/');
            $img = Image::make($photo->path());
            $img->resize(1920,1080,function ($constraint){
                $constraint->aspectRatio();
            })->save($dPath.$photoName);
            $banner->image = 'banner/'.$photoName;
        }
        $banner->save();
        return redirect()->route('admin.banners')->with('success',__('Successfully Added!'));
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Banner
    |--------------------------------------------------------------------------
    */
    public function delete($id){
        Slider::where('id',$id)->delete();
        return redirect()->back()->with('success', __('Successfully Deleted!'));
    }
}
