<?php

/*
    |-----------------------------------------------------
    |  All orders routes
    |-----------------------------------------------------
    */
Route::group(['namespace' => 'Orders', 'prefix' => 'orders'], function () {

    /*
    |---------------------------------------------------
    | Əmrlər
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */

    Route::get('/', [
        'as' => 'orders.index',
        'uses' => 'OrderController@index'
    ]);

    Route::get('/create', [
        'as' => 'orders.create',
        'uses' => 'OrderController@create'
    ]);

    Route::get('/{order}/edit', [
        'as' => 'orders.edit',
        'uses' => 'OrderController@edit'
    ]);

    Route::put('/{order}', [
        'as' => 'orders.update',
        'uses' => 'OrderController@update'
    ]);

    Route::post('/', [
        'as' => 'orders.store',
        'uses' => 'OrderController@store'
    ]);

    Route::delete('/{order}', [
        'as' => 'orders.destroy',
        'uses' => 'OrderController@destroy'
    ]);

    Route::get('list-orders', [
        'as' => 'orders.select',
        'uses' => 'OrderController@listOrders'
    ]);

    Route::post('gen-file', 'OrderController@genFile');

    Route::post('gen-download', 'OrderController@fileDownload');

    /*
    |---------------------------------------------------
    | Modal Routes
    |---------------------------------------------------
    |
    */
    Route::get('/common-modal', [
        'as' => 'common-modal',
        'uses' => 'OrderTypeController@listOrderTypes'
    ]);

    Route::get('/get-order-type-name/{id}', 'OrderTypeController@getOrderTypeNameById');

    // Business Trip
    Route::get('/business-trip', 'ModalController@business_trip');

    // Appointment
    Route::get('/appointment', 'ModalController@appointment');

    // Assignment
    Route::get('/assignment', 'ModalController@assignment');

    //Dismissal
    Route::get('/dismissal', 'ModalController@dismissal');

    //replacement
    Route::get('/replacement', 'ModalController@replacement');

    //reward
    Route::get('/reward', 'ModalController@reward');

    //damage
    Route::get('/damage-compensation', 'ModalController@damage_compensation');

    //salaryDeduction
    Route::get('/salary-deduction', 'ModalController@salary_deduction');

    //salaryDeduction
    Route::get('/salary-addition', 'ModalController@SalaryAddition');

    //warning
    Route::get('/warning', 'ModalController@warning');

    //financialAid
    Route::get('/financialAid', 'ModalController@financialAid');

    //additional work time
    Route::get('/additionalWorkTime', 'ModalController@additionalWorkTime');

    //nonWorkingDaysSelection
    Route::get('/nonWorkingDaysSelection', 'ModalController@nonWorkingDaysSelection');

    //compensationForVacationDays
    Route::get('/compensationForVacationDays', 'ModalController@compensationForVacationDays');

    //discipline
    Route::get('/discipline', 'ModalController@discipline');


    Route::get('/get-dismissal-types', 'ListDismissalTypeController@getListDismissalTypes');

    //add new state
    Route::get('/addState', 'ModalController@addState');

    // remove State
    Route::get('/removeState', 'ModalController@removeState');

    // salaryAddition
    Route::get('/orderTransfer', 'ModalController@orderTransfer');

    // vacationRecall
    Route::get('/vacationRecall', 'ModalController@vacationRecall');

    // qualification degree
    Route::get('/QualificationDegree', 'ModalController@QualificationDegree');

    //damage
    Route::get('/damage', 'ModalController@damage');

    /*
     * Əlavə əməkhaqqı (fərdi) - get id by label (individual)
     * */
    Route::get('/get-payment-type-id-by-label/{label}', [
        'as' => 'payment-type-id-by-label.get',
        'uses' => 'PaymentTypeController@getIndividualPaymentId'
    ]);

    // Orders Vacation
    Route::get('/vacation', 'ModalController@vacation');

    /*
    |---------------------------------------------------
    | Əmrin növləri
    |---------------------------------------------------
    |
    | [DB] table name = --ListOrderType
    |
    */
    Route::get('/list-order-types', [
        'as' => 'order-types.list',
        'uses' => 'OrderTypeController@listOrderTypes'
    ]);

    /*
    |---------------------------------------------------
    | Əməkdaşlar
    |---------------------------------------------------
    |
    | [DB] table name = --Users
    |
    */
    Route::get('/list-employees/{positionId?}', [
        'as' => 'employees.list',
        'uses' => 'UserPositionController@listUsers'
    ]);

    Route::get('/list-employees-by-structure/{positionId?}/{structureId?}', [
        'as' => 'employeesbystructure.list',
        'uses' => 'UserPositionController@listUsersByStructures'
    ]);

    /*
    |---------------------------------------------------
    | Ölkə adları
    |---------------------------------------------------
    |
    | [DB] table name = --ListCountry
    |
    */
    Route::get('/list-countries', [
        'as' => 'countries.list',
        'uses' => 'CountryController@listCountries'
    ]);

    /*
    |---------------------------------------------------
    | Şəhər adları
    |---------------------------------------------------
    |
    | [DB] table name = --ListCities
    |
    */
    Route::get('/list-cities/{countryId?}', [
        'as' => 'cities.list',
        'uses' => 'CityController@listCities'
    ]);

    /*
    |---------------------------------------------------
    | Kənd adları
    |---------------------------------------------------
    |
    | [DB] table name = --ListVillages
    |
    */

    Route::get('/list-villages/{cityId?}', [
        'as' => 'villages.list',
        'uses' => 'VillageController@listVillages'
    ]);

    /*
    |---------------------------------------------------
    | Məzuniyyətin tipləri
    |---------------------------------------------------
    |
    | [DB] table name = --ListVacationType
    |
    */
    Route::get('/get-list-vacation-types', [
        'as' => 'vacation-types.list',
        'uses' => 'ListVacationTypeController@getListVacationTypes'
    ]);

    /*
     * ------------------------------------------
     *
     *  Qalıq məzuniyyət günləri
     *
     * ------------------------------------------
     *
     * Custom url = orderCommons/remainingDays?userId={id}&date={date}
     *
     * */

    Route::get('/vacation/get-remaining-days/{user}/{date}', [
        'as'   => 'vacation.remaining-days.get',
        'uses' => 'OrderController@getRemainingVacationDays'
    ]);

    /*
    |---------------------------------------------------
    | Get Position By UserId
    |---------------------------------------------------
    |
    | [DB] table name = --ListVacationType
    |
    */
    Route::get('/get-position-by-userId/{user}', [
        'as' => 'get-position-by-userId.get',
        'uses' => 'UserPositionController@getPosByUserId'
    ]);

});

