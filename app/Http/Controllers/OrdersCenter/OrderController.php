<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Library\FileOperations\DocxConversion;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class OrderController extends Controller
{

    /**
     * Instance TableName
     * @var string
     */
    private $tableName = 'OrderCommon';

    /**
     * @var OrderTypeGetArrayFactory
     */
    private $formArrayFactory;

    /**
     * @var OrderTypePostArrayFactory
     */
    private $postArrayFactory;



    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->formArrayFactory = new OrderTypeGetArrayFactory();
        $this->postArrayFactory = new OrderTypePostArrayFactory();
    }

    /**
     * Display a listing of the resource.
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        try {

            /* get all fields and values to filter the result */
            $columns     = $request->get('column');
            $values      = $request->get('value');
            $filterTypes = $request->get('filterType');

            $filter = '';

            /* if columns are not empty */
            if(count($columns) > 0) {

                /* generate query string for each */
                foreach ($columns as $key=>$column)
                {
                    if ($values[$key] != 'null')
                        $filter .= '"'.$column.'":%7B"'.$filterTypes[$key].'":"'.$values[$key].'"%7D';
                    if ($key != count($columns)-1) $filter .= ',';
                }
            }

            /* call the service */


            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     =>  ['id', 'listOrderTypeId', 'orderNum', 'orderDate'],
                    'offset' =>  $this->offset,
                    'max'    =>  $this->limit,
                    'filter' =>  $filter,
                    'sort'   => 'dateCreated',
                    'order'  => 'desc'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            if($data->hasError){
                return eH($data);
            }

            /* if count is greater than zero */
            if ($data->totalCount > 0) {
                foreach ($data->data as $value) {
                    $value->orderDate = date('d.m.Y', strtotime($value->orderDate));
                }
            }

            $page = $this->page;

            /* return json for ajax requests */
            if ($request->ajax() && $this->load != true) {

                $data->page = $this->page;
                return response()->json($data);

            } else {

                return view('pages.orders_center.index', compact('data', 'page'));
            }

//        } catch (\Exception $e){
//
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//
//        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return app('App\Http\Controllers\OrdersCenter\ModalController')->common();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function insertVacationDetail(Request $request, $orderCommonId){

//        try {
            $getVacationId = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'orderCommonId.id'],
                    'filter' => '"orderVacationId.id":%7B"=":"' . $orderCommonId . '"%7D',

                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacation'
                    ]
                ]
            ]);

            if($getVacationId->hasError){
                return eH($getVacationId);
            }
            $dataOrderVacationDetail = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'dateCreated', 'totalMainVacationDay', 'totalAdditionVacationDay', 'mainVacationDay', 'totalVacationDay', 'additionVacationDay', 'additionRemainderVacationDay', 'vacationWorkPeriodFrom', 'vacationWorkPeriodTo', 'workStartDate', 'startDate', 'endDate'],
                    'filter' => '"orderVacationId.id":%7B"=":"' . $getVacationId->data[0]->id . '"%7D',
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationDetail'
                    ]
                ]
            ]);

            if($dataOrderVacationDetail->hasError){
                return eH($dataOrderVacationDetail);
            }
            foreach($dataOrderVacationDetail->data as $vacationDetail){

                $fromPeriod=$vacationDetail->vacationWorkPeriodFrom;

                foreach ($request->$fromPeriod as $key=>$val){

                    $day_key=$request->$fromPeriod.'_day';

                    $dataOrderVacationAdditionDetail = Service::request([
                        'method'  => 'POST',
                        'url'     => Service::url('hr','crud'),
                        'options' => [
                            'headers' => [
                                'TableName' => 'OrderVacationAdditionDetail'
                            ],
                            'json' => [
                                'orderVacationDetailId' => [
                                    'id'    => $vacationDetail->id
                                ],
                                'listVacationAdditionalTypesId' => [
                                    'id'    =>$request->$fromPeriod[$key]
                                ],
                                'day'=>$request->$day_key[$key]
                            ]
                        ]
                    ]);

                    if($dataOrderVacationAdditionDetail->hasError){
                        return eH($dataOrderVacationAdditionDetail);
                    }

                }

            }

//        }
//        catch (\Exception $e){
//
//            return exceptionH(\Request::ajax(),500,$e->getMessage());
//
//        }


    }

    public function sabbaticalLeaveInsert($data){
//        dd($data['durationTypeHidden']);
        $vacationDay=$data['vacationDay'];

        if($data['durationTypeHidden']=='Ay'){

            $today=date('Y-m-d');
            $date = strtotime(date("Y-m-d", strtotime($today)) . " +$vacationDay month");
            $date = date("Y-m-d",$date);
            $data['vacationDay']=(strtotime($date)-strtotime($today))/86400;

        }
        else if($data['durationTypeHidden']=='İl'){

            $today=date('Y-m-d');
            $date = strtotime(date("Y-m-d", strtotime($today)) . " +$vacationDay year");
            $date = date("Y-m-d",$date);
            $data['vacationDay']=(strtotime($date)-strtotime($today))/86400;
        }
            $dataOrderCommon = Service::request([
                'method' => 'POST',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderCommon'
                    ],
                    'json' => [
                        'listOrderTypeId' => [
                            'id' => $data['listOrderTypeId']
                        ],
                        'orderNum' => $data['orderNumber'],
                        'orderDate' => date('Y-m-d', strtotime($data['orderDate'])),
                        'basis' => $data['orderBasis']

                    ]
                ]
            ]);


            if($dataOrderCommon->hasError){
                return eH($dataOrderCommon);
            }
            $orderCommonid = $dataOrderCommon->body['data']['id'];

            $userId = $data['userId'];
            $posId = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'positionId.id', 'orderAppointmentId.id'],
                    'filter' => '"isclosed" : {"=":false}, "userId.id" : { "=" : "' . $userId . '" }'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserPosition'
                    ]
                ]
            ]);

            if($posId->hasError){
                return eH($posId);
            }

//            dd($posId);
            $positionId = $posId->data[0]->positionIdId;

            $dataOrderVacation = Service::request([
                'method' => 'POST',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacation'
                    ],
                    'json' => [
                        'orderCommonId' => [
                            'id' => $orderCommonid
                        ],
                        'userId' => [
                            'id' => $userId
                        ],
                        'listVacationTypeId' => [
                            'id' => $data['listVacationTypeId']
                        ],
                        'vacationComment' => 'gg',
                        'positionId' => [
                            'id' => $positionId
                        ]
                    ]
                ]
            ]);


            if($dataOrderVacation->hasError){
                return eH($dataOrderVacation);
            }
            $orderVacationId = $dataOrderVacation->body['data']['id'];

            $dataOrderVacationOtherDetail = Service::request([
                'method' => 'POST',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationOtherDetail'
                    ],
                    'json' => [
                        'endDate' => date('Y-m-d', strtotime($data['vacationEndDate'])),
                        'listVacationId'=>[
                            'id'=>(int)$data['sabbaticalLeaveName']
                        ],
                        'orderVacationId' => [
                            'id' => $orderVacationId
                        ],

                        'startDate' => date('Y-m-d', strtotime($data['vacationStartDate'])),
                        'vacationDay' => (int)$data['vacationDay'],

                        'workStartDate' => date('Y-m-d', strtotime($data['workStartDate']))
                    ]
                ]
            ]);

            if($dataOrderVacationOtherDetail->hasError){
                return eH($dataOrderVacationOtherDetail);
            }

            return $dataOrderVacationOtherDetail;

    }

    public function sabbaticalLeaveUpdate($id, $data){

//        dd($data);

//        if($data['durationTypeHidden']=='Ay'){
//
//            $today=date('Y-m-d');
//            $date = strtotime(date("Y-m-d", strtotime($today)) . " +2 month");
//            $date = date("Y-m-d",$date);
//            $data['vacationDay']=(strtotime($date)-strtotime($today))/86400;
//
//        }

//        dd($data);

        $dataOrderCommon = Service::request([
            'method' => 'PUT',
            'url' => Service::url('hr', 'crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderCommon'
                ],
                'json' => [
                    'id'          => $id,
                    'listOrderTypeId' => [
                        'id' => $data['listOrderTypeId']
                    ],
                    'orderNum' => $data['orderNumber'],
                    'orderDate' => date('Y-m-d', strtotime($data['orderDate'])),
                    'basis' => $data['orderBasis']

                ]
            ]
        ]);


        if($dataOrderCommon->hasError){
            return eH($data);
        }
        $orderCommonid = $id;

        $userId = $data['userId'];

        $posId = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'positionId.id', 'orderAppointmentId.id'],
                'filter' => '"isclosed" : {"=":false}, "userId.id" : { "=" : "' . $userId . '" }'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPosition'
                ]
            ]
        ]);

        if($posId->hasError){
            return eH($posId);
        }

        $positionId = $posId->data[0]->positionIdId;
//dd($positionId);
        $dataOrderVacation = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id'],
                'filter' => '"orderCommonId.id" : { "=" : "' . $id . '" }'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderVacation'
                ]
            ]
        ]);

        if($dataOrderVacation->hasError){
            return eH($dataOrderVacation);
        }
//        dd($dataOrderVacation->data[0]->id);
        $orderVacationId=$dataOrderVacation->data[0]->id;
        $dataOrderVacation = Service::request([
            'method' => 'PUT',
            'url' => Service::url('hr', 'crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderVacation'
                ],
                'json' => [
                    'id'          => $orderVacationId,
                    'orderCommonId' => [
                        'id' => $orderCommonid
                    ],
                    'userId' => [
                        'id' => $userId
                    ],
                    'listVacationTypeId' => [
                        'id' => $data['listVacationTypeId']
                    ],
                    'vacationComment' => 'changed',
                    'positionId' => [
                        'id' => $positionId
                    ]
                ]
            ]
        ]);

        if($dataOrderVacation->hasError){
            return eH($dataOrderVacation);
        }
        $dataOrderVacationOtherDetails=Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id'],
                'filter' => '"orderVacationId.id" : { "=" : "' . $orderVacationId . '" }'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderVacationOtherDetail'
                ]
            ]
        ]);

        if($dataOrderVacationOtherDetails->hasError){
            return eH($dataOrderVacationOtherDetails);
        }
