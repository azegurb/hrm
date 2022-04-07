<?php

namespace App\Http\Controllers\Auth;

use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UsersController extends Controller
{
    //Set Main User to Session (Personal Cards)
    public function setUser($userId){
        session()->forget('selected');
        session(['selected' => (object)[
            'userId' => $userId,
        ]]);
        session()->save();
    }

    // Forget Main User from User (Personal Cards)
    public function userForget()
    {
        session()->forget('selected');
    }

    public function userDataCrud()
    {
        $name = '';
        $last = '';
        $patronymic = '';
        $date = '';
        $marital = '';
        $search = '';
        $gender = '';
        if(!empty(Input::get('name')) && !is_null(Input::get('name'))){
            $name = '"firstName":%7B"contains":"'.Input::get('name').'"%7D';
        }
        if(!empty(Input::get('last'))  && !is_null(Input::get('last'))){
            $last = '"lastName":%7B"contains":"'.Input::get('last').'"%7D';
        }
        if(!empty(Input::get('patronymic')) && !is_null(Input::get('patronymic')) ){
            $patronymic = '"patronymic":%7B"contains":"'.Input::get('patronymic').'"%7D';
        }
        if(!empty(Input::get('gender'))  && !is_null(Input::get('gender')) ){
            if(Input::get('gender') == 1){
                $gender = '"gender":%7B"=":false%7D';
            }elseif (Input::get('gender') == 2){
                $gender = '"gender":%7B"=":true%7D';
            }
        }
        if(!empty(Input::get('marital')) && !is_null(Input::get('marital')) && Input::get('marital') != 'null'){
            $marital = '"familyStatusId.id":%7B"=":"'.Input::get('marital').'"%7D';
        }
        if(!empty(Input::get('startDate')) && Input::get('endDate')){
            $start = !empty(Input::get('startDate')) ? date('Y-m-d' , strtotime(Input::get('startDate'))) : '';
            $end = !empty(Input::get('endDate')) ? date('Y-m-d' , strtotime(Input::get('endDate'))) : '';
            $date = '"birthDate":%7B">":"'.$start.'"%7D,"birthDate":%7B"<":"'.$end.'"%7D';
        }
        $pa = [$name,$last,$patronymic,$date,$gender,$marital];
        foreach ($pa as $p){
            if($p != '') {
                $search .= $p . ',';
            }
        }
        $search = rtrim($search,',');
//        dd($search);
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => [
                    'id',
                    'firstName',
                    'lastName',
                    'patronymic'
                ],
                'filter'  => $search,
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Users'
                ]
            ]
        ]);

        $returnData = [];
        if($data->totalCount > 0){
            foreach ($data->data as $user){
                $name = !empty($user->firstName) ? $user->firstName : '';
                $last = !empty($user->lastName) ? ' '.$user->lastName : '';
                $patronymic = !empty($user->patronymic) ? ' '.$user->patronymic : '';
                $userInfo = $name.$last.$patronymic;
                $returnData[] = (object)[
                    'id' => $user->id,
                    'text' => $userInfo
                ];
            }
        }

        return response()->json($returnData)
            ->header('origin' ,'http://localhost:9090')
            ->header('Access-Control-Allow-Origin','http://localhost:9090',true)
            ->header('Access-Control-Allow-Headers','x-requested-with',true)
            ->header('Access-Control-Allow-Methods','OPTIONS',true)
            ->header('Allow','OPTIONS',true);

    }

    // Get User By User Id
    public function getUserById($id,$type)
    {


        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'id'    => $id,
                'sc'     => [
                    'id',
                    'firstName',
                    'lastName',
                    'patronymic',
                    'birthDate',
                    'birthPlace',
                    'gender',
                    'listNationalityId.name',
                    'listNationalityId.id',
                    'registrationAddress',
                    'familyStatusId.name',
                    'familyStatusId.id',
                    'criminalType',
                    'criminalNote',
                    'ssn',
                    'lastNameBefore',
                    'lastNameBeforeType',
                    'residenceAddress',
                    'docNumber',
                    'docSeries',
                    'pin',
                    'docIssueDate',
                    'docOrgan',
                    'photo',
                    'bankAccount'
                ],
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Users'
                ]
            ]
        ]);
//        dd($data);

//
        $data2 = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id', 'startDate'],
                'filter' => '"userId.id" : %7B "=" : "'.$id.'" %7D,  "isClosed" : %7B "=" : false %7D',
                'order'   => 'desc',
                'sort' => 'dateCreated',
                'max'=>1
            ],

            'options' => [
                'headers' => [
                    'TableName' => 'RelUserTradeUnions'
                ]
            ]
        ]);

        $checkButtons = Service::request([

            'method' => 'POST',
            'url'    => Service::url('csec','Token/checkTokenMany', false),
            'params' => [

            ],
            'options'=> [

                'headers' => ['TableName' => 'ListApplication'],
                'json'    => [
                    "services" => [
                        0 => [
                            "name" => "/crud/users/update",
                            "type" =>  "PUT"
                        ]

                    ]
                ]

            ]
        ]);


