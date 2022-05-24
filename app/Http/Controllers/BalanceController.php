<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;

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

		return view('balance.exchange', compact('canExchange'));
	}
}
