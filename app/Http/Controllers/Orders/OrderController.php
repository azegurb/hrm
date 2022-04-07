<?php

namespace App\Http\Controllers\Orders;

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
        try {

            /* get all fields and values to filter the result */
            $columns = $request->get('column');
            $values = $request->get('value');
            $filterTypes = $request->get('filterType');

            $filter = '';

            /* if columns are not empty */
            if (count($columns) > 0) {

                /* generate query string for each */
                foreach ($columns as $key => $column) {
                    if ($values[$key] != 'null')
                        $filter .= '"' . $column . '":%7B"' . $filterTypes[$key] . '":"' . $values[$key] . '"%7D';
                    if ($key != count($columns) - 1) $filter .= ',';
                }
            }

            /* call the service */


            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'listOrderTypeId', 'orderNum', 'orderDate'],
                    'offset' => $this->offset,
                    'max' => $this->limit,
                    'filter' => $filter,
                    'sort' => 'dateCreated',
                    'order' => 'desc'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

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

                return view('pages.orders.index', compact('data', 'page'));
            }

        } catch (\Exception $e) {

            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return app('App\Http\Controllers\Orders\ModalController')->common();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function insertVacationDetail(Request $request, $orderCommonId)
    {

        try {
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

            foreach ($dataOrderVacationDetail->data as $vacationDetail) {

                $fromPeriod = $vacationDetail->vacationWorkPeriodFrom;

                foreach ($request->$fromPeriod as $key => $val) {

                    $day_key = $request->$fromPeriod . '_day';

                    $dataOrderVacationAdditionDetail = Service::request([
                        'method' => 'POST',
                        'url' => Service::url('hr', 'crud'),
                        'options' => [
                            'headers' => [
                                'TableName' => 'OrderVacationAdditionDetail'
                            ],
                            'json' => [
                                'orderVacationDetailId' => [
                                    'id' => $vacationDetail->id
                                ],
                                'listVacationAdditionalTypesId' => [
                                    'id' => $request->$fromPeriod[$key]
                                ],
                                'day' => $request->$day_key[$key]
                            ]
                        ]
                    ]);

                }

            }

        } catch (\Exception $e) {

            return exceptionH(\Request::ajax(), 500, $e->getMessage());

        }


    }

    /**
     * @param $data
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function sabbaticalLeaveInsert($data)
    {

        if (isset($data['durationTypeHidden']) && $data['durationTypeHidden'] == 'Ay') {

            $today = date('Y-m-d');
            $date = strtotime(date("Y-m-d", strtotime($today)) . " +2 month");
            $date = date("Y-m-d", $date);
            $data['vacationDay'] = (strtotime($date) - strtotime($today)) / 86400;

        }

        $listVacationType = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'name', 'label'],
                'filter' => '"id" : { "=" : "' . $data['listVacationTypeId'] . '" }'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListVacationType'
                ]
            ]
        ]);

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
                    'vacationComment' => 'smth',
                    'positionId' => [
                        'id' => $positionId
                    ]
                ]
            ]
        ]);

        $orderVacationId = $dataOrderVacation->body['data']['id'];

        if($listVacationType->data[0]->label=='nonpaid_vacation' || $listVacationType->data[0]->label=='collective_agreement') {
            $dataOrderVacationOtherDetail = Service::request([
                'method' => 'POST',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationOtherDetail'
                    ],
                    'json' => [
                        'endDate' => date('Y-m-d', strtotime($data['vacationEndDate'])),
                        'listVacationId' => null,

                        'orderVacationId' => [
                            'id' => $orderVacationId
                        ],


                        'startDate' => date('Y-m-d', strtotime($data['vacationStartDate'])),
                        'vacationDay' => (int)$data['vacationDay'],
                        'workStartDate' => date('Y-m-d', strtotime($data['workStartDate']))
                    ]
                ]
            ]);

        }
        else {

            $dataOrderVacationOtherDetail = Service::request([
                'method' => 'POST',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationOtherDetail'
                    ],
                    'json' => [
                        'endDate' => date('Y-m-d', strtotime($data['vacationEndDate'])),
                        'listVacationId' => [
                            'id' => (int)$data['sabbaticalLeaveName']
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

        }

        return $dataOrderVacationOtherDetail;

    }

    /**
     * @param $id
     * @param $data
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function sabbaticalLeaveUpdate($id, $data)
    {


        $dataOrderCommon = Service::request([
            'method' => 'PUT',
            'url' => Service::url('hr', 'crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderCommon'
                ],
                'json' => [
                    'id' => $id,
                    'listOrderTypeId' => [
                        'id' => $data['listOrderTypeId']
                    ],
                    'orderNum' => $data['orderNumber'],
                    'orderDate' => date('Y-m-d', strtotime($data['orderDate'])),
                    'basis' => $data['orderBasis']

                ]
            ]
        ]);

        $orderCommonid = $id;

        $listVacationType = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'name', 'label'],
                'filter' => '"id" : { "=" : "' . $data['listVacationTypeId'] . '" }'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListVacationType'
                ]
            ]
        ]);

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


        $positionId = $posId->data[0]->positionIdId;

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

        $orderVacationId = $dataOrderVacation->data[0]->id;
        $dataOrderVacation = Service::request([
            'method' => 'PUT',
            'url' => Service::url('hr', 'crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderVacation'
                ],
                'json' => [
                    'id' => $orderVacationId,
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

        $dataOrderVacationOtherDetails = Service::request([
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

        $orderVacationOtherDetailId = $dataOrderVacationOtherDetails->data[0]->id;

        if($listVacationType->data[0]->label=='nonpaid_vacation'){

            $dataOrderVacationOtherDetail = Service::request([
                'method' => 'PUT',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationOtherDetail'
                    ],
                    'json' => [
                        'id' => $orderVacationOtherDetailId,
                        'endDate' => date('Y-m-d', strtotime($data['vacationEndDate'])),
                        'orderVacationId' => [
                            'id' => $orderVacationId
                        ],
                        'listVacationId' => null,
                        'startDate' => date('Y-m-d', strtotime($data['vacationStartDate'])),
                        'vacationDay' => (int)$data['vacationDay'],
                        'workStartDate' => date('Y-m-d', strtotime($data['workStartDate']))
                    ]
                ]
            ]);
        }
        else {

             $dataOrderVacationOtherDetail = Service::request([
                'method' => 'PUT',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationOtherDetail'
                    ],
                    'json' => [
                        'id' => $orderVacationOtherDetailId,
                        'endDate' => date('Y-m-d', strtotime($data['vacationEndDate'])),
                        'orderVacationId' => [
                            'id' => $orderVacationId
                        ],
                        'listVacationId' => [
                            'id' => (int)$data['sabbaticalLeaveName']
                        ],
                        'startDate' => date('Y-m-d', strtotime($data['vacationStartDate'])),
                        'vacationDay' => (int)$data['vacationDay'],
                        'workStartDate' => date('Y-m-d', strtotime($data['workStartDate']))
                    ]
                ]
            ]);
        }


        return $dataOrderVacationOtherDetail;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //get order type label from request. (e.g. busines  sTrip)
        $orderTypeLabel = $request->get('orderTypeLabel');

        //each orderType has its own column name in OrderCommon table
        //define them by labels
        //e.g below

//        dd($request->get('listVacationTypeIdLabel'), $request->all());

        if (!isset($request->vacationWorkPeriodFrom) && $orderTypeLabel == 'vacation' && $request->get('listVacationTypeIdLabel') == 'labor_vacation') {

            return response()->json(['code' => 'Xəta', 'notselected' => 'Xahiş olunur ən azı bir məzuniyyət dövrü seçəsiniz']);

        }

        $keys = [
            'businessTrip' => 'orderBusinessTripList',
            'vacation' => 'orderVacationList',
            'appointment' => 'orderAppointmentList',
            'assignment' => 'orderAppointmentList',
            'replacement' => 'orderAppointmentList',
            'dismissal' => 'orderDismissalList',
            'salaryAddition' => 'salaryAdditionList',
            'nonWorkingDaysSelection' => 'orderRestDayList',
            'staff-add' => 'positionList',
            'additionalWorkTime' => 'orderExcessWorkList',
            'Reward' => 'userRewardIndividualList'
        ];

        //pass orderTypeLabel to POSTArrayFactory to get specific array for your own orderType
        //write your own function in OrderTypePostArrayFactory and define it in getPostArray() method
        //it will be switching  by orderType label

        if ($request->get('listVacationTypeIdLabel') != 'sabbatical_leave') {

            $postArray = $this->postArrayFactory->getPostArray($orderTypeLabel, $request);
        }


        try {


            if ($orderTypeLabel == "financialAid") {

                //insert financial Aid Order
                $data = OrderFinancialAidController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            } elseif ($orderTypeLabel == "salaryAddition") {

                //insert financial Aid Order


                $data = OrderSalaryAddtiionController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            } elseif ($orderTypeLabel == "salaryDeduction") {

                //insert financial Aid Order
                $data = OrderSalaryDeductionController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            } elseif ($orderTypeLabel == "QualificationDegree") {

                //insert financial Aid Order
                $data = OrderQualificationDegreeController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            } elseif ($request->get('listVacationTypeIdLabel') == 'sabbatical_leave' || $request->get('listVacationTypeIdLabel') == 'nonpaid_vacation' || $request->get('listVacationTypeIdLabel') == 'collective_agreement') {

                $vacationStartDate = date('Y-m-d', strtotime($request->vacationStartDate));
                $vacationEndDate = date('Y-m-d', strtotime($request->vacationEndDate));

                $controlVacationDay = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'orderCommons/vacationControl?userId=' . $request->userId . '&fromDate=' . $vacationStartDate . '&toDate=' . $vacationEndDate, false),

                    'options' => [
                        'headers' => [
                            'TableName' => ''
                        ]
                    ]
                ]);

                if ($controlVacationDay->data->result != 'ok') {

                    return response()->json(['code' => 'Xəta', 'notselected' => 'Seçilmiş dövrdə işçiyə ' . $controlVacationDay->data->result . ' verilmişdir']);
                }

                $data = $this->sabbaticalLeaveInsert($request->all());

                return response()->json($data);
            } elseif ($orderTypeLabel == "appointmentDTO") {

                //insert  Order
                $data = OrderAppointmentController::insertOrderTransfer($request, $postArray);

                return response()->json($data);

                // Custom Service for Orders
            } elseif ($orderTypeLabel == "discipline") {

                //insert  Order
                $data = OrderDisciplineController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            } elseif ($orderTypeLabel == "warning") {

                //insert  Order
                $data = OrderWarningController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            } elseif ($orderTypeLabel == "staffOpening") {

                //insert  Order
                $data = OrderStaffAddController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            } elseif ($orderTypeLabel == "damage") {

                //insert  Order
                $data = OrderDamageController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            } elseif ($orderTypeLabel == "staffCancellation") {

                //insert  Order
                $data = OrderStaffCancellationController::insertOrder($request);

                return response()->json($data);

                // Custom Service for Orders
            } else if ($orderTypeLabel == "additionalWorkTime") {
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

                return response()->json($data);
            } else if ($orderTypeLabel == "vacationRecall") {

                $request->recallDate = date('Y-m-d', strtotime($request->recallDate));
                $orderVacationByReturnDate = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'orderCommons/orderVacationByReturnDate?userId=' . $request->userId . '&returnDate=' . $request->recallDate, false),

                    'options' => [
                        'headers' => [
                            'TableName' => ''
                        ]
                    ]
                ]);


                if (count((array)$orderVacationByReturnDate->data) == '0') {

                    return response()->json(['code' => 'Xəta', 'notselected' => 'Seçilmiş əməkdaş məzuniyyətdə deyil']);

                }

                $vacationId = $orderVacationByReturnDate->data->orderVacationDetail->orderVacationId->id;
                $request->vacationId = $vacationId;

                $postArray = $this->postArrayFactory->getPostArray($orderTypeLabel, $request);


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

                return response()->json($data);
            } else {


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

                    $data->body['data']['orderDate'] = date('d.m.Y', $data->body['data']['orderDate'] / 1000);
                    $data->body['data']['listOrderTypeId']['name'] = OrderTypeController::getOrderTypeNameById($request->get('listOrderTypeId'));
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

                    $orderVacationId = $dataOrderVacation->body['data']['id'];
                    $detailsArrayforCollectiveAggrement = [];

                    foreach ($request->vacationWorkPeriodFrom as $key => $val) {

                        if ($key == '0' && isset($request['hiddenForKm'])) {

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
                                        'totalVacationDay' => '0',
                                        'mainVacationDay' => '0',
                                        'mainRemainderVacationDay' => '0',
                                        'additionVacationDay' => '0',
                                        'additionRemainderVacationDay' => '0',
                                        'workStartDate' => date('U', strtotime($request->wsDate)) * 1000,
                                        'totalMainVacationDay' => '0',
                                        'totalAdditionVacationDay' => '0'
                                    ]
                                ]
                            ]);

                        } else {

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

                        }

                        if (((int)$request->chosenVal[$key] + (int)$request->mainRemainderVacationDay[$key]) > (int)$request->mainVacationDayForPerson[$key]) {


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

                        } else {

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

                        }

                        $allWomanField = $request->allWomenDay[$key];

                        if ($allWomanField == '0') {

                            $allWomanField = 5;
                        }

                        if ($request->commonKvChild142[$key] > 0) {
                            $child142field = $request->kvChild142[$key];
                            if ($child142field == '0') {

                                $child142field = 1;
                            }

                        } else {

                            $child142field = 0;

                        }
                        if ($request->commonKvChild143[$key] > 0) {
                            $child143field = $request->kvChild143[$key];
                            if ($child143field == '0') {

                                $child143field = 1;
                            }

                        } else {

                            $child143field = 0;

                        }

                        if ($request->commonChernobylAccident[$key] > 0) {
                            $workConditionDayfield = $request->workConditionDay[$key];
                            if ($workConditionDayfield == '0') {

                                $workConditionDayfield = 1;
                            }

                        } else {

                            $workConditionDayfield = 0;

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
                                    'remaindeAllWomenDay' => (int)$request->remaindeAllWomenDay[$key],
                                    'remaindeChild142' => (int)$request->kvRemaindeChild142[$key],
                                    'remaindeChild143' => (int)$request->kvRemaindeChild143[$key],
                                    'remaindeChernobylAccidenDay' => $request->remaindeChernobylAccidenDay[$key],
                                    'totalAllWomenDay' => (int)$request->allWomenDay[$key],
                                    'totalChild142' => (int)$request->kvChild142[$key],
                                    'totalChild143' => (int)$request->kvChild143[$key],
                                    'totalChernobylAccidenDay' => (int)$request->chernobylAccident[$key]
                                ]
                            ]
                        ]);


                    }

                    /*
                     *
                     * new added function by Azer
                     */


                    /*
                     *
                     * ended function
                     */

                    if (isset($request->collectiveVac)) {

                        $periodCheck = $request->periodFromDate;

//                        dd($detailsArrayforCollectiveAggrement, $periodCheck);
                        foreach ($request->collectiveVac as $key1 => $val1) {

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

                        }

                    }


                }

                return response()->json($data);
            }

        } catch (\Exception $e) {

            return exceptionH(\Request::ajax(), 500, $e->getMessage());

        }
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

    public function getSabbaticalLeave()
    {

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

        return response()->json($data);

    }

    /**
     * @param $type
     * @param $amount
     * @param $startDate
     * @return \Illuminate\Http\JsonResponse
     */
    public function countVacationDay($type, $amount, $startDate)
    {

        if ($type == "month") {

            $amount = (int)$amount;

            $str = ($startDate) . " +$amount month";

            $data = date('d.m.Y', strtotime(date("d.m.Y", strtotime($startDate)) . " +$amount month"));

        } else {

            $data = date('d.m.Y', strtotime(date("d.m.Y", strtotime($startDate)) . " +$amount day"));

        }

        return response()->json($data);

    }

    /**
     * @param $type
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSabbaticalVacationDays($type, $userId)
    {


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


        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'value', 'listDurationTypeId.name'],
                'filter' => '"listVacationId.id":%7B"=":"' . $type . '"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListVacationDuration'
                ]
            ]
        ]);


        return response()->json($data);

    }

    /**
     * @param $listVacationTypeId
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function getSabbaticalLeaveSearch($listVacationTypeId)
    {


        try {
            $filter = [];
            $search = !empty(Input::get('q')) ? Input::get('q') : '';
            if (Input::get('select') != null) {

                $label = Input::get('select');
                if ($label == 'root') {
                    $filter['filter'] = '"label":%7B"=":"' . $label . '"%7D, "vacationTypeId":%7B"=":"' . $listVacationTypeId . '"%7D, "name":%7B"contains":"' . $search . '"%7D';
                } else {

                    $label = (int)$label;
                    $filter['filter'] = '"label":%7B"=":"' . $label . '"%7D, "vacationTypeId":%7B"=":"' . $listVacationTypeId . '"%7D, "name":%7B"contains":"' . $search . '"%7D';
                }

            } else {
                $filter['filter'] = '"name":%7B"contains":"' . $search . '"%7D';

            }
            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'name', 'vacationTypeId.label'],
                    'filter' => $filter['filter']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListVacation'
                    ]
                ]
            ]);

            if ($data->totalCount > 0) {
                foreach ($data->data as $item) {
                    $select[] = (object)[
                        'id' => $item->id,
                        'text' => $item->name,
                        'vacationTypeId' => $item->vacationTypeIdLabel
                    ];

                }
                return response()->json($select);
            } else {
                return 404;
            }


        } catch (\Exception $e) {
            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());
        }

    }

    /**
     * @param $label
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSabbaticalChildCount($label)
    {

        try {
            $filter = [];

            if ($label != null) {

                $label = (int)$label;
                $filter['filter'] = '"label":%7B"=":"' . $label . '"%7D';

                $data = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'name'],
                        'filter' => $filter['filter']
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'ListVacation'
                        ]
                    ]
                ]);
            }

            return response()->json($data);

        } catch (\Exception $e) {
            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());
        }

    }

    /**
     * @param $userid
     * @return \Illuminate\Http\JsonResponse
     */
    public function partialPaidSocialVacation($userid)
    {

        try {
            $filter = [];

            $birthDayDates = [];
            if ($userid != null) {

                $data = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'name', 'surname', 'birthDate', 'listFamilyRelationTypesId.id'],
                        'filter' => '"userId.id":%7B"=":"' . $userid . '"%7D, "listFamilyRelationTypesId.label":%7B"=":"child"%7D'
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'UserFamily'
                        ]
                    ]
                ]);

                if (is_array($data->data) && isset($data->data[0])) {
                    foreach ($data->data as $birthDay) {

                        $birthDayDates[] = strtotime($birthDay->birthDate);

                    }

                    $stDate = date('Y-m-d', max($birthDayDates));
                    $lastPossibleDate = date('d.m.Y', strtotime(date("Y-m-d", strtotime($stDate)) . " +3 year"));
                } else {

                    $lastPossibleDate = "Uyğün məlumat tapilmadı";
                }

            }

            return response()->json($lastPossibleDate);

        } catch (\Exception $e) {
            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());
        }

    }

    /**
     * @param $userId
     * @param $periodFrom
     * @param $periodTo
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCollectiveAggrement($userId, $periodFrom, $periodTo)
    {

        $vacationTypesForPerson = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'orderCommons/vacationAddDayTab?userId=' . $userId . '&workPeriodFrom=' . $periodFrom . '&workPeriodTo=' . $periodTo, false),
            'params' => [],
            'options' => [
                'headers' => ['TableName' => '']
            ]
        ]);

        return response()->json($vacationTypesForPerson);

    }

    /**
     * @param $listVacationTypeId
     * @return mixed
     */
    public function checkListVacationType($listVacationTypeId)
    {

        $dataVacation = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'label', 'name'],
                'filter' => '"id":%7B"=":"' . $listVacationTypeId . '"%7D',
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListVacationType'
                ]
            ]
        ]);

        return $dataVacation->data;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
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

        if ($data->data->listOrderTypeId->label == 'vacation') {

            $dataOrderVacation = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'userId.id', 'listVacationTypeId.id', 'userId.firstName', 'userId.lastName', 'userId.patronymic'],
                    'filter' => '"orderCommonId.id":%7B"=":"' . $id . '"%7D',
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacation'
                    ]
                ]
            ]);

