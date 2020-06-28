<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
	public function currencies() {
		return response()->json([
			"status" => "success"
		]);
	}

	public function getExchangeData() {
		$balance = $this->getBalance()->sortBy("id")->toArray();
        foreach ($balance as $currency => $amount) {
            if ($amount <= 0) {
                unset($balance[$currency]);
            }
		}

		$currencies = Currency::all()->toArray();
		$exchangeKey = config("app.fixer_io_key");

		return response()->json([
			"status" => "success",
			"balance" => $balance,
			"currencies" => $currencies,
			"exchangeKey" => config("app.fixer_io_key")
		]);
	}
}
