<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\WorkExperienceRequest;
use App\Library\FileOperations\DocxConversion;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class WorkExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        try{

            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','userPositions/userPositionsByUserId/'.selected()->userId , false),
                'params'  => [
                ],
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ]
                ]
            ]);

            $collection = collect($data->data);

            $data->data = $collection->sortBy('startDate')->values()->all();
            $dataNC = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','orderCommons/orderAppointmentNCByUserIdAndUserGroups?offset=0&max=1000&order=desc&sort=dateCreated&userId='.selected()->userId , false),
                'params'  => [
                ],
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ]
                ]
            ]);

//            dd(json_encode($dataNC));
//
//            $data2 = Service::request([
//                'method'  => 'GET',
//                'url'     => Service::url('hr','crud'),
//                'params'  => [
//                    'sc'     => ['id'],
//                    'filter' => '"userId.id" : %7B "=" : "'.selected()->userId.'" %7D'
//                ],
//                'options' => [
//                    'headers' => [
//                        'TableName' => 'RelUserTradeUnions'
//                    ]
//                ]
//            ]);

                $data2 = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id'],
                        'filter' => '"userId.id" : %7B "=" : "' . selected()->userId . '" %7D, "isClosed" : %7B "=" : false %7D',
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

//            dd($data);
                if(isset($data2->totalCount) && $data2->totalCount>0){
                    $data->isUserTradeUnion=$data2->totalCount;
                    if(is_array(($data->data))){
                        foreach ($data->data as $array_data){
                            $array_data->totalCountAttached = $data2->totalCount;
                        }
                    }
                    else {

                        $data->data->totalCountAttached = $data2->totalCount;

                    }
                  //  $data->data->totalCountAttached = $data2->totalCount;

                }

            if(isset($data->totalCount) && $data->totalCount>0) {
                foreach ($data->data as $value) {
                    $value->orderDate = !is_null($value->orderDate) ? date('d.m.Y', $value->orderDate / 1000) : '';
                    $value->startDate = !is_null($value->startDate) ? date('d.m.Y', strtotime($value->startDate)) : '';
                    $value->endDate = !is_null($value->endDate) ? date('d.m.Y', strtotime($value->endDate)) : '';
                }
            }

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
                                "name" => "/crud/UserPosition/insert",
                                "type" =>  "POST"
                            ]

                        ]
                    ]

                ]
            ]);

