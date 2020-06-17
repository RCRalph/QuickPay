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
        // -- Get Transactions --
        $transactions = auth()->user()->transactionsSender
            ->merge(auth()->user()->transactionsRecipient)
            ->sortByDesc("created_at")->take(5);

        // -- Get Balance --
        $tRecipient = auth()->user()->transactionsRecipient->groupBy("currency_id")->map(function ($row) {
            return $row->sum('amount');
        });
        $tSender = auth()->user()->transactionsSender->groupBy("currency_id")->map(function ($row) {
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
            $ISO_4217 = \App\Currency::find($keysAndValues[0][$i])->ISO_4217;
            if (array_key_exists($ISO_4217, $balance)) {
                $balance[$ISO_4217] += $keysAndValues[1][$i];
            }
            else {
                $balance[$ISO_4217] = $keysAndValues[1][$i];
            }
        }
        $balance = collect($balance)->sortDesc()->take(4);

        return view('home', compact('transactions', 'balance'));
    }
}
