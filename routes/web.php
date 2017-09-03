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
    Route::get('download/template', 'MailRecipientController@download')->name('recipients.download.template');
    Route::post('store', 'MailRecipientController@store')->name('recipients.store');
    Route::post('update', 'MailRecipientController@update')->name('recipients.update');
    Route::post('import', 'MailRecipientController@import')->name('recipients.import');
    Route::delete('delete/{id}', 'MailRecipientController@destroy')->name('recipients.delete');
});

/*========================= Templates Routes ======================*/
Route::group(['prefix' => 'templates'], function () {
    Route::get('/', 'MailTemplateController@index')->name('templates.index');
    Route::get('create', 'MailTemplateController@create')->name('templates.create');
    Route::get('edit', 'MailTemplateController@edit')->name('templates.edit');
    Route::get('get/{id}/body', 'MailTemplateController@getContent')->name('templates.get.body');
    Route::post('store', 'MailTemplateController@store')->name('templates.store');
    Route::post('update', 'MailTemplateController@update')->name('templates.update');
    Route::delete('delete/{id}', 'MailTemplateController@destroy')->name('templates.delete');
});

/*========================= Datatables Routes ======================*/
Route::group(['prefix' => 'datatables'], function () {
    Route::get('fetch/recipients', 'DatatablesController@fetchRecipients')->name('datatables.fetch.recipients');
    Route::get('fetch/templates', 'DatatablesController@fetchTemplates')->name('datatables.fetch.templates');
});