//        dd($dataOrderVacationOtherDetails->data[0]);

        $orderVacationOtherDetailId=$dataOrderVacationOtherDetails->data[0]->id;
        $dataOrderVacationOtherDetail = Service::request([
            'method' => 'PUT',
            'url' => Service::url('hr', 'crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderVacationOtherDetail'
                ],
                'json' => [
                    'id'          => $orderVacationOtherDetailId,
                    'endDate' => date('Y-m-d', strtotime($data['vacationEndDate'])),
                    'orderVacationId' => [
                        'id' => $orderVacationId
                    ],
                    'listVacationId'=>$data['sabbaticalLeaveName'],
                    'startDate' => date('Y-m-d', strtotime($data['vacationStartDate'])),
                    'vacationDay' => (int)$data['vacationDay'],
//                    'vacationWorkPeriodFrom' => date('Y-m-d', strtotime($data['sabbaticalLeaveFromPeriod'])),
//                    'vacationWorkPeriodTo' => date('Y-m-d', strtotime($data['sabbaticalLeaveToPeriod'])),
                    'workStartDate' => date('Y-m-d', strtotime($data['workStartDate']))
                ]
            ]
        ]);

        if($dataOrderVacationOtherDetail->hasError){
            return eH($dataOrderVacationOtherDetail);
        }

        return $dataOrderVacationOtherDetail;

    }

    public function store(Request $request)
    {

        //get order type label from request. (e.g. busines  sTrip)
        $orderTypeLabel = $request->get('orderTypeLabel');

        //each orderType has its own column name in OrderCommon table
        //define them by labels
        //e.g below


        if(!isset($request->vacationWorkPeriodFrom) &&  $orderTypeLabel=='vacation' && $request->get('listVacationTypeIdLabel')=='labor_vacation'){

            return response()->json(['code'=>'Xəta', 'notselected'=>'Xahiş olunur ən azı bir məzuniyyət dövrü seçəsiniz']);

        }

//        dd($request->all());
        $keys = [
            'businessTrip'              => 'orderBusinessTripList',
            'vacation'                  => 'orderVacationList',
            'appointment'               => 'orderAppointmentList',
            'assignment'                => 'orderAppointmentList',
            'replacement'               => 'orderAppointmentList',
            'dismissal'                 => 'orderDismissalList',
            'salaryAddition'            => 'salaryAdditionList',
            'nonWorkingDaysSelection'   => 'orderRestDayList',
            'staff-add'                 => 'positionList',
            'additionalWorkTime'        => 'orderExcessWorkList',
            'Reward'                    => 'userRewardIndividualList'
        ];

        //pass orderTypeLabel to POSTArrayFactory to get specific array for your own orderType
        //write your own function in OrderTypePostArrayFactory and define it in getPostArray() method
        //it will be switching  by orderType label

        if($request->get('listVacationTypeIdLabel')!='sabbatical_leave'){

            $postArray = $this->postArrayFactory->getPostArray($orderTypeLabel, $request);
        }

//        try {



            if($orderTypeLabel == "financialAid"){

                //insert financial Aid Order
                $data = OrderFinancialAidController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            }

            if($orderTypeLabel == "salaryDeduction"){

                //insert financial Aid Order
                $data = OrderSalaryDeductionController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            }

            else if($request->get('listVacationTypeIdLabel')=='sabbatical_leave') {

                $data = $this->sabbaticalLeaveInsert($request->all());

                return response()->json($data);
            }

            else if($orderTypeLabel == "appointmentDTO"){

                //insert  Order
                $data = OrderAppointmentController::insertOrderTransfer($request,$postArray);

                return response()->json($data);

                // Custom Service for Orders
            }

            else if($orderTypeLabel == "discipline"){

                //insert  Order
                $data = OrderDisciplineController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            }

            else if($orderTypeLabel == "warning"){

                //insert  Order
                $data = OrderWarningController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            }

            elseif($orderTypeLabel == "QualificationDegree"){

                //insert financial Aid Order
                $data = OrderQualificationDegreeController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            }

            else if($orderTypeLabel == "staffOpening"){

                //insert  Order
                $data = OrderStaffAddController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            }

            else if($orderTypeLabel == "staffCancellation"){

                //insert  Order
                $data = OrderStaffCancellationController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            }
            else if ($orderTypeLabel == "additionalWorkTime") {
                $data = Service::request([
                    'method' => 'POST',
                    'url' => Service::url('hr', 'orderCommons/', false),
                    'options' => [
                        'headers' => [
                            'TableName' => ''
                        ],
                        'json' => $postArray
                    ]
                ]);
                if($data->hasError){

                    return eH($data);
                }
                return response()->json($data);
            }

            else {

                if ($orderTypeLabel != 'vacation') {
                    $data = Service::request([
                        'method' => 'POST',
                        'url' => Service::url('hr', 'orderCommons/', false),
                        'options' => [
                            'headers' => [
                                'TableName' => ''
                            ],
                            'json' => [
                                'listOrderTypeId' => [
                                    'id' => $request->get('listOrderTypeId')
                                ],
                                'orderNum' => $request->get('orderNumber'),
                                'orderDate' => date('U', strtotime($request->get('orderDate'))) * 1000,
                                'basis' => $request->get('orderBasis'),
                                //pass the key and your array to request body
                                $keys[$orderTypeLabel] => $postArray
                            ]
                        ]
                    ]);

                    if($data->hasError){
                        return eH($data);
                    }

//                    dd($data);
                    $data->body['data']['orderDate'] = date('d.m.Y', $data->body['data']['orderDate'] / 1000);
                    $data->body['data']['listOrderTypeId']->name = OrderTypeController::getOrderTypeNameById($request->get('listOrderTypeId'));

                }

                if ($orderTypeLabel == 'vacation') {

                    $data = Service::request([
                        'method' => 'POST',
                        'url' => Service::url('hr', 'crud'),
                        'options' => [
                            'headers' => [
                                'TableName' => 'OrderCommon'
                            ],
                            'json' => [
                                'listOrderTypeId' => [
                                    'id' => $request->get('listOrderTypeId')
                                ],
                                'orderNum' => $request->get('orderNumber'),
                                'orderDate' => date('U', strtotime($request->get('orderDate'))) * 1000,
                                'basis' => $request->get('orderBasis')

                            ]
                        ]
                    ]);
                    if($data->hasError){
                        return eH($data);
                    }
                    $data->body['data']['orderDate'] = date('d.m.Y', $data->body['data']['orderDate'] / 1000);
                    $data->body['data']['listOrderTypeId']['name'] = OrderTypeController::getOrderTypeNameById($request->get('listOrderTypeId'));

                    $orderCommonid = $data->body['data']['id'];

                    $userId = $request->userId;
                    $posId = Service::request([
                        'method' => 'GET',
                        'url' => Service::url('hr', 'crud'),
                        'params' => [
                            'sc' => ['id', 'positionId.id', 'orderAppointmentId.id'],
                            'filter' => '"isclosed" : {"=":false}, "userId.id" : { "=" : "' . $userId . '" }'
                        ],
                        'options' => [
                            'headers' => [
                                'TableName' => 'UserPosition'
                            ]
                        ]
                    ]);

                    if($posId->hasError){
                        return eH($posId);
                    }
                    $positionId = $posId->data[0]->positionIdId;

                    $dataOrderVacation = Service::request([
                        'method' => 'POST',
                        'url' => Service::url('hr', 'crud'),
                        'options' => [
                            'headers' => [
                                'TableName' => 'OrderVacation'
                            ],
                            'json' => [
                                'orderCommonId' => [
                                    'id' => $orderCommonid
                                ],
                                'userId' => [
                                    'id' => $userId
                                ],
                                'listVacationTypeId' => [
                                    'id' => $request->listVacationTypeId
                                ],
                                'vacationComment' => 'smth',
                                'positionId' => [
                                    'id' => $positionId
                                ]
                            ]
                        ]
                    ]);

                    if($dataOrderVacation->hasError){
                        return eH($dataOrderVacation);
                    }
                    $orderVacationId = $dataOrderVacation->body['data']['id'];
                    $detailsArrayforCollectiveAggrement=[];

                    foreach ($request->vacationWorkPeriodFrom as $key=>$val){

                        if($key=='0' && isset($request['hiddenForKm'])){

                                $dataInsertOrderVacationDetail = Service::request([
                                'method' => 'POST',
                                'url' => Service::url('hr', 'crud'),
                                'options' => [
                                    'headers' => [
                                        'TableName' => 'OrderVacationDetail'
                                    ],
                                    'json' => [
                                        'orderVacationId' => [
                                            'id' => $orderVacationId
                                        ],
                                        'startDate' => date('U', strtotime($request->vacationStartDate[$key])) * 1000,
                                        'endDate' => date('U', strtotime($request->vacationEndDate[$key])) * 1000,
                                        'vacationWorkPeriodFrom' => date('U', strtotime($request->vacationWorkPeriodFrom[$key])) * 1000,
                                        'vacationWorkPeriodTo' => date('U', strtotime($request->vacationWorkPeriodTo[$key])) * 1000,
                                        'totalVacationDay' =>'0',
                                        'mainVacationDay' => '0',
                                        'mainRemainderVacationDay' => '0',
                                        'additionVacationDay' => '0',
                                        'additionRemainderVacationDay' =>'0',
                                        'workStartDate' =>date('U', strtotime($request->wsDate)) * 1000,
                                        'totalMainVacationDay' =>'0',
                                        'totalAdditionVacationDay' => '0'
                                    ]
                                ]
                            ]);

                            if($dataInsertOrderVacationDetail->hasError){
                                return eH($dataInsertOrderVacationDetail);
                            }

                        }
                        else {

                            $dataInsertOrderVacationDetail = Service::request([
                                'method' => 'POST',
                                'url' => Service::url('hr', 'crud'),
                                'options' => [
                                    'headers' => [
                                        'TableName' => 'OrderVacationDetail'
                                    ],
                                    'json' => [
                                        'orderVacationId' => [
                                            'id' => $orderVacationId
                                        ],
                                        'startDate' => date('U', strtotime($request->vacationStartDate[$key])) * 1000,
                                        'endDate' => date('U', strtotime($request->vacationEndDate[$key])) * 1000,
                                        'vacationWorkPeriodFrom' => date('U', strtotime($request->vacationWorkPeriodFrom[$key])) * 1000,
                                        'vacationWorkPeriodTo' => date('U', strtotime($request->vacationWorkPeriodTo[$key])) * 1000,
                                        'totalVacationDay' => $request->chosenAmount[$key],
                                        'mainVacationDay' => $request->rmainVacation[$key],
                                        'mainRemainderVacationDay' => abs($request->currentMainVacation[$key] - $request->rmainVacation[$key]),
                                        'additionVacationDay' => $request->radditionalVacation[$key],
                                        'additionRemainderVacationDay' => abs($request->additionalRemainderVacationDay[$key] - $request->radditionalVacation[$key]),
                                        'workStartDate' => date('U', strtotime($request->wsDate)) * 1000,
                                        'totalMainVacationDay' => $request->mainVacationDayForPerson[$key],
                                        'totalAdditionVacationDay' => $request->currentAdditionalVacation[$key]
                                    ]
                                ]
                            ]);

                            if($dataInsertOrderVacationDetail->hasError){
                                return eH($dataInsertOrderVacationDetail);
                            }

                        }

                        if(((int)$request->chosenVal[$key]+(int)$request->mainRemainderVacationDay[$key])>(int)$request->mainVacationDayForPerson[$key]){


                            $dataOrderVacationDetailAdd = Service::request([
                                'method' => 'POST',
                                'url' => Service::url('hr', 'crud'),
                                'options' => [
                                    'headers' => [
                                        'TableName' => 'OrderVacationDetailAdd'
                                    ],
                                    'json' => [
                                        'orderVacationDetailId' => [
                                            'id' => $dataInsertOrderVacationDetail->body['data']['id']
                                        ],
                                        'totalExperienceDay' => (int)$request->experienceDay[$key],
                                        'totalWorkConditionDay' => (int)$request->workConditionDay[$key],
                                        'totalChild142' => (int)$request->child142[$key],
                                        'totalChild143' => (int)$request->child143[$key],
                                        'experienceDay' => (int)$request->totalExperienceDay[$key],
                                        'workConditionDay' => (int)$request->totalWorkConditionDay[$key],
                                        'child142' => (int)$request->totalChild142[$key],
                                        'child143' => $request->totalChild142[$key],
                                        'remaindeExperienceDay' => (int)$request->remaindeExperienceDay[$key],
                                        'remaindeWorkConditionDay' => (int)$request->remaindeWorkConditionDay[$key],
                                        'remaindeChild142' => $request->remaindeChild142[$key],
                                        'remaindeChild143' => $request->remaindeChild143[$key]
                                    ]
                                ]
                            ]);
                            if($dataOrderVacationDetailAdd->hasError){
                                return eH($dataOrderVacationDetailAdd);
                            }

                        }
                        else {

                            $dataOrderVacationDetailAdd = Service::request([
                                'method' => 'POST',
                                'url' => Service::url('hr', 'crud'),
                                'options' => [
                                    'headers' => [
                                        'TableName' => 'OrderVacationDetailAdd'
                                    ],
                                    'json' => [
                                        'orderVacationDetailId' => [
                                            'id' => $dataInsertOrderVacationDetail->body['data']['id']
                                        ],
                                        'totalExperienceDay' => '0',
                                        'totalWorkConditionDay' => '0',
                                        'totalChild142' => '0',
                                        'totalChild143' => '0',
                                        'experienceDay' => (int)$request->experienceDay[$key],
                                        'workConditionDay' => (int)$request->workConditionDay[$key],
                                        'child142' => (int)$request->child142[$key],
                                        'child143' => $request->child143[$key],
                                        'remaindeExperienceDay' => (int)$request->experienceDay[$key],
                                        'remaindeWorkConditionDay' => (int)$request->workConditionDay[$key],
                                        'remaindeChild142' => $request->child142[$key],
                                        'remaindeChild143' => $request->child143[$key]
                                    ]
                                ]
                            ]);

                            if($dataOrderVacationDetailAdd->hasError){
                                return eH($dataOrderVacationDetailAdd);
                            }
                        }

                        $allWomanField=$request->allWomenDay[$key];

                        if($allWomanField=='0'){

                            $allWomanField=5;
                        }

                        if($request->commonKvChild142[$key]>0) {
                            $child142field = $request->kvChild142[$key];
                            if ($child142field == '0') {

                                $child142field = 1;
                            }

                        }
                        else {

                            $child142field=0;

                        }
                        if($request->commonKvChild143[$key]>0) {
                            $child143field = $request->kvChild143[$key];
                            if ($child143field == '0') {

                                $child143field = 1;
                            }

                        }
                        else {

                            $child143field=0;

                        }

                        if($request->commonChernobylAccident[$key]>0) {
                            $workConditionDayfield = $request->workConditionDay[$key];
                            if ($workConditionDayfield == '0') {

                                $workConditionDayfield = 1;
                            }

                        }
                        else {

                            $workConditionDayfield=0;

                        }

                        $dataOrderVacationCollectiveDetail = Service::request([
                            'method' => 'POST',
                            'url' => Service::url('hr', 'crud'),
                            'options' => [
                                'headers' => [
                                    'TableName' => 'OrderVacationCollectiveDetail'
                                ],
                                'json' => [
                                    'orderVacationDetailId' => [
                                        'id' => $dataInsertOrderVacationDetail->body['data']['id']
                                    ],
                                    'allWomenDay' => (int)$request->commonAllWomenDay[$key],
                                    'child142' => (int)$request->commonKvChild142[$key],
                                    'child143' => (int)$request->commonKvChild143[$key],
                                    'chernobylAccidenDay' => (int)$request->commonChernobylAccident[$key],
                                    'remaindeAllWomenDay' =>(int)$request->remaindeAllWomenDay[$key],
                                    'remaindeChild142' => (int)$request->kvRemaindeChild142[$key],
                                    'remaindeChild143' =>(int)$request->kvRemaindeChild143[$key],
                                    'remaindeChernobylAccidenDay' =>$request->remaindeChernobylAccidenDay[$key],
                                    'totalAllWomenDay' => (int)$request->allWomenDay[$key],
                                    'totalChild142' => (int)$request->kvChild142[$key],
                                    'totalChild143' => (int)$request->kvChild143[$key],
                                    'totalChernobylAccidenDay' => (int)$request->chernobylAccident[$key]
                                ]
                            ]
                        ]);

                        if($dataOrderVacationCollectiveDetail->hasError){
                            return eH($dataOrderVacationCollectiveDetail);
                        }

                    }

                    /*
                     *
                     * new added function by Azer
                     */


                    /*
                     *
                     * ended function
                     */

                    if(isset($request->collectiveVac)){

                        $periodCheck=$request->periodFromDate;

//                        dd($detailsArrayforCollectiveAggrement, $periodCheck);
                        foreach ($request->collectiveVac as $key1=>$val1){

                        $dataOrderVacationCollectiveAgreement = Service::request([
                            'method' => 'POST',
                            'url' => Service::url('hr', 'crud'),
                            'options' => [
                                'headers' => [
                                    'TableName' => 'OrderVacationCollectiveAgreement'
                                ],
                                'json' => [
                                    'orderVacationDetailId' => [
                                        'id' => $detailsArrayforCollectiveAggrement[$periodCheck]
                                    ],
                                    'day' => $request->collectiveVacDay[$key1],

                                    'collectiveAgreementVacationId' => [
                                        'id' => $request->collectiveVac[$key1]
                                    ]


                                ]
                            ]
                        ]);

                            if($dataOrderVacationCollectiveAgreement->hasError){
                                return eH($dataOrderVacationCollectiveAgreement);
                            }

                    }

                    }


                }

                return response()->json($data);
            }

//        } catch (\Exception $e){
//
//            return exceptionH(\Request::ajax(),500,$e->getMessage());
//
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function getSabbaticalLeave(){

        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'name', 'label']
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListVacation'
                ]
            ]
        ]);

        if($data->hasError){
            return eH($data);
        }
        return response()->json($data);

    }

    public function countVacationDay($type, $amount, $startDate){

        if($type=="month"){

            $amount=(int)$amount;

            $str= ($startDate) . " +$amount month";

            $data=date('d.m.Y', strtotime(date("d.m.Y", strtotime($startDate)) . " +$amount month"));

        }
        else {

            $data=date('d.m.Y', strtotime(date("d.m.Y", strtotime($startDate)) . " +$amount day"));

        }

        return response()->json($data);

    }

    public function getSabbaticalVacationDays($type, $userId){


        $posId = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     =>  ['id', 'positionId.id', 'orderAppointmentId.id'],
                'filter' =>  '"isclosed" : {"=":false}, "userId.id" : { "=" : "'.$userId.'" }'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPosition'
                ]
            ]
        ]);

        if($posId->hasError){
            return eH($posId);
        }

