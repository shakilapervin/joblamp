<?php

namespace App\Http\Controllers\Website;


use App\UserTransaction;
use App\UserWithdrawMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Countries\Package\Countries;
use Stripe;

class WithdrawController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Withdraw Method
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $countryList = new Countries();
        $countries = $countryList->all()->toArray();
        $currencies = $countryList->currencies();
        $user = Auth::user();
        $bank = UserWithdrawMethod::where('user_id', $user->id)->where('type','bank')->first();
        $paypal = UserWithdrawMethod::where('user_id', $user->id)->where('type','paypal')->first();
        $cashIn = UserTransaction::where('user_id', $user->id)->sum('credit');
        $cashOut = UserTransaction::where('user_id', $user->id)->sum('debit');
        $balance = $cashIn - $cashOut;
        return view('frontend.withdraw.index', compact('user', 'bank','paypal', 'countries', 'currencies', 'balance'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Withdraw Method
    |--------------------------------------------------------------------------
    */
    public function updateWithdrawMethod(Request $request)
    {
        $user = Auth::user();
        if ($request->type == 'bank_account') {
            $validator = Validator::make($request->all(), [
                'country' => 'required',
                'currency' => 'required',
                'account_holder_name' => 'required',
                'routing_number' => 'required',
                'account_number' => 'required',
                'account_holder_type' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $account = UserWithdrawMethod::where('user_id', $user->id)->where('type', 'bank')->first();
            if (!empty($account)){
                $account->country = $request->country;
                $account->currency = $request->currency;
                $account->account_holder_name = $request->account_holder_name;
                $account->routing_number = $request->routing_number;
                $account->account_number = $request->account_number;
                $account->account_holder_type = $request->account_holder_type;
                $account->save();
                return redirect()->back()->with('success',__('Account Successfully Updated'));
            }else{
                $bankData = array(
                    'user_id' => $user->id,
                    'country' => $request->country,
                    'currency' => $request->currency,
                    'account_holder_name' => $request->account_holder_name,
                    'routing_number' => $request->routing_number,
                    'account_number' => $request->account_number,
                    'account_holder_type' => $request->account_holder_type,
                );
                UserWithdrawMethod::create($bankData);
                return redirect()->back()->with('success',__('Account Successfully Updated'));
            }

        } else {
            $validator = Validator::make($request->all(), [
                'paypal_email' => 'required',
                'currency' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $account = UserWithdrawMethod::where('user_id', $user->id)->where('type', 'paypal')->first();
            if (!empty($account)) {
                $account->account_number = $request->paypal_email;
                $account->currency = $request->currency;
                $account->save();
                return redirect()->back()->with('success', __('Paypal account updated'));
            } else {
                UserWithdrawMethod::create(array(
                    'user_id' => $user->id,
                    'account_number' => $request->paypal_email,
                    'currency' => $request->currency
                ));
                return redirect()->back()->with('success', __('Paypal account updated'));
            }

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Withdraw Request
    |--------------------------------------------------------------------------
    */
    public function withdrawRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'withdraw_method' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $userId = Auth::id();
        $account = UserWithdrawMethod::where('user_id', $userId)->where('type', $request->withdraw_method)->first();
        if (!empty($account)) {
            $cashIn = UserTransaction::where('user_id', $userId)->sum('credit');
            $cashOut = UserTransaction::where('user_id', $userId)->sum('debit');
            $balance = $cashIn - $cashOut;
            if ($request->amount <= $balance) {
                $withdrawData = array(
                    'user_id' => $userId,
                    'method' => $request->withdraw_method,
                    'amount' => $request->amount,
                );
            } else {
                return redirect()->back()->with('error', __('You don\'t have enough balance'));
            }
        } else {
            return redirect()->back()->with('error', __('Please setup your withdraw method first'));
        }
    }
}
