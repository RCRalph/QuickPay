<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index()
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