//dd($posId, $userId);
//        $orderAppointmentId=$posId->data[0]->orderAppointmentIdId;

//        $orderAppointmentData = Service::request([
//            'method' => 'GET',
//            'url'    => Service::url('hr', 'crud'),
//            'params' => [
//                'sc'     =>  ['id', 'startDate'],
//                'filter' =>  '"id" : { "=" : "'.$orderAppointmentId.'" }'
//            ],
//            'options' => [
//                'headers' => [
//                    'TableName' => 'OrderAppointment'
//                ]
//            ]
//        ]);



//        $userAppointmentDate=$orderAppointmentData->data[0]->startDate;

//        $userAppointmentDate_arr=explode('-', $userAppointmentDate);

//        $userAppointmentDateYear=$userAppointmentDate_arr[0];

//        $currentYear=date('Y');
//
//        $periodDate=$currentYear.'-'.$userAppointmentDate_arr[1].'-'.$userAppointmentDate_arr[2];
//        $today=date("Y-m-d");
//
//        if(strtotime($today)<strtotime($periodDate)){
//            $periodLastDate=($currentYear-1).'-'.$userAppointmentDate_arr[1].'-'.$userAppointmentDate_arr[2];
//            $periodFirstDate=($currentYear-2).'-'.$userAppointmentDate_arr[1].'-'.$userAppointmentDate_arr[2];
//        }
//        else {
//            $periodLastDate=($currentYear).'-'.$userAppointmentDate_arr[1].'-'.$userAppointmentDate_arr[2];
//            $periodFirstDate=($currentYear-1).'-'.$userAppointmentDate_arr[1].'-'.$userAppointmentDate_arr[2];
//        }
//        dd($periodLastDate, $periodFirstDate);


        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'value', 'listDurationTypeId.name'],
                'filter'=>'"listVacationId.id":%7B"=":"' . $type . '"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListVacationDuration'
                ]
            ]
        ]);

        if($data->hasError){
            return eH($data);
        }
//        dd($data);

//        if(is_array($data->data)){
//
//            $data->data[0]->periodLastDate=$periodLastDate;
//            $data->data[0]->periodFirstDate=$periodFirstDate;
//        }


        return response()->json($data);

    }

    public function getSabbaticalLeaveSearch($listVacationTypeId){


//        try {

//            dd($listVacationTypeId);
            $filter=[];
            $search = !empty(Input::get('q')) ? Input::get('q') : '';
            if(Input::get('select')!=null){

                $label=Input::get('select');
//                dd($label);
                if($label=='root'){
                    $filter['filter']='"label":%7B"=":"'.$label.'"%7D, "vacationTypeId":%7B"=":"'.$listVacationTypeId.'"%7D, "name":%7B"contains":"' . $search . '"%7D';
                }
                else {

//                    dd($label=='7');

                    $label=(int)$label;
                    $filter['filter']='"label":%7B"=":"'.$label.'"%7D, "vacationTypeId":%7B"=":"'.$listVacationTypeId.'"%7D, "name":%7B"contains":"' . $search . '"%7D';
//               dd($filter);
                }

            }
            else {
                $filter['filter']='"name":%7B"contains":"' . $search . '"%7D';

            }
            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'name', 'vacationTypeId.label'],
                    'filter' =>$filter['filter']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListVacation'
                    ]
                ]
            ]);

            if($data->hasError){
                return eH($data);
            }
