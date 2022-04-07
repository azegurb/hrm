<?php

namespace App\Http\Controllers\OrdersCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library\Service\Service;

class OrderAddWorkTimeController extends Controller
{

    /**
     * @var string
     */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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

    /**
     *
     * Get notes by order dismissal id
     * @param $orderDismissalId
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */

    public static function insertOrder($request){

        $data = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderCommon'
                ],
                'json' => [
                    'orderDate'         => date("Y-m-d", strtotime($request->orderDate)),
                    'orderNum'          => $request->orderNumber,
                    'listOrderTypeId'   => [
                        'id' => $request->listOrderTypeId,
                        'name' => OrderFinancialAidController::givename_orderType($request->listOrderTypeId)
                    ]
                ]
            ]
        ]);

        if($data->hasError){
            return  eH($data);
        }

        $orderId = $data->body['data']['id'];

        if(isset($request->workerS)){
            $workerS = true;
        }else{
            $workerS = false;
        }

        $data2 = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'UserDisciplinaryAction'
                ],
                'json' => [
                    'userId'            => [
                        'id' => $request->userId
                    ],
                    'executorUserId'    => [
                        'id' => $request->user2Id
                    ],
                    'orderCommonId'     => [
                        'id' => $orderId
                    ],
                    'listDisciplinaryActionId' => [
                        'id' => $request->disciplineType
                    ],
                    'isExplanation' => $workerS
                ]
            ]
        ]);

        if($data2->hasError){
            return eH($data2);
        }
        return $data;
    }

    public static function getOrder($orderCommonId){

        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id','orderExcessWorkId','userId','positionId'],
                'filter' => '"orderExcessWorkId.orderCommonId.id":%7B"=":"'.$orderCommonId.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserExcessWork'
                ]
            ]
        ]);

        if($data->hasError){
            return eH($data);
        }
        return $data;



    }

    public static function updateOrder($request,$id){

        $date                       = date("Y-m-d" ,strtotime($request['input_startDate']));
        $orderNumber                = $request['orderNumber'];
        $orderDate                  = date('U', strtotime($request['orderDate'])) * 1000;
        $basis                      = $request['orderBasis'];
        $listOrderTypeId            = (object)["id" => $request['listOrderTypeId']];
        $listExcessWorkTypeId[0]    = (object)["id" => $request['additionalWorkTimeType']];
        $orderExcessWorkList        = [];
        foreach ($request['additionalWorkDateStart'] as $key => $value) {
            if ($request['listExcessWorkId'] != "" && array_key_exists($key,$request['listExcessWorkId'])) {
                $orderExcessWorkList[$key]["id"] = $request["listExcessWorkId"][$key];
            }
            $orderExcessWorkList[$key]["startDate"] =  $date.' '.$value;
            $orderExcessWorkList[$key]["endDate"] =  $date.' '.$request['additionalWorkDateEnd'][$key];
            $orderExcessWorkList[$key]["listExcessWorkTypeId"] =  (object)["id" => $request['additionalWorkTimeType']];
            if ( $request['mainId'] != "" && array_key_exists($key,$request['mainId'])) {
                $orderExcessWorkList[$key]["relUserExcessWorkList"] =  [ 0 => (object)[
                    "id" => $request['mainId'][$key],
                    "positionId" => (object)[
                        "id" => UserPositionController::getPosByUserId2($request['userId'][$key])->positionId->id
                    ],
                    "userId" => (object)[
                        "id" => $request['userId'][$key]
                    ]
                ]
                ];
            }
            else {
                $orderExcessWorkList[$key]["relUserExcessWorkList"] =  [ 0 => (object)[
                    "positionId" => (object)[
                        "id" => UserPositionController::getPosByUserId2($request['userId'][$key])->positionId->id
                    ],
                    "userId" => (object)[
                        "id" => $request['userId'][$key]
                    ]
                ]
                ];
            }
        }
        $dat = (object)[
            "listOrderTypeId"       => $listOrderTypeId,
            "orderNum"              => $orderNumber,
            "orderDate"             => $orderDate,
            "basis"                 => $basis,
            "orderExcessWorkList"   => $orderExcessWorkList,
        ];
        $data = Service::request([
            'method' => 'PUT',
            'url' => Service::url('hr', 'orderCommons/'.$id, false),
            'options' => [
                'headers' => [
                    'TableName' => ''
                ],
                'json' => $dat
            ]
        ]);
        if($data->hasError){
            return eH($data);
        }
        if(isset($request->workerS)){
            $workerS = true;
        }else{
            $workerS = false;
        }
        $orderId = $data->data->id;
        $orderTypeId = OrderTypeController::getOrderTypeNameById($request->listOrderTypeId);
        $data->data->listOrderTypeId->name = $orderTypeId;
        return $data;
    }
}
