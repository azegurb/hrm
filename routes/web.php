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


Route::group( ['middleware' => 'hr.auth'] , function(){
    // Temporarily Redirect to Dashboard
    Route::get('/', function () {
        return redirect()->to('/personal-cards');
    });

    Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard'], function (){

        Route::get('/' , 'DashboardController@index');

        Route::get('/user-info/{id}' , 'DashboardController@show');

    });



    /*******************************
     *
     *          Salary
     *
     * *****************************
     * */
    Route::group(['namespace' => 'Salary', 'prefix' => 'salary'], function (){

        Route::get('/', [
            'as'    => 'salary.index',
            'uses'  => 'GeneralController@index'
        ]);

        Route::get('/get-str-by-user/{id?}', 'AdvanceController@getStrNameByUserId');


        Route::resource('salary_vacation', 'SalaryVacationController');

        Route::resource('privileges', 'PrivilegesController');

        Route::resource('advance', 'AdvanceController');

        Route::get('/list-user-by-structure/{structureId?}', [
            'as'   => 'usersByStructure.list',
            'uses' => 'PrivilegesController@getUserByStructure'
        ]);


//        Route::get('/advance',[
//            'as' => 'salary.advance.index',
//            'uses' => 'AdvanceController@index'
//        ]);

    });


    /*******************************
     *
     *          PersonalCards
     *
     * *****************************
     * */
    Route::get('personal-cards/', [
        'as'    => 'personal-cards.index',
        'uses'  => 'PersonalCards\GeneralController@index'
    ]);


    Route::group(['namespace'=>'PersonalCards', 'prefix'=>'personal-cards' , 'middleware' => 'hr.selected'], function(){

        /*
        |---------------------------------------------------
        | Əmək fəaliyyəti
        |---------------------------------------------------
        |
        | [DB] table name = --
        |
        */

//
//        Route::get('changed-state-persons' , [
//            'uses' => 'ChangedStateUserController@index',
//            'as'   => 'changed-user-state.index'
//        ]);


        Route::resource('work-experience', 'WorkExperienceController');

        Route::get('/work-exp-confirmation/{id}/{isc}/{ccId}' , 'WorkExperienceController@confirmationPOST');


        Route::get('work-experiences/get-file/{userPosition}/{user}' , [
            'uses' => 'WorkExperienceController@getFile',
            'as'   => 'work-experiences.get-file'
        ]);
        Route::get('checkedStatement' , [
            'uses' => 'WorkExperienceController@checkedStatement',
        ]);

        Route::get('uncheckedStatement' , [
            'uses' => 'WorkExperienceController@uncheckedStatement',
        ]);

        Route::get('orderAppointments/{orderNum}' , [
            'uses' => 'WorkExperienceController@orderAppointments',
        ]);
        Route::get('orderAppointments/{orderNum}/get/data' , [
            'uses' => 'WorkExperienceController@orderAppointmentsGetById',
        ]);

        Route::get('get-select/for-position' , [
            'uses' => 'WorkExperienceController@positionGetSelect',
            'as'   => 'position-get-select',
        ]);


        /*
         *
         * Azer wrote
         */

        Route::get('get-month/' , [
            'as' => 'get.month',
            'uses' => 'SpecialWorkGraphicsController@getMonth',
        ]);
        /*
        |---------------------------------------------------
        | Xüsusi iş qrafiki
        |---------------------------------------------------
        |
        | [DB] table name = --
        |
        */
        Route::resource('special-work-graphics', 'SpecialWorkGraphicsController');

        Route::get('special-work-shift' , [
            'as' => 'shift.get',
            'uses' => 'SpecialWorkGraphicsController@getShift',
        ]);
        Route::post('special-work-connect-to-user' , [
            'as' => 'specialWorkConnectToUser',
            'uses' => 'SpecialWorkGraphicsController@userShift',
        ]);
        Route::post('special-work-reconnect-to-user' , [
            'as' => 'specialWorkReConnectToUser',
            'uses' => 'SpecialWorkGraphicsController@userShiftRe',
        ]);


        /*
        |---------------------------------------------------
        | Əlaqə vasitələri
        |---------------------------------------------------
        |
        | [DB] table name = userContact
        | [Hibernate] Entity Name = UserContact
        |
        */
        Route::resource('contacts', 'UserContactController');
        Route::get('/contact-confirm/{id}/{isc}/' , 'UserContactController@confirmationPOST');


        /*
        |---------------------------------------------------
        | Əlaqə vasitələri
        |---------------------------------------------------
        |
        | [DB] table name = userContact
        | [Hibernate] Entity Name = UserContact
        |
        */
        Route::resource('provision', 'UserProvisionController');
        Route::resource('salaryperson', 'SalaryPersonController');

        Route::get('provision-get' ,['as' => 'provision-get' , 'uses' => 'UserProvisionController@listProvision']);

        Route::get('/provision-confirmation/{id}/{isc}/{ccId}' , 'UserProvisionController@confirmationPOST');



        /*
        |   Select class = listContactType
        |   [Hibernate] Entity Name = ListContactType
        |
        */
        Route::get('list-contact-controller',
        [
            'as'    => 'listContactController.get',
            'uses'  => 'UserContactController@contactType'
        ] );
        /*
        |---------------------------------------------------
        | İcazələr
        |---------------------------------------------------
        |
        | [DB] table name = requestForPermission
        |
        */
        Route::resource('permission', 'RequestForPermissionController');
        Route::get('permissions/permission_reasons', [
            'as'    => 'permission.permissionReasons',
            'uses'  => 'RequestForPermissionController@permissionReasons'
        ]);
        Route::get('permissions/permission-users', [
            'as'    => 'permission.permissionUsers',
            'uses'  => 'RequestForPermissionController@permissionUsers'
        ]);
        /*
        |---------------------------------------------------
        | Tapşırıqlar
        |---------------------------------------------------
        |
        | [DB] table name = --
        |
        */
        #Route::resource('link', 'controller');

        /*
        |---------------------------------------------------
        | File Download
        |---------------------------------------------------
        |
        | [DB] table name = --
        |
        */
        #Route::resource('link', 'controller');
        Route::get('personal-cards/filedownload/{id}' , 'UserDocumentController@fileD' );
        Route::post('personal-cards/download' , 'UserDocumentController@download' );

        /*
        |---------------------------------------------------
        | Maaş
        |---------------------------------------------------
        |
        | [DB] table name = Via 1C API
        |
        */
        Route::resource('Salary', 'SalariesController');



        /*
        |---------------------------------------------------
        | Dövlət qulluğunu keçməsi
        |---------------------------------------------------
        |
        | [DB] table name = attestation
        |
        */
        Route::resource('attestation', 'AttestationController');
        /*
       |   Select class = listContactType
       |   [Hibernate] Entity Name = ListContactType
       |
       */
        Route::get('attestations/attestation-types', [
            'as'    => 'attestation.attestationTypes',
            'uses'  => 'AttestationController@attestationTypes'
        ]);
        Route::get('attestations/attestation-results', [
            'as'    => 'attestation.attestationResults',
            'uses'  => 'AttestationController@attestationResults'
        ]);
        /*
        |---------------------------------------------------
        | İxtisas dərəcəsi
        |---------------------------------------------------
        |
        | [DB] table name = userQualificationDegree
        |
        */
        Route::resource('qualification-degree', 'UserQualificationDegreeController');

        Route::get('/qualification-confirm/{id}/{isc}/' , 'UserQualificationDegreeController@confirmationPOST');

        Route::get('qualifications/list-position-classifications', [
            'as'    => 'qualifications.positionClassifications',
            'uses'  => 'UserQualificationDegreeController@positionClassifications'
        ]);

        Route::get('qualifications/list-qualification-types/{id?}', [
            'as'    => 'qualifications.qualificationTypes',
            'uses'  => 'UserQualificationDegreeController@qualificationTypes'
        ]);

        /*
        |---------------------------------------------------
        | Xüsusi rütbə
        |---------------------------------------------------
        |
        | [DB] table name = userrank
        |
        */
        Route::resource('user-rank', 'UserRankController');
        Route::get('ranks/list-special-ranks/{id?}', [
            'as'    => 'ranks.specialRanks',
            'uses'  => 'UserRankController@specialRanks'
        ]);
        Route::get('ranks/list-special-rank-types', [
            'as'    => 'ranks.specialRankTypes',
            'uses'  => 'UserRankController@specialRankTypes'
        ]);
        /*
        |---------------------------------------------------
        | Təhsili
        |---------------------------------------------------
        |
        | [DB] table name = userEducation
        |
        */
        Route::resource('education', 'UserEducationController');

        Route::get('/education-confirm/{id}/{isc}/' , 'UserEducationController@confirmationPOST');

        Route::get('educations/list-educational-institutions', [
            'as'    => 'education.educationalInstitutions',
            'uses'  => 'UserEducationController@educationalInstitutions'
        ]);

        Route::get('educations/list-education-forms', [
            'as'    => 'education.educationForms',
            'uses'  => 'UserEducationController@educationForms'
        ]);
        Route::get('educations/list-education-levels', [
            'as'    => 'education.educationLevels',
            'uses'  => 'UserEducationController@educationLevels'
        ]);
        /*
        |---------------------------------------------------
        | Biliklər / Sertifikatlar
        |---------------------------------------------------
        |
        | [DB] table name = userLanguage (Dil bilikləri)
        | [DB] table name = userITKnowledges (Komputer bilikləri)
        | [DB] table name = userCertificate (Sertifikatlar)
        |
        */
        Route::resource('language', 'UserLanguageController');
        Route::get('list-language-controller',
            [
                'as' => 'listLanguageController.get',
                'uses' => 'UserLanguageController@languageList'
            ]

        );

        Route::get('list-knowledgeLevel-controller',
            [
                'as'   => 'listKnowledgeLevelController.get',
                'uses' => 'UserLanguageController@knowledgeLevelList'
            ]
        );

        Route::resource('it-knowledge', 'UserItKnowledgeController');

        Route::get('list-it-knowledgeLevel-controller',
            [
                'as'   => 'listItKnowledgeLevelController.get',
                'uses' => 'UserItKnowledgeController@itKnowledgeLevelList'
            ]
        );

        Route::get('itknowledge-controller',
            [
                'as'   => 'itKnowledgeController.get',
                'uses' => 'UserItKnowledgeController@itKnowledge'
            ]
        );


        Route::resource('certificates', 'UserCertificateController');



        /*
        |---------------------------------------------------
        | Elmi dərəcə
        |---------------------------------------------------
        |
        | [DB] table name = userAcademicDegree
        |
        */
        Route::resource('academic-degree', 'UserAcademicDegreeController');

        Route::get('list-academic-degree-controller',
            [
                'as'    => 'listAcademicDegree.get',
                'uses'  => 'UserAcademicDegreeController@academicDegree'
            ] );

        Route::get('list-academic-area-controller',
            [
                'as'    => 'listAcademicArea.get',
                'uses'  => 'UserAcademicDegreeController@academicArea'
            ] );

        /*
        |---------------------------------------------------
        | Dövlət təltifləri / Fərdi mükafatlar
        |---------------------------------------------------
        |
        | [DB] table name = userRewardGov (Dovlet teltifleri)
        | [DB] table name = userRewardHonor (Fexri adlar)
        | [DB] table name = userRewardIndividual (Ferdi mukafatlar)
        |
        */
        Route::resource('reward-gov', 'UserRewardGovController');
        // Get listRewardGovNameId Select
        Route::get('list-reward-gov-name-get',[
            'as'    => 'listRewardGovNameId.get',
            'uses'  => 'UserRewardGovController@listRewardGovNameId'
        ]);
        Route::resource('reward-honor', 'UserRewardHonorController');
        Route::get('list-reward-honor-name-get',[
            'as'    => 'listRewardHonorNameId.get',
            'uses'  => 'UserRewardHonorController@listRewardHonorNameId'
        ]);

        Route::resource('reward-individual', 'UserRewardIndividualController');
        Route::get('list-reward-individual-name-get',[
            'as'    => 'listRewardIndividualNameId.get',
            'uses'  => 'UserRewardIndividualController@listRewardIndividualNameId'
        ]);

        /*
        |---------------------------------------------------
        | İntizam məsuliyyəti
        |---------------------------------------------------
        |
        | [DB] table name = userDisciplinaryAction
        |
        */
        Route::resource('disciplinary', 'UserDisciplinaryController');

        Route::get('/disciplinary-confirm/{id}/{isc}/' , 'UserDisciplinaryController@confirmationPOST');

        Route::get('disciplinary-type' ,['as' => 'disciplinary-type' , 'uses' => 'UserDisciplinaryController@getType'] );
        Route::get('list-disciplinary-action-type-get',[
            'as'    => 'listDisciplinaryActionTypeId.get',
            'uses'  => 'UserDisciplinaryController@listDisciplinaryActionTypeId'
        ]);
        /*
        |---------------------------------------------------
        | İşə davamiyyət
        |---------------------------------------------------
        |
        | [DB] table name = Prosedura ile
        |
        */
        Route::resource('work-attendance', 'WorkAttendanceController');

        /*
        |---------------------------------------------------
        | Qiymətləndirmə
        |---------------------------------------------------
        |
        | [DB] table name = userAssessment
        |
        */
        Route::resource('assessment', 'AssessmentController');

        /*
        |---------------------------------------------------
        | Təlim
        |---------------------------------------------------
        |
        | [DB] table name = userTraining
        |
        */
        Route::resource('training', 'UserTrainingController');

        Route::get('/training-confirmation/{id}/{isc}/{ccId}' , 'UserTrainingController@confirmationPOST');

        Route::get('trainings/list-training-need', [
            'as'    => 'training.need',
            'uses'  => 'UserTrainingController@userTrainingNeedId'
        ]);

        Route::get('trainings/list-training-names', [
            'as'    => 'training.trainingNames',
            'uses'  => 'UserTrainingController@trainingNames'
        ]);

        Route::get('trainings/list-training-forms', [
            'as'    => 'training.trainingForms',
            'uses'  => 'UserTrainingController@trainingForms'


        ]);

        Route::get('trainings/list-training-locations', [
            'as'    => 'training.trainingLocations',
            'uses'  => 'UserTrainingController@trainingLocations'


        ]);

        Route::get('trainings/list-training-types', [
            'as'    => 'training.trainingTypes',
            'uses'  => 'UserTrainingController@trainingTypes'


        ]);
        /*
        |---------------------------------------------------
        | Təlim tələbatı
        |---------------------------------------------------
        |
        | [DB] table name = userTrainingNeed
        |
        */
        Route::resource('training-needs', 'UserTrainingNeedController');

        Route::get('/training-needs-confirm/{id}/{isc}/' , 'UserTrainingNeedController@confirmationPOST');

        Route::get('list-training-names', [
            'as'   => 'training-names.list',
            'uses' => 'UserTrainingNeedController@listTrainingNames'
        ]);

        /*
        |---------------------------------------------------
        | Ezamiyyət
        |---------------------------------------------------
        |
        | [DB] table name = userBusinessTrip
        |
        */
        Route::resource('business-trip', 'UserBusinessTripController');

        /*
        |---------------------------------------------------
        | Məzuniyyət
        |---------------------------------------------------
        |
        | [DB] table name = userVacation
        |
        */
        Route::resource('vocation', 'UserVacationController');
        Route::get('order-vocation-detail/{id}', [
            'uses'  => 'UserVacationController@orderVocationDetail'
        ]);
        Route::get('list-vocation-types', [
            'as'    => 'vocation.vocationTypes',
            'uses'  => 'UserVacationController@vocationTypes'
        ]);
        /*
        |---------------------------------------------------
        | Sənədlər
        |---------------------------------------------------
        |
        | [DB] table name = userDocument
        |
        */
        Route::resource('document', 'UserDocumentController');

        Route::get('document-type' , [
            'as' => 'documtent-type',
            'uses' => 'UserDocumentController@docType'

        ]);

        /*
        |---------------------------------------------------
        | Ailə tərkibi
        |---------------------------------------------------
        |
        | [DB] table name = userFamily
        |
        */
        Route::resource('family', 'UserFamilyController');

        Route::get('/family-confirm/{id}/{isc}/' , 'UserFamilyController@confirmationPOST');

        Route::get('get-family-relation-types', [
            'as'   => 'family-relation-types.list',
            'uses' => 'UserFamilyController@getFamilyRelationTypes'
        ]);

        /*
        |---------------------------------------------------
        | Xüsusi qeydlər
        |---------------------------------------------------
        |
        | [DB] table name = userNote
        |
        */
        Route::resource('note', 'UserNoteController');

        Route::get('/note-confirm/{id}/{isc}/' , 'UserNoteController@confirmationPOST');

        /*
           |---------------------------------------------------
           | Xestelik vereqesi
           |---------------------------------------------------
           |
           | [DB] table name = userSick
           |
           */
        Route::resource('sicklist', 'UserSicklistController');

        /*
        |---------------------------------------------------
        | Digər məlumatlar
        |---------------------------------------------------
        |
        | [DB] table name = userOtherInfo
        |
        */
        Route::resource('other-info', 'UserOtherInfoController');

        Route::get('/other-confirm/{id}/{isc}/' , 'UserContactController@confirmationPOST');

        Route::get('chat', 'ChatController@index');

    });

    /*
    |---------------------------------------------------
    | Users
    |---------------------------------------------------
    |
    | [DB] table name = Users
    |
    */
    // User Modal
    Route::get('users/create' ,         [ 'uses' => 'Auth\UsersController@create', 'as' => 'users.create']);
    // User Insert
    Route::post('users/store' ,         [ 'uses' => 'Auth\UsersController@store', 'as' => 'users.store']);
    // User Update
    Route::post('users/update/{id}' ,    [ 'uses' => 'Auth\UsersController@update', 'as' => 'users.update']);
    // User Destroy
    Route::delete('users/destroy/{id}' ,   [ 'uses' => 'Auth\UsersController@destroy', 'as' => 'users.destroy']);

    //Users Search
    Route::get('users-get' , [ 'uses' => 'Auth\UsersController@users', 'as' => 'users']);

