@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="mr-auto my-auto h4">Request #{{ $request->id }}</div>
                    <div class="d-flex">
                        <a role="button" class="btn btn-primary mr-3" href="/requests/create">New Request</a>
                        <a role="button" class="btn btn-primary" href="/requests">Show requests</a>
                    </div>
                </div>

                <div class="row">
                    <div class="card-body w-100 d-flex justify-content-between align-items-center mx-3">
                        <a href="{{ $receiver['id'] == 0 ? '#' : '/users/' . $receiver['id'] }}" class="text-decoration-none w-100 text-dark">
                            <div class="card w-100">
                                <div class="card-header text-center font-weight-bold h2 text-nowrap">Payer</div>
                                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <img src="/storage/{{ $receiver['picture'] }}" class="rounded{{ $receiver['picture'] != 'default-profile-picture.png' ? '-circle' : '' }}" style="max-width: 75%; max-height: 225px;">
                                    <div class="mt-3 font-weight-bold h5">{{ $receiver['username'] }}</div>
                                </div>
                            </div>
                        </a>

                        <div class="display-1 my-0 py-0 mx-4 text-primary">
							<i class="fas fa-long-arrow-alt-right"></i>
                        </div>

                        <a href="{{ $sender['id'] == 0 ? '#' : '/users/' .  $sender['id'] }}" class="text-decoration-none w-100 text-dark">
                            <div class="card w-100">
                                <div class="card-header text-center font-weight-bold h2 text-nowrap">Receiver</div>
                                <div class="card-body text-center">
                                    <img src="/storage/{{ $sender['picture'] }}" class="rounded{{ $sender['picture'] != 'default-profile-picture.png' ? '-circle' : '' }}" style="max-width: 75%; max-height: 225px;">
                                    <div class="mt-3 font-weight-bold h5">{{ $sender['username'] }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="card-body col-10 offset-1 w-100">
                    <div class="card">
                        <div class="card-header text-center h2 font-weight-bold">
                            Request information
                        </div>
                        <div class="card-body">
                            <div class="row">
								<div class="col-lg-4 mb-3">
									<div class="card">
										<div class="card-header text-center font-weight-bold h4">
											Created at
										</div>
										<div class="card-body text-center">
											{{ DateTime::createFromFormat("yy-m-d G:i:s", $request->created_at)->format("yy-m-d G:i") }}
										</div>
									</div>
								</div>

                                <div class="col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-header text-center font-weight-bold h4">
                                            Title
                                        </div>
                                        <div class="card-body text-center">
                                            {{ $request->title }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 {{ $request->description != null ? 'mb-3' : '' }}">
                                    <div class="card">
                                        <div class="card-header text-center font-weight-bold h4">
                                            Amount
                                        </div>
                                        <div class="card-body text-center font-weight-bold text-primary">
                                        	{{ number_format($request->amount, 2, ".", " ") }} {{ $currency->ISO_4217 }}
                                        </div>
                                    </div>
                                </div>
                            </div>
							@if ($request->description != null)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header text-center font-weight-bold h4">
                                            Description
                                        </div>
                                        <div class="card-body text-justify">
                                            {{ $request->description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
							@endif
                            <hr>
                            <div class="row">
                                @can ('complete', $request)
                                    <div class="col-md-6 mb-3">
                                        <form method="POST" action="/requests/{{ $request->id }}" enctype="multipart/form-data">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input type="hidden" name="btnAct" value="a">
                                            <button type="submit" class="btn btn-block btn-success font-weight-bold" {{ $isDisabled ? 'disabled' : '' }}>Accept Request</button>
                                        </form>
                                    </div>
                                @endcan

                                <div class="@can('complete', $request) col-md-6 @else col-md-12 @endcan">
                                    <form method="POST" action="/requests/{{ $request->id }}" enctype="multipart/form-data">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input type="hidden" name="btnAct" value="d">
                                        <button type="submit" class="btn btn-block btn-danger font-weight-bold">Delete Request</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
