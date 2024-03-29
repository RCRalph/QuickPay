<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="icon" href="{{ URL::asset('favicon.svg') }}" type="image/svg"/>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" @auth href="/home" @else href="/" @endauth>
					<img src="/favicon.svg" width="30" height="30" class="d-inline-block align-top" alt="">
					{{ config('app.name', 'QuickPay') }}
				</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                        <li class="nav-item">
                            <a id="balanceView" class="nav-link" href="/balance">
								<i class="fas fa-file-invoice-dollar"></i>
								{{ __('Account Balance') }}
							</a>
                        </li>
                        <li class="nav-item">
                            <a id="requestsView" class="nav-link" href="/requests">
								<i class="fas fa-hand-holding-usd"></i>
								{{ __('Requests') }}
							</a>
                        </li>
                        <li class="nav-item">
                            <a id="transactionsView" class="nav-link" href="/transactions">
								<i class="fas fa-exchange-alt"></i>
								{{ __('Transactions') }}
							</a>
                        </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle p-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <img src="/storage/{{ auth()->user()->picture ?? 'default-profile-picture.png'}}" class="rounded-circle mx-1 bg-white border" style="height: 40px; width: 40px;">
                                        <span class="caret"></span>
                                    </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/users/{{ auth()->user()->id }}">View profile</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
	<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
	@yield('script')
</body>
</html>
