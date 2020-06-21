@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="mr-auto my-auto font-weight-bold h2">User #{{ $user->id }}</div>
                    @if ($user->id == auth()->user()->id)
                    <a role="button" class="btn btn-primary" href="/requests/create">Edit profile</a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5 text-center mb-3">
                            <img src="https://pbs.twimg.com/media/D7dBfozUEAEkItp.jpg" class="rounded-circle" style="max-width: 100%; max-height: 400px;">
                        </div>
                        <div class="col-lg-7 d-flex align-items-center">
                            <div class="card w-100">
                                <div class="card-header font-weight-bold text-center h2">
                                    User information
                                </div>
                                <div class="card-body w-100">
                                    <div class="row">
                                        <div class="h4 col-6 text-right font-weight-bold my-auto">Username:</div>
                                        <div class="h4 col-6 my-auto">{{ $user->username }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="h4 col-6 text-right font-weight-bold my-auto">Member since:</div>
                                        <div class="h4 col-6 my-auto">{{ DateTime::createFromFormat("yy-m-d G:i:s", $user->created_at)->format("yy-m-d") }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="h4 col-6 text-right font-weight-bold my-auto">Completed transactions:</div>
                                        <div class="h4 col-6 my-auto">{{ $transactionCount }}</div>
                                    </div>
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
