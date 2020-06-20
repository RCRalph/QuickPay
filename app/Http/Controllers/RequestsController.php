<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\User;
use App\Transaction;
use App\Currency;
use App\Request;

class RequestsController extends Controller
{
    public function index()
    {
        $sent = auth()->user()->requestsSender->sortByDesc('created_at');
        $recieved = auth()->user()->requestsReciever->sortByDesc('created_at');

        return view('requests.index', compact('sent', 'recieved'));
    }

    public function show($request)
    {
        $request = Request::findOrFail($request);
        if ($request->sender_id == auth()->user()->id || $request->reciever_id == auth()->user()->id) {
            $sender = User::find($request->sender_id);
            $reciever = User::find($request->reciever_id);
            $currency = Currency::find($request->currency_id);
            return view("requests.show", compact("request", "sender", "reciever", "currency"));
        }
        abort(404);
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
            'currency' => ['required', 'integer']
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
        }

        return redirect("/requests");
    }
}
