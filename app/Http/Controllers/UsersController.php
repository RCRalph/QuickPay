<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($user)
    {
        $user = User::findOrFail($user);
        $transactionCount = $user->transactionsRecipient->count() + $user->transactionsSender->count();

        return view('users.show', compact('user', 'transactionCount'));
    }
}