//            dd($data);

            if ($data->totalCount > 0) {
                foreach ($data->data as $item) {
                    $select[] = (object)[
                        'id' => $item->id,
                        'text' => $item->name,
                        'vacationTypeId'=>$item->vacationTypeIdLabel
                    ];

                }
                return response()->json($select);
            } else {
                return 404;
            }

       
//        }
//       catch (\Exception $e) {
//            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());
//        }

    }

    public function getSabbaticalChildCount($label){

//        try {
            $filter=[];

            if($label!=null){

                    $label=(int)$label;
                    $filter['filter']='"label":%7B"=":"'.$label.'"%7D';

                    $data = Service::request([
                        'method' => 'GET',
                        'url' => Service::url('hr', 'crud'),
                        'params' => [
                            'sc' => ['id', 'name'],
                            'filter' =>$filter['filter']
                        ],
                        'options' => [
                            'headers' => [
                                'TableName' => 'ListVacation'
                            ]
                        ]
                    ]);
            }

            if($data->hasError){
                return eH($data);
            }
            return response()->json($data);

//        }
//        catch (\Exception $e) {
//            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());
//        }

    }

    public function partialPaidSocialVacation($userid){

//        try {
            $filter=[];

            $birthDayDates=[];
            if($userid!=null){

                $data = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'name', 'surname', 'birthDate', 'listFamilyRelationTypesId.id'],
                        'filter' =>'"userId.id":%7B"=":"'.$userid.'"%7D, "listFamilyRelationTypesId.label":%7B"=":"child"%7D'
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'UserFamily'
                        ]
                    ]
                ]);

                if($data->hasError){
                    return eH($data);
                }
//                dd($data);
                if(is_array($data->data) && isset($data->data[0])) {
                    foreach ($data->data as $birthDay) {

                        $birthDayDates[] = strtotime($birthDay->birthDate);

                    }

                    $stDate=date('Y-m-d', max($birthDayDates));
                    $lastPossibleDate=date('d.m.Y', strtotime(date("Y-m-d", strtotime($stDate)) . " +3 year"));


                }
                else {

                    $lastPossibleDate="Uyğün məlumat tapilmadı";
                }

//                dd($lastPossibleDate);
            }

            return response()->json($lastPossibleDate);

//        }
//        catch (\Exception $e) {
//            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());
//        }

    }

    public function getCollectiveAggrement($userId, $periodFrom, $periodTo){

        $vacationTypesForPerson = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'orderCommons/vacationAddDayTab?userId='.$userId.'&workPeriodFrom='.$periodFrom.'&workPeriodTo='.$periodTo, false),
            'params' => [],
            'options' => [
                'headers' => ['TableName' => '']
            ]
        ]);

        if($vacationTypesForPerson->hasError){
            return eH($vacationTypesForPerson);
        }

        return response()->json($vacationTypesForPerson);

    }

    public function checkListVacationType($listVacationTypeId){

        $dataVacation = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'label', 'name'],
                'filter' => '"id":%7B"=":"'.$listVacationTypeId.'"%7D',
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListVacationType'
                ]
            ]
        ]);

        if($dataVacation->hasError){
            return eH($dataVacation);
        }

        return $dataVacation->data;
    }

    public function edit($id)
    {
        //get order common info from  crud


        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'id' => $id,
                'sc' => ['id', 'listOrderTypeId', 'orderNum', 'orderDate', 'basis']
            ],
            'options' => [
                'headers' => [
                    'TableName' => $this->tableName
                ]
            ]
        ]);

        if($data->hasError){
            return eH($data);
        }
        if($data->data->listOrderTypeId->label=='vacation') {

            $dataOrderVacation = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'userId.id', 'listVacationTypeId.id', 'userId.firstName', 'userId.lastName', 'userId.patronymic'],
                    'filter' => '"orderCommonId.id":%7B"=":"'.$id.'"%7D',
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacation'
                    ]
                ]
            ]);

            if($dataOrderVacation->hasError){
                return eH($dataOrderVacation);
            }

//            dd($dataOrderVacation);
            $listVacationTypeId=$dataOrderVacation->data[0]->listVacationTypeIdId;

            $orderVacationId=$dataOrderVacation->data[0]->id;

            $label=$this->checkListVacationType($listVacationTypeId);

//            dd($label);
            if($label[0]->label=='sabbatical_leave' || $label[0]->label=='paid_social_vacation' || $label[0]->label=='paid_educational_vacation' || $label[0]->label=='nonpaid_vacation' || $label[0]->label=='partialpaid_social_vacation'){

                $dataVacation = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'orderVacationId.id', 'endDate', 'startDate', 'workStartDate', 'vacationWorkPeriodFrom', 'vacationWorkPeriodTo', 'vacationDay', 'listVacationId.name', 'listVacationId.id'],
                        'filter' => '"orderVacationId.id":%7B"=":"'.$orderVacationId.'"%7D',
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'OrderVacationOtherDetail'
                        ]
                    ]
                ]);

                if($dataVacation->hasError){
                    return eH($dataVacation);
                }
                $dataListVacationDuration = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'listDurationTypeId.id', 'listDurationTypeId.name'],
                        'filter' => '"listVacationId.id":%7B"=":"'.$dataVacation->data[0]->listVacationIdId.'"%7D',
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'ListVacationDuration'
                        ]
                    ]
                ]);

                if($dataListVacationDuration->hasError){
                    return eH($dataListVacationDuration);
                }

                $dataUserStructure = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'userId.id', 'positionId.id', 'positionId.posNameId.name', 'positionId.structureId.name'],
                        'filter' => '"userId.id":%7B"=":"'.$dataOrderVacation->data[0]->userIdId.'"%7D',
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'UserPosition'
                        ]
                    ]
                ]);

                if($dataUserStructure->hasError){
                    return eH($dataUserStructure);
                }
                $response = (object)[
                    'fields' => [
                        'listOrderTypes' => [
                            'id'   => $data->data->listOrderTypeId->id,
                            'text' => $data->data->listOrderTypeId->name
                        ],
                        'orderTypeLabel' => $data->data->listOrderTypeId->label,
                        'orderNumber'    => $data->data->orderNum,
                        'orderDate'      => date('d.m.Y', strtotime($data->data->orderDate)),
                        'orderBasis'     => $data->data->basis,
                        'child'=>[
                            'endDate'=>date('d.m.Y', strtotime($dataVacation->data[0]->endDate)),
                            'startDate'=>date('d.m.Y',strtotime($dataVacation->data[0]->startDate)),
                            'vacationWorkPeriodTo'=>date('d.m.Y', strtotime($dataVacation->data[0]->vacationWorkPeriodTo)),
                            'vacationWorkPeriodFrom'=>date('d.m.Y', strtotime($dataVacation->data[0]->vacationWorkPeriodFrom)),
                            'workStartDate'=>date('d.m.Y', strtotime($dataVacation->data[0]->workStartDate)),
                            'orderVacationIdId'=>$dataVacation->data[0]->orderVacationIdId,
                            'vacationDay'=>$dataVacation->data[0]->vacationDay,
                            'orderVacationOtherDetailId'=>$dataVacation->data[0]->id,
                            'listVacationTypeName'=>$label[0]->name,
                            'label'=>$label[0]->label,
                            'userId'=>$dataOrderVacation->data[0]->userIdId,
                            'userName'=>$dataOrderVacation->data[0]->userIdLastName.' '.$dataOrderVacation->data[0]->userIdFirstName.' '.$dataOrderVacation->data[0]->userIdPatronymic,
                            'userStructure'=>$dataUserStructure->data[0],
                            'listVacationName'=>$dataVacation->data[0]->listVacationIdName,
                            'listVacationId'=>$dataVacation->data[0]->listVacationIdId ,
                            'listVacationDurationTypeName'=>$dataListVacationDuration->data[0]->listDurationTypeIdName
                        ]

                    ],
                    'id'   => $data->data->id,
                    'code' => $data->code,
                    'url'  => route('orders.update', $data->data->id),
                    'label'=>'sabbatical_leave',
                    'listVacationTypeName'=>$label[0]->name,
                    'listVacationTypeId'=>$listVacationTypeId,

                ];

                return app('App\Http\Controllers\OrdersCenter\ModalController')->common($response);
            }

            $enable = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'orderCommons/userLastVacation?orderCommonId=' . $id, false),
                'params' => [],
                'options' => [
                    'headers' => ['TableName' => '']
                ]
            ]);

            if($enable->hasError){
                return eH($enable);
            }

        }

        //define order type by label
        $childKey = $data->data->listOrderTypeId->label;
        /*
         * using the App\Http\Controllers\Controller\OrderTypeGetArrayFactory
         * generate your own array to fill your modal
        */

        $childFields = $this->formArrayFactory->getChildFields($childKey, $data->data->id);

        $response = new \stdClass();

        if($data->data->listOrderTypeId->label=='vacation') {

            $orderVacationDetailArray=[];

            $dataUser = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'dateCreated', 'totalMainVacationDay', 'mainRemainderVacationDay', 'totalAdditionVacationDay', 'mainVacationDay', 'totalVacationDay', 'additionVacationDay', 'additionRemainderVacationDay', 'vacationWorkPeriodFrom', 'vacationWorkPeriodTo', 'workStartDate', 'startDate', 'endDate'],
                    'filter' => '"orderVacationId.id":%7B"=":"' . $orderVacationId . '"%7D',
                    'sort'   => 'vacationWorkPeriodFrom',
                    'order'  => 'asc'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationDetail'
                    ]
                ]
            ]);

            if($dataUser->hasError){
                return eH($dataUser);
            }

            $test=$dataUser;



            $dataCollectiveAggrement='';
            $dataCollectiveAggrementPeriod='';
            $periodArray=[];

            foreach ($dataUser->data as $arr) {

                $periodArray[]=$arr->id;

                $vacationWorkPeriodFromUnix=$arr->vacationWorkPeriodFrom;
                $vacationWorkPeriodToUnix=$arr->vacationWorkPeriodTo;
                $arr->vacationWorkPeriodFrom=date('d.m.Y', strtotime($arr->vacationWorkPeriodFrom));
                $arr->vacationWorkPeriodTo=date('d.m.Y', strtotime($arr->vacationWorkPeriodTo));
                $arr->startDate=date('d.m.Y', strtotime($arr->startDate));
                $arr->endDate=date('d.m.Y', strtotime($arr->endDate));
                $dataOrderVacationDetailAdd = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'orderVacationDetailId.id', 'orderVacationDetailId.vacationWorkPeriodFrom', 'orderVacationDetailId.vacationWorkPeriodTo', 'totalExperienceDay', 'totalWorkConditionDay', 'totalChild142', 'totalChild143', 'remaindeChild142', 'remaindeChild143', 'remaindeExperienceDay', 'remaindeWorkConditionDay', 'workConditionDay', 'child142', 'child143', 'experienceDay'],
                        'filter' => '"orderVacationDetailId.id":%7B"=":"' . $arr->id . '"%7D',
                        'sort'   => 'id',
                        'order'  => 'asc'
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'OrderVacationDetailAdd'
                        ]
                    ]
                ]);

                if($dataOrderVacationDetailAdd->hasError){
                    return eH($dataOrderVacationDetailAdd);
                }

                $dataOrderVacationCollectiveDetail = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'orderVacationDetailId.id', 'orderVacationDetailId.vacationWorkPeriodFrom', 'orderVacationDetailId.vacationWorkPeriodTo', 'allWomenDay', 'chernobylAccidenDay', 'child142', 'child143', 'remaindeChild142', 'remaindeChild143', 'remaindeAllWomenDay', 'remaindeChernobylAccidenDay', 'totalAllWomenDay', 'totalChernobylAccidenDay', 'totalChild142', 'totalChild143'],
                        'filter' => '"orderVacationDetailId.id":%7B"=":"' . $arr->id . '"%7D',
                        'sort'   => 'id',
                        'order'  => 'asc'
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'OrderVacationCollectiveDetail'
                        ]
                    ]
                ]);

                if($dataOrderVacationCollectiveDetail->hasError){
                    return eH($dataOrderVacationCollectiveDetail);
                }
                if(!isset($dataUser->orderVacationDetailAddArray)){

                    $dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodFrom=date('d.m.Y', strtotime($dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodFrom));
                    $dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodTo=date('d.m.Y', strtotime($dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodTo));
                    $dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodFrom=date('d.m.Y', strtotime($dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodFrom));
                    $dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodTo=date('d.m.Y', strtotime($dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodTo));


                    $dataUser->orderVacationDetailAddArray=[];
                    $dataUser->orderVacationDetailCollectiveArray=[];
                    $dataUser->orderVacationDetailAddArray[]=$dataOrderVacationDetailAdd->data[0];
                    $dataUser->orderVacationDetailCollectiveArray[]=$dataOrderVacationCollectiveDetail->data[0];
                }
                else {
                    $dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodFrom=date('d.m.Y', strtotime($dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodFrom));
                    $dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodTo=date('d.m.Y', strtotime($dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodTo));

                    $dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodFrom=date('d.m.Y', strtotime($dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodFrom));
                    $dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodTo=date('d.m.Y', strtotime($dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodTo));

                    $dataUser->orderVacationDetailAddArray[]=$dataOrderVacationDetailAdd->data[0];
                    $dataUser->orderVacationDetailCollectiveArray[]=$dataOrderVacationCollectiveDetail->data[0];

                }
                $dateC=date('Y-m-d', $arr->dateCreated/1000);


                $userOldSamePeriodVacation = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'totalMainVacationDay', 'totalAdditionVacationDay', 'mainVacationDay', 'mainRemainderVacationDay', 'totalVacationDay', 'additionVacationDay', 'additionRemainderVacationDay', 'vacationWorkPeriodFrom', 'vacationWorkPeriodTo', 'workStartDate', 'startDate', 'endDate', 'dateCreated'],
                        'filter' => '"orderVacationId.userId":%7B"=":"' . $dataOrderVacation->data[0]->userIdId. '"%7D, "vacationWorkPeriodFrom":%7B"=":"' . $vacationWorkPeriodFromUnix. '"%7D, "vacationWorkPeriodTo":%7B"=":"' . $vacationWorkPeriodToUnix . '"%7D',
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'OrderVacationDetail'
                        ]
                    ]
                ]);

                if($userOldSamePeriodVacation->hasError){
                    return eH($userOldSamePeriodVacation);
                }
                if(is_array($userOldSamePeriodVacation->data)) {
//                          dd('here');
                    $arr->usedVacationDayForSamePeriod = '0';

                    foreach ($userOldSamePeriodVacation->data as $samePeriod) {

                        $arr->usedVacationDayForSamePeriod = $arr->usedVacationDayForSamePeriod + $samePeriod->totalVacationDay;

                    }

                }

            }

