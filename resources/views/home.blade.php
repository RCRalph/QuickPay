@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5 mt-3">
            <div class="card h-100">
                <div class="card-header">Account Balance</div>
                <div class="card-body w-100">
                    <div class="h2 text-center">
                        122 133.00 PLN
                    </div>
                    <hr>
                    <div class="h2 text-center">
                        213.00 USD
                    </div>
                    <div class="h2 text-center">
                        122 133.00 PLN
                    </div>
                    <hr>
                    <div class="h2 text-center">
                        213.00 USD
                    </div>
                    <div class="h2 text-center">
                        122 133.00 PLN
                    </div>
                    <hr>
                    <div class="h2 text-center">
                        213.00 USD
                    </div>
                    <div class="h2 text-center">
                        122 133.00 PLN
                    </div>
                    <hr>
                    <div class="h2 text-center">
                        213.00 USD
                    </div>
                    <div class="h2 text-center">
                        122 133.00 PLN
                    </div>
                    <hr>
                    <div class="h2 text-center">
                        213.00 USD
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 mt-3">
            <div class="card h-100">
                <div class="card-header">Payment Requests</div>
                <div class="card-body">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">ID</th>
                                <th scope="col" class="text-center">User</th>
                                <th scope="col" class="text-center">Amount</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="text-center">1</th>
                                <td class="text-center">User 1</td>
                                <td class="text-center">100.00 EUR</td>
                                <td><a role="button" class="btn btn-primary btn-sm btn-block" href="#">View request</a></td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-center">213213213</th>
                                <td class="text-center">User 132132131</td>
                                <td class="text-center">12 321 100.00 EUR</td>
                                <td><a role="button" class="btn btn-primary btn-sm btn-block" href="#">View request</a></td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-center">1</th>
                                <td class="text-center">User 1</td>
                                <td class="text-center">100.00 EUR</td>
                                <td><a role="button" class="btn btn-primary btn-sm btn-block" href="#">View request</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header">Recent Transactions</div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
    <!--<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>-->
</div>
@endsection
