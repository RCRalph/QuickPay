<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use JavaScript;

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

    public function getBalance()
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
			$id = Currency::find($keysAndValues[0][$i])->id;
            if (array_key_exists($id, $balance)) {
                $balance[$id] += $keysAndValues[1][$i];
            }
            else {
				$balance[$id] = $keysAndValues[1][$i];
			}
        }

        return collect($balance)->sortDesc();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$balance = $this->getBalance();

		//get currency info
		$currencies = Currency::find(array_keys($balance->toArray()))->toArray();
		$currencyData = [];
		foreach($currencies as $currency) {
			$currencyData[$currency["id"]] = ["ISO_4217" => $currency["ISO_4217"], "name" => $currency["name"]];
        }

        return view('balance.index', compact('balance', 'currencyData'));
    }

    public function exchange()
    {
        $balance = $this->getBalance()->sortBy("id")->toArray();
        foreach ($balance as $currency => $amount) {
            if ($amount <= 0) {
                unset($balance[$currency]);
            }
		}
		$canExchange = count($balance);

		if ($canExchange) {
			JavaScript::put([
				"balance" => $balance,
				"currencies" => Currency::all()->toArray(),
				"exchangeKey" => config("app.fixer_io_key")
			]);
		}

        return view('balance.exchange', compact('canExchange'));
    }
}