//            dd($dataUser);

           $response = (object)[
                'fields' => [
                    'listOrderTypes' => [
                        'id'   => $data->data->listOrderTypeId->id,
                        'text' => $data->data->listOrderTypeId->name
                    ],
                    'orderTypeLabel' => $data->data->listOrderTypeId->label,
                    'orderNumber'    => $data->data->orderNum,
                    'orderDate'      => date('d.m.Y', strtotime($data->data->orderDate)),
                    'orderBasis'     => $data->data->basis,
                    $childKey        => $childFields
                ],
                'id'   => $data->data->id,
                'code' => $data->code,
                'url'  => route('orders.update', $data->data->id),
                'vacation'=>$dataUser,
                'enable'=>$enable->data->isEditable,
                'ordercommonid'=>$id

            ];

        }
        else {

            $response = (object)[
                'fields' => [
                    'listOrderTypes' => [
                        'id'   => $data->data->listOrderTypeId->id,
                        'text' => $data->data->listOrderTypeId->name
                    ],
                    'orderTypeLabel' => $data->data->listOrderTypeId->label,
                    'orderNumber'    => $data->data->orderNum,
                    'orderDate'      => date('d.m.Y', strtotime($data->data->orderDate)),
                    'orderBasis'     => $data->data->basis,
                    $childKey        => $childFields
                ],
                'id'   => $data->data->id,
                'code' => $data->code,
                'url'  => route('orders.update', $data->data->id)

            ];
        }

        return app('App\Http\Controllers\OrdersCenter\ModalController')->common($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //get order type label from request. (e.g. businessTrip)
        $orderTypeLabel = $request->get('orderTypeLabel');

        //each orderType has its own column name in OrderCommon table
        //define them by labels
        //e.g below

//        dd($request->all(), isset($request->hiddenEdit));
        $keys = [
            'businessTrip'            => 'orderBusinessTripList',
            'vacation'                => 'orderVacationList',
            'appointment'             => 'orderAppointmentList',
            'assignment'              => 'orderAppointmentList',
            'replacement'             => 'orderAppointmentList',
            'dismissal'               => 'orderDismissalList',
            'nonWorkingDaysSelection' => 'orderRestDayList',
            'warning'                 => 'orderWarningList',
            'Reward'                  => 'userRewardIndividualList',
            'additionalWorkTime'        => 'orderExcessWorkList'
        ];


        //pass orderTypeLabel to POSTArrayFactory to get specific array for your own orderType
        //write your own function in App\Http\Controllers\Orders\OrderTypePostArrayFactory and define it in getPostArray() method
        //it will be switching  by orderType labels

            if($request->get('listVacationTypeIdLabel')!='sabbatical_leave') {
                $postArray = $this->postArrayFactory->getPostArray($orderTypeLabel, $request);
            }
//        dd($postArray);
//        try {
            if ($orderTypeLabel == 'financialAid') {

                $data = OrderFinancialAidController::updateOrder($request);

                return response()->json($data);

            }
            else if ($orderTypeLabel == 'discipline') {

                $data = OrderDisciplineController::updateOrder($request);

                return response()->json($data);

            }else if ($orderTypeLabel == 'appointmentDTO') {

                $data = OrderAppointmentController::updateOrder($request);

                return response()->json($data);

            }
            else if ($orderTypeLabel == 'warning') {

                $data = OrderWarningController::updateOrder($request);

                return response()->json($data);

            }

            else if ($orderTypeLabel == 'QualificationDegree') {

                $data = OrderQualificationDegreeController::updateOrder($request);

                return response()->json($data);

            }
            else if ($orderTypeLabel == 'staffOpening') {

                $data = OrderStaffAddController::updateOrder($request, $id);

                return response()->json($data);

            }
            else if($orderTypeLabel == "appointmentDTO"){

                //insert  Order
                $data = OrderAppointmentController::updateOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            }
            else if($orderTypeLabel == "additionalWorkTime"){

                //insert  Order
                $data = OrderAddWorkTimeController::updateOrder($request,$id);

                return response()->json($data);

                // Custom Service for Orders
            }
            else if($orderTypeLabel == "staffCancellation"){

                //insert  Order
                $data = OrderStaffCancellationController::updateOrder($request,$id);

                return response()->json($data);

                // Custom Service for Orders
            }
            else if($request->get('listVacationTypeIdLabel')=='sabbatical_leave'){

                $data=$this->sabbaticalLeaveUpdate($id, $request->all());

                return response()->json($data);

            }
            else {

                if ($orderTypeLabel == 'vacation' && !isset($request->hiddenDetail)) {



                    $getVacationId = Service::request([
                        'method' => 'GET',
                        'url' => Service::url('hr', 'crud'),
                        'params' => [
                            'sc' => ['id', 'orderCommonId.id'],
                            'filter' => '"orderCommonId.id":%7B"=":"' . $id . '"%7D',

                        ],
                        'options' => [
                            'headers' => [
                                'TableName' => 'OrderVacation'
                            ]
                        ]
                    ]);

                    if($getVacationId->hasError){
                        return eH($getVacationId);
                    }
                    $dataOrderVacationDetail = Service::request([
                        'method' => 'GET',
                        'url' => Service::url('hr', 'crud'),
                        'params' => [
                            'sc' => ['id', 'dateCreated', 'totalMainVacationDay', 'totalAdditionVacationDay', 'mainVacationDay', 'totalVacationDay', 'additionVacationDay', 'additionRemainderVacationDay', 'vacationWorkPeriodFrom', 'vacationWorkPeriodTo', 'workStartDate', 'startDate', 'endDate'],
                            'filter' => '"orderVacationId.id":%7B"=":"' . $getVacationId->data[0]->id . '"%7D',
                        ],
                        'options' => [
                            'headers' => [
                                'TableName' => 'OrderVacationDetail'
                            ]
                        ]
                    ]);
                    if($dataOrderVacationDetail->hasError){
                        return eH($dataOrderVacationDetail);
                    }
                    $OrderVacationDetailId = $dataOrderVacationDetail->data[0]->id;

                    if (is_array($dataOrderVacationDetail->data)) {
                        foreach ($dataOrderVacationDetail->data as $detailId) {
//                            dd($detailId->id);
                            $dataAdd = Service::request([
                                'method' => 'GET',
                                'url' => Service::url('hr', 'crud'),
                                'params' => [
                                    'sc' => ['id'],
                                    'filter' => '"orderVacationDetailId.id":%7B"=":"' . $detailId->id . '"%7D',
                                ],
                                'options' => [
                                    'headers' => [
                                        'TableName' => 'OrderVacationDetailAdd'
                                    ]
                                ]
                            ]);

                            if($dataAdd->hasError){
                                return eH($dataAdd);
                            }

                            if($dataAdd->data[0]->id!=null) {
                                $dataDelete = Service::request([
                                    'method' => 'DELETE',
                                    'url' => Service::url('hr', 'crud'),
                                    'params' => [
                                        'id' => $dataAdd->data[0]->id
                                    ],
                                    'options' => [
                                        'headers' => [
                                            'TableName' => 'OrderVacationDetailAdd'
                                        ]
                                    ]
                                ]);

                                if($dataDelete->hasError){
                                    return eH($dataDelete);
                                }


                            }

                            $dataCollective = Service::request([
                                'method' => 'GET',
                                'url' => Service::url('hr', 'crud'),
                                'params' => [
                                    'sc' => ['id'],
                                    'filter' => '"orderVacationDetailId.id":%7B"=":"' . $detailId->id . '"%7D',
                                ],
                                'options' => [
                                    'headers' => [
                                        'TableName' => 'OrderVacationCollectiveDetail'
                                    ]
                                ]
                            ]);

                            if($dataCollective->hasError){
                                return eH($dataCollective);
                            }


                            if($dataCollective->data[0]->id!=null) {
                                $dataDelete = Service::request([
                                    'method' => 'DELETE',
                                    'url' => Service::url('hr', 'crud'),
                                    'params' => [
                                        'id' => $dataCollective->data[0]->id
                                    ],
                                    'options' => [
                                        'headers' => [
                                            'TableName' => 'OrderVacationCollectiveDetail'
                                        ]
                                    ]
                                ]);

                                if($dataDelete->hasError){
                                    return eH($dataDelete);
                                }
                            }

                            $dataDeleteDetail = Service::request([
                                'method' => 'DELETE',
                                'url' => Service::url('hr', 'crud'),
                                'params' => [
                                    'id' => $detailId->id
                                ],
                                'options' => [
                                    'headers' => [
                                        'TableName' => 'OrderVacationDetail'
                                    ]
                                ]
                            ]);

                            if($dataDeleteDetail->hasError){
                                return eH($dataDeleteDetail);
                            }

                        }
                    }

                }

                if($orderTypeLabel!='vacation'){
//                    dd(json_encode($request->all()));
                    $data = Service::request([
                        'method' => 'PUT',
                        'url' => Service::url('hr', 'orderCommons/' . $id, false),
                        'options' => [
                            'headers' => [
                                'TableName' => ''
                            ],
                            'json' => [
                                'listOrderTypeId' => [
                                    'id' => $request->get('listOrderTypeId')
                                ],
                                'orderNum' => $request->get('orderNumber'),
                                'orderDate' => date('U', strtotime($request->get('orderDate'))) * 1000,
                                'basis' => $request->get('orderBasis'),
                                //pass the key and your array to request body
                                $keys[$orderTypeLabel] => $postArray
                            ]
                        ]
                    ]);

                    if($data->hasError){
                        return eH($data);
                    }
                }

                if($orderTypeLabel=='vacation'){

                        $data = Service::request([
                            'method' => 'PUT',
                            'url' => Service::url('hr', 'crud'),
                            'options' => [
                                'headers' => [
                                    'TableName' => 'OrderCommon'
                                ],
                                'json' => [
                                    'id'=>$id,
                                    'listOrderTypeId' => [
                                        'id' => $request->get('listOrderTypeId')
                                    ],
                                    'orderNum' => $request->get('orderNumber'),
                                    'orderDate' => date('U', strtotime($request->get('orderDate'))) * 1000,
                                    'basis' => $request->get('orderBasis')

                                ]
                            ]
                        ]);

                        if($data->hasError){
                            return eH($data);
                        }
                        $orderVacationData = Service::request([
                            'method' => 'GET',
                            'url' => Service::url('hr', 'crud'),
                            'params' => [
                                'sc' => ['id'],
                                'filter' => '"orderCommonId.id":%7B"=":"' . $id . '"%7D',
                            ],
                            'options' => [
                                'headers' => [
                                    'TableName' => 'OrderVacation'
                                ]
                            ]
                        ]);

                        if($orderVacationData->hasError){
                            return eH($orderVacationData);
                        }

                        $userId = $request->userId;
                        $posId = Service::request([
                            'method' => 'GET',
                            'url' => Service::url('hr', 'crud'),
                            'params' => [
                                'sc' => ['id', 'positionId.id', 'orderAppointmentId.id'],
                                'filter' => '"isclosed" : {"=":false}, "userId.id" : { "=" : "' . $userId . '" }'
                            ],
                            'options' => [
                                'headers' => [
                                    'TableName' => 'UserPosition'
                                ]
                            ]
                        ]);

                        if($posId->hasError){
                            return eH($posId);
                        }

                        $positionId = $posId->data[0]->positionIdId;

                        $dataUpdateOrderVacation = Service::request([
                            'method' => 'PUT',
                            'url' => Service::url('hr', 'crud'),
                            'options' => [
                                'headers' => [
                                    'TableName' => 'OrderVacation'
                                ],
                                'json' => [
                                    'id'=>$orderVacationData->data[0]->id,
                                    'orderCommonId' => [
                                        'id' => $id
                                    ],
                                    'userId' => [
                                        'id' => $userId
                                    ],
                                    'listVacationTypeId' => [
                                        'id' => $request->listVacationTypeId
                                    ],
                                    'vacationComment' => 'smth',
                                    'positionId' => [
                                        'id' => $positionId
                                    ]
                                ]
                            ]
                        ]);

                        if($dataUpdateOrderVacation->hasError){
                            return eH($dataUpdateOrderVacation);
                        }

                        $dataOrderVacationDetail = Service::request([
                            'method' => 'GET',
                            'url' => Service::url('hr', 'crud'),
                            'params' => [
                                'sc' => ['id', 'dateCreated', 'totalMainVacationDay', 'totalAdditionVacationDay', 'mainVacationDay', 'totalVacationDay', 'additionVacationDay', 'additionRemainderVacationDay', 'vacationWorkPeriodFrom', 'vacationWorkPeriodTo', 'workStartDate', 'startDate', 'endDate'],
                                'filter' => '"orderVacationId.id":%7B"=":"' . $orderVacationData->data[0]->id . '"%7D',
                            ],
                            'options' => [
                                'headers' => [
                                    'TableName' => 'OrderVacationDetail'
                                ]
                            ]
                        ]);

                        if($dataOrderVacationDetail->hasError){
                            return eH($dataOrderVacationDetail);
                        }

                    if(!isset($request->hiddenDetail)){
                                foreach ($request->vacationWorkPeriodFrom as $key=>$val){

                                    if($key=='0' && isset($request['hiddenForKm'])){

                                    $dataInsertOrderVacationDetail = Service::request([
                                        'method' => 'POST',
                                        'url' => Service::url('hr', 'crud'),
                                        'options' => [
                                            'headers' => [
                                                'TableName' => 'OrderVacationDetail'
                                            ],
                                            'json' => [
                                                'orderVacationId' => [
                                                    'id' => $orderVacationData->data[0]->id
                                                ],
                                                'startDate' => date('U', strtotime($request->vacationStartDate[$key])) * 1000,
                                                'endDate' => date('U', strtotime($request->vacationEndDate[$key])) * 1000,
                                                'vacationWorkPeriodFrom' => date('U', strtotime($request->vacationWorkPeriodFrom[$key])) * 1000,
                                                'vacationWorkPeriodTo' => date('U', strtotime($request->vacationWorkPeriodTo[$key])) * 1000,
                                                'totalVacationDay' =>'0',
                                                'mainVacationDay' => '0',
                                                'mainRemainderVacationDay' => '0',
                                                'additionVacationDay' => '0',
                                                'additionRemainderVacationDay' =>'0',
                                                'workStartDate' =>'0',
                                                'totalMainVacationDay' =>'0',
                                                'totalAdditionVacationDay' => '0'
                                            ]
                                        ]
                                    ]);

                                        if($dataInsertOrderVacationDetail->hasError){
                                            return eH($dataInsertOrderVacationDetail);
                                        }

                                }

                                else {

                                    $dataInsertOrderVacationDetail = Service::request([
                                        'method' => 'POST',
                                        'url' => Service::url('hr', 'crud'),
                                        'options' => [
                                            'headers' => [
                                                'TableName' => 'OrderVacationDetail'
                                            ],
                                            'json' => [
                                                'orderVacationId' => [
                                                    'id' => $orderVacationData->data[0]->id
                                                ],
                                                'startDate' => date('U', strtotime($request->vacationStartDate[$key])) * 1000,
                                                'endDate' => date('U', strtotime($request->vacationEndDate[$key])) * 1000,
                                                'vacationWorkPeriodFrom' => date('U', strtotime($request->vacationWorkPeriodFrom[$key])) * 1000,
                                                'vacationWorkPeriodTo' => date('U', strtotime($request->vacationWorkPeriodTo[$key])) * 1000,
                                                'totalVacationDay' => $request->chosenAmount[$key],
                                                'mainVacationDay' => $request->rmainVacation[$key],
                                                'mainRemainderVacationDay' => abs($request->currentMainVacation[$key] - $request->rmainVacation[$key]),
                                                'additionVacationDay' => $request->radditionalVacation[$key],
                                                'additionRemainderVacationDay' => abs($request->additionalRemainderVacationDay[$key] - $request->radditionalVacation[$key]),
                                                'workStartDate' => date('U', strtotime($request->wsDate)) * 1000,
                                                'totalMainVacationDay' => $request->mainVacationDayForPerson[$key],
                                                'totalAdditionVacationDay' => $request->currentAdditionalVacation[$key]
                                            ]
                                        ]
                                    ]);

                                    if($dataInsertOrderVacationDetail->hasError){
                                        return eH($dataInsertOrderVacationDetail);
                                    }
                                }

                                $totalSum=(int)$request->chosenAmount[$key]+(int)$request->mainRemainderVacationDay[$key];
                                if($totalSum>$request->mainVacationDayForPerson[$key]){

                                    $dataOrderVacationDetailAdd = Service::request([
                                        'method' => 'POST',
                                        'url' => Service::url('hr', 'crud'),
                                        'options' => [
                                            'headers' => [
                                                'TableName' => 'OrderVacationDetailAdd'
                                            ],
                                            'json' => [
                                                'orderVacationDetailId' => [
                                                    'id' => $dataInsertOrderVacationDetail->body['data']['id']
                                                ],
                                                'totalExperienceDay' => (int)$request->totalExperienceDay[$key],
                                                'totalWorkConditionDay' => (int)$request->totalWorkConditionDay[$key],
                                                'totalChild142' => (int)$request->totalChild142[$key],
                                                'totalChild143' => (int)$request->totalChild143[$key],
                                                'experienceDay' => (int)$request->experienceDay[$key],
                                                'workConditionDay' => (int)$request->workConditionDay[$key],
                                                'child142' => (int)$request->child142[$key],
                                                'child143' => $request->child143[$key],
                                                'remaindeExperienceDay' => (int)$request->remaindeExperienceDay[$key],
                                                'remaindeWorkConditionDay' => (int)$request->remaindeWorkConditionDay[$key],
                                                'remaindeChild142' => $request->remaindeChild142[$key],
                                                'remaindeChild143' => $request->remaindeChild143[$key]
                                            ]
                                        ]
                                    ]);

                                    if($dataOrderVacationDetailAdd->hasError){
                                        return eH($dataOrderVacationDetailAdd);
                                    }

                                }
                                else {


                                    $dataOrderVacationDetailAdd = Service::request([
                                        'method' => 'POST',
                                        'url' => Service::url('hr', 'crud'),
                                        'options' => [
                                            'headers' => [
                                                'TableName' => 'OrderVacationDetailAdd'
                                            ],
                                            'json' => [
                                                'orderVacationDetailId' => [
                                                    'id' => $dataInsertOrderVacationDetail->body['data']['id']
                                                ],
                                                'totalExperienceDay' => '0',
                                                'totalWorkConditionDay' => '0',
                                                'totalChild142' => '0',
                                                'totalChild143' => '0',
                                                'experienceDay' => (int)$request->experienceDay[$key],
                                                'workConditionDay' => (int)$request->workConditionDay[$key],
                                                'child142' => (int)$request->child142[$key],
                                                'child143' => $request->child143[$key],
                                                'remaindeExperienceDay' => (int)$request->experienceDay[$key],
                                                'remaindeWorkConditionDay' => (int)$request->workConditionDay[$key],
                                                'remaindeChild142' => (int)$request->child142[$key],
                                                'remaindeChild143' => (int)$request->child143[$key]
                                            ]
                                        ]
                                    ]);

                                    if($dataOrderVacationDetailAdd->hasError){
                                        return eH($dataOrderVacationDetailAdd);
                                    }
                                }

                                $dataVacationCollectiveDetail = Service::request([
                                    'method' => 'POST',
                                    'url' => Service::url('hr', 'crud'),
                                    'options' => [
                                        'headers' => [
                                            'TableName' => 'OrderVacationCollectiveDetail'
                                        ],
                                        'json' => [
                                            'orderVacationDetailId' => [
                                                'id' => $dataInsertOrderVacationDetail->body['data']['id']
                                            ],
                                            'allWomenDay' => (int)$request->commonAllWomenDay[$key],
                                            'child142' => (int)$request->commonKvChild142[$key],
                                            'child143' => (int)$request->commonKvChild143[$key],
                                            'chernobylAccidenDay' => (int)$request->commonChernobylAccident[$key],
                                            'remaindeAllWomenDay' =>(int)$request->remaindeAllWomenDay[$key],
                                            'remaindeChild142' => (int)$request->kvRemaindeChild142[$key],
                                            'remaindeChild143' => (int)$request->kvRemaindeChild143[$key],
                                            'remaindeChernobylAccidenDay' => (int)$request->remaindeChernobylAccidenDay[$key],
                                            'totalAllWomenDay' => (int)$request->allWomenDay[$key],
                                            'totalChild142' => (int)$request->kvChild142[$key],
                                            'totalChild143' => $request->kvChild143[$key],
                                            'totalChernobylAccidenDay' => $request->chernobylAccident[$key]
                                        ]
                                    ]
                                ]);

                                    if($dataVacationCollectiveDetail->hasError){
                                        return eH($dataVacationCollectiveDetail);
                                    }
                            }

                    }
                    else {

//                        foreach ($request->vacationWorkPeriodFrom as $key=>$val){
//
//                            $dataUpdateOrderVacationDetail = Service::request([
//                                'method' => 'PUT',
//                                'url' => Service::url('hr', 'crud'),
//                                'options' => [
//                                    'headers' => [
//                                        'TableName' => 'OrderVacationDetail'
//                                    ],
//                                    'json' => [
//                                        'id' => $request->hiddenDetail[$key],
//                                        'orderVacationId' => [
//                                            'id' => $orderVacationData->data[0]->id
//                                        ],
//                                        'startDate' => date('U', strtotime($request->vacationStartDate[$key])) * 1000,
//                                        'endDate' => date('U', strtotime($request->vacationEndDate[$key])) * 1000,
//                                        'vacationWorkPeriodFrom' => date('U', strtotime($request->vacationWorkPeriodFrom[$key])) * 1000,
//                                        'vacationWorkPeriodTo' => date('U', strtotime($request->vacationWorkPeriodTo[$key])) * 1000,
//                                        'totalVacationDay' =>(int) $request->mainRemainderVacationDay[$key]+(int)$request->additionalVacationDay[$key],
//                                        'mainVacationDay' => $request->mainRemainderVacationDay[$key],
//                                        'mainRemainderVacationDay' => $request->currentMainVacation[$key],
//                                        'additionVacationDay' => $request->additionalVacationDay[$key],
//                                        'additionRemainderVacationDay' => $request->additionalRemainderVacationDay[$key],
//                                        'workStartDate' => date('U', strtotime($request->wsDate)) * 1000,
//                                        'totalMainVacationDay' => $request->mainVacationDayForPerson[$key],
//                                        'totalAdditionVacationDay' => $request->currentAdditionalVacation[$key]
//                                    ]
//                                ]
//                            ]);
//
//                            $dataUpdateOrderVacationDetailAdd = Service::request([
//                            'method' => 'PUT',
//                            'url' => Service::url('hr', 'crud'),
//                            'options' => [
//                                'headers' => [
//                                    'TableName' => 'OrderVacationDetailAdd'
//                                ],
//                                'json' => [
//                                    'id' => $request->hiddenAdd[$key],
//                                    'orderVacationDetailId' => [
//                                        'id' => $request->hiddenDetail[$key]
//                                    ],
//                                    'totalExperienceDay' => (int)$request->totalExperienceDay[$key],
//                                    'totalWorkConditionDay' => (int)$request->totalWorkConditionDay[$key],
//                                    'totalChild142' => (int)$request->totalChild142[$key],
//                                    'totalChild143' => (int)$request->totalChild143[$key],
//                                    'experienceDay' => (int)$request->experienceDay[$key],
//                                    'workConditionDay' => (int)$request->workConditionDay[$key],
//                                    'child142' => (int)$request->child142[$key],
//                                    'child143' => $request->child143[$key],
//                                    'remaindeExperienceDay' => (int)$request->remaindeExperienceDay[$key],
//                                    'remaindeWorkConditionDay' => (int)$request->remaindeWorkConditionDay[$key],
//                                    'remaindeChild142' => $request->remaindeChild142[$key],
//                                    'remaindeChild143' => $request->remaindeChild143[$key]
//                                ]
//                            ]
//                        ]);
//
//                            $dataUpdateVacationCollectiveDetail = Service::request([
//                            'method' => 'PUT',
//                            'url' => Service::url('hr', 'crud'),
//                            'options' => [
//                                'headers' => [
//                                    'TableName' => 'OrderVacationCollectiveDetail'
//                                ],
//                                'json' => [
//                                    'id' => $request->hiddenCollective[$key],
//                                    'orderVacationDetailId' => [
//                                        'id' => $request->hiddenDetail[$key]
//                                    ],
//                                    'allWomenDay' => (int)$request->commonAllWomenDay[$key],
//                                    'child142' => (int)$request->commonKvChild142[$key],
//                                    'child143' => (int)$request->commonKvChild143[$key],
//                                    'chernobylAccidenDay' => (int)$request->commonChernobylAccident[$key],
//                                    'remaindeAllWomenDay' =>(int)$request->remaindeAllWomenDay[$key],
//                                    'remaindeChild142' => (int)$request->kvRemaindeChild142[$key],
//                                    'remaindeChild143' => (int)$request->kvRemaindeChild143[$key],
//                                    'remaindeChernobylAccidenDay' => (int)$request->remaindeChernobylAccidenDay[$key],
//                                    'totalAllWomenDay' => (int)$request->allWomenDay[$key],
//                                    'totalChild142' => (int)$request->kvChild142[$key],
//                                    'totalChild143' => $request->kvChild143[$key],
//                                    'totalChernobylAccidenDay' => $request->chernobylAccident[$key]
//                                ]
//                            ]
//                        ]);
//
//                        }

                    }

                    }

                }

                $data->data->orderDate = date('d.m.Y', $data->data->orderDate / 1000);
                $data->data->listOrderTypeId->name = OrderTypeController::getOrderTypeNameById($request->get('listOrderTypeId'));

                return response()->json($data);


//        }
//        catch (\Exception $e){
//
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        try {

            $data = Service::request([
                'method' => 'DELETE',
                'url' => Service::url('hr', 'orderCommons/' . $id, false),
                'options' => [
                    'headers' => []
                ]
            ]);

            if($data->hasError){
                return eH($data);
            }
            return $data->code;

//        } catch (\Exception $e){
//
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//
//        }

    }


    /**
     *
     * Written by anonymous and does something unknown
     * @return \Illuminate\Http\JsonResponse
     */
    public function listOrders()
    {
        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['orderNum', 'id']
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderCommon'
                ]
            ]
        ]);
        if($data->hasError){

            return eH($data);
        }
        $select = [];

        if ($data->totalCount > 0) {

            foreach ($data->data as $item) {

                $select[] = (object)[
                    'id' => $item->id,
                    'text' => $item->orderNum
                ];

            }

        }

        return response()->json($select);
    }

    /* download file */
    public function fileDownload(Request $request){
        //header part
        header("Content-type: application/vinod.ms-word");
        header("Content-Disposition: attachment;Filename=".uniqid().".doc");
        echo "<html>
             <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
             <body>
             <p>&nbsp;</p>
             <p>&nbsp;</p>
             <p>&nbsp;</p>
             <p>&nbsp;</p>
             $request->html
             </body>
             </html>";
    }

    /* generate file */
    public function genFile(Request $request)
    {

        $string = str_replace('\\', '/', $request->obj);
        $string = preg_replace("/[\r\n]+/", " ", $string);
        $obj = json_decode($string);

        $file = new DocxConversion;
//        dd($request->all());
//

        $file = $file->makeFile($obj, $request->get('label'));

        return $file;
    }

    /**
     *
     * Get reamining vacation days
     *
     * @param $userId
     * @param $date
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRemainingVacationDays($userId, $date)
    {
//        try {

            /* generate query string for custom service */
            $queryString = 'remainingDays?userId='.$userId.'&date='.$date;

            /* make service call */
            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'orderCommons/'.$queryString, false),
                'options' => [
                    'headers' => []
                ]
            ]);
        if($data->hasError){

            return eH($data);
        }

            /* prepare default response */
