<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BalanceController;
use App\Currency;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('check_balance', function ($attribute, $value, $parameters, $validator) {
            $amount = $validator->getData()[$parameters[0]];
            $currency_id = $validator->getData()[$parameters[1]];
            $balance = app('App\Http\Controllers\BalanceController')->getBalance()->toArray();
            return (array_key_exists($currency_id, $balance) && $balance[$currency_id] >= $amount);
        });
    }
}
