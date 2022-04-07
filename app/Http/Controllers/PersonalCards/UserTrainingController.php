<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\UserTrainingRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;

class UserTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{

            if($this->search != ''){
                $search = '"listTrainingNameId.name":%7B"contains":"'.$this->search.'"%7D,';
            }else{
                $search = '';
            }

//            $dataNC = Service::request([
//                'method'  => 'GET',
//                'url'     => Service::url('hr','userTrainings/nc/userTrainingNCByUserIdAndUserGroups?userId='.selected()->userId , false),
//                'params'  => [
//                ],
//                'options' => [
//                    'headers' => [
//                        'TableName' => ''
//                    ]
//                ]
//            ]);


//            dd($dataNC);
//            dd(json_encode($dataNC));
            $sc = ['id','listTrainingNameId.name','listTrainingFormId.name','trainingStartDate','trainingEndDate'];
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'     => $sc,
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => $search.'"userId.id":%7B"=":"'.selected()->userId.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserTraining',
                    ]
                ]
            ]);
//            if($data->totalCount > 0){
//                $nc = nc($data,$sc, 'UserTrainingNC');
//
//                $data = $nc->data;
//                $new  = $nc->newNC;
//            }
            $page = $this->page;
            if ($data->totalCount != 0 ){
                foreach($data->data as  $value){
                    $value->trainingStartDate =  date('d.m.Y',strtotime( $value->trainingStartDate));
                    $value->trainingEndDate =  date('d.m.Y',strtotime( $value->trainingEndDate));

                }
            }
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;

                return response()->json($data);
            }elseif($this->load == true){

//                $nc = $this->confirmation();
                return view('pages.personal_cards.training.index',compact('data','page'));

            }else{
                return redirect(url('/personal-cards'));
            }
        }catch (Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function confirmationPOST($id,$isc,$ccID)
    {
        $url =  Service::url('hr','crud');
        $userGroup = Service::request([
            'method'  => 'GET',
            'url'     => $url,
            'params'  => [
                'sc'     => ['userGroupId'],
                'filter'  => '"confirmId":%7B"=":'.$ccID.'%7D,"isConfirmed":%7B"=":false%7D,"isCustomConfirm":%7B"=":true%7D',
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'TableUserConfirmation'
                ]
            ]
        ]);

        $userGroupId = '';
        if(!empty($userGroup) && !empty($userGroup->data) && count($userGroup->data) > 0){
            $userGroupId = $userGroup->data[0]->userGroupId;
        }

        $url =  Service::url('hr','/userTrainings/confirmation/userTrainingProfileNC', false);
//            Service::url('hr','userProvisions/'.selected()->userId , false),
        $requestConfirmation = Service::request([
            'method'  => 'POST',
            'url'     => $url,
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserTrainingNeedNC'
                ],
                'json' => [
                    "id" => (int)$id,
                    "isConfirmed" => $isc == 'true' ? true : false,
                    "roleId" => 10045
                ]
            ]
        ]);
