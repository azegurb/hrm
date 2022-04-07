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

Route::get('/main' , 'RatingPagesController@index');

Route::get('/criterias' , 'RatingPagesController@criterias');

Route::get('/assessment/criteriaDetails' , 'RatingPagesController@details');

Route::get('/criteria/details/info' , 'RatingPagesController@getDetails');

Route::get('/assessment' , 'RatingPagesController@assessment');

Route::get('/yearly' , 'RatingPagesController@yearly');\

/**
 * Yearly View
 */
Route::get('/yearlyView' , 'RatingPagesController@yearlyView');

Route::post('/post' , 'RatingPagesController@post');

Route::get('assessment/waitForConfirm' , 'RatingPagesController@getNot');

Route::get('assessment/confirm' , 'RatingPagesController@confirmation');

Route::get('assessment/reject' , 'RatingPagesController@rejection');
