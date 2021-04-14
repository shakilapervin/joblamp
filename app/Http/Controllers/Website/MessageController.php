<?php

namespace App\Http\Controllers\Website;

use App\UserChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Message
    |--------------------------------------------------------------------------
    */
    public function index(){
        return view('frontend.message.index');
    }
    /*
    |--------------------------------------------------------------------------
    | Chat
    |--------------------------------------------------------------------------
    */
    public function chat($id){
        $sender = Auth::user();
        $receiver = UserChat::with('receiver')->where('sender_id',$sender->id)->where('receiver_id',$id)->first();
        if (empty($receiverId)){
            $data = array(
                'sender_id' => $sender->id,
                'receiver_id' => $id
            );
            UserChat::create($data);
        }

        $contacts = UserChat::with('receiver')->where('sender_id',$sender->id)->get();
        return view('frontend.message.chat',compact('contacts','receiver'));
    }
}
