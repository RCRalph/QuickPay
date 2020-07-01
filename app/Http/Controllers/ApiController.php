<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use App\Transaction;
use Fixerio;

class ApiController extends Controller
{
	public function index() {
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

	public function store() {
		$data = request()->validate([
			"sourceCurrency" => ["required", "integer", "exists:currencies,id"],
			"targetCurrency" => ["required", "integer", "exists:currencies,id", "different:sourceCurrency"],
			"value" => ["required", "numeric", "check_balance:value,sourceCurrency", "gt:0"]
		]);
		$data["value"] = floor($data["value"] * 100) / 100;

		$exchangeRates = Fixerio::latest()->toArray()["rates"];
		$sourceCurrencyISO = Currency::find($data["sourceCurrency"])->ISO_4217;
		$targetCurrencyISO = Currency::find($data["targetCurrency"])->ISO_4217;

		$targetValue = $data["value"] *
			$exchangeRates[$targetCurrencyISO] /
			$exchangeRates[$sourceCurrencyISO];

		$targetValue = floor($targetValue * 100) / 100;

		Transaction::create([
			"sender_id" => auth()->user()->id,
			"recipient_id" => 0,
			"title" => "Currency exchange: $sourceCurrencyISO → $targetCurrencyISO",
			"amount" => $data["value"],
			"currency_id" => $data["sourceCurrency"]
		]);

		Transaction::create([
			"sender_id" => 0,
			"recipient_id" => auth()->user()->id,
			"title" => "Currency exchange: $sourceCurrencyISO → $targetCurrencyISO",
			"amount" => $targetValue,
			"currency_id" => $data["targetCurrency"]
		]);

		return response()->json([
			"status" => "success"
		]);
	}
}
