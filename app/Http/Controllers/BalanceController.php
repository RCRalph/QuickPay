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
			$id = \App\Currency::find($keysAndValues[0][$i])->id;
            if (array_key_exists($id, $balance)) {
                $balance[$id] += $keysAndValues[1][$i];
            }
            else {
				$balance[$id] = $keysAndValues[1][$i];
			}
		}

		//get currency info
		$currencies = \App\Currency::find(array_keys($balance))->toArray();
		$currencyData = [];
		foreach($currencies as $currency) {
			$currencyData[$currency["id"]] = ["ISO_4217" => $currency["ISO_4217"], "name" => $currency["name"]];
		}

        $balance = collect($balance)->sortDesc();
        return view('balance', compact('balance', 'currencyData'));
    }
}
