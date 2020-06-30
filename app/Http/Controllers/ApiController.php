<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use Fixerio;

class ApiController extends Controller
{
	public function getExchangeData(Request $request) {
		$currencies = Currency::all()->toArray();

		$balance = app('App\Http\Controllers\BalanceController')->getBalance()->sortBy("id")->toArray();
        foreach ($balance as $currency => $amount) {
            if ($amount <= 0) {
                unset($balance[$currency]);
            }
		}

		$exchangeRates = Fixerio::latest()->toArray()["rates"];
		$currencyExchangeRates = [];
		foreach ($currencies as $currency) {
			$currencyExchangeRates[$currency["ISO_4217"]] = $exchangeRates[$currency["ISO_4217"]];
		}

		return response()->json([
			"balance" => $balance,
			"currencies" => $currencies,
			"exchangeRates" => $currencyExchangeRates
		]);
	}
}
