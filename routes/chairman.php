<?php
Route::get('/main' , 'ChairmanController@index');

Route::get('/get/component' , 'ChairmanController@component');

Route::get('/structure/{id}/{structure}' , 'ChairmanController@structure')->name('get.structure');

Route::get('/substructure/{id}' , 'ChairmanController@substructure');

Route::get('/users/cv/{id}' , 'ChairmanController@usersCV');