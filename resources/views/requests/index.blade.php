@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="mr-auto my-auto">Requests</div>
                    <a role="button" class="btn btn-primary" href="/requests/create">New Request</a>
                </div>

                <div class="card-body">
                    @if ($sent->count() > 0 || $recieved->count() > 0)
                        @if ($recieved->count() > 0)
                            <div class="card">
                                <div class="card-header">Recieved requests</div>

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
                                            @foreach($recieved as $request)
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
                            </div>
                        @endif

                        @if ($sent->count() > 0)
                            <div class="card {{ $recieved->count() > 0 ? 'mt-4' : ''}}">
                                <div class="card-header">Sent requests</div>

                                <div class="card-body w-100 d-flex justify-content-center align-items-center">
                                    @if ($sent->count() > 0)
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
                                                @foreach($sent as $request)
                                                    <tr onclick='window.document.location="/requests/{{ $request->id }}"'>
                                                        <td class="align-middle">{{ DateTime::createFromFormat("yy-m-d G:i:s", $request->created_at)->format("yy-m-d") }}</td>
                                                        <td class="align-middle">{{ $request->reciever_id == 0 ? "SuperUser" : $request->sender->username }}</td>
                                                        <td class="align-middle">{{ $request->title }}</td>
                                                        <td class="align-middle font-weight-bold ">
                                                            {{ number_format($request->amount, 2, ".", " ") }} {{ $request->currency->ISO_4217 }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @else
                        No requests found
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
