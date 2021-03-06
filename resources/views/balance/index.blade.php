@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header d-flex">
					<div class="mr-auto my-auto h4">Account Balance</div>
                    <a role="button" class="btn btn-primary" href="/balance/exchange">Exchange Currencies</a>
				</div>

                <div class="card-body w-100">
					@if ($balance->count() > 0)
						<div class="table-responsive-xl w-100">
							<table class="table table-hover text-center text-nowrap">
								<thead>
									<tr>
										<th scope="col">Currency</th>
										<th scope="col">Amount</th>
									</tr>
								</thead>
								<tbody>
									@foreach($balance as $id => $amount)
										<tr onclick='window.document.location="/transactions/currency/{{ $id }}"'>
											<th class="align-middle">{{ $currencyData[$id]["name"] }}</td>
											<td class="align-middle">{{ number_format($amount, 2, ".", " ")}} {{ $currencyData[$id]["ISO_4217"] }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
                    @else
                        No account balance found
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