//        dd($requestConfirmation);
        return $requestConfirmation->code;
    }

    public function confirmation(){
        $checkButtons = Service::request([

            'method' => 'POST',
            'url'    => Service::url('csec','Token/checkTokenMany', false),
            'params' => [

            ],
            'options'=> [

                'headers' => ['TableName' => ''],
                'json'    => [
                    "services" => [
                        0 => [
                            "name" => "/userTrainings/confirmation/userTrainingProfileNC",
                            "type" =>  "POST"
                        ]

                    ]
                ]

            ]
        ]);
        $hasAccess = false;
//        dd($checkButtons);
//        if(is_array($checkButtons->data->permissions)){
//            $hasAccess = $checkButtons->data->permissions[0]->accesible;
//        }
        return $hasAccess;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function checker(){
        $checkButtons = Service::request([

            'method' => 'POST',
            'url'    => Service::url('csec','Token/checkTokenMany', false),
            'params' => [

            ],
            'options'=> [

                'headers' => ['TableName' => ''],
                'json'    => [
                    "services" => [
                        0 => [
                            "name" => "/userTrainings/training",
                            "type" =>  "POST"
                        ]

                    ]
                ]

            ]
        ]);
        $hasAccess = false;
        if(is_array($checkButtons->data->permissions)){
            $hasAccess = $checkButtons->data->permissions[0]->accesible;
        }
        return $hasAccess;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
//            $hasAccess = $this->checker();

            $trainingstartdate = date('U', strtotime($request->trainingStartDate));
            $trainingenddate = date('U', strtotime($request->trainingEndDate));

//            if($hasAccess) {
                $url = 'userTrainings/training';
//            }else{
//                $url = 'userTrainings/nc/training';
//            }

            $data = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr',$url , false),
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ],
                    'json' => [
                        'userTrainingNeedId' => [
                            'id'    => $request->listTrainingNeed
                        ],
                        'listTrainingNameId' => [
                            'id'    => $request->listTrainingNameId
                        ],
                        'listTrainingFormId'=>[
                            'id'    => $request->listTrainingFormId
                        ],
                        'trainingStartDate' => $trainingstartdate*1000,
                        'trainingEndDate' => $trainingenddate*1000,
                        'period' => $request->period,
                        'listTrainingLocationId'=>[
                            'id'    => $request->listTrainingLocationId
                        ],
                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ]);
            $data->body['data']['listTrainingNameIdName'] = $request->listTrainingNameIdName;
            $data->body['data']['listTrainingFormIdName'] = $request->listTrainingFormIdName;
            $data->body['data']['trainingStartDate'] = $request->trainingStartDate;
            $data->body['data']['trainingEndDate'] = $request->trainingEndDate;

            return response()->json($data);
        }catch (Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'id' => $id,
                    'sc' => ['id','listTrainingNameId','listTrainingFormId','trainingStartDate','trainingEndDate','period','listTrainingLocationId','userTrainingNeedId.id','userTrainingNeedId.note'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserTraining'
                    ]
                ]
            ]);
            $response = [
                'fields' => [
                    'listTrainingNeed' => [
                        'id'    => $data->data->userTrainingNeedIdId,
                        'text' => $data->data->userTrainingNeedIdNote
                    ],
                    'listTrainingNameId' => [
                        'id'    => $data->data->listTrainingNameId->id,
                        'text' => $data->data->listTrainingNameId->name
                    ],
                    'listTrainingFormId'  => [
                        'id' => $data->data->listTrainingFormId->id,
                        'text' => $data->data->listTrainingFormId->name
                    ],
                    'trainingStartDate'     =>   date('d.m.Y',strtotime( $data->data->trainingStartDate)),   //$data->data->trainingDate,
                    'trainingEndDate'       =>   date('d.m.Y',strtotime( $data->data->trainingEndDate)),  ///$data->data->trainingEndDate,
                    'period'=> $data->data->period,
                    'listTrainingLocationId'  => [
                        'id' => $data->data->listTrainingLocationId->id,
                        'text' => $data->data->listTrainingLocationId->name
                    ],
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('training.update', $data->data->id)
            ];

            return response()->json($response);

        }catch (Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserTrainingRequest $request, $id)
    {
        try{
            $trainingstartdate = date('U', strtotime($request->trainingStartDate));
            $trainingenddate = date('U', strtotime($request->trainingEndDate));

            $data = Service::request([
                'method'  => 'PUT',
                'url' => Service::url('hr','userTrainings/training/'.$id , false),
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ],
                    'json' => [
                        'id'          => $id,
                        'userTrainingNeedId' => [
                            'id'    => $request->listTrainingNeed
                        ],
                        'listTrainingNameId' => [
                            'id'    => $request->listTrainingNameId
                        ],
                        'listTrainingFormId'=>[
                            'id'    => $request->listTrainingFormId
                        ],
                        'trainingStartDate' => $trainingstartdate*1000,
                        'trainingEndDate' => $trainingenddate*1000,
                        'period' => $request->period,
                        'listTrainingLocationId'=>[
                            'id'    => $request->listTrainingLocationId
                        ],
                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ]);
            $data->data->id = $id;
            $data->data->listTrainingNameIdName = $request->listTrainingNameIdName;
            $data->data->listTrainingFormIdName = $request->listTrainingFormIdName;
            $data->data->trainingStartDate = $request->trainingStartDate;
            $data->data->trainingEndDate = $request->trainingEndDate;

            return response()->json($data);

        }catch (Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $data = Service::request([
                'method'  => 'DELETE',
                'url'     => Service::url('hr','crud'),
                'params' => [
                    'id' => $id
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserTraining'
                    ]
                ]
            ]);
            return $data->code;
        }catch (Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }


    public function trainingTypes()
    {
        $search = !empty(Input::get('q')) ? Input::get('q') : '';
        if($search != ''){
            $search = '"name":%7B"contains":"'.$search.'"%7D';
        }else{
            $search = '';
        }
        //'filter' => $search
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params' => [
                'sc' => ['id','name'],
                'filter' => $search
            ],
            'options' => [
                'headers' =>
                    [
                        'TableName' => 'ListTrainingType'
                    ]
            ]

        ]);
        $select = [];
        if($data->totalCount > 0){
            foreach ($data->data as $item) {

                $select[] = (object)[
                    'id' => $item->id,
                    'text' => $item->name
                ];

            }
        }

        return response()->json($select);
    }

    public function trainingNames()
    {
        $search = !empty(Input::get('q')) ? Input::get('q') : '';
        if($search != ''){
            $search = '"name":%7B"contains":"'.$search.'"%7D';
        }else{
            $search = '';
        }
        //'filter' => $search
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params' => [
                'sc' => ['id','name'],
                'filter' => $search
            ],
            'options' => [
                'headers' =>
                    [
                        'TableName' => 'ListTrainingName'
                    ]
            ]

        ]);
        $select = [];
        if($data->totalCount > 0){
            foreach ($data->data as $item) {

                $select[] = (object)[
                    'id' => $item->id,
                    'text' => $item->name
                ];

            }
        }

        return response()->json($select);
    }

    public function trainingForms()
    {
        $search = !empty(Input::get('q')) ? Input::get('q') : '';
        if($search != ''){
            $search = '"name":%7B"contains":"'.$search.'"%7D';
        }else{
            $search = '';
        }
        //'filter' => $search
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params' => [
                'sc' => ['id','name'],
                'filter' => $search
            ],
            'options' => [
                'headers' =>
                    [
                        'TableName' => 'ListTrainingForm'
                    ]
            ]

        ]);
        $select = [];
        if($data->totalCount > 0){
            foreach ($data->data as $item) {

                $select[] = (object)[
                    'id' => $item->id,
                    'text' => $item->name
                ];

            }
        }

        return response()->json($select);
    }

    public function trainingLocations()
    {
        $search = !empty(Input::get('q')) ? Input::get('q') : '';
        if($search != ''){
            $search = '"name":%7B"contains":"'.$search.'"%7D';
        }else{
            $search = '';
        }
        //'filter' => $search
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params' => [
                'sc' => ['id','name'],
                'filter' => $search
            ],
            'options' => [
                'headers' =>
                    [
                        'TableName' => 'ListTrainingLocation'
                    ]
            ]

        ]);
        $select = [];
        if($data->totalCount > 0){
            foreach ($data->data as $item) {

                $select[] = (object)[
                    'id' => $item->id,
                    'text' => $item->name
                ];

            }
        }

        return response()->json($select);
    }

    public function userTrainingNeedId()
    {
        $search = !empty(Input::get('q')) ? Input::get('q') : '';
        if($search != ''){
            $search = '"name":%7B"contains":"'.$search.'"%7D,';
        }else{
            $search = '';
        }
        //'filter' => $search
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params' => [
                'sc' => ['id','note'],
                'filter' => $search.'"userId.id":%7B"=":"'.selected()->userId.'" %7D,"isclosed":%7B"=":false%7D'
            ],
            'options' => [
                'headers' =>
                    [
                        'TableName' => 'UserTrainingNeed'
                    ]
            ]

        ]);
        $select = [];
        if($data->totalCount > 0){
            foreach ($data->data as $item) {

                $select[] = (object)[
                    'id' => $item->id,
                    'text' => $item->note
                ];

            }
        }
        return response()->json($select);
    }


}