//
//            orderVacationId.$userId

            $OrderVacationDetail = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     =>  ['id'],
                    'filter' => '"orderVacationId.userId" : { "=" : "'.$userId.'" }'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationDetail'
                    ]
                ]
            ]);
            $response = [
                'code'       => 200,
                'totalCount' => 0,
                'data'       => [ 'vacationDays' => 0, 'additionalVacationDays' => 0 ]
            ];

            if (isset($data->totalCount))
            {
                /* original response */
                $response = $data;
            }

        if($OrderVacationDetail->hasError){
            return eH($data);
        }
            /* return json object */
            return response()->json($response);

//        } catch (\Exception $e){
//
//            /* render the exception */
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//
//        }
    }

    public function getArch($userId)
    {
//        try {

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     =>  ['id', 'additionRemainderVacationDay', 'additionVacationDay', 'mainVacationDay', 'totalVacationDay', 'vacationWorkPeriodFrom', 'vacationWorkPeriodTo'],
                    'filter' =>  '"orderVacationId.userId.id" : { "=" : "'.$userId.'" }',
                    'sort'   => 'dateCreated',
                    'order'  => 'desc'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationDetail'
                    ]
                ]
            ]);

        if($data->hasError){

            return eH($data);
        }
            $dataUser = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     =>  ['id', 'gender'],
                    'filter' =>  '"id" : { "=" : "'.$userId.'" }',


                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'Users'
                    ]
                ]
            ]);

        if($dataUser->hasError){

            return eH($dataUser);
        }