//        dd($checkButtons->data->permissions);
        $data->permission=false;
        if(is_array($checkButtons->data->permissions)){

            $data->permission=$checkButtons->data->permissions;
        }

        if(isset($data2->totalCount )){
            $data->data->totalCountAttached = $data2->totalCount;

        }

        if(is_array($data2->data) && !empty($data2->data)){

            $data->data->startDate=date('d.m.Y' , strtotime($data2->data[0]->startDate));
            $data->data->startDateId=$data2->data[0]->id;
        }

        if($data->code == 200 && isset($data->data->birthDate) && isset($data->data->docIssueDate)){
            $data->data->birthDate = date('d.m.Y' , strtotime($data->data->birthDate));
            $data->data->docIssueDate = date('d.m.Y' , strtotime($data->data->docIssueDate));
        }

        if($type == 'select'){
            $select = [];

            return response()->json($select);
        }elseif ($type == 'json'){
            $this->setUser($data->data->id);
            return response()->json($data);
        }elseif ($type == 'rawJson'){
            return json_encode($data);
        }elseif ($type == 'responseHttp'){
            return view('pages.personal_cards.index.components.modal' , compact('data','type'));
        }elseif ($type == 'http'){
            return $data;
        }
//        }catch (\Exception $e){
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//        }
    }

    // Retrieve Auth User
    public function getAuthUser($type)
    {
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','firstName'],
                'id'    => $this->userId
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Users'
                ]
            ]
        ]);
        if($type == 'select'){
            $select = [];

            foreach ($data->data as $item){
                $select[] = (object)[
                    'text' => $item->firstName,
                    'id'  => $item->id,
                ];
            }

            return response()->json($select);
        }
    }

    // Users List
    public function getUsers($type)
    {
        $name = '';
        $last = '';
        $patronymic = '';
//        try{
        $search = '';
        $archive='';
        if($this->search != ''){
            $search = '"firstName":%7B"contains":"'.$this->search.'"%7D';
        }else{
            $search = '';
        }
        if(!empty(Input::get('isArchived'))){
            $archive = '&isArchived='.Input::get('isArchived');
        }
        if ($type == 'select'){
            $request = [
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'     => ['id','firstName','lastName' , 'patronymic'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'Users'
                    ]
                ]
            ];
        }elseif ($type == 'raw' || $type == 'json'){
            if(!empty(Input::get('structureId'))){
                $structurId = Input::get('structureId');
            }else{
                $structurId = '';
            }
            $request = [
                'method'  => 'GET',
                'url'     => Service::url('hr','users/list?offset='.$this->offset.'&max='.$this->limit.'&filter='.$this->search.'&structureId='.$structurId.$archive , false),
                'params'  => [],
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ]
                ]
            ];
        }
//            dd($request);
        $data = Service::request($request);
//        dd($data);
        if($data->totalCount > 0){
            if(is_array($data->data)) {
                foreach ($data->data as $value){
                    $value->id = $value->userId;
                }
            }
        }
        $data->page = $this->page;

        if($type == 'select'){
            $select = [];

            foreach ($data->data as $item){
                $select[] = (object)[
                    'text' => $item->firstName.' '.$item->lastName.' '.$item->patronymic,
                    'id'  => $item->id,
                ];
            }
            return response()->json($select);
        }elseif ($type == 'raw'){
            return $data;
        }elseif ($type == 'json'){

            return response()->json($data);
        }

