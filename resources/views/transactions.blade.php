@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header">Recent Transactions</div>

                <div class="card-body w-100 d-flex justify-content-center align-items-center">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Sender</th>
                                <th scope="col">Recipient</th>
                                <th scope="col">Title</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td class="align-middle">{{ DateTime::createFromFormat("yy-m-d G:i:s", $transaction->created_at)->format("d-m-yy") }}</td>
                                    <td class="align-middle">{{  }}</td> <!-- sender username -->
                                    <td class="align-middle">{{  }}</td> <!-- recipient username -->
                                    <td class="align-middle">{{ $transaction->title }}</td>
                                    <td class="align-middle font-weight-bold {{ $transaction->amount >= 0 ? ('text-success') : ('text-danger') }}">{{ ($transaction->amount > 0 ? "+" : "") . number_format($transaction->amount, 2, ".", " ") . " " . $transaction->currency}}</td>
                                    <td class="align-middle"><a role="button" class="btn btn-primary btn-sm btn-block" href="/transactions/{{ $transaction->id }}">View transaction</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
