@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('New Transaction') }}</div>

                <div class="card-body w-100 {{count($currencies) == 0 ? 'd-flex justify-content-center align-items-center' : ''}}">
                    @if (count($currencies) > 0)
                        <form method="POST" action="/transactions" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="recipient" class="col-md-4 col-form-label text-md-right">{{ __('Recipient username') }}</label>

                                <div class="col-md-6">
                                    <input id="recipient" type="text" class="form-control @error('recipient') is-invalid @enderror" name="username" value="{{ old('recipient') }}" required autocomplete="recipient" autofocus>

                                    @error('recipient')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title">

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="description"></textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>

                                <div class="col-md-6">
                                    <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required autocomplete="amount">

                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="currency" class="col-md-4 col-form-label text-md-right">{{ __('Currency') }}</label>

                                <div class="col-md-6">
                                    <select id="currency" class="form-control @error('currency') is-invalid @enderror" name="currency" value="{{ old('currency') }}" required autocomplete="currency">
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}">{{ $currency->ISO_4217 }}</option>
                                        @endforeach
                                    </select>
                                    @error('currency')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        Currently you are unable to create a transaction due to lack of funds.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
