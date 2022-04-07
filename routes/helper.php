<?php

Route::group(['namespace'=>'HelperLists', 'prefix'=>'helper-lists'], function(){

    Route::get('/', [
        'as'    => 'helper-list.index',
        'uses'  => 'GeneralController@index'
    ]);
    /*
    |---------------------------------------------------
    | Vəzifə adları
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('position-names', 'PositionNamesController');

    Route::get('position-select/{id}' , 'PositionNamesController@positionSelect');

    Route::get('/list-position-names', 'PositionNamesController@listPositionNames');

    /*
    |---------------------------------------------------
    | Elmi adlar
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('academic-names', 'AcademicNamesController');

    /*
    |---------------------------------------------------
    | Elmi istiqamətlər
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('academic-directions', 'AcademicDirectionsController');

    /*
    |---------------------------------------------------
    | Təhsil müəssisələri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('educational-institutions', 'EducationalInstitutionsController');

    Route::get('list-educational-type-controller',
        [
            'as'    => 'listEducationalTypeController.get',
            'uses'  => 'EducationalInstitutionsController@educationalType'
        ] );

    /*
    |---------------------------------------------------
    | Təhsil növləri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('educational-types', 'EducationalTypesController');

    /*
    |---------------------------------------------------
    | Təhsil səviyyələri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('educational-levels', 'EducationalLevelsController');

    /*
    |---------------------------------------------------
    | Dillər
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('languages', 'LanguagesController');

    /*
    |---------------------------------------------------
    | Bilik səviyyələri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('knowledge', 'KnowledgeController');

    /*
    |---------------------------------------------------
    | Sertifikat adarı
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('certificate-names', 'CertificateNamesController');

    /*
    |---------------------------------------------------
    | Mükafat növləri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('award-types', 'AwardTypesController');

    /*
    |---------------------------------------------------
    | Təlim növləri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('training-types', 'TrainingTypesController');

    /*
    |---------------------------------------------------
    | Təlim formaları
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('training-forms', 'TrainingFormsController');

    /*
    |---------------------------------------------------
    | İcazə səbəbləri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('permission-reasons', 'PermissionReasonsController');

    /*
    |---------------------------------------------------
    | Müsabiqə növləri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('contest-types', 'ContestTypesController');

    /*
    |---------------------------------------------------
    | Müsabiqənin nəticələri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('contest-results', 'ContestResultsController');

    /*
    |---------------------------------------------------
    | Müsabiqənin nəticələri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('dismissal', 'DismissalController');

    /*
    |---------------------------------------------------
    | Əmək müqavilələri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('labor-contracts', 'LaborContractsController');

    Route::get('labor-contracts/select/{civil}', [
        'as'    => 'labor-contracts-select',
        'uses'  => 'LaborContractsController@laborContractsSelect'
    ]);

    /*
    |---------------------------------------------------
    | İxtisas dərəcələri adları
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('qualification-names', 'QualificationNamesController');

    /*
    |---------------------------------------------------
    | İxtisas dərəcələri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('qualification', 'QualificationController');

    Route::get('list-qualification-type-controller',
        [
            'as'    => 'listQualificationType.get',
            'uses'  => 'QualificationController@listQualificationType'
        ] );

    Route::get('list-pos-classification-controller',
        [
            'as'    => 'listPositionClassification.get',
            'uses'  => 'QualificationController@listPositionClassification'
        ] );
    /*
    |---------------------------------------------------
    | Dövlət təltifləri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('state-awards', 'StateAwardsController');

    /*
    |---------------------------------------------------
    | Xüsusi rütbə növləri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('rank-types', 'RankTypesController');

    Route::get('list-rank-type-controller',
        [
            'as'    => 'listRankTypeController.get',
            'uses'  => 'RankTypesController@rankType'
        ] );

    /*
    |---------------------------------------------------
    | Təminatlar
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('provision', 'ProvisionController');

    /*
    |---------------------------------------------------
    | Vəzifə təminatları
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('position-provisions', 'PositionProvisionsController');

    Route::get('get-provision-list/{positionId?}', [
        'as'    => 'provisions.get',
        'uses'  => 'ProvisionController@getProvisionList'
    ]);

    Route::get('get-provisions-by-position/{positionId?}', [
        'as'    => 'provisions.get',
        'uses'  => 'PositionProvisionsController@getProvisions'
    ]);

    Route::get('get-provisions-by-positionn/{positionId?}', [
        'as'    => 'provisions.gett',
        'uses'  => 'PositionProvisionsController@getProvisionss'
    ]);

    /*
    |---------------------------------------------------
    | Qeyri iş günləri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('non-work-days', 'NonWorkDaysController');

    /*
    |---------------------------------------------------
    | Cəza növləri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('punishment', 'PunishmentController');


    /*
    |---------------------------------------------------
    | Növbələr
    |---------------------------------------------------
    |
    | [DB] table name = ListShift
    |
    */
    Route::resource('list-shift', 'ListShiftController');

    /*
    |---------------------------------------------------
    | Növbələr
    |---------------------------------------------------
    |
    | [DB] table name = ShiftInWeekDay
    |
    */
    Route::resource('shift-in-week-day', 'ShiftInWeekDayController');

    Route::resource('periodic-shift-detail', 'PeriodicShiftDetailController');

    Route::get('get-shift-slide-panel', 'ShiftInWeekDayController@getSlidePanel');

    /*
    |---------------------------------------------------
    | Təlim adları
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('training-names', 'TrainingNamesController');

    Route::get('list-training-type-controller',
        [
            'as'    => 'listTrainingTypeController.get',
            'uses'  => 'TrainingNamesController@trainingType'
        ] );
    /*
    |---------------------------------------------------
    | Orqanizasiya adları
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('organizations', 'ListOrganizationController');

    /*
    |---------------------------------------------------
    | Orqanizasiyalara struktur əlavə etmək üçün səhifə
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('organizationstructures', 'ListOrgStructuresController');

    Route::get('org-name-select/{term?}', [
        'as'    => 'org-name-select',
        'uses'  => 'ListOrganizationController@orgNameSelect'
    ]);

    /* Structure by Organizations */
    Route::get('str-by-org-select/{id?}', [
        'as'    => 'str-by-org-select',
        'uses'  => 'ListOrgStructuresController@structureSelect'
    ]);

    /*
    |---------------------------------------------------
    | Ölkələr
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */

    Route::resource('countries', 'CountriesController');

    /*
    |---------------------------------------------------
    | Şəhərlər
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('cities', 'CitiesController');

    Route::get('list-countries-controller',
        [
            'as'    => 'listCountriesController.get',
            'uses'  => 'CitiesController@countries'
        ]);

    /*
    |---------------------------------------------------
    | Ölkələr
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */

    Route::resource('villages', 'VillagesController');

    /*
    |---------------------------------------------------
    | Ölkə, şəhər və rayonlar
    |---------------------------------------------------
    |
    | [DB] table name = --ListRegions
    |
    */

    Route::resource('regions', 'RegionsController');

    // list regions
    Route::get('/list-regions', 'RegionsController@listRegions');

    // region types
    Route::get('/list-region-types', 'RegionsController@listRegionTypes');

    /*
    |---------------------------------------------------
    | Qohumluq Əlaqələri
    |---------------------------------------------------
    |
    | [DB] table name = --
    |
    */
    Route::resource('relation-types', 'RelationTypesController');

    /*
    |---------------------------------------------------
    | İstehsalat cədvəli
    |---------------------------------------------------
    |
    | [DB] table name = --ProductionCalendar
    |
    */

    Route::resource('prod-calendar', 'ProdCalendarController');

});

