<?php
/*
|--------------------------------------------------------------------------
| Accounting Routes
|--------------------------------------------------------------------------
|
| Here is where you can register accounting routes for HR application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" and "hr.auth" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Accounting', 'prefix' => 'accounting'], function() {

    Route::get('/', [
        'as'   => 'accounting.index',
        'uses' => 'AccountingController@index'
    ]);

    /* UserPayment routes */
    Route::get('/salary/index', 'SalaryController@index');

    Route::get('/salary/get-detailed-payment-info', 'SalaryController@getDetailedPaymentInfo');

    Route::post('/salary/refresh', 'SalaryController@refresh');

    Route::post('/salary/calculate', 'SalaryController@calculate');

    Route::put('/salary/close', 'SalaryController@close');


    /* UserAdvance routes */
    Route::get('/advance/index', 'AdvanceController@index');

    Route::post('/advance/refresh', 'AdvanceController@refresh');

    Route::post('/advance/calculate', 'AdvanceController@calculate');

    Route::put('/advance/close', 'AdvanceController@close');

    /* UserVacationPayments routes */
    Route::get('/vacation/index', 'VacationController@index');

    /* Export routes */
    Route::get('/export/index', 'ExportController@index');

    Route::get('/export/get-salary-template', 'ExportController@getSalaryTemplate');

    Route::get('/export/get-advance-template', 'ExportController@getAdvanceTemplate');

    Route::get('/export/get-individual-template', 'ExportController@getIndividualTemplate');

});