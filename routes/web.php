<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WelcomeController@index')->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/balance', 'BalanceController@index')->name('balance.index');
Route::get('/balance/exchange', 'BalanceController@exchange')->name('balance.exchange');
Route::post('/balance', 'BalanceController@executeExchange')->name('balance.executeExchange');

Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');

Route::get('/transactions', 'TransactionsController@index')->name('transactions.index');
Route::post('/transactions', 'TransactionsController@store')->name('transactions.store');
Route::get('/transactions/create', 'TransactionsController@create')->name('transactions.create');
Route::get('/transactions/currency/{currency}', 'TransactionsController@currency')->name('transactions.currency');
Route::get('/transactions/{transaction}', 'TransactionsController@show')->name('transactions.show');

Route::get('/requests', 'RequestsController@index')->name('requests.index');
Route::get('/requests/sent', 'RequestsController@sent')->name('requests.sent');
Route::get('/requests/received', 'RequestsController@received')->name('requests.sent');
Route::post('/requests', 'RequestsController@store')->name('requests.store');
Route::get('/requests/create', 'RequestsController@create')->name('requests.create');
Route::get('/requests/{request}', 'RequestsController@show')->name('requests.show');
Route::delete('/requests/{request}', 'RequestsController@destroy')->name('requests.destroy');

Route::get('/exchange/index', "ApiController@index");
Route::post('/exchange/store', "ApiController@store");