//            $data->permission=false;
//            if(is_array($checkButtons->data->permissions)){
//
//                $data->permission=$checkButtons->data->permissions;/////
//            }

            $page = $this->page;////jjjj

            if ($request->ajax() && $this->load != true) {

                $data->page = $this->page;
                return response()->json($data);
            }elseif($this->load == true){
                $nc = $this->confirmation();
                return view('pages.personal_cards.work_experience.index' , compact('data','page','dataNC','nc'));
            }else{
                return redirect(url('/personal-cards'));
            }
        }catch (\Exception $e){
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

        $url =  Service::url('hr','orderCommons/confirmation/orderAppointmentProfileNC', false);
//            Service::url('hr','userProvisions/'.selected()->userId , false),
        $requestConfirmation = Service::request([
            'method'  => 'POST',
            'url'     => $url,
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPositionNC'
                ],
                'json' => [
                    "id" => (int)$id,
                    "isConfirmed" => $isc == 'true' ? true : false,
                    "roleId" => $userGroupId
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
                            "name" => "/orderCommons/confirmation/orderAppointmentProfileNC",
                            "type" =>  "POST"
                        ]

                    ]
                ]

            ]
        ]);
        $hasAccess = false;
        if(isset($checkButtons->data) && isset($checkButtons->data->permissions) && is_array($checkButtons->data->permissions)){
            $hasAccess = $checkButtons->data->permissions[0]->accesible;
        }
        return $hasAccess;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.personal_cards.work_experience.modal-inside.modal-inside');
    }

    public function checkedStatement()
    {
        return view('pages.personal_cards.work_experience.modal-inside._checked');
    }

    public function uncheckedStatement()
    {
        return view('pages.personal_cards.work_experience.modal-inside._unchecked');
    }
    
    //Get Data From Order Common
    //
    public function orderAppointments($orderNum)
    {
        $orderTypeId = !empty(Input::get('orderTypeId')) ? Input::get('orderTypeId') : '';
        $orderTypeFIlter = '"listOrderTypeId":%7B"=":"'.$orderTypeId.'"%7D';
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','orderNum'],
                'filter' => '"orderNum" : %7B "=" : "'.$orderNum.'" %7D,'.$orderTypeFIlter
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderCommon'
                ]
            ]
        ]);
        if($data->totalCount > 0){
            return response()->json($data->data);
        }else{
            return 404;
        }
    }

    public function orderAppointmentsGetById($orderNumId)
    {

        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','civilService','positionId','startDate','appointmentMonth','listContractTypeId'],
                'filter' => '"orderCommonId":%7B"=":"'.$orderNumId.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderAppointment'
                ]
            ]
        ]);
        if($data->totalCount > 0){
            $data->data[0]->startDate = !empty($data->data[0]->startDate) && $data->data[0]->startDate != 0 ? date('d.m.Y' , strtotime($data->data[0]->startDate)) : '';
            return response()->json($data->data);
        }else{
            return 404;
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!empty($request->differentOrg) && $request->differentOrg == 'true'){
            $data = $this->checked($request);
        }else{
            $data = $this->unchecked($request);
        }
        return response()->json($data);
    }

    public function checker(){
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
                            "name" => "/crud/UserPosition/insert",
                            "type" =>  "POST"
                        ]

                    ]
                ]

            ]
        ]);
        $hasAccess = false;
        if(isset($checkButtons->data) && isset($checkButtons->data->permissions) && is_array($checkButtons->data->permissions)){
            $hasAccess = $checkButtons->data->permissions[0]->accesible;
        }
        return $hasAccess;
    }

    // If Different Organization Stores data to DB
    public function checked($request,$id = null)
    {
        $civil = !empty($request->differentOrgIsCivilService) && $request->differentOrgIsCivilService == 'true' ? (boolean)true : (boolean)false;
        $request->reasondifferentOrgOrderDate = date('Y-m-d' , strtotime($request->reasondifferentOrgOrderDate));
        $request->differentOrgStartDate = date('Y-m-d' , strtotime($request->differentOrgStartDate));
        $request->differentOrgEndDate = date('Y-m-d' , strtotime($request->differentOrgEndDate));
//        try{
            $requestData = [
                'method'  => !empty($id) ? 'PUT' : 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserPosition'
                    ],
                    'json' => [
                        'isclosed' => (bool)true,
                        'differentOrg' => (bool)$request->differentOrg,
                        'differentOrgIsCivilService' => $civil,
                        'listOrganizationId' => [
                            'id'    => (int)$request->listOrganizationId
                        ],
                        'listPositionNameId' => [
                            'id'    => $request->listPositionNameId
                        ],
//                        'differentOrgListContractTypeId' => [
//                            'id'    => $request->differentOrgListContractTypeId
//                        ],
//                        'listOrderTypeId' => [
//                            'id'    => $request->listOrderTypeId
//                        ],
//                        'differentOrgOrderDate' => $request->reasondifferentOrgOrderDate,
                        'relOrganizationStructuresNameId' => [
                            'id' => $request->listStructureId
                            ],
                        'differentOrgStartDate' => $request->differentOrgStartDate,
                        'differentOrgEndDate'   => $request->differentOrgEndDate,
//                        'differentOrgOrderNum'  => $request->differentOrgOrderNum,
                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ];

            if ($id != null){
                $requestData['options']['json']['id'] = $id;
            }
//            dd($requestData);
            $data = Service::request($requestData);
//            dd($data);
            return $data;
//        }catch (\Exception $e){
//            exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//        }
    }

    // Else If Same Org Stores Data to Database
    public function unchecked($request,$id = null)
    {
        $hasAccess = $this->checker();
        // Prepare Variables
        $civil = !empty($request->isCivil) && $request->isCivil == 'true' ? (boolean)true : (boolean)false;
        $request->orderDate = date('U' , strtotime($request->orderDate));
        $request->startDate = date('Y-m-d' , strtotime($request->startDate));
        $orderAppointmentList = [
            'positionId' => [
                'id' =>$request->positionId,
            ],
            'startDate' => $request->startDate,
            'appointmentMonth' => (int)$request->appointmentMonth,
            'civilService' => $civil,

            'listContractTypeId' => [
                'id' => $request->differentOrgListContractTypeId
            ],
            'isFree' => true,
            'userPositionList' => array([
                'oldSalary' => $request->positionSalary,
                'userId' => [
                    'id'    => selected()->userId
                ]
            ])
        ];
        if($request->appointmentId != ''){
            $orderAppointmentList['id'] = $request->appointmentId;
        }
        // Send Data
        try{
            if($hasAccess) {
                $url = !empty($id) ? 'orderCommons/orderAppointments/' . $id : 'orderCommons/orderAppointments';
            }else{
                $url = !empty($id) ? 'orderCommons/orderAppointmentsNC/' . $id : 'orderCommons/orderAppointmentsNC';
            }
            $requestData = [
                'method'  =>  !empty($id) ? 'PUT' : 'POST',
                'url'     => Service::url('hr',$url, false),
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ],
                    'json' => [
                        'orderNum' => $request->orderNum,
                        'orderDate' => $request->orderDate*1000,
                        'basis'     => $request->basis,
                        'listOrderTypeId' => [
                            'id'    => $request->listOrderTypeId
                        ],
                        'orderAppointmentList' => array($orderAppointmentList)
                    ]
                ]
            ];
            if($id != null || $request->orderNumId != null){
                $requestData['options']['json']['id'] = $request->orderNumId;
            }
            $data = Service::request($requestData);

            return $data;
        }catch (\Exception $e){
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

        if(Input::get('diff') == 'true'){
            $data = $this->getByIdDiff($id);
            $url = route('work-experience.update' , $data->data->id);
            return view('pages.personal_cards.work_experience.modal-inside.modal-inside' , compact('data','url'));
        }else{
            $data = $this->getByIdNonDiff($id);
            $url = route('work-experience.update' , $data->data->id);
            return view('pages.personal_cards.work_experience.modal-inside.modal-inside' , compact('data','url'));
        }
    }
    
    // If Different True
    public function getByIdDiff($id)
    {
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'id'  => $id,
                'sc'     => ['id','isclosed','differentOrg','differentOrgIsCivilService','listPositionNameId.name','listPositionNameId.id','listOrganizationId.id','listOrganizationId.name','differentOrgListContractTypeId.id','differentOrgListContractTypeId.name','listOrderTypeId.id','listOrderTypeId.name','differentOrgOrderDate','differentOrgStartDate','differentOrgEndDate','differentOrgOrderNum','relOrganizationStructuresNameId.structuresNameId.name'],
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPosition'
                ]
            ]
        ]);

        if($data->code == 200){
            $data->data->differentOrgEndDate = date('d.m.Y' , strtotime($data->data->differentOrgEndDate));
            $data->data->differentOrgOrderDate = date('d.m.Y' , gmdate($data->data->differentOrgOrderDate/1000));
            $data->data->differentOrgStartDate = date('d.m.Y' , strtotime($data->data->differentOrgStartDate));
            $data->data->differentOrg = true;
        }
        return $data;
    }
    // If Different false
    public function getByIdNonDiff($id)
    {
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'id'  => $id,
                'sc'     => [
                    'id',
                    'isclosed',
                    'listOrderTypeId.name',
                    'listOrderTypeId.id',
                    'orderAppointmentId.orderCommonId.id',
                    'orderAppointmentId.orderCommonId.orderNum',
                    'orderAppointmentId.orderCommonId.orderDate',
                    'orderAppointmentId.orderCommonId.basis',
                    'orderAppointmentId.positionId.structureId.id',
                    'orderAppointmentId.positionId.structureId.parentId.name',
                    'orderAppointmentId.positionId.structureId.name',
                    'orderAppointmentId.positionId.id',
                    'orderAppointmentId.positionId.posNameId.name',
                    'orderAppointmentId.civilService',
                    'orderAppointmentId.trialPeriodMonth ',
                    'orderAppointmentId.id',
                    'orderAppointmentId.startDate',
                    'orderAppointmentId.appointmentMonth',
                    'orderAppointmentId.listContractTypeId.id',
                    'oldSalary',
                    'orderAppointmentId.listContractTypeId.name',
                    'positionId.id'
                ],
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPosition'
                ]
            ]
        ]);

        if($data->code == 200 && $data->data != null){
            $data->id                             = $data->data->id;
            $data->data->orderId                  = $data->data->orderCommonIdId;
            $data->data->orderNum                 = $data->data->orderCommonIdOrderNum;
            $data->data->orderDate                = !empty($data->data->orderCommonIdOrderDate) ? date('d.m.Y' , strtotime($data->data->orderCommonIdOrderDate)) : '';
            $data->data->basis                    = $data->data->orderCommonIdBasis;
            $data->data->structureIdName          = $data->data->parentIdName.' '.$data->data->structureIdName;
            $data->data->positionIdName           = $data->data->posNameIdName;
            $data->data->isCivilService           = $data->data->orderAppointmentIdCivilService;
            $data->data->isClosed                 = $data->data->isclosed;
            $data->data->startDate                = !empty($data->data->orderAppointmentIdStartDate) ? date('d.m.Y' , strtotime($data->data->orderAppointmentIdStartDate)) : '' ;
            $data->data->appointmentMonth         = $data->data->orderAppointmentIdAppointmentMonth;
            $data->data->differentOrg             = false;

        }
        return $data;
    }
    
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!empty($request->differentOrg) && $request->differentOrg == 'true'){
            $data = $this->checked($request,$id);
        }else{
            $data = $this->unchecked($request,$id);

        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function positionGetSelect()
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
            'params'  => [
                'sc'    => ['id','name'],
                'filter' => $search
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListPositionName'
                ]
            ]
        ]);
        $select = [];
        if($data->totalCount > 0){
            foreach ($data->data as $item){
                $select[] = (object)[
                    'text' => $item->name,
                    'id'  => $item->id,
                ];
            }
        }

        return response()->json($select);
    }
    
    /**
     * Get user labor contract info
     * @param $userPosition - userPositinId
     * @param $userId - userId
     * @return DocxConversion|string
     */
    public function getFile($userPosition, $userId)
    {
        $workexp     = $this->getByIdNonDiff($userPosition);
        $positionId  = $workexp->data->positionIdId;
        $userPayment = app('App\Http\Controllers\StaffTable\RelUserPaymentsController')->getUserPaymentByUser($userId);
        $positionPayment = app('App\Http\Controllers\StaffTable\RelPositionPaymentController')->getPaymentsByPositionId($positionId, 1);
        $user        = app('App\Http\Controllers\Auth\UsersController')->getUserById($userId,'http');
        $education   = app('App\Http\Controllers\PersonalCards\UserEducationController')->index('http');

        $fileData = (object)[
            'workexp'        => $workexp,
            'user'           => $user,
            'education'      => $education,
            'userPayment'    => $userPayment,
            'positionPayment'=> $positionPayment,
            'orderTypeLabel' => 'workDoc'
        ];

        $file = new DocxConversion;

        $file = $file->makeFile($fileData);

        return $file;

    }
}
