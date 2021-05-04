<?php

namespace App\Http\Controllers\Admin;

use App\Transaction;
use App\User;
use App\UserWithdrawMethod;
use App\WithdrawRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PragmaRX\Countries\Package\Countries;
class TransactionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Transactions
    |--------------------------------------------------------------------------
    */
    public function index(){
        $transactions = Transaction::all();
        return view('admin.transaction.index',compact('transactions'));
    }

    /*
    |--------------------------------------------------------------------------
    | All Not Paid Withdraw Request
    |--------------------------------------------------------------------------
    */
    public function notPaidRequests(){
        $rows = WithdrawRequest::where('status','not_paid')->get();
        return view('admin.withdraw.index',compact('rows'));
    }
    /*
    |--------------------------------------------------------------------------
    | Withdraw Details
    |--------------------------------------------------------------------------
    */
    public function withdrawDetails($id){
        $countries = new Countries();
        $withdrawData = WithdrawRequest::where('id',$id)->first();
        $accountData = UserWithdrawMethod::where('type',$withdrawData->method)->first();
        $userData = User::where('id',$withdrawData->user_id)->first();
        return view('admin.withdraw.details',compact('withdrawData','accountData','userData','countries'));
    }

    /*
    |--------------------------------------------------------------------------
    | Mark Withdraw Request Paid
    |--------------------------------------------------------------------------
    */
    public function markWithdrawRequestPaid($id){
        $withdrawData = WithdrawRequest::where('id',$id)->first();
        $withdrawData->status = 'paid';
        $withdrawData->save();
        return redirect()->route('admin.withdraw.not.paid')->with('success', __('Marked as paid!'));
    }

    /*
    |--------------------------------------------------------------------------
    | All Paid Withdraw Request
    |--------------------------------------------------------------------------
    */
    public function paidRequests(){
        $rows = WithdrawRequest::where('status','paid')->get();
        return view('admin.withdraw.index',compact('rows'));
    }
}