//        dd($userId);
//        dd($dataUser->data[0]->gender);

             $getUserDetails= Service::request([
                'method'  => 'GET',
                'url'    => Service::url('hr', 'orderCommons/orderVacationDetails?userId='.$userId, false),
                'params'  => [
                    'sc'     => ['id', 'startDate']

                ],

                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ]
                ]
            ]);

        if($getUserDetails->hasError){

            return eH($getUserDetails);
        }
//             dd($getUserDetails);
            $dateArray=[];

            if($dataUser->data[0]->gender==0){

                $dataListCollectiveAgreementVacation = Service::request([
                    'method' => 'GET',
                    'url'    => Service::url('hr', 'crud'),
                    'params' => [
                        'sc'     =>  ['id', 'name', 'day', 'label'],
                        'filter' =>  '"label" : { "=" : "edit" }',

                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'ListCollectiveAgreementVacation'
                        ]
                    ]
                ]);

                if($dataListCollectiveAgreementVacation->hasError){

                    return eH($dataListCollectiveAgreementVacation);
                }
                $getUserDetails->add=$dataListCollectiveAgreementVacation->data;
            }

            $getUserDetails->dateArray=$dateArray;

            foreach ($getUserDetails->data as $arr){

                foreach($arr as $key=>$val){

                    if($key=='child-14-13'){

                        $arr->child_14_13=$val;
                    }
                    if($key=='remainderChild-14-2'){

                       $arr->remainderChild_14_12=$val;
                    }
                    if($key=='remainderChild-14-3'){

                        $arr->remainderChild_14_13=$val;
                    }
                    if($key=='child-14-12'){

                        $arr->child_14_12=$val;
                    }
                    if($key=='fromDate'){

                        $arr->fromDate=date('d.m.Y', strtotime($arr->fromDate));
                    }
                    if($key=='toDate'){

                        $arr->toDate=date('d.m.Y', strtotime($arr->toDate));
                    }

                }


            }

