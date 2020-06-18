<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\User;
use App\Transaction;
use App\Currency;

class TransactionsController extends Controller
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
        $tSender = auth()->user()->transactionsSender;
        $tRecipient = auth()->user()->transactionsRecipient;
        $transactions = $tSender->merge($tRecipient)->sortByDesc("created_at");

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $currencies = Currency::all()->sortBy('ISO_4217');
        //dd($currencies);

        return view('transactions.create', compact('currencies'));
    }

    public function store()
    {
		$data = request()->validate([
			'username' => [
				'required',
				'string',
				'different:SuperUser',
				Rule::exists('users')->where(function ($query) {
                	$query->where('username', '<>', auth()->user()->username);
				})
			],
            'title' => ['required', 'string'],
            'description' => ['max:1024'],
            'amount' => ['required', 'numeric'],
            'currency' => ['required', 'integer']
        ]);
        dd(request()->all());
    }
}