//    //Sabbatical vacation search
//    Route::get('sabbatical-vacation' , [ 'uses' => 'Orders\OrderController@getSabbaticalVacations']);

    // Get User Data By Serial
    Route::get('users/data-by-serial/{serial}' , [ 'uses' => 'Auth\UsersController@serial', 'as' => 'users.serial']);

    // Get Users
    Route::get('get-users/{type}', [
        'as'   => 'users.list',
        'uses' => 'Auth\UsersController@getUsers'
    ]);
    // Get Users
    Route::get('crud-users/', [
        'as'   => 'users.crud',
        'uses' => 'Auth\UsersController@userDataCrud'
    ]);

    // Nationality
    Route::get('users/nationality', [
        'as'   => 'nationality',
        'uses' => 'Auth\UsersController@listNationalityId'
    ]);

    // Family Status
    Route::get('users/family-statusid-name', [
        'as'   => 'family',
        'uses' => 'Auth\UsersController@familyStatusIdName'
    ]);

    // Get User by Id
    Route::get('get-user-by-id/{id}/{type}', [
        'as'   => 'users.show',
        'uses' => 'Auth\UsersController@getUserById'
    ]);

    // Get Auth User
    Route::get('get-auth-user/{type}',[
        'as'   => 'users.auth',
        'uses' => 'Auth\UsersController@getAuthUser'
    ]);

    // Forget Selected User
    Route::get('forget/selected/user' , [
       'uses' => 'Auth\UsersController@userForget'
    ]);

});
Route::get('logout' , function(){
    Cookie::queue(Cookie::forget('SSO-TOKEN', '/', '.portofbaku.com'));
    session()->forget('authUser');
    return redirect('/');
});

Route::get('exsession' , function(){
    return view('errors.403');
});

Route::get('/getposition' , 'StaffTable\PositionController@getPositions');

// Change User Group
Route::get('/change-user-group/{id}' , 'Chairman\ChairmanController@change');