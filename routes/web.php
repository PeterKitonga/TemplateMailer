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

/*========================= Test Routes ======================*/
Route::get('test/recipients', function () {
    $schedule = \App\MailSchedule::query()
        ->with('mailTemplate', 'mailRecipients')
        ->first();

    $variables = array_pluck(json_decode($schedule->toArray()['mail_template']['mail_attachment_file_variables']), 'tag');

    return $schedule;
});

Route::get('test/role/{id}', function ($id) {
    $role = \App\Role::query()
        ->where('id', '=', $id)
        ->first();

    return $role->role_permissions;
});

Route::get('test/pdf/{id}', function ($id) {
    $template = \App\MailTemplate::query()
        ->findOrFail($id);

    $pdf = \Illuminate\Support\Facades\App::make('dompdf.wrapper');
    $pdf->loadHTML($template->mail_body_content)->setPaper('a4', 'landscape')->setWarnings(false);

    return $pdf->stream('sample.pdf');
});

Route::get('test/word', function () {
    $wordFile = storage_path('templates/test'.mt_rand(1000, 9999));
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('templates/sample.docx'));
    $templateProcessor->setValue(array('{{company}}', '{{position}}', '{{name}}', '{{last}}', '{{date}}'), array('Transnational Bank Kenya Limited', 'Chief Executive Officer', 'Sammy Lang’at', 'Lang’at', '25th August 2017'));
    $templateProcessor->saveAs($wordFile.'.docx');

    shell_exec(env('LIBREOFFICE_DIR').' --headless --convert-to pdf '.$wordFile.'.docx --outdir '.storage_path('templates'));

    \Illuminate\Support\Facades\File::delete($wordFile.'.docx');

    return response()->download($wordFile.'.pdf')->deleteFileAfterSend(true);
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
    Route::get('edit/{id}', 'MailTemplateController@edit')->name('templates.edit');
    Route::get('get/{id}/body', 'MailTemplateController@getContent')->name('templates.get.body');
    Route::post('store', 'MailTemplateController@store')->name('templates.store');
    Route::post('update', 'MailTemplateController@update')->name('templates.update');
    Route::delete('delete/{id}', 'MailTemplateController@destroy')->name('templates.delete');
});

/*========================= Templates Schedules Routes ======================*/
Route::group(['prefix' => 'templates/schedules'], function () {
    Route::get('{templateId}/create', 'MailScheduleController@create')->name('templates.schedules.create');
    Route::post('{templateId}/store', 'MailScheduleController@store')->name('templates.schedules.store');
    Route::post('{templateId}/update/{id}', 'MailScheduleController@update')->name('templates.schedules.update');
    Route::delete('{templateId}/delete/{id}', 'MailScheduleController@destroy')->name('templates.schedules.delete');
});

/*========================= Datatables Routes ======================*/
Route::group(['prefix' => 'datatables'], function () {
    Route::get('fetch/recipients', 'DatatablesController@fetchRecipients')->name('datatables.fetch.recipients');
    Route::get('fetch/templates', 'DatatablesController@fetchTemplates')->name('datatables.fetch.templates');
});