//            dd($getUserDetails);
            return response()->json($getUserDetails);

//        } catch (\Exception $e){
//
//            /* render the exception */
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//
//        }
    }

    public function getAdditionalVacationDays($userId)
    {
//        try {

            $getAdditionalVacationDaysForPerson = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     =>  ['id', 'name', 'day', 'durationTypeId.name'],
                    'sort'   => 'dateCreated',
//                    'filter' => '"isMain":%7B"=":"true"%7D',
                    'order'  => 'desc'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListCollectiveAgreementVacation'
                    ]
                ]
            ]);

            if($getAdditionalVacationDaysForPerson->hasError){

                return eH($getAdditionalVacationDaysForPerson);

            }

            /* return json object */
//            return response()->json($getAdditionalVacationDaysForPerson);
//
//        } catch (\Exception $e){

            /* render the exception */
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//
//        }
    }

    public function calculateVacationDay($totalday, $vacationStartDate, $userid){

        if($totalday=='0'){

            return response()->json(['code'=>'Xəta', 'notselected'=>'Xahiş olunur aralıq dövrünü düzgün seçəsiniz']);

        }
        else {

            $vacationEndDate=date('Y-m-d', strtotime($vacationStartDate)+$totalday*86400);

            $vacationStartDate=date('Y-m-d', strtotime($vacationStartDate));

        }

        $checkVacationDay= Service::request([
            'method'  => 'GET',
            'url'    => Service::url('hr', 'orderCommons/restDays?startDate='.$vacationStartDate.'&endDate='.$vacationEndDate, false),

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        if($checkVacationDay->hasError){

            return eH($checkVacationDay);
        }

        $days=0;


        foreach ($checkVacationDay->data as $key=>$val){

            if(strtotime($vacationStartDate)>strtotime($checkVacationDay->data[$key]->startDate)){

                $reminderDay=(strtotime($checkVacationDay->data[$key]->endDate)-strtotime($vacationStartDate))/86400;

            }
            else {
                $reminderDay=(strtotime($checkVacationDay->data[$key]->endDate)-strtotime($checkVacationDay->data[$key]->startDate))/86400;

            }

            $days=$days+$reminderDay;
        }


        $latestEndDate=(object)['data'=>date('Y-m-d', strtotime($vacationEndDate)-86400+$days*86400)];


//        dd($lastendDate, $vacationStartDate);
        $controlVacationDay= Service::request([
            'method'  => 'GET',
            'url'    => Service::url('hr', 'orderCommons/vacationControl?userId='.$userid.'&fromDate='.$vacationStartDate.'&toDate='.$latestEndDate->data, false),

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        if($checkVacationDay->hasError){

            return eH($controlVacationDay);
        }

        if($controlVacationDay->data->result!='ok'){

            return response()->json(['code'=>'Xəta', 'notselected'=>'Seçilmiş dövrdə işçiyə '.$controlVacationDay->data->result.' verilmişdir']);
        }


        return response()->json($latestEndDate);

    }

    public function calculateVacationDay2($vacationStartDate, $vacationEndDate, $userid){

        $diffDays=(strtotime($vacationEndDate)-strtotime($vacationStartDate))/86400;

        $vacationStartDate=date('Y-m-d', strtotime($vacationStartDate));

        $vacationEndDate=date('Y-m-d', strtotime($vacationEndDate));

        $checkVacationDay= Service::request([
            'method'  => 'GET',
            'url'    => Service::url('hr', 'orderCommons/restDays?startDate='.$vacationStartDate.'&endDate='.$vacationEndDate, false),

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        if($checkVacationDay->hasError){

            return eH($checkVacationDay);
        }

        $days=0;


        foreach ($checkVacationDay->data as $key=>$val){

            if(strtotime($vacationStartDate)>strtotime($checkVacationDay->data[$key]->startDate)){

                $reminderDay=(strtotime($checkVacationDay->data[$key]->endDate)-strtotime($vacationStartDate))/86400;

            }
            else {
                $reminderDay=(strtotime($checkVacationDay->data[$key]->endDate)-strtotime($checkVacationDay->data[$key]->startDate))/86400;

            }

            $days=$days+$reminderDay;
        }

        $latestEndDate=(object)['data'=>date('Y-m-d', strtotime($vacationEndDate)-$days*86400)];

        $lastendDate=date('Y-m-d', strtotime($latestEndDate->data)-86400);

//        dd($lastendDate, $vacationStartDate);
        $controlVacationDay= Service::request([
            'method'  => 'GET',
            'url'    => Service::url('hr', 'orderCommons/vacationControl?userId='.$userid.'&fromDate='.$vacationStartDate.'&toDate='.$lastendDate, false),

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        $latestEndDate->data=date('d.m.Y', strtotime($latestEndDate->data));
        if($checkVacationDay->hasError){

            return eH($controlVacationDay);
        }

        if($controlVacationDay->data->result!='ok'){

            return response()->json(['code'=>'Xəta', 'notselected'=>'Seçilmiş dövrdə işçiyə '.$controlVacationDay->data->result.' verilmişdir']);
        }


        return response()->json($latestEndDate);

    }

    public function getPermanentVacation($userId, $orderCommonId){

        $checkVacationDay= Service::request([
            'method'  => 'GET',
            'url'    => Service::url('hr', '/orderCommons/orderVacationDetailsEdit?userId='.$userId.'&orderCommonId='.$orderCommonId, false),

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        if($checkVacationDay->hasError){

            return eH($checkVacationDay);
        }
        foreach ($checkVacationDay->data as $arr){

            foreach($arr as $key=>$val){

                if($key=='child-14-13'){

                    $arr->child_14_13=$val;
                }
                if($key=='remainderChild-14-2'){

                    $arr->remainderChild_14_12=$val;
                }
                if($key=='remainderChild-14-3'){

                    $arr->remainderChild_14_13=$val;
                }
                if($key=='child-14-12'){

                    $arr->child_14_12=$val;
                }
                if($key=='fromDate'){

                    $arr->fromDate=date('d.m.Y', strtotime($arr->fromDate));
                }
                if($key=='toDate'){

                    $arr->toDate=date('d.m.Y', strtotime($arr->toDate));
                }

            }


        }

        return response()->json($checkVacationDay);

    }

    public static function getVacationLabelById($id){
        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id', 'label','name'],
                'filter' => '"id":%7B"=":"'.$id.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListVacationType'
                ]
            ]
        ]);

        if($data->hasError){

            return eH($data);
        }
        return $data->data[0]->label;
    }



}
