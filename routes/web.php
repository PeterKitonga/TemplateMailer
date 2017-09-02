<?php

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

/*========================= Landing Route ======================*/
Route::get('/', function () {
    if (Auth::guest())
    {
        return redirect('login');
    } else {
        return redirect('home');
    }
});

/*========================= Authentication Routes ======================*/
Auth::routes();

/*========================= Home Route ======================*/
Route::get('/home', 'HomeController@index');

/*========================= Activation Route ======================*/
Route::get('activate/account/{code}', ['as' => 'activate.account', 'uses' => 'Auth\RegisterController@activate']);
