@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="mr-auto my-auto h4">Transactions</div>
                    <a role="button" class="btn btn-primary" href="/transactions/create">New Transaction</a>
                </div>

                <div class="card-body w-100">
					@if ($transactions->count() > 0)
						<div class="table-responsive-xl w-100">
							<table class="table table-hover text-center text-nowrap">
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
											<td class="align-middle">{{ DateTime::createFromFormat("Y-m-d G:i:s", $transaction->created_at)->format("Y-m-d") }}</td>
											<td class="align-middle {{ $transaction->sender_id == auth()->user()->id ? 'text-primary font-weight-bold' : '' }}">{{ $transaction->sender_id == 0 ? "SuperUser" : $transaction->sender->username }}</td>
											<td class="align-middle {{ $transaction->recipient_id == auth()->user()->id ? 'text-primary font-weight-bold' : '' }}">{{ $transaction->recipient_id == 0 ? "SuperUser" : $transaction->recipient->username }}</td>
											<td class="align-middle">{{ $transaction->title }}</td>
											<td class="align-middle font-weight-bold {{ $transaction->recipient_id == auth()->user()->id ? ('text-success') : ('text-danger') }}">
												{{ ($transaction->recipient_id == auth()->user()->id ? "+" : "-") . number_format($transaction->amount, 2, ".", " ") }} {{ $transaction->currency->ISO_4217 }}
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>

						<div class="d-flex justify-content-center">
							{{ $transactions->links() }}
						</div>
                    @else
                        No transactions found
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