// order routes for ASAN Centers

Route::group(['namespace' => 'OrdersCenter', 'prefix' => 'orders-s'], function () {

    /*
    |---------------------------------------------------
    | Əmrlər
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */

    Route::get('/', [
        'as' => 'orders-s.index',
        'uses' => 'OrderController@index'
    ]);

    Route::get('/create', [
        'as' => 'orders-s.create',
        'uses' => 'OrderController@create'
    ]);

    Route::get('/{order}/edit', [
        'as' => 'orders-s.edit',
        'uses' => 'OrderController@edit'
    ]);

    Route::put('/{order}', [
        'as' => 'orders-s.update',
        'uses' => 'OrderController@update'
    ]);

    Route::post('/', [
        'as' => 'orders-s.store',
        'uses' => 'OrderController@store'
    ]);

    Route::delete('/{order}', [
        'as' => 'orders-s.destroy',
        'uses' => 'OrderController@destroy'
    ]);

    Route::get('list-orders', [
        'as' => 'orders-s.select',
        'uses' => 'OrderController@listOrders'
    ]);

    Route::post('gen-file', 'OrderController@genFile');

    Route::post('gen-download', 'OrderController@fileDownload');

    /*
    |---------------------------------------------------
    | Modal Routes
    |---------------------------------------------------
    |
    */
    Route::get('/common-modal', [
        'as' => 'common-modal',
        'uses' => 'OrderTypeController@listOrderTypes'
    ]);

    Route::get('/get-order-type-name/{id}', 'OrderTypeController@getOrderTypeNameById');

    // Business Trip
    Route::get('/business-trip', 'ModalController@business_trip');

    // Appointment
    Route::get('/appointment', 'ModalController@appointment');

    // Assignment
    Route::get('/assignment', 'ModalController@assignment');

    //Dismissal
    Route::get('/dismissal', 'ModalController@dismissal');

    Route::get('/getUserRelatedData',['uses' => 'OrderDismissalController@getUserRelatedData' ,'as' => 'getUserRelatedData']);

    //replacement
    Route::get('/replacement', 'ModalController@replacement');

    //reward
    Route::get('/reward', 'ModalController@reward');

    //damage
    Route::get('/damage-compensation', 'ModalController@damage_compensation');

    //salaryDeduction
    Route::get('/salary-deduction', 'ModalController@salary_deduction');

    //warning
    Route::get('/warning', 'ModalController@warning');

    //financialAid
    Route::get('/financialAid', 'ModalController@financialAid');

    //additional work time
    Route::get('/additionalWorkTime', 'ModalController@additionalWorkTime');

    //nonWorkingDaysSelection
    Route::get('/nonWorkingDaysSelection', 'ModalController@nonWorkingDaysSelection');

    //compensationForVacationDays
    Route::get('/compensationForVacationDays', 'ModalController@compensationForVacationDays');

    //discipline
    Route::get('/discipline', 'ModalController@discipline');


    Route::get('/get-dismissal-types', 'ListDismissalTypeController@getListDismissalTypes');

    //add new state
    Route::get('/addState', 'ModalController@addState');

    // remove State
    Route::get('/removeState', 'ModalController@removeState');

    // salaryAddition
    Route::get('/orderTransfer', 'ModalController@orderTransfer');

    // vacationRecall
    Route::get('/vacationRecall', 'ModalController@vacationRecall');

    // qualification degree
    Route::get('/QualificationDegree', 'ModalController@QualificationDegree');

    //damage
    Route::get('/damage', 'ModalController@damage');

    /*
     * Əlavə əməkhaqqı (fərdi) - get id by label (individual)
     * */
    Route::get('/get-payment-type-id-by-label/{label}', [
        'as' => 'payment-type-id-by-label.get',
        'uses' => 'PaymentTypeController@getIndividualPaymentId'
    ]);

    // Orders Vacation
    Route::get('/vacation', 'ModalController@vacation');

    /*
    |---------------------------------------------------
    | Əmrin növləri
    |---------------------------------------------------
    |
    | [DB] table name = --ListOrderType
    |
    */
    Route::get('/list-order-types', [
        'as' => 'order-types-center.list',
        'uses' => 'OrderTypeController@listOrderTypes'
    ]);

    /*
    |---------------------------------------------------
    | Əməkdaşlar
    |---------------------------------------------------
    |
    | [DB] table name = --Users
    |
    */
    Route::get('/list-employees/{positionId?}', [
        'as' => 'employees.list',
        'uses' => 'UserPositionController@listUsers'
    ]);

    Route::get('/list-employees-by-structure/{positionId?}/{structureId?}', [
        'as' => 'employeesbystructure.list',
        'uses' => 'UserPositionController@listUsersByStructures'
    ]);

    Route::get('/getarch/{userid}', 'OrderController@getArch');

    Route::get('/get-sabbatical-leave', 'OrderController@getSabbaticalLeave');

    Route::get('/partialpaid-social-vacation/{userid}', 'OrderController@partialPaidSocialVacation');

    Route::get('/get-sabbatical-child-count/{label}', 'OrderController@getSabbaticalChildCount');

    Route::get('/get-sabbatical-leave-search/{listvacationtypeid}/', 'OrderController@getSabbaticalLeaveSearch');

    Route::get('/get-collective-aggrement/{userid}/{periodfrom}/{periodto}', 'OrderController@getCollectiveAggrement');

    Route::get('/get-sabbatical-vacation-days/{type}/{userid}/', 'OrderController@getSabbaticalVacationDays');

    Route::get('/get-additional-vacation-days/{userid}', 'OrderController@getAdditionalVacationDays');

    Route::get('/get-last-vacation-days/{userid}/{ordercommonid}', 'OrderController@getPermanentVacation');

    Route::get('/calculatevacationday/{totalday}/{vacationstartday}/{userid}', 'OrderController@calculateVacationDay');

    Route::get('/calculatevacationday2/{startdate}/{enddate}/{userid}', 'OrderController@calculateVacationDay2');

    Route::get('/count-days/{type}/{amount}/{startdate}', 'OrderController@countVacationDay');

    /*
    |---------------------------------------------------
    | Ölkə adları
    |---------------------------------------------------
    |
    | [DB] table name = --ListCountry
    |
    */
    Route::get('/list-countries', [
        'as' => 'countries.list',
        'uses' => 'CountryController@listCountries'
    ]);

    /*
    |---------------------------------------------------
    | Şəhər adları
    |---------------------------------------------------
    |
    | [DB] table name = --ListCities
    |
    */
    Route::get('/list-cities/{countryId?}', [
        'as' => 'cities.list',
        'uses' => 'CityController@listCities'
    ]);

    /*
    |---------------------------------------------------
    | Kənd adları
    |---------------------------------------------------
    |
    | [DB] table name = --ListVillages
    |
    */

    Route::get('/list-villages/{cityId?}', [
        'as' => 'villages.list',
        'uses' => 'VillageController@listVillages'
    ]);

    /*
    |---------------------------------------------------
    | Məzuniyyətin tipləri
    |---------------------------------------------------
    |
    | [DB] table name = --ListVacationType
    |
    */
    Route::get('/get-list-vacation-types', [
        'as' => 'vacation-types.list',
        'uses' => 'ListVacationTypeController@getListVacationTypes'
    ]);

    /*
     * ------------------------------------------
     *
     *  Qalıq məzuniyyət günləri
     *
     * ------------------------------------------
     *
     * Custom url = orderCommons/remainingDays?userId={id}&date={date}
     *
     * */

    Route::get('/vacation/get-remaining-days/{user}/{date}', [
        'as'   => 'vacation.remaining-days.get',
        'uses' => 'OrderController@getRemainingVacationDays'
    ]);

    /*
    |---------------------------------------------------
    | Get Position By UserId
    |---------------------------------------------------
    |
    | [DB] table name = --ListVacationType
    |
    */
    Route::get('/get-position-by-userId/{user}', [
        'as' => 'get-position-by-userId.get',
        'uses' => 'UserPositionController@getPosByUserId'
    ]);

});

