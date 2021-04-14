<?php

namespace App\Http\Controllers\Admin;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
