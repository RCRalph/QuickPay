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

                <div class="card-body row">
					@if ($received || $sent)
						<div class="col-md-6 my-1">
							<a href="/requests/sent" class="text-decoration-none text-light text-center h1">
								<div class="card bg-secondary">
									<div class="card-body">
										Sent
										<i class="fas fa-paper-plane"></i>
									</div>
								</div>
							</a>
						</div>

						<div class="col-md-6 my-1">
							<a href="/requests/received" class="text-decoration-none text-light text-center h1">
								<div class="card bg-secondary">
									<div class="card-body">
										Received
										<i class="fas fa-sign-in-alt"></i>
									</div>
								</div>
							</a>
						</div>
                    @else
						<div class="text-center w-100">
							No requests found
						</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
