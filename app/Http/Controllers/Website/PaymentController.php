<?php

namespace App\Http\Controllers\Website;

use App\Charge;
use App\Job;
use App\JobApplication;
use App\LottoUser;
use App\Notification;
use App\SubscriptionPlan;
use App\Transaction;
use App\User;
use App\UserJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\SubscriptionPlanPrice;
use Stripe;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;
use Exception;
use Mail;

class PaymentController extends Controller
{
    public $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(env('PAYPAL_CLIENT_SECRET'));
    }

    /*
    |--------------------------------------------------------------------------
    | Job Checkout Page
    |--------------------------------------------------------------------------
    */
    public function jobCheckout($jobId, $serviceProviderId)
    {
        try {
            $jobId = decrypt($jobId);
        } catch (\RuntimeException $e) {
            return redirect('');
        }

        try {
            $serviceProviderId = decrypt($serviceProviderId);
        } catch (\RuntimeException $e) {
            return redirect('');
        }
        $amount = JobApplication::where('job_id', $jobId)->where('candidate_id', $serviceProviderId)->first();
        $charge = Charge::latest('id')->first();
        $extra = ($amount->bid_amount * $charge->customer_charge) / 100;
        return view('frontend.checkout.checkout-job', compact('amount', 'jobId', 'serviceProviderId', 'extra'));
    }

    /*
    |--------------------------------------------------------------------------
    | Capture Card Job Payment
    |--------------------------------------------------------------------------
    */
    public function captureJobPayment(Request $request)
    {
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        $amount = JobApplication::where('job_id', $request->jobId)->where('candidate_id', $request->candidateId)->first();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $charge = Charge::latest('id')->first();
        $extra = ($amount->bid_amount * $charge->customer_charge) / 100;

        $tx = Stripe\Charge::create([
            "amount" => ($amount->bid_amount + $extra) * 100,
            "currency" => env('CURRENCY'),
            "source" => $request->stripeToken,
            "description" => "Joblamp",
        ]);
        Session::flash('success', 'Payment successful!');

        if (Auth::user()->user_type == 'customer') {
            $job = Job::with('creatorDetails')->where('id', $request->jobId)->first();
            if (!empty($job)) {
                $data = array(
                    'customer_id' => Auth::user()->id,
                    'service_provider_id' => $request->candidateId,
                    'job_id' => $request->jobId,
                );
                $success = UserJob::create($data);
                $job->status = 'hired';
                $job->save();

                $application = JobApplication::where('job_id', $request->jobId)->where('candidate_id', $request->candidateId)->first();
                $application->status = 'hired';
                $application->save();
                $transaction = array(
                    'transaction_id' => $tx->id,
                    'payment_method' => 'Stripe',
                    'user_id' => $user->id,
                    'narration' => $user->first_name . ' ' . $user->last_name . '- Payment for task worker hired',
                );
                Transaction::create($transaction);
                if ($success) {
                    return redirect('dashboard')->with('success', __('Payment done'));
                } else {
                    return redirect('dashboard')->with('error', __('An error occurred, Please try again!'));
                }
            } else {
                return redirect('')->home();
            }

        } else {
            return redirect('')->home();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Api Job Checkout Page
    |--------------------------------------------------------------------------
    */
    public function apiJobCheckout($user_id, $job_id, $applicant_id)
    {
        $userId = $user_id;
        $jobId = $job_id;
        $serviceProviderId = $applicant_id;
        $amount = JobApplication::where('job_id', $jobId)->where('candidate_id', $serviceProviderId)->first();
        $charge = Charge::latest('id')->first();
        $extra = ($amount->bid_amount * $charge->customer_charge) / 100;
        return view('api.checkout.job-checkout', compact('amount', 'jobId', 'serviceProviderId', 'extra', 'userId'));
    }

    /*
    |--------------------------------------------------------------------------
    | Capture Api Card Job Payment
    |--------------------------------------------------------------------------
    */
    public function apiCaptureJobPayment(Request $request)
    {
        $userId = $request->user_id;
        $user = User::where('id', $userId)->first();
        $amount = JobApplication::where('job_id', $request->jobId)->where('candidate_id', $request->candidateId)->first();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $charge = Charge::latest('id')->first();
        $extra = ($amount->bid_amount * $charge->customer_charge) / 100;

        $tx = Stripe\Charge::create([
            "amount" => ($amount->bid_amount + $extra) * 100,
            "currency" => env('CURRENCY'),
            "source" => $request->stripeToken,
            "description" => "Joblamp",
        ]);
        $job = Job::with('creatorDetails')->where('id', $request->jobId)->first();
        $data = array(
            'customer_id' => $userId,
            'service_provider_id' => $request->candidateId,
            'job_id' => $request->jobId,
        );
        $success = UserJob::create($data);
        $job->status = 'hired';
        $job->save();

        $application = JobApplication::where('job_id', $request->jobId)->where('candidate_id', $request->candidateId)->first();
        $application->status = 'hired';
        $application->save();
        $transaction = array(
            'transaction_id' => $tx->id,
            'payment_method' => 'Stripe',
            'user_id' => $user->id,
            'narration' => $user->first_name . ' ' . $user->last_name . '- Payment for task worker hired',
        );
        Transaction::create($transaction);
        $status = true;
        $message = 'Payment done';
        return response()->json(compact('status', 'message'));
    }

    /*
    |--------------------------------------------------------------------------
    | Capture Api Paypal Job Payment
    |--------------------------------------------------------------------------
    */

    public function apiCaptureJobPaypalPayment($user_id, $job_id, $applicant_id)
    {
        session()->put('jobId', $job_id);
        session()->put('candidateId', $applicant_id);
        session()->put('userId', $user_id);
        $amount = JobApplication::where('job_id', $job_id)->where('candidate_id', $applicant_id)->first();
        $charge = Charge::latest('id')->first();
        $extra = ($amount->bid_amount * $charge->customer_charge) / 100;

        try {
            $response = $this->gateway->purchase(array(
                'amount' => $amount->bid_amount + $extra,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => route('api.job.success.paypal.payment'),
                'cancelUrl' => route('api.job.cancel.paypal.payment'),
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function apiJobPaymentCancel()
    {
        $status = false;
        $message = 'Payment error';
        return response()->json(compact('status', 'message'));
    }

    public function apiJobPaymentSuccess(Request $request)
    {
        $jobId = session()->get('jobId');
        $userId = session()->get('userId');
        $user = User::where(id, $userId)->first();
        $candidateId = session()->get('candidateId');
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $job = Job::where('id', $jobId)->first();
                $data = array(
                    'customer_id' => $userId,
                    'service_provider_id' => $candidateId,
                    'job_id' => $jobId,
                );

                UserJob::create($data);
                $job->status = 'hired';
                $job->save();

                $application = JobApplication::where('job_id', $jobId)->where('candidate_id', $candidateId)->first();
                $application->status = 'hired';
                $application->save();
                $transaction = array(
                    'transaction_id' => $request->input('paymentId'),
                    'payment_method' => 'Paypal',
                    'user_id' => $user->id,
                    'narration' => $user->first_name . ' ' . $user->last_name . '- Payment for task worker hired',
                );
                Transaction::create($transaction);
                $status = true;
                $message = 'Payment done';
                return response()->json(compact('status', 'message'));
            } else {
                $status = false;
                $message = $response->getMessage();
                return response()->json(compact('status', 'message'));
            }
        } else {
            $status = false;
            $message = 'Please try again';
            return response()->json(compact('status', 'message'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Capture Paypal Job Payment
    |--------------------------------------------------------------------------
    */

    public function handlePaypalPayment($jobId, $serviceProviderId)
    {
        try {
            $jobId = decrypt($jobId);
        } catch (\RuntimeException $e) {
            return redirect('');
        }

        try {
            $serviceProviderId = decrypt($serviceProviderId);
        } catch (\RuntimeException $e) {
            return redirect('');
        }


        session()->put('jobId', $jobId);
        session()->put('candidateId', $serviceProviderId);
        $job = Job::where('id', $jobId)->first();
        $amount = JobApplication::where('job_id', $jobId)->where('candidate_id', $serviceProviderId)->first();
        $charge = Charge::latest('id')->first();
        $extra = ($amount->bid_amount * $charge->customer_charge) / 100;

        try {
            $response = $this->gateway->purchase(array(
                'amount' => $amount->bid_amount + $extra,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => route('success.paypal.payment'),
                'cancelUrl' => route('cancel.paypal.payment'),
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function paymentCancel()
    {
        return redirect()->back()->with('error', __('An error occurred, Please try again!'));
    }

    public function paymentSuccess(Request $request)
    {
        $jobId = session()->get('jobId');
        $user = Auth::user();
        $candidateId = session()->get('candidateId');
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                if (Auth::user()->user_type == 'customer') {
                    $job = Job::where('id', $jobId)->first();
                    if (!empty($job)) {
                        $data = array(
                            'customer_id' => Auth::user()->id,
                            'service_provider_id' => $candidateId,
                            'job_id' => $jobId,
                        );

                        $success = UserJob::create($data);

                        $job->status = 'hired';
                        $job->save();

                        $application = JobApplication::where('job_id', $jobId)->where('candidate_id', $candidateId)->first();
                        $application->status = 'hired';
                        $application->save();
                        $transaction = array(
                            'transaction_id' => $request->input('paymentId'),
                            'payment_method' => 'Paypal',
                            'user_id' => $user->id,
                            'narration' => $user->first_name . ' ' . $user->last_name . '- Payment for task worker hired',
                        );
                        Transaction::create($transaction);
                        if ($success) {
                            return redirect('dashboard')->with('success', __('Payment done'));
                        } else {
                            return redirect()->back()->with('error', __('An error occurred, Please try again!'));
                        }
                    } else {
                        return redirect('')->home();
                    }

                } else {
                    return redirect('')->home();
                }
            } else {
                return redirect()->back()->with('error', $response->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Please try again'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Capture Card Subscription Payment
    |--------------------------------------------------------------------------
    */
    public function captureSubscriptionPayment(Request $request)
    {
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        $amount = SubscriptionPlanPrice::where('plan_id', $request->planId)->where('country_id', $user->country)->first();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $tx = Stripe\Charge::create([
            "amount" => $amount->price * 100,
            "currency" => "inr",
            "source" => $request->stripeToken,
            "description" => "Joblamp",
        ]);
        $plan = SubscriptionPlan::where('id', $request->planId)->first();
        $date = Carbon::now();
        $expiryDate = $date->addDay(30);
        $user->plan_id = $request->planId;
        $user->plan_expiry_date = $expiryDate;
        if ($plan->number_of_jobs != 'unlimited') {
            $user->remain_job = $plan->number_of_jobs;
        } else {
            $user->remain_job = 'unlimited';
        }
        $user->save();
        $transaction = array(
            'transaction_id' => $tx->id,
            'payment_method' => 'Stripe',
            'user_id' => $user->id,
            'narration' => $user->first_name . ' ' . $user->last_name . '- Subscription charge for ' . $plan->title,
        );
        Transaction::create($transaction);
        $lotto = array(
            'user_id' => $user->id
        );
        LottoUser::create($lotto);
        return redirect('dashboard')->with('success', __('Payment done'));

    }

    /*
    |--------------------------------------------------------------------------
    | Capture Paypal Subscription Payment
    |--------------------------------------------------------------------------
    */
    public function captureSubscriptionPaypalPayment($planId)
    {
        try {
            $id = decrypt($planId);
        } catch (\RuntimeException $e) {
            return redirect('');
        }
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        $plan = SubscriptionPlan::where('id', $id)->first();
        $planPrice = SubscriptionPlanPrice::where('plan_id', $id)->where('country_id', $user->country)->first();
        session()->put('userId', $userId);
        session()->put('planId', $id);
        try {
            $response = $this->gateway->purchase(array(
                'amount' => $planPrice->price,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => route('subscription.success.paypal.payment'),
                'cancelUrl' => route('subscription.cancel.paypal.payment'),
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function paymentSubsSuccess(Request $request)
    {
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        $plan = SubscriptionPlan::where('id', $request->planId)->first();
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $date = Carbon::now();
                $expiryDate = $date->addDay(30);
                $user->plan_id = $request->planId;
                $user->plan_expiry_date = $expiryDate;
                if ($plan->number_of_jobs != 'unlimited') {
                    $user->remain_job = $plan->number_of_jobs;
                } else {
                    $user->remain_job = 'unlimited';
                }
                $user->save();
                $transaction = array(
                    'transaction_id' => $request->input('paymentId'),
                    'payment_method' => 'Paypal',
                    'user_id' => $user->id,
                    'narration' => $user->first_name . ' ' . $user->last_name . '- Subscription charge for ' . $plan->title,
                );
                Transaction::create($transaction);
                $lotto = array(
                    'user_id' => $user->id
                );
                LottoUser::create($lotto);
                return redirect('dashboard')->with('success', __('Payment done'));
            } else {
                return redirect()->back()->with('error', $response->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Please try again'));
        }
    }

    public function paymentSubsCancel()
    {
        return redirect()->back()->with('error', __('Payment canceled'));
    }

    /*
    |--------------------------------------------------------------------------
    | Capture Card Job Application Payment
    |--------------------------------------------------------------------------
    */
    public function captureJobApplicationPayment(Request $request)
    {
        $user = Auth::user();
        $amount = 2;
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $tx = Stripe\Charge::create([
            "amount" => $amount * 100,
            "currency" => env('CURRENCY'),
            "source" => $request->stripeToken,
            "description" => "Joblamp",
        ]);
        $transaction = array(
            'transaction_id' => $tx->id,
            'payment_method' => 'Stripe',
            'user_id' => $user->id,
            'narration' => $user->first_name . ' ' . $user->last_name . '- Job application charge',
        );
        Transaction::create($transaction);
        $data = Session::get('jobData');
        $status = JobApplication::create($data);
        $job = Job::with('creatorDetails')->where('id', $data['job_id'])->first();
        if ($status) {
            $mailData = array();
            $mailAddress = $job->creatorDetails->email;
            try {
                Mail::send('mail.application-submitted', $mailData, function ($message) use ($mailAddress) {
                    $message->to($mailAddress)->subject('A new candidate applied on your job');
                    $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
                });
            } catch (\Exception $e) {

            }
            $notification = array(
                'user_id' => $job->creatorDetails->id,
                'description' => 'A new candidate applied on your job',
            );
            Notification::create($notification);
            Session::forget('jobData');
            return redirect('dashboard')->with('success', __('Successfully Applied!'));
        } else {
            return redirect()->back()->with('error', __('Error try again!'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Capture Paypal Job Application Payment
    |--------------------------------------------------------------------------
    */
    public function handleJobApplicationPaypalPayment()
    {

        try {
            $response = $this->gateway->purchase(array(
                'amount' => 2,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => route('success.job.application.paypal.payment'),
                'cancelUrl' => route('cancel.job.application.paypal.payment'),
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function paymentJobApplicationSuccess(Request $request)
    {
        $user = Auth::user();
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $transaction = array(
                    'transaction_id' => $request->input('paymentId'),
                    'payment_method' => 'Paypal',
                    'user_id' => $user->id,
                    'narration' => $user->first_name . ' ' . $user->last_name . '- Job application charge',
                );
                Transaction::create($transaction);
                $data = Session::get('jobData');
                $status = JobApplication::create($data);
                $job = Job::with('creatorDetails')->where('id', $data['job_id'])->first();
                if ($status) {
                    $mailData = array();
                    $mailAddress = $job->creatorDetails->email;
                    try {
                        Mail::send('mail.application-submitted', $mailData, function ($message) use ($mailAddress) {
                            $message->to($mailAddress)->subject('A new candidate applied on your job');
                            $message->from(env('MAIL_FROM_ADDRESS'), 'Joblamp');
                        });
                    } catch (\Exception $e) {

                    }
                    $notification = array(
                        'user_id' => $job->creatorDetails->id,
                        'description' => 'A new candidate applied on your job',
                    );
                    Notification::create($notification);
                    Session::forget('jobData');
                    return redirect('dashboard')->with('success', __('Successfully Applied!'));
                } else {
                    return redirect()->back()->with('error', __('Error try again!'));
                }
            } else {
                return redirect()->back()->with('error', $response->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Please try again'));
        }
    }

    public function paymentJobApplicationCancel()
    {
        return redirect()->back()->with('error', __('Payment canceled'));
    }

    /*
    |--------------------------------------------------------------------------
    | Promote Profile Checkout Page
    |--------------------------------------------------------------------------
    */
    public function promoteProfileCheckout()
    {
        $cost = Charge::latest('id')->first()->promote;
        return view('frontend.checkout.checkout-promote-profile', compact('cost'));
    }

    /*
    |--------------------------------------------------------------------------
    | Promote Profile Stripe Payment
    |--------------------------------------------------------------------------
    */
    public function stripePaymentForProfilePromote(Request $request)
    {
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        $amount = Charge::latest('id')->first()->promote;
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $tx = Stripe\Charge::create([
            "amount" => $amount * 100,
            "currency" => env('CURRENCY'),
            "source" => $request->stripeToken,
            "description" => "Joblamp",
        ]);

        $date = Carbon::now();
        $expiryDate = $date->addDay(10);
        $user->promoted = 'true';
        $user->promotion_expire = $expiryDate;
        $user->save();
        $transaction = array(
            'transaction_id' => $tx->id,
            'payment_method' => 'Stripe',
            'user_id' => $user->id,
            'narration' => $user->first_name . ' ' . $user->last_name . '- Subscription charge for profile promotion',
        );
        Transaction::create($transaction);
        return redirect('dashboard')->with('success', __('You are successfully promoted your profile for 10 Days'));
    }

    /*
    |--------------------------------------------------------------------------
    | Promote Profile Paypal Payment
    |--------------------------------------------------------------------------
    */
    public function paypalPaymentForProfilePromote()
    {
        $amount = Charge::latest('id')->first()->promote;
        try {
            $response = $this->gateway->purchase(array(
                'amount' => $amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => route('promote.success.paypal.payment'),
                'cancelUrl' => route('promote.cancel.paypal.payment'),
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function paymentPromoteSuccess(Request $request)
    {
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $date = Carbon::now();
                $expiryDate = $date->addDay(10);
                $user->promoted = 'true';
                $user->promotion_expire = $expiryDate;
                $user->save();
                $transaction = array(
                    'transaction_id' => $request->input('paymentId'),
                    'payment_method' => 'Stripe',
                    'user_id' => $user->id,
                    'narration' => $user->first_name . ' ' . $user->last_name . '- Subscription charge for profile promotion',
                );
                Transaction::create($transaction);
                return redirect('dashboard')->with('success', __('You are successfully promoted your profile for 10 Days'));
            } else {
                return redirect()->back()->with('error', $response->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Please try again'));
        }
    }

    public function paymentPromoteCancel()
    {
        return redirect()->back()->with('error', __('Payment canceled'));
    }
}
