@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="mr-auto my-auto">Transaction #{{$transaction->id}}</div>
                    <div class="d-flex">
                        <a role="button" class="btn btn-primary mr-3" href="/transactions/create">New Transaction</a>
                        <a role="button" class="btn btn-primary" href="/transactions">Show Transactions</a>
                    </div>
                </div>

                <div class="row">
                    <div class="card-body w-100 d-flex justify-content-between align-items-center mx-3">
                        <div class="card w-100">
                            <div class="card-header text-center font-weight-bold h2">Sender</div>
                            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                <img src="https://i.pinimg.com/originals/81/6d/a5/816da533638aee63cfbd315ea24cccbd.jpg" class="rounded-circle" style="max-width: 75%; max-height: 225px;">
                                <div class="mt-3 font-weight-bold h5">{{ $sender->username ?? "SuperUser" }}</div>
                            </div>
                        </div>

                        <div class="display-1 my-0 py-0 mx-4 text-primary">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </div>

                        <div class="card w-100">
                            <div class="card-header text-center font-weight-bold h2">Recipient</div>
                            <div class="card-body text-center">
                                <img src="https://pbs.twimg.com/media/D7dBfozUEAEkItp.jpg" class="rounded-circle" style="max-width: 75%; max-height: 225px;">
                                <div class="mt-3 font-weight-bold h5">{{ $recipient->username }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body col-10 offset-1 w-100">
                    <div class="card">
                        <div class="card-header text-center h2 font-weight-bold">
                            Transaction information
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-header text-center font-weight-bold h4">
                                            Title
                                        </div>
                                        <div class="card-body text-center">
                                            {{ $transaction->title }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-header text-center font-weight-bold h4">
                                            Amount
                                        </div>
                                        <div class="card-body text-center font-weight-bold {{ $transaction->recipient->id == auth()->user()->id ? ('text-success') : ('text-danger') }}">
                                        {{ ($transaction->recipient->id == auth()->user()->id ? "+" : "-") . number_format($transaction->amount, 2, ".", " ") }} {{ $currency->ISO_4217 }}
                                        </div>
                                    </div>
                                </div>
                            </div>
							@if ($transaction->description != null)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header text-center font-weight-bold h4">
                                            Description
                                        </div>
                                        <div class="card-body text-justify">
                                            {{ $transaction->description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
							@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
