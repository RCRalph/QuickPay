<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\User;
use App\Transaction;
use App\Currency;
use App\Request;

class RequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sent = auth()->user()->requestsSender->sortByDesc('created_at');
        $recieved = auth()->user()->requestsReciever->sortByDesc('created_at');

        return view('requests.index', compact('sent', 'recieved'));
    }

    public function show(Request $request)
    {
        $this->authorize("view", $request);

        $sender = User::find($request->sender_id);
        if ($sender->picture == null) {
            $sender->picture = "default-profile-picture.png";
        }

        $reciever = User::find($request->reciever_id);
        if ($reciever->picture == null) {
            $reciever->picture = "default-profile-picture.png";
        }

        $currency = Currency::find($request->currency_id);

        $balance = app('App\Http\Controllers\BalanceController')->getBalance()->toArray();
        $isDisabled = array_key_exists($currency->id, $balance) ?
            (floatval($request->amount) > $balance[$currency->id]) : true;

        return view("requests.show", compact("request", "sender", "reciever", "currency", "isDisabled"));
    }

    public function create()
    {
        $currencies = Currency::all()->sortBy('ISO_4217');
        return view('requests.create', compact('currencies'));
    }

    public function store()
    {
		$data = request()->validate([
			'username' => [
				'required',
                'string',
				'check_reciever:username,username'
			],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['max:2047'],
            'amount' => ['required', 'numeric'],
            'currency' => ['required', 'integer', 'exists:currencies,id']
        ]);

        if (strtolower($data["username"]) == "superuser") {
            Transaction::create([
                "sender_id" => 0,
                "recipient_id" => auth()->user()->id,
                "title" => $data["title"],
                "description" => $data["description"],
                "amount" => $data["amount"],
                "currency_id" => $data["currency"]
            ]);
            return redirect("/transactions");
        }
        else {
            Request::create([
                "sender_id" => auth()->user()->id,
                "reciever_id" => User::where("username", "=", $data["username"])->first()->id,
                "title" => $data["title"],
                "description" => $data["description"],
                "amount" => $data["amount"],
                "currency_id" => $data["currency"]
            ]);
            return redirect("/requests");
        }
    }

    public function destroy(Request $request)
    {
        $this->authorize('view', $request);

        $data = request()->validate([
            'btnAct' => ['required', Rule::in(['a', 'd'])]
        ]);

        if ($data['btnAct'] == 'a') {
            $this->authorize('complete', $request);

            $balance = app('App\Http\Controllers\BalanceController')->getBalance()->toArray();
            $currency = Currency::findOrFail($request->currency_id);

            if (array_key_exists($currency->id, $balance)) {
                if (floatval($request->amount) <= $balance[$currency->id]) {
                    Transaction::create([
                        "sender_id" => $request->reciever_id,
                        "recipient_id" => $request->sender_id,
                        "title" => $request->title,
                        "description" => $request->description,
                        "amount" => $request->amount,
                        "currency_id" => $request->currency_id
                    ]);
                }
            }
        }

        $request->delete();
        return redirect($data["btnAct"] == 'a' ? "/transactions" : "/requests");
    }
}
