<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
        // -- get transactions --
        $transactions = auth()->user()->transactionsSender
            ->merge(auth()->user()->transactionsRecipient)
            ->sortByDesc("created_at")->take(5);

        // -- get balance --
        $tRecipient = auth()->user()->transactionsRecipient->groupBy("currency")->map(function ($row) {
            return $row->sum('amount');
        });
        $tSender = auth()->user()->transactionsSender->groupBy("currency")->map(function ($row) {
            return -$row->sum('amount');
        });
        $keysAndValues = [
            array_merge(
                $tRecipient->keys()->toArray(),
                $tSender->keys()->toArray()
            ),
            array_merge(
                $tRecipient->values()->toArray(),
                $tSender->values()->toArray()
            )
        ];

        $balance = [];
        for ($i = 0; $i < count($keysAndValues[0]); $i++) {
            if (array_key_exists($keysAndValues[0][$i], $balance)) {
                $balance[$keysAndValues[0][$i]] += $keysAndValues[1][$i];
            }
            else {
                $balance[$keysAndValues[0][$i]] = $keysAndValues[1][$i];
            }
        }
        $balance = collect($balance)->sortDesc()->take(4);

        return view('home', compact('transactions', 'balance'));
    }
}
