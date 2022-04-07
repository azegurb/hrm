<?php


/*******************************
 *
 *          StaffTable
 *
 * *****************************
 * */

Route::group(['namespace' => 'StaffTable', 'prefix' => 'staff-table'], function () {

    /*
    |---------------------------------------------------
    | Ştat cədvəli
    |---------------------------------------------------
    |
    | [DB] table name = --Position
    |
    */
    Route::get('changed-state-persons' , 'ChangedUserStateController@index');

    Route::get('getpaymenttypes', 'PositionController@getPaymentTypes');

    Route::get('getpaymenttypesByUserId', 'PositionController@getPaymentTypesByUserId');

    // Structures Controller
    Route::resource('/structures', 'StructuresController');

    Route::get('/', [
        'as' => 'position.index',
        'uses' => 'PositionController@index'
    ]);

    Route::post('/', [
        'as' => 'position.store',
        'uses' => 'PositionController@store'
    ]);

    Route::put('/{position}', [
        'as' => 'position.update',
        'uses' => 'PositionController@update'
    ]);

    Route::get('/{position}/edit', [
        'as' => 'position.edit',
        'uses' => 'PositionController@edit'
    ]);

    Route::delete('/{position}', [
        'as' => 'position.destroy',
        'uses' => 'PositionController@destroy'
    ]);

    /*
    |---------------------------------------------------
    | Vəzifə adları
    |---------------------------------------------------
    |
    | [DB] table name = --Position
    |
    */

    Route::get('/list-positions-names/{structureId?}', [
        'as' => 'position-names.list',
        'uses' => 'PositionController@listPositionNames'
    ]);

    Route::get('/list-positions-names-search/{structureId?}', [
        'as' => 'position-names-search.list',
        'uses' => 'PositionController@listPositionNamesSearch'
    ]);

    Route::get('/list-positions-namesn/', [
        'as' => 'position-namesn.list',
        'uses' => 'PositionController@listPositionNamesN'
    ]);


    Route::get('get-position-by-user/{user}', 'PositionController@getPositionDetailsByUserId');

    /*
    |---------------------------------------------------
    | Struktur bölmə
    |---------------------------------------------------
    |
    | [DB] table name = --Structures
    | */

    Route::get('/list-structures/{term?}', [
        'as' => 'structures.list',
        'uses' => 'StructureController@listStructures'
    ]);

    Route::put('/change-structure-parent/{id}', [
        'as' => 'structure.change-parent',
        'uses' => 'StructureController@changeParent'
    ]);

    // Get List Structure Type
    Route::get('/list-structures-type', [
        'as' => 'structures.type',
        'uses' => 'StructureController@listStructureType'
    ]);

    /*
    |---------------------------------------------------
    | Vəzifə təsnifatı
    |---------------------------------------------------
    |
    | [DB] table name = --ListPositionClassification
    | */

    Route::get('/list-position-classifications', [
        'as' => 'position-classification.list',
        'uses' => 'PositionClassificationController@listPositionClassifications'
    ]);


    Route::get('/tree', 'StructuresController@tree');
    Route::get('/treea', 'StructuresController@treea');

    /*
    |---------------------------------------------------
    | Vəzifə maaşı
    |---------------------------------------------------
    |
    | [DB] table name = --RelPositionPayment
    |
    */

    Route::get('/get-position-payment/{positionId?}/{structureId?}', [
        'as'    => 'position-payment.get',
        'uses'  => 'RelPositionPaymentController@getPositionPaymentsByPositionNameId'
    ]);

    /*
   |---------------------------------------------------
   | Əməkdaş maaşı
   |---------------------------------------------------
   |
   | [DB] table name = --RelUserPayments
   |
   */

    /* user payment by userId and paymentTypeLabel */
    Route::get('/get-individual-user-payment/{userId}/{paymentTypeLabel}', [
        'as'   => 'individual-user-payment.get',
        'uses' => 'RelUserPaymentsController@getUserPaymentByUser'
    ]);

    /* get all user payments */
    Route::get('/user-payments/{userId}', [
        'as'    => 'user-payments.get',
        'uses'  => 'RelUserPaymentsController@getAllUserPayments'
    ]);

    Route::get('/get-pos-data/{positionId?}', [
        'as' => 'posData',
        'uses' => 'RelPositionPaymentController@getPosData'
    ]);

});