//        }catch (\Exception $e){
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//        }
    }

    // User Add Modal Initializer
    public function create()
    {
        return view('pages.personal_cards.index.components.modal');
    }

    // User Insert Into Users Table
    public function store(Request $request)
    {
        try{
            if(!empty($request->changedPhoto)){
                $photo = $this->makeBase64($request->changedPhoto);
            }else{
                $photo = $request->photo;
            }

            $data = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'Users'
                    ],
                    'json' => [
                        'docSeries'     => $request->docSeries,
                        'docNumber'     => $request->docNumber,
                        'lastName'      => $request->lastName,
                        'firstName'     => $request->firstName,
                        'patronymic'    => $request->patronymic,
                        'birthDate'     => date('Y-m-d' , strtotime($request->birthDate)),
                        'birthPlace'    => $request->birthPlace,
                        'gender'        => $request->gender == 'M' ? (bool)true : (bool)false,
                        'photo'         => $photo,

                        'familyStatusId' => [
                            'id'    => $request->familyStatusId
                        ],
                        'listNationalityId' => [
                            'id'    => $request->listNationalityId
                        ],
                        'registrationAddress'   => $request->registrationAddress,
                        'ssn'                   => $request->ssn,
                        'residenceAddress'      => $request->residenceAddress,
                        'pin'                   => $request->pin,
                        'docIssueDate'          => date('Y-m-d' , strtotime($request->docIssueDate)),
                        'docOrgan'              => $request->docOrgan,
                        'criminalType'          => !empty($request->criminalType) ? (bool)true : (bool)false,
                        'lastNameBeforeType'    => !empty($request->lastNameBeforeType) ? (bool)true : (bool)false,
                        'lastNameBefore'        => $request->lastNameBefore,
                        'criminalNote'          => $request->criminalNote

                    ]
                ]
            ]);
            return response()->json($data);
        }catch (\Exception $e){
            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return response()->json($response);
        }
    }

    // Update User Data
    public function update(Request $request , $id)
    {

        try{
            // If Has DATA

            $dateStart=$request->startDate;
            if(!empty($request->changedPhoto)){
                $photo = $this->makeBase64($request->changedPhoto);
            }else{
                $photo = $request->photo;
            }

//            dd($request->all());
            $boolean=isset($request->startDateId)?$request->startDateId:false;
            $request1 = [
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'Users'
                    ],
                    'json' => [
                        'id'            => $id,
                        'docSeries'     => $request->docSeries,
                        'docNumber'     => $request->docNumber,
                        'lastName'      => $request->lastName,
                        'firstName'     => $request->firstName,
                        'patronymic'    => $request->patronymic,
                        'birthDate'     => date('Y-m-d' , strtotime($request->birthDate)),
                        'birthPlace'    => $request->birthPlace,
                        'gender'        => $request->gender == 'M' ? (bool)true : (bool)false,
                        'photo'         => $photo,
                        'familyStatusId' => [
                            'id'    => $request->familyStatusId
                        ],
                        'listNationalityId' => [
                            'id'    => $request->listNationalityId
                        ],
                        'registrationAddress'   => $request->registrationAddress,
                        'ssn'                   => $request->ssn,
                        'residenceAddress'      => $request->residenceAddress,
                        'pin'                   => $request->pin,
                        'docIssueDate'          => date('Y-m-d' , strtotime($request->docIssueDate)),
                        'docOrgan'              => $request->docOrgan,
                        'criminalType'          => !empty($request->criminalType) ? (bool)true : (bool)false,
                        'lastNameBeforeType'    => !empty($request->lastNameBeforeType) ? (bool)true : (bool)false,
                        'lastNameBefore'        => $request->lastNameBefore,
                        'criminalNote'          => $request->criminalNote,
                        'bankAccount'           => $request->bankaccount

                    ]
                ]
            ];

