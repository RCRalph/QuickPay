@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="mr-auto my-auto h2 font-weight-bold">Transaction #{{$transaction->id}}</div>
                    <div class="d-flex">
                        <a role="button" class="btn btn-primary mr-3" href="/transactions/create">New Transaction</a>
                        <a role="button" class="btn btn-primary" href="/transactions">Show Transactions</a>
                    </div>
                </div>

                <div class="row">
                    <div class="card-body w-100 d-flex justify-content-between align-items-center mx-3">
                        <a href="{{ $sender['id'] == 0 ? '#' : '/users/' . $sender['id'] }}" class="text-decoration-none w-100 text-dark">
                            <div class="card w-100">
                                <div class="card-header text-center font-weight-bold h2 text-nowrap">Sender</div>
                                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <img src="/storage/{{ $sender['picture'] }}" class="rounded{{ $sender['picture'] != 'default-profile-picture.png' ? '-circle' : '' }}" style="max-width: 75%; max-height: 225px;">
                                    <div class="mt-3 font-weight-bold h5">{{ $sender['username'] }}</div>
                                </div>
                            </div>
                        </a>

                        <div class="display-1 my-0 py-0 mx-4 text-primary">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </div>

                        <a href="{{ $recipient['id'] == 0 ? '#' : '/users/' .  $recipient['id'] }}" class="text-decoration-none w-100 text-dark">
                            <div class="card w-100">
                                <div class="card-header text-center font-weight-bold h2 text-nowrap">Recipient</div>
                                <div class="card-body text-center">
                                    <img src="/storage/{{ $recipient['picture'] }}" class="rounded{{ $recipient['picture'] != 'default-profile-picture.png' ? '-circle' : '' }}" style="max-width: 75%; max-height: 225px;">
                                    <div class="mt-3 font-weight-bold h5">{{ $recipient['username'] }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="card-body col-10 offset-1 w-100">
                    <div class="card">
                        <div class="card-header text-center h2 font-weight-bold">
                            Transaction information
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-header text-center font-weight-bold h4">
											Created at
                                        </div>
                                        <div class="card-body text-center">
                                        	{{ DateTime::createFromFormat("yy-m-d G:i:s", $transaction->created_at)->format("yy-m-d G:i") }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-header text-center font-weight-bold h4">
                                            Title
                                        </div>
                                        <div class="card-body text-center">
                                            {{ $transaction->title }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 mb-3">
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
