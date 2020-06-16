<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transaction;
use \Awobaz\Compoships\Compoships;

class TransactionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tSender = auth()->user()->transactionsSender;
        $tRecipient = auth()->user()->transactionsRecipient;
        $transactions = $tSender->merge($tRecipient)->sortByDesc("created_at");

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $currencies = array_keys(auth()->user()->transactionsRecipient->groupBy('currency')->toArray());

        return view('transactions.create', compact('currencies'));
    }
}