//dd($request->all());
            $tradeUnion=(isset($request->isTradeUnion) && $request->isTradeUnion=='on')?true:false;
            //   dd($tradeUnion);
            $dateStart=date('Y-m-d', strtotime($dateStart));
            $selecTedUserid=(isset(selected()->userId))?selected()->userId:$id;

            if($boolean && $tradeUnion){
                $request2 = [
                    'method'  => 'PUT',
                    'url'     => Service::url('hr','crud'),
                    'options' => [
                        'headers' => [
                            'TableName' => 'RelUserTradeUnions'
                        ],
                        'json' => [
                            'id'=>$boolean,
                            'startDate' =>$dateStart,
                            'userId' => [
                                'id'    => $selecTedUserid
                            ]
                        ]
                    ]
                ];
                $data2= Service::request($request2);
            }
            else if(!$boolean && $tradeUnion) {

                $request2 = [
                    'method'  => 'POST',
                    'url'     => Service::url('hr','crud'),
                    'options' => [
                        'headers' => [
                            'TableName' => 'RelUserTradeUnions'
                        ],
                        'json' => [
                            'startDate' =>$dateStart,
                            'userId' => [
                                'id'    => $selecTedUserid
                            ]
                        ]
                    ]
                ];

                $data2= Service::request($request2);
            }
            else if($boolean && !$tradeUnion) {

                $dateEnd=date('Y-m-d', strtotime($request->endDate));
                $request2 = [
                    'method'  => 'PUT',
                    'url'     => Service::url('hr','crud'),
                    'options' => [
                        'headers' => [
                            'TableName' => 'RelUserTradeUnions'
                        ],
                        'json' => [
                            'id'=>$boolean,
                            'endDate' =>$dateEnd,
                            'userId' => [
                                'id'    => $selecTedUserid
                            ],
                            'isClosed'=>true
                        ]
                    ]
                ];

                $data2= Service::request($request2);
            }

            $data = Service::request($request1);

            $data->data->id=$id;

            $data->data->docIssueDate=date('d.m.Y' , strtotime($request->docIssueDate));

            $data->data->birthDate= date('d.m.Y' , strtotime($request->birthDate));

            return response()->json($data);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    // Get User Data from Gov by Serial
    public function serial($serial)
    {
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','iamasRequest/personBySN?serialNum='.$serial , false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);
        $pin = $this->checkPin($data->data->person->pin);
        if($pin == 'same'){

            $data = $this->address($data);

            $data->data->socialStatus->citizenship = $this->nationalityForGovReq($data->data->socialStatus->citizenship);

            return response()->json($data);

        }else{
            return $this->getUserById($pin , 'responseHttp');
        }
    }

    //Generate Proper Address Form
    public function address($data)
    {
        $data->data->userAdress = (object)[];
        $data->data->userAdress = $data->data->address->country . ', ';

        if(!is_null($data->data->address->province))
        {
            $data->data->userAdress .= $data->data->address->province . ', ';
        }

        if(!is_null($data->data->address->city))
        {
            $data->data->userAdress .= $data->data->address->city . ', ';
        }

        $data->data->userAdress .= $data->data->address->street;

        if(!empty($data->data->address->building))
        {
            $data->data->userAdress .= ' ev: '.$data->data->address->building;
        }

        if(!empty($data->data->address->apartment))
        {
            $data->data->userAdress .= ' m: ' . $data->data->address->apartment;
        }



        // Birth Place
        $data->data->userBP = (object)[];
        $data->data->userBP = $data->data->birthAddress->country . ' ';

        if(!is_null($data->data->birthAddress->city))
        {
            $data->data->userBP .= $data->data->birthAddress->city . ' ';
        }

        if(!empty($data->data->birthAddress->foreignCity))
        {
            $data->data->userBP .= ' '.$data->data->birthAddress->foreignCity;
        }

        if(!empty($data->data->birthAddress->district))
        {
            $data->data->userBP .= ' ' . $data->data->birthAddress->district;
        }
        return $data;
    }

    // Checks Pin by Serial
    public function checkPin($pin)
    {
        $request = [
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['pin','id'],
                'filter' => '"pin":%7B"=":"'.$pin.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Users'
                ]
            ]
        ];
        $response = Service::request($request);
        if ($response->totalCount == 0){
            return 'same';
        }else{
            return $response->data[0]->id;
        }
    }

    //Get Nationality for User
    public function nationalityForGovReq($citizenship)
    {
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','name'],
                'filter' => '"name":%7B"contains":"'.$citizenship.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListNationality'
                ]
            ]
        ]);
        if($data->totalCount > 0){
            $select = (object)[
                'text' => $data->data[0]->name,
                'id'  => $data->data[0]->id,
            ];
            return $select;
        }

    }

    // Nationality
    public function listNationalityId()
    {
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','name']
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListNationality'
                ]
            ]
        ]);
        if($data->totalCount > 0){
            $select = [];

            foreach ($data->data as $item){
                $select[] = (object)[
                    'text' => $item->name,
                    'id'  => $item->id,
                ];
            }

            return response()->json($select);
        }
    }

    // Family Status
    public function familyStatusIdName()
    {
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','name']
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListFamilyStatus'
                ]
            ]
        ]);
        if($data->totalCount > 0){
            $select = [];

            foreach ($data->data as $item){
                $select[] = (object)[
                    'text' => $item->name,
                    'id'  => $item->id,
                ];
            }

            return response()->json($select)
                ->header('Access-Control-Allow-Origin','http://localhost:9090',true)
                ->header('Access-Control-Allow-Headers','x-requested-with',true)
                ->header('Access-Control-Allow-Methods','OPTIONS',true)
                ->header('Allow','OPTIONS',true);
        }
    }

    // Users Search for select 2
    public function users()
    {
        $search = !empty(Input::get('q')) ? Input::get('q') : '';
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','users/?sc=[id,firstName,lastName,patronymic]&order=desc&max=100&offset=0&filter='.$search, false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);
        $select = [];
        if($data->totalCount > 0){
            foreach ($data->data as $item){
                $select[] = (object)[
                    'text' => $item->firstName.' '.$item->lastName.' '.$item->patronymic,
                    'id'  => $item->id,
                ];
            }

        }

        return response()->json($select)
            ->header('origin' ,'http://localhost:9090')
            ->header('Access-Control-Allow-Origin','http://localhost:9090',true)
            ->header('Access-Control-Allow-Headers','x-requested-with',true)
            ->header('Access-Control-Allow-Methods','OPTIONS',true)
            ->header('Allow','OPTIONS',true);
    }

    //Make Img Base 64
    public function makeBase64($photo){
        // Get File Content for Converting into Base64
        $file_Content = file_get_contents($photo);
        // Convert into Base64
        $file64 = base64_encode($file_Content);

        return $file64;
    }
}
