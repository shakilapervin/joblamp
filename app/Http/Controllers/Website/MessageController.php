<?php

namespace App\Http\Controllers\Website;

use App\UserChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Message
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
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
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
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
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
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
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
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

    /*
    |--------------------------------------------------------------------------
    | Upload Chat File
    |--------------------------------------------------------------------------
    */
    public function saveChatFile(Request $request)
    {
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
        $validator = Validator::make($request->all(), [
            'chat_file' => 'required|mimes:jpg,jpeg,png,bmp,tiff,pdf,zip,doc,docx,txt,svg,gif',
        ]);
        if ($validator->fails()) {
            $status = false;
            $error = 'Sorry This file is not allowed';
            return response()->json(compact('error','status'));
        }else{
            if ($request->hasFile('chat_file')){
                $file_name = $request->file('chat_file')->store('chat-file');
                if ($request->file('chat_file')->extension() == 'jpg' || $request->file('chat_file')->extension() == 'jpeg' || $request->file('chat_file')->extension() == 'png' || $request->file('chat_file')->extension() == 'svg' || $request->file('chat_file')->extension() == 'gif'){
                    $file_type = 'image';
                }else{
                    $file_type = 'file';
                }
                $date = date('M d, Y');
                $time = date('h:i A');
                return response()->json(compact('file_name','file_type','date','time'));
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Download Chat File
    |--------------------------------------------------------------------------
    */
    public function downloadChatFile($file){
        $lang = session()->get('lang')?: 'en';
        app()->setLocale($lang);
        return Storage::download('chat-file/'.$file);
    }
}
