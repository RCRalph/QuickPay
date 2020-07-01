<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Currency;

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
			->sortByDesc("id")->take(5);

        // -- Get Requests --
        $requests = auth()->user()->requestsReceiver->sortByDesc("id")->take(3);

        // -- Get Balance --
        $balance = app('App\Http\Controllers\BalanceController')->getBalance()->take(3);
        $currencies = Currency::find(array_keys($balance->toArray()))->toArray();
		$currencyData = [];
		foreach($currencies as $currency) {
			$currencyData[$currency["id"]] = ["ISO_4217" => $currency["ISO_4217"], "name" => $currency["name"]];
        }

        return view('home', compact('transactions', 'balance', 'currencyData', 'requests'));
	}

	public function welcome()
	{
		$transactionsCount = Cache::remember(
			"transactionsCount",
			now()->addMinutes(1),
			function () {
				return \App\Transaction::all()->count();
			}
		);

		$usersCount = Cache::remember(
			"usersCount",
			now()->addMinutes(1),
			function () {
				return \App\User::all()->count();
			}
		);

		$currenciesCount = Cache::remember(
			"currenciesCount",
			now()->addMinutes(1),
			function () {
				return \App\Currency::all()->count();
			}
		);

		$requestsCount = Cache::remember(
			"requestsCount",
			now()->addMinutes(1),
			function () {
				return \App\Request::all()->count();
			}
		);

		return view('welcome', compact('transactionsCount', 'usersCount', 'currenciesCount', 'requestsCount'));
	}
}
