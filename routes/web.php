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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/transactions', 'TransactionsController@index')->name('transactions.index');
Route::get('/transactions/create', 'TransactionsController@create')->name('transactions.create');
Route::get('/transactions/{id}', 'TransactionsController@show')->name('transactions.show');
Route::delete('/transactions/{id}', 'TransactionsController@destroy')->name('transactions.destroy');
