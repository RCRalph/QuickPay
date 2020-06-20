<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BalanceController;
use App\Currency;
use App\User;

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

        Validator::extend('check_superuser', function ($attribute, $value, $parameters, $validator) {
            $username = $validator->getData()['username'];
            return (strtolower($username) != "superuser");
        });

        Validator::extend('check_reciever', function ($attribute, $value, $parameters, $validator) {
            $columnName = $validator->getData()[$parameters[0]];
            $username = $validator->getData()[$parameters[1]];
            return (strtolower($username) == "superuser" || User::where("username", "=", $username)->exists());
        });
    }
}
