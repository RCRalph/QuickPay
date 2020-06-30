<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;

class ApiController extends Controller
{
	public function getExchangeData(Request $request) {
		$data = $request->input();

		$balance = app('App\Http\Controllers\BalanceController')->getBalance()->sortBy("id")->toArray();
        foreach ($balance as $currency => $amount) {
            if ($amount <= 0) {
                unset($balance[$currency]);
            }
		}

		$currencies = Currency::all()->toArray();
		$exchangeKey = config("app.fixer_io_key");

		return response()->json([
			"balance" => $balance,
			"currencies" => $currencies,
			"exchangeKey" => config("app.fixer_io_key")
		]);
	}
}
