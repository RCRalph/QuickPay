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
					@if (!$received && !$sent)
						@if ($sent)
							<div class=""></div>
						@endif
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
