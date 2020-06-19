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

                <div class="card-body w-100 d-flex justify-content-between align-items-center">
                    <div class="card">
                        <div class="card-header">Sender</div>
                    </div>
                    <div class="h1 m-0 p-0">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </div>
                    <div class="card">
                        <div class="card-header">Recipient</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
