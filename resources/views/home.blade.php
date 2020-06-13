@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-3 mt-3">
            <div class="card h-100">
                <div class="card-header">Account Balance</div>

                <div class="card-body w-100 d-flex justify-content-center align-items-center">
                    <table class="table text-center table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Currency</th>
                                <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">PLN</td>
                                <td>122&nbsp133.00</td>
                            </tr>
                            <tr>
                                <th scope="row">EUR</td>
                                <td>321.00</td>
                            </tr>
                            <tr>
                                <th scope="row">USD</td>
                                <td>213.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-9 mt-3">
            <div class="card h-100">
                <div class="card-header">Payment Requests</div>

                <div class="card-body w-100 d-flex justify-content-center align-items-center">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">User</th>
                                <th scope="col">Title</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-middle">User 1</td>
                                <td class="align-middle">This is a normal title for a money request.</td>
                                <td class="align-middle">100.00&nbspEUR</td>
                                <td class="align-middle"><a role="button" class="btn btn-primary btn-sm btn-block" href="#">View request</a></td>
                            </tr>
                            <tr>
                                <td class="align-middle">User 2</td>
                                <td class="align-middle">This is a normal title for a money request.</td>
                                <td class="align-middle">100&nbsp000.00&nbspUSD</td>
                                <td class="align-middle"><a role="button" class="btn btn-primary btn-sm btn-block" href="#">View request</a></td>
                            </tr>
                            <tr>
                                <td class="align-middle">User 3</td>
                                <td class="align-middle">This is a normal title for a money request.</td>
                                <td class="align-middle">100.00&nbspPLN</td>
                                <td class="align-middle"><a role="button" class="btn btn-primary btn-sm btn-block" href="#">View request</a></td>
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

                <div class="card-body w-100 d-flex justify-content-center align-items-center">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Title</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-middle">13.06.2020</td>
                                <td class="align-middle">This is a normal title for a transaction.</td>
                                <td class="align-middle font-weight-bold text-success">100.00&nbspEUR</td>
                                <td class="align-middle"><a role="button" class="btn btn-primary btn-sm btn-block" href="#">View transaction</a></td>
                            </tr>
                            <tr>
                                <td class="align-middle">12.06.2020</td>
                                <td class="align-middle">This is a normal title for a transaction. This is a normal title for a transaction.</td>
                                <td class="align-middle font-weight-bold text-success">12&nbsp321&nbsp100.00&nbspEUR</td>
                                <td class="align-middle"><a role="button" class="btn btn-primary btn-sm btn-block" href="#">View transaction</a></td>
                            </tr>
                            <tr>
                                <td class="align-middle">11.06.2020</td>
                                <td class="align-middle">This is a normal title for a transaction.</td>
                                <td class="align-middle font-weight-bold text-danger">-100.00&nbspPLN</td>
                                <td class="align-middle"><a role="button" class="btn btn-primary btn-sm btn-block" href="#">View transaction</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
