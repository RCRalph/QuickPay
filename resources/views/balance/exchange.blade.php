@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header font-weight-bold h2">Exchange Currencies</div>

                <div class="card-body w-100 d-flex justify-content-center align-items-center">
                    @if ($canExchange)
                        <div id="currency" class="w-100"></div>
                    @else
                        Not enough money
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
	<script src="{{ asset('js/exchange.js') }}" defer></script>
@endsection
