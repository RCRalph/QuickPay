@extends('layouts.app')

@section('content')
	<div class="container text-center">
		<header class="masthead text-center">
			<h1 class="masthead-heading mt-1 mb-5 display-3">QuickPay</h1>
			<p class="h3 mb-4">An Online Money Transfer Platform</p>

			<a href="/register" type="button" class="btn btn-lg btn-dark">Register now!</a>
		</header>

		<hr>

		<div class="row">
			<div class="col-lg-6 mt-2">
				<div class="card bg-secondary text-light">
					<div class="card-header h4">Registered Users</div>

					<div class="card-body display-4">
						{{ $usersCount }}
					</div>
				</div>
			</div>

			<div class="col-lg-6 mt-2">
				<div class="card bg-secondary text-light">
					<div class="card-header h4">Transaction Count</div>

					<div class="card-body display-4">
						{{ $transactionsCount }}
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6 mt-2">
				<div class="card bg-secondary text-light">
					<div class="card-header h4">Currency Count</div>

					<div class="card-body display-4">
						{{ $currenciesCount }}
					</div>
				</div>
			</div>

			<div class="col-lg-6 mt-2">
				<div class="card bg-secondary text-light">
					<div class="card-header h4">Current Request Count</div>

					<div class="card-body display-4">
						{{ $requestsCount }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
