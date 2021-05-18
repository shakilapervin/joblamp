<?php

namespace App\Http\Controllers\Admin;

use App\ContactSupport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Mail;

class ContactSupportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Support Contact
    |--------------------------------------------------------------------------
    */
    public function index(){
        $supports = ContactSupport::all();
        return view('admin.contact.index',compact('supports'));
    }
    /*
    |--------------------------------------------------------------------------
    | Reply Support Contact
    |--------------------------------------------------------------------------
    */
    public function reply($id){
        $support = ContactSupport::where('id',$id)->first();
        return view('admin.contact.reply',compact('support'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store Support Contact
    |--------------------------------------------------------------------------
    */
    public function replyStore(Request $request){
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $support = ContactSupport::where('id',$request->id)->first();
        $support->status = $request->status;
        $support->save();

        $mailData = array(
            'reply' => $request->message
        );
        $mailAddress = $support->email;
        try {
            Mail::send('mail.support', $mailData, function ($message) use ($mailAddress) {
                $message->to($mailAddress)->subject('Enquiry Reply');
                $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
            });
        } catch (\Exception $e) {

        }
        return redirect()->route('admin.supports')->with('success','Replied successfully');
    }
    /*
    |--------------------------------------------------------------------------
    | Delete Support Contact
    |--------------------------------------------------------------------------
    */
    public function delete(Request $request){
        ContactSupport::where('id',$request->id)->delete();
        return redirect()->back()->with('success','Deleted');
    }
}
