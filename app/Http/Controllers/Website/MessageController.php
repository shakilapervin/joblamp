<?php

namespace App\Http\Controllers\Website;

use App\UserChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MessageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Message
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $id = Auth::id();
        $contacts = UserChat::with('receiver')->where('sender_id', $id)->orderBy('created_at', 'desc')->get();
        return view('frontend.message.index', compact('contacts'));
    }

    /*
    |--------------------------------------------------------------------------
    | Chat
    |--------------------------------------------------------------------------
    */
    public function chat($id)
    {
        $sender = Auth::user();
        $chat = UserChat::where('sender_id', $sender->id)->where('receiver_id', $id)->first();
        $receiver2 = UserChat::where('sender_id', $id)->where('receiver_id', $sender->id)->first();
        if (empty($chat)) {
            $data = array(
                'sender_id' => $sender->id,
                'receiver_id' => $id,
                'url' => 'user_' . $sender->id . '_' . $id
            );
            UserChat::create($data);
        }
        if (empty($receiver2)) {
            $data = array(
                'sender_id' => $id,
                'receiver_id' => $sender->id,
                'url' => 'user_' . $sender->id . '_' . $id
            );
            UserChat::create($data);
        }
        $receiver = UserChat::with('receiver')->where('sender_id', $sender->id)->where('receiver_id', $id)->first();
        $contacts = UserChat::with('receiver')->where('sender_id', $sender->id)->orderBy('created_at', 'desc')->get();
        return view('frontend.message.chat', compact('contacts', 'receiver'));
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Chat Time
    |--------------------------------------------------------------------------
    */
    public function getCurrentTime(){
        $date = date('M d, Y');
        $time = date('h:i A');
        return response()->json(compact('date','time'));
    }
    /*
    |--------------------------------------------------------------------------
    | Chat Update Time
    |--------------------------------------------------------------------------
    */
    public function chatUpdateTime(Request $request)
    {
        UserChat::where('sender_id', $request->sender_id)
            ->where('receiver_id', $request->receiver_id)
            ->update(array('created_at' => date('Y-m-d H:i:s')));
        UserChat::where('sender_id', $request->receiver_id)
            ->where('receiver_id', $request->sender_id)
            ->update(array('created_at' => date('Y-m-d H:i:s')));
        $receiver = $request->receiver_id;
        $contacts = UserChat::with('receiver')->where('sender_id', $request->sender_id)->orderBy('created_at', 'desc')->get();
        return view('frontend.partials.contacts', compact('contacts', 'receiver'));
    }
}
