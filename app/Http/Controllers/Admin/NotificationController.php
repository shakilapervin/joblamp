<?php

namespace App\Http\Controllers\Admin;

use App\Notification;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function create(){
        if (Auth::user()->user_type != 'admin'){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.notification.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->to == 'customer'){
            $receivers = User::where('user_type','customer')->get();
        }elseif ($request->to == 'worker'){
            $receivers = User::where('user_type','service_provider')->get();
        }else{
            $receivers = User::get();
        }
        foreach ($receivers as $receiver){
            $notification = array(
                'user_id' => $receiver->id,
                'title' => $receiver->title,
                'description' => $receiver->description,
            );
            Notification::create($notification);

            $headers = array(
                'Authorization: key=' . env('FIREBASE_API_KEY'),
                'Content-Type: application/json'
            );
            $msg = array(
                'title' => $receiver->title,
                'body' => $receiver->description,
            );

            $fields = array(
                'registration_ids' => $receiver->device_token,
                'notification' => $msg,
                'data' => $receiver->title
            );
            try {
                Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send',$fields);
            }catch (\Exception $e){

            }
        }
        return redirect()->back()->with('success','Successfully Send');
    }
}
