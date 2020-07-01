@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4 mt-3">
            <div class="card h-100">
                <div class="card-header d-flex">
                    <div class="mr-auto my-auto">Account Balance</div>
                    <a role="button" class="btn btn-primary" href="/balance">Show Balance</a>
                </div>

                <div class="card-body w-100 d-flex justify-content-center align-items-center">
                @if ($balance->count() > 0)
                    <table class="table text-center table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Currency</th>
                                <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($balance as $currency => $amount)
                                <tr onclick="window.document.location='/transactions/currency/{{ $currency }}'">
                                    <th scope="row">{{ $currencyData[$currency]["ISO_4217"] }}</td>
                                    <td>{{ number_format($amount, 2, ".", " ") }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    The account currenly has no balance
                @endif
                </div>
            </div>
        </div>
        <div class="col-lg-8 mt-3">
            <div class="card h-100">
            <div class="card-header d-flex">
                    <div class="mr-auto my-auto">Payment Requests</div>
                    <div class="d-flex">
                        <a role="button" class="btn btn-primary mr-3" href="/requests/create">New Request</a>
                        <a role="button" class="btn btn-primary" href="/requests">Show Requests</a>
                    </div>
                </div>

                <div class="card-body w-100 d-flex justify-content-center align-items-center">
                    @if ($requests->count() > 0)
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Sender</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($requests as $request)
                                <tr onclick='window.document.location="/requests/{{ $request->id }}"'>
                                    <td class="align-middle">{{ DateTime::createFromFormat("yy-m-d G:i:s", $request->created_at)->format("yy-m-d") }}</td>
                                    <td class="align-middle">{{ $request->sender_id == 0 ? "SuperUser" : $request->sender->username }}</td>
                                    <td class="align-middle">{{ $request->title }}</td>
                                    <td class="align-middle font-weight-bold">
                                        {{ number_format($request->amount, 2, ".", " ") }} {{ $request->currency->ISO_4217 }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        No requests were found
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="mr-auto my-auto">Recent Transactions</div>
                    <div class="d-flex">
                        <a role="button" class="btn btn-primary mr-3" href="/transactions/create">New Transaction</a>
                        <a role="button" class="btn btn-primary" href="/transactions">Show Transactions</a>
                    </div>
                </div>

                <div class="card-body w-100 d-flex justify-content-center align-items-center">
                    @if ($transactions->count() > 0)
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Sender</th>
                                    <th scope="col">Recipient</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr onclick='window.document.location="/transactions/{{ $transaction->id }}"'>
                                    <td class="align-middle">{{ DateTime::createFromFormat("yy-m-d G:i:s", $transaction->created_at)->format("yy-m-d") }}</td>
                                    <td class="align-middle {{ $transaction->sender_id == auth()->user()->id ? 'text-primary font-weight-bold' : '' }}">{{ $transaction->sender_id == 0 ? "SuperUser" : $transaction->sender->username }}</td>
                                    <td class="align-middle {{ $transaction->recipient_id == auth()->user()->id ? 'text-primary font-weight-bold' : '' }}">{{ $transaction->recipient_id == 0 ? "SuperUser" : $transaction->recipient->username }}</td>
                                    <td class="align-middle">{{ $transaction->title }}</td>
                                    <td class="align-middle font-weight-bold {{ $transaction->recipient_id == auth()->user()->id ? ('text-success') : ('text-danger') }}">
                                        {{ ($transaction->recipient_id == auth()->user()->id ? "+" : "-") . number_format($transaction->amount, 2, ".", " ") . " " . $transaction->currency->ISO_4217 }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                    	No transactions were found
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
