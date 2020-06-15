<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceController extends Controller
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


        $balances = $tSender->merge($tRecipient)->sortByDesc("created_at");

        return view('balance', compact('balances'));
    }
}
