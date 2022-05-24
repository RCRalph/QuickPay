@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="mr-auto my-auto h4">Received requests</div>
                    <div class="d-flex">
                        <a role="button" class="btn btn-primary mr-3" href="/requests/create">New Request</a>
                        <a role="button" class="btn btn-primary" href="/requests">Show All Requests</a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($requests->count() > 0)
						<div class="card-body w-100">
							<div class="table-responsive-xl w-100">
								<table class="table table-hover text-center text-nowrap">
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
												<td class="align-middle">{{ DateTime::createFromFormat("Y-m-d G:i:s", $request->created_at)->format("Y-m-d") }}</td>
												<td class="align-middle">{{ $request->sender_id == 0 ? "SuperUser" : $request->sender->username }}</td>
												<td class="align-middle">{{ $request->title }}</td>
												<td class="align-middle font-weight-bold ">
													{{ number_format($request->amount, 2, ".", " ") }} {{ $request->currency->ISO_4217 }}
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>

						<div class="d-flex justify-content-center">
							{{ $requests->links() }}
						</div>
                    @else
						<div class="text-center">
							No received requests found
						</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
