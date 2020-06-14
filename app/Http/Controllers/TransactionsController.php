<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
        return view('transactions');
    }

    public function show($transaction)
    {
        return view('transactions');
    }
}
