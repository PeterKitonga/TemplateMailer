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

/*========================= Recipients Routes ======================*/
Route::group(['prefix' => 'recipients'], function () {
    Route::get('/', 'MailRecipientController@index')->name('recipients.index');
    Route::post('store', 'MailRecipientController@store')->name('recipients.store');
    Route::post('update/{id}', 'MailRecipientController@update')->name('recipients.update');
    Route::delete('delete/{id}', 'MailRecipientController@destroy')->name('recipients.delete');
    Route::post('import', 'MailRecipientController@import')->name('recipients.import');
    Route::get('download/template', 'MailRecipientController@download')->name('recipients.download.template');
});

/*========================= Datatables Routes ======================*/
Route::group(['prefix' => 'datatables'], function () {
    Route::get('fetch/recipients', 'DatatablesController@fetchRecipients')->name('datatables.fetch.recipients');
});