//            dd($dataOrderVacation);
            $listVacationTypeId = isset($dataOrderVacation->data[0]->listVacationTypeIdId) ? $dataOrderVacation->data[0]->listVacationTypeIdId : '';

            $orderVacationId = $dataOrderVacation->data[0]->id;

            $label = $this->checkListVacationType($listVacationTypeId);

//            dd($label);
            if ($label[0]->label == 'sabbatical_leave' || $label[0]->label == 'paid_social_vacation' || $label[0]->label == 'paid_educational_vacation' || $label[0]->label == 'collective_agreement' || $label[0]->label == 'nonpaid_vacation' || $label[0]->label == 'partialpaid_social_vacation') {

                $dataVacation = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'orderVacationId.id', 'endDate', 'startDate', 'workStartDate', 'vacationWorkPeriodFrom', 'vacationWorkPeriodTo', 'vacationDay', 'listVacationId.name', 'listVacationId.id'],
                        'filter' => '"orderVacationId.id":%7B"=":"' . $orderVacationId . '"%7D',
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'OrderVacationOtherDetail'
                        ]
                    ]
                ]);


                if($label[0]->label != 'nonpaid_vacation' && $label[0]->label != 'collective_agreement'){

                    $dataListVacationDuration = Service::request([
                        'method' => 'GET',
                        'url' => Service::url('hr', 'crud'),
                        'params' => [
                            'sc' => ['id', 'listDurationTypeId.id', 'listDurationTypeId.name'],
                            'filter' => '"listVacationId.id":%7B"=":"' . $dataVacation->data[0]->listVacationIdId . '"%7D',
                        ],
                        'options' => [
                            'headers' => [
                                'TableName' => 'ListVacationDuration'
                            ]
                        ]
                    ]);
                }


