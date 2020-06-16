@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header">Account Balance</div>

                <div class="card-body w-100 d-flex justify-content-center align-items-center">
                    @if ($balance->count() > 0)
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">Currency</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($balance as $currency => $amount)
                                <tr onclick='window.document.location="/transactions/currency/{{ $currency }}"'>
                                    <th class="align-middle">{{ $currency }}</td>
                                    <td class="align-middle">{{ number_format($amount, 2, ".", " ") }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    No account balance was found
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
