@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="mr-auto my-auto h4">Requests</div>
                    <a role="button" class="btn btn-primary" href="/requests/create">New Request</a>
                </div>

                <div class="card-body">
					@if ($received->count() > 0)
						<div class="card">
							<div class="card-header">Received requests</div>

							<div class="card-body w-100 d-flex justify-content-center align-items-center">
								<table class="table table-hover text-center">
									<thead>
										<tr>
											<th scope="col">Date</th>
											<th scope="col">Sender</th>
											<th scope="col">Title</th>
											<th scope="col">Amount</th>
										</tr>
									</thead>

									<tbody>
										@foreach($received as $request)
											<tr onclick='window.document.location="/requests/{{ $request->id }}"'>
												<td class="align-middle">{{ DateTime::createFromFormat("yy-m-d G:i:s", $request->created_at)->format("yy-m-d") }}</td>
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

							<div class="d-flex justify-content-center">
								{{ $received->links() }}
							</div>
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
