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
        return view('transactions.create', compact('currencies'));
    }

    public function store()
    {
		$data = request()->validate([
			'username' => [
				'required',
                'string',
				Rule::exists('users')->where(function ($query) {
                	$query->where([['username', '<>', auth()->user()->username], ['username', '<>', 'SuperUser']]);
				})
			],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['max:2047'],
            'amount' => ['required', 'numeric', 'check_balance:amount,currency'],
            'currency' => ['required', 'integer', 'exists:currencies,id']
        ]);

        Transaction::create([
            "sender_id" => auth()->user()->id,
            "recipient_id" => User::where("username", "=", $data["username"])->first()->id,
            "title" => $data["title"],
            "description" => $data["description"],
            "amount" => $data["amount"],
            "currency_id" => $data["currency"]
        ]);

        return redirect("/transactions");
    }

    public function show(Transaction $transaction)
    {
        $this->authorize("view", $transaction);

        $sender = User::find($transaction->sender_id);
        if ($sender == null) {
            $sender = [
                "id" => 0,
                "username" => "SuperUser",
                "picture" => "superuser.jpg"
            ];
        }
        else {
            $sender = $sender->toArray();
        }

        $recipient = User::find($transaction->recipient_id);
        if ($recipient == null) {
            $recipient = collect([
                "id" => 0,
                "username" => "SuperUser",
                "picture" => "superuser.jpg"
            ]);
        }

        $currency = Currency::find($transaction->currency_id);

        return view("transactions.show", compact("transaction", "sender", "recipient", "currency"));
    }

    public function currency(Currency $currency)
    {
        $tSender = auth()->user()->transactionsSender;
        $tRecipient = auth()->user()->transactionsRecipient;
        $transactions = $tSender->merge($tRecipient)->where('currency_id', $currency->id)->sortByDesc("created_at");

        return view('transactions.currency', compact('transactions', 'currency'));
    }
}