//                dd($label[0]->label);
                $dataUserStructure = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'userId.id', 'positionId.id', 'positionId.posNameId.name', 'positionId.structureId.name'],
                        'filter' => '"userId.id":%7B"=":"' . $dataOrderVacation->data[0]->userIdId . '"%7D',
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'UserPosition'
                        ]
                    ]
                ]);


                $response = (object)[
                    'fields' => [
                        'listOrderTypes' => [
                            'id' => $data->data->listOrderTypeId->id,
                            'text' => $data->data->listOrderTypeId->name
                        ],
                        'orderTypeLabel' => $data->data->listOrderTypeId->label,
                        'orderNumber' => $data->data->orderNum,
                        'orderDate' => date('d.m.Y', strtotime($data->data->orderDate)),
                        'orderBasis' => $data->data->basis,
                        'child' => [
                            'endDate' => date('d.m.Y', strtotime($dataVacation->data[0]->endDate)),
                            'startDate' => date('d.m.Y', strtotime($dataVacation->data[0]->startDate)),
                            'vacationWorkPeriodTo' => date('d.m.Y', strtotime($dataVacation->data[0]->vacationWorkPeriodTo)),
                            'vacationWorkPeriodFrom' => date('d.m.Y', strtotime($dataVacation->data[0]->vacationWorkPeriodFrom)),
                            'workStartDate' => date('d.m.Y', strtotime($dataVacation->data[0]->workStartDate)),
                            'orderVacationIdId' => $dataVacation->data[0]->orderVacationIdId,
                            'vacationDay' => $dataVacation->data[0]->vacationDay,
                            'orderVacationOtherDetailId' => $dataVacation->data[0]->id,
                            'listVacationTypeName' => $label[0]->name,
                            'label' => $label[0]->label,
                            'userId' => $dataOrderVacation->data[0]->userIdId,
                            'userName' => $dataOrderVacation->data[0]->userIdLastName . ' ' . $dataOrderVacation->data[0]->userIdFirstName . ' ' . $dataOrderVacation->data[0]->userIdPatronymic,
                            'userStructure' => $dataUserStructure->data[0],
                            'listVacationName' => $dataVacation->data[0]->listVacationIdName,
                            'listVacationId' => $dataVacation->data[0]->listVacationIdId,
                            'listVacationDurationTypeName' => isset($dataListVacationDuration->data[0]->listDurationTypeIdName) ? $dataListVacationDuration->data[0]->listDurationTypeIdName : ''
                        ]

                    ],
                    'id' => $data->data->id,
                    'code' => $data->code,
                    'url' => route('orders.update', $data->data->id),
                    'label' => 'sabbatical_leave',
                    'listVacationTypeName' => $label[0]->name,
                    'listVacationTypeId' => $listVacationTypeId,

                ];

                return app('App\Http\Controllers\Orders\ModalController')->common($response);
            }

            $enable = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'orderCommons/userLastVacation?orderCommonId=' . $id, false),
                'params' => [],
                'options' => [
                    'headers' => ['TableName' => '']
                ]
            ]);

        }

        //define order type by label
        $childKey = $data->data->listOrderTypeId->label;
        /*
         * using the App\Http\Controllers\Controller\OrderTypeGetArrayFactory
         * generate your own array to fill your modal
        */


        $childFields = $this->formArrayFactory->getChildFields($childKey, $data->data->id);

        if ($data->data->listOrderTypeId->label == 'vacation') {

            $orderVacationDetailArray = [];

            $dataUser = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'dateCreated', 'totalMainVacationDay', 'mainRemainderVacationDay', 'totalAdditionVacationDay', 'mainVacationDay', 'totalVacationDay', 'additionVacationDay', 'additionRemainderVacationDay', 'vacationWorkPeriodFrom', 'vacationWorkPeriodTo', 'workStartDate', 'startDate', 'endDate'],
                    'filter' => '"orderVacationId.id":%7B"=":"' . $orderVacationId . '"%7D',
                    'sort' => 'vacationWorkPeriodFrom',
                    'order' => 'asc'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationDetail'
                    ]
                ]
            ]);

            $test = $dataUser;


            $dataCollectiveAggrement = '';
            $dataCollectiveAggrementPeriod = '';
            $periodArray = [];

            foreach ($dataUser->data as $arr) {

                $periodArray[] = $arr->id;

                $vacationWorkPeriodFromUnix = $arr->vacationWorkPeriodFrom;
                $vacationWorkPeriodToUnix = $arr->vacationWorkPeriodTo;
                $arr->vacationWorkPeriodFrom = date('d.m.Y', strtotime($arr->vacationWorkPeriodFrom));
                $arr->vacationWorkPeriodTo = date('d.m.Y', strtotime($arr->vacationWorkPeriodTo));
                $arr->startDate = date('d.m.Y', strtotime($arr->startDate));
                $arr->endDate = date('d.m.Y', strtotime($arr->endDate));
                $dataOrderVacationDetailAdd = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'orderVacationDetailId.id', 'orderVacationDetailId.vacationWorkPeriodFrom', 'orderVacationDetailId.vacationWorkPeriodTo', 'totalExperienceDay', 'totalWorkConditionDay', 'totalChild142', 'totalChild143', 'remaindeChild142', 'remaindeChild143', 'remaindeExperienceDay', 'remaindeWorkConditionDay', 'workConditionDay', 'child142', 'child143', 'experienceDay'],
                        'filter' => '"orderVacationDetailId.id":%7B"=":"' . $arr->id . '"%7D',
                        'sort' => 'id',
                        'order' => 'asc'
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'OrderVacationDetailAdd'
                        ]
                    ]
                ]);

                $dataOrderVacationCollectiveDetail = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'orderVacationDetailId.id', 'orderVacationDetailId.vacationWorkPeriodFrom', 'orderVacationDetailId.vacationWorkPeriodTo', 'allWomenDay', 'chernobylAccidenDay', 'child142', 'child143', 'remaindeChild142', 'remaindeChild143', 'remaindeAllWomenDay', 'remaindeChernobylAccidenDay', 'totalAllWomenDay', 'totalChernobylAccidenDay', 'totalChild142', 'totalChild143'],
                        'filter' => '"orderVacationDetailId.id":%7B"=":"' . $arr->id . '"%7D',
                        'sort' => 'id',
                        'order' => 'asc'
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'OrderVacationCollectiveDetail'
                        ]
                    ]
                ]);


                if (!isset($dataUser->orderVacationDetailAddArray)) {

                    $dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodFrom = date('d.m.Y', strtotime($dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodFrom));
                    $dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodTo = date('d.m.Y', strtotime($dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodTo));
                    $dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodFrom = date('d.m.Y', strtotime($dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodFrom));
                    $dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodTo = date('d.m.Y', strtotime($dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodTo));


                    $dataUser->orderVacationDetailAddArray = [];
                    $dataUser->orderVacationDetailCollectiveArray = [];
                    $dataUser->orderVacationDetailAddArray[] = $dataOrderVacationDetailAdd->data[0];
                    $dataUser->orderVacationDetailCollectiveArray[] = $dataOrderVacationCollectiveDetail->data[0];
                } else {
                    $dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodFrom = date('d.m.Y', strtotime($dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodFrom));
                    $dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodTo = date('d.m.Y', strtotime($dataOrderVacationCollectiveDetail->data[0]->orderVacationDetailIdVacationWorkPeriodTo));

                    $dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodFrom = date('d.m.Y', strtotime($dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodFrom));
                    $dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodTo = date('d.m.Y', strtotime($dataOrderVacationDetailAdd->data[0]->orderVacationDetailIdVacationWorkPeriodTo));

                    $dataUser->orderVacationDetailAddArray[] = $dataOrderVacationDetailAdd->data[0];
                    $dataUser->orderVacationDetailCollectiveArray[] = $dataOrderVacationCollectiveDetail->data[0];

                }
                $dateC = date('Y-m-d', $arr->dateCreated / 1000);


                $userOldSamePeriodVacation = Service::request([
                    'method' => 'GET',
                    'url' => Service::url('hr', 'crud'),
                    'params' => [
                        'sc' => ['id', 'totalMainVacationDay', 'totalAdditionVacationDay', 'mainVacationDay', 'mainRemainderVacationDay', 'totalVacationDay', 'additionVacationDay', 'additionRemainderVacationDay', 'vacationWorkPeriodFrom', 'vacationWorkPeriodTo', 'workStartDate', 'startDate', 'endDate', 'dateCreated'],
                        'filter' => '"orderVacationId.userId":%7B"=":"' . $dataOrderVacation->data[0]->userIdId . '"%7D, "vacationWorkPeriodFrom":%7B"=":"' . $vacationWorkPeriodFromUnix . '"%7D, "vacationWorkPeriodTo":%7B"=":"' . $vacationWorkPeriodToUnix . '"%7D',
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'OrderVacationDetail'
                        ]
                    ]
                ]);

                if (is_array($userOldSamePeriodVacation->data)) {
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
                        'id' => $data->data->listOrderTypeId->id,
                        'text' => $data->data->listOrderTypeId->name
                    ],
                    'orderTypeLabel' => $data->data->listOrderTypeId->label,
                    'orderNumber' => $data->data->orderNum,
                    'orderDate' => date('d.m.Y', strtotime($data->data->orderDate)),
                    'orderBasis' => $data->data->basis,
                    $childKey => $childFields
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('orders.update', $data->data->id),
                'vacation' => $dataUser,
                'enable' => $enable->data->isEditable,
                'ordercommonid' => $id

            ];

        } else {


            $response = (object)[
                'fields' => [
                    'listOrderTypes' => [
                        'id' => $data->data->listOrderTypeId->id,
                        'text' => $data->data->listOrderTypeId->name
                    ],
                    'orderTypeLabel' => $data->data->listOrderTypeId->label,
                    'orderNumber' => $data->data->orderNum,
                    'orderDate' => date('d.m.Y', strtotime($data->data->orderDate)),
                    'orderBasis' => $data->data->basis,
                    $childKey => $childFields
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('orders.update', $data->data->id)

            ];

        }

        return app('App\Http\Controllers\Orders\ModalController')->common($response);
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
        $keys = [
            'businessTrip' => 'orderBusinessTripList',
            'vacation' => 'orderVacationList',
            'appointment' => 'orderAppointmentList',
            'assignment' => 'orderAppointmentList',
            'replacement' => 'orderAppointmentList',
            'dismissal' => 'orderDismissalList',
            'nonWorkingDaysSelection' => 'orderRestDayList',
            'warning' => 'orderWarningList',
            'Reward' => 'userRewardIndividualList'
        ];


        //pass orderTypeLabel to POSTArrayFactory to get specific array for your own orderType
        //write your own function in App\Http\Controllers\Orders\OrderTypePostArrayFactory and define it in getPostArray() method
        //it will be switching  by orderType labels

        if ($request->get('listVacationTypeIdLabel') != 'sabbatical_leave' && $orderTypeLabel != "vacationRecall") {
            $postArray = $this->postArrayFactory->getPostArray($orderTypeLabel, $request);

        }
        if ($orderTypeLabel == 'financialAid') {

            $data = OrderFinancialAidController::updateOrder($request);

            return response()->json($data);

        } elseif ($orderTypeLabel == "salaryAddition") {

            //insert financial Aid Order


            $data = OrderSalaryAddtiionController::updateOrder($request, $id);

            return response()->json($data);

            // Custom Service for Orders
        } else if ($orderTypeLabel == 'discipline') {

            $data = OrderDisciplineController::updateOrder($request);

            return response()->json($data);

        } else if ($orderTypeLabel == 'warning') {

            $data = OrderWarningController::updateOrder($request);

            return response()->json($data);

        } else if ($orderTypeLabel == 'staffOpening') {

            $data = OrderStaffAddController::updateOrder($request);

            return response()->json($data);

        } else if ($orderTypeLabel == 'staffCancellation') {

            $data = OrderStaffCancellationController::updateOrder($request);

            return response()->json($data);

        } else if ($orderTypeLabel == "additionalWorkTime") {

            //insert  Order
            $data = OrderAddWorkTimeController::updateOrder($request, $id);
            return response()->json($data);

            // Custom Service for Orders
        } else if ($request->get('listVacationTypeIdLabel') == 'sabbatical_leave' || $request->get('listVacationTypeIdLabel') == 'nonpaid_vacation' ) {

            $data = $this->sabbaticalLeaveUpdate($id, $request->all());

            return response()->json($data);

        } else if ($orderTypeLabel == 'appointmentDTO') {

            $data = OrderAppointmentController::updateOrderTransfer($request, $id, $postArray);

            return response()->json($data);

        } elseif ($orderTypeLabel == "damage") {

            //insert  Order
            $request->input_startDate = trim($request->input_startDate);
            $request->input_endDate = trim($request->input_endDate);

            $data = OrderDamageController::updateOrder($id, $request);

            return response()->json($data);

            // Custom Service for Orders
        } else if ($orderTypeLabel == "vacationRecall") {

            $request->recallDate = date('Y-m-d', strtotime($request->recallDate));
            $orderVacationByReturnDate = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'orderCommons/orderVacationByReturnDate?userId=' . $request->userId . '&returnDate=' . $request->recallDate, false),

                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ]
                ]
            ]);


            if (count((array)$orderVacationByReturnDate->data) == '0') {

                return response()->json(['code' => 'Xəta', 'notselected' => 'Seçilmiş əməkdaş məzuniyyətdə deyil']);

            }

            $vacationId = $orderVacationByReturnDate->data->orderVacationDetail->orderVacationId->id;
            $request->vacationId = $vacationId;

            $request->meth = "PUT";

            $postArray = $this->postArrayFactory->getPostArray($orderTypeLabel, $request, $id);

            $data = Service::request([
                'method' => 'PUT',
                'url' => Service::url('hr', 'orderCommons/' . $id, false),
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ],
                    'json' => $postArray
                ]
            ]);

            return response()->json($data);
        } else {

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

                $OrderVacationDetailId = $dataOrderVacationDetail->data[0]->id;

                if (is_array($dataOrderVacationDetail->data)) {
                    foreach ($dataOrderVacationDetail->data as $detailId) {
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


                        if ($dataAdd->data[0]->id != null) {
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


                        if ($dataCollective->data[0]->id != null) {
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

                    }
                }

            }

            if ($orderTypeLabel != 'vacation') {

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

            }

            if ($orderTypeLabel == 'vacation') {

                $data = Service::request([
                    'method' => 'PUT',
                    'url' => Service::url('hr', 'crud'),
                    'options' => [
                        'headers' => [
                            'TableName' => 'OrderCommon'
                        ],
                        'json' => [
                            'id' => $id,
                            'listOrderTypeId' => [
                                'id' => $request->get('listOrderTypeId')
                            ],
                            'orderNum' => $request->get('orderNumber'),
                            'orderDate' => date('U', strtotime($request->get('orderDate'))) * 1000,
                            'basis' => $request->get('orderBasis')

                        ]
                    ]
                ]);

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

                $positionId = $posId->data[0]->positionIdId;

                $dataUpdateOrderVacation = Service::request([
                    'method' => 'PUT',
                    'url' => Service::url('hr', 'crud'),
                    'options' => [
                        'headers' => [
                            'TableName' => 'OrderVacation'
                        ],
                        'json' => [
                            'id' => $orderVacationData->data[0]->id,
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

                if (!isset($request->hiddenDetail)) {
                    foreach ($request->vacationWorkPeriodFrom as $key => $val) {

                        if ($key == '0' && isset($request['hiddenForKm'])) {

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
                                        'totalVacationDay' => '0',
                                        'mainVacationDay' => '0',
                                        'mainRemainderVacationDay' => '0',
                                        'additionVacationDay' => '0',
                                        'additionRemainderVacationDay' => '0',
                                        'workStartDate' => '0',
                                        'totalMainVacationDay' => '0',
                                        'totalAdditionVacationDay' => '0'
                                    ]
                                ]
                            ]);

                        } else {

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

                        }

                        $totalSum = (int)$request->chosenAmount[$key] + (int)$request->mainRemainderVacationDay[$key];
                        if ($totalSum > $request->mainVacationDayForPerson[$key]) {

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

                        } else {


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
                                    'remaindeAllWomenDay' => (int)$request->remaindeAllWomenDay[$key],
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

                    }

                }

            }

        }

        $data->data->orderDate = date('d.m.Y', $data->data->orderDate / 1000);
        $data->data->listOrderTypeId->name = OrderTypeController::getOrderTypeNameById($request->get('listOrderTypeId'));

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $data = Service::request([
                'method' => 'DELETE',
                'url' => Service::url('hr', 'orderCommons/' . $id, false),
                'options' => [
                    'headers' => []
                ]
            ]);

            return $data->code;

        } catch (\Exception $e) {

            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());

        }

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

    /**
     * @param Request $request
     */
    public function fileDownload(Request $request)
    {
        //header part
        header("Content-type: application/vinod.ms-word");
        header("Content-Disposition: attachment;Filename=" . uniqid() . ".doc");
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

    /**
     * @param Request $request
     * @return DocxConversion|string
     */
    public function genFile(Request $request)
    {

        $string = str_replace('\\', '/', $request->obj);
        $string = preg_replace("/[\r\n]+/", " ", $string);
        $obj = json_decode($string);

        $file = new DocxConversion;

        $file = $file->makeFile($obj, $request->get('label'));

        return $file;
    }

    /**
     * @param $userId
     * @param $date
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRemainingVacationDays($userId, $date)
    {
        try {

            /* generate query string for custom service */
            $queryString = 'remainingDays?userId=' . $userId . '&date=' . $date;

            /* make service call */
            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'orderCommons/' . $queryString, false),
                'options' => [
                    'headers' => []
                ]
            ]);

            /* prepare default response */
            $OrderVacationDetail = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id'],
                    'filter' => '"orderVacationId.userId" : { "=" : "' . $userId . '" }'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationDetail'
                    ]
                ]
            ]);
            $response = [
                'code' => 200,
                'totalCount' => 0,
                'data' => ['vacationDays' => 0, 'additionalVacationDays' => 0]
            ];

            if (isset($data->totalCount)) {
                /* original response */
                $response = $data;
            }

            /* return json object */
            return response()->json($response);

        } catch (\Exception $e) {

            /* render the exception */
            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());

        }
    }

    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArch($userId)
    {

        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'additionRemainderVacationDay', 'additionVacationDay', 'mainVacationDay', 'totalVacationDay', 'vacationWorkPeriodFrom', 'vacationWorkPeriodTo'],
                'filter' => '"orderVacationId.userId.id" : { "=" : "' . $userId . '" }',
                'sort' => 'dateCreated',
                'order' => 'desc'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderVacationDetail'
                ]
            ]
        ]);

        $dataUser = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'gender'],
                'filter' => '"id" : { "=" : "' . $userId . '" }',


            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Users'
                ]
            ]
        ]);

        $getUserDetails = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'orderCommons/orderVacationDetails?userId=' . $userId, false),
            'params' => [
                'sc' => ['id', 'startDate']

            ],

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        $dateArray = [];

        if ($dataUser->data[0]->gender == 0) {

            $dataListCollectiveAgreementVacation = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'name', 'day', 'label'],
                    'filter' => '"label" : { "=" : "edit" }',

                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListCollectiveAgreementVacation'
                    ]
                ]
            ]);

            $getUserDetails->add = $dataListCollectiveAgreementVacation->data;
        }

        $getUserDetails->dateArray = $dateArray;

        foreach ($getUserDetails->data as $arr) {

            foreach ($arr as $key => $val) {

                if ($key == 'child-14-13') {

                    $arr->child_14_13 = $val;
                }
                if ($key == 'remainderChild-14-2') {

                    $arr->remainderChild_14_12 = $val;
                }
                if ($key == 'remainderChild-14-3') {

                    $arr->remainderChild_14_13 = $val;
                }
                if ($key == 'child-14-12') {

                    $arr->child_14_12 = $val;
                }
                if ($key == 'fromDate') {

                    $arr->fromDate = date('d.m.Y', strtotime($arr->fromDate));
                }
                if ($key == 'toDate') {

                    $arr->toDate = date('d.m.Y', strtotime($arr->toDate));
                }

            }


        }

        return response()->json($getUserDetails);
    }

    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdditionalVacationDays($userId)
    {
        try {

            $getAdditionalVacationDaysForPerson = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'name', 'day', 'durationTypeId.name'],
                    'sort' => 'dateCreated',
                    'order' => 'desc'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListCollectiveAgreementVacation'
                    ]
                ]
            ]);

            /* return json object */
            return response()->json($getAdditionalVacationDaysForPerson);

        } catch (\Exception $e) {

            /* render the exception */
            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());

        }
    }

    /**
     * @param $totalday
     * @param $vacationStartDate
     * @param $userid
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateVacationDay($totalday, $vacationStartDate, $userid)
    {

        if ($totalday == '0') {

            return response()->json(['code' => 'Xəta', 'notselected' => 'Xahiş olunur aralıq dövrünü düzgün seçəsiniz']);

        } else {

            $vacationEndDate = date('Y-m-d', strtotime($vacationStartDate) + $totalday * 86400);

            $vacationStartDate = date('Y-m-d', strtotime($vacationStartDate));

        }

        $checkVacationDay = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'orderCommons/restDays?startDate=' . $vacationStartDate . '&endDate=' . $vacationEndDate, false),

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        $days = 0;


        foreach ($checkVacationDay->data as $key => $val) {

            if (strtotime($vacationStartDate) > strtotime($checkVacationDay->data[$key]->startDate)) {

                $reminderDay = (strtotime($checkVacationDay->data[$key]->endDate) - strtotime($vacationStartDate)) / 86400;

            } else {
                $reminderDay = (strtotime($checkVacationDay->data[$key]->endDate) - strtotime($checkVacationDay->data[$key]->startDate)) / 86400;

            }

            $days = $days + $reminderDay;
        }

        $latestEndDate = (object)['data' => date('d.m.Y', strtotime($vacationEndDate) - 86400)];

        $lastendDate = date('Y-m-d', strtotime($vacationEndDate) - 86400);

        $controlVacationDay = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'orderCommons/vacationControl?userId=' . $userid . '&fromDate=' . $vacationStartDate . '&toDate=' . $lastendDate, false),

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        if ($controlVacationDay->data->result != 'ok') {

            return response()->json(['code' => 'Xəta', 'notselected' => 'Seçilmiş dövrdə işçiyə ' . $controlVacationDay->data->result . ' verilmişdir']);
        }


        return response()->json($latestEndDate);

    }

    /**
     * @param $userId
     * @param $orderCommonId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermanentVacation($userId, $orderCommonId)
    {

        $checkVacationDay = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', '/orderCommons/orderVacationDetailsEdit?userId=' . $userId . '&orderCommonId=' . $orderCommonId, false),

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        foreach ($checkVacationDay->data as $arr) {

            foreach ($arr as $key => $val) {

                if ($key == 'child-14-13') {

                    $arr->child_14_13 = $val;
                }
                if ($key == 'remainderChild-14-2') {

                    $arr->remainderChild_14_12 = $val;
                }
                if ($key == 'remainderChild-14-3') {

                    $arr->remainderChild_14_13 = $val;
                }
                if ($key == 'child-14-12') {

                    $arr->child_14_12 = $val;
                }
                if ($key == 'fromDate') {

                    $arr->fromDate = date('d.m.Y', strtotime($arr->fromDate));
                }
                if ($key == 'toDate') {

                    $arr->toDate = date('d.m.Y', strtotime($arr->toDate));
                }

            }


        }

        return response()->json($checkVacationDay);

    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getVacationLabelById($id)
    {
        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'label', 'name'],
                'filter' => '"id":%7B"=":"' . $id . '"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListVacationType'
                ]
            ]
        ]);


        return $data->data[0]->label;
    }


}
