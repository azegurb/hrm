<?php

namespace App\Http\Controllers\OrdersCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StaffTable\RelPositionPaymentController;

use App\Library\Service\Service;

class OrderStaffCancellationController extends Controller
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

        $arr = [];
        foreach ($request->positionId as $key=>$single){
            $var = (object)['id' => $single];

            array_push($arr,$var);

        }


        $data = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','positions/orderPositionAbolish',false),
            'options' => [
                'headers' => [
                    'TableName' => ''
                ],
                'json' => [
                    'orderDate'         => date('U', strtotime($request->get('orderDate'))) * 1000,
                    'orderNum'          => $request->orderNumber,
                    'basis'             => $request->orderBasis,
                    'listOrderTypeId'   => [
                        'id' => $request->listOrderTypeId,
                        'name' => OrderFinancialAidController::givename_orderType($request->listOrderTypeId)
                    ],
                    'positionList'      => $arr
                ]
            ]
        ]);

        if($data->hasError){

            return eH($data);
        }
        return $data;
    }

    public static function getOrder($orderCommonId){

        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id','positionId','orderCommonId'],
                'filter' => '"orderCommonId.id":%7B"=":"'.$orderCommonId.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderPositionAbolish'
                ]
            ]
        ]);

        if($data->hasError){

            return eH($data);
        }

        return $data;



    }

    public static function updateOrder($request,$orderCommonId){

        $posData['id'] = $request->positionId[0];

        $posData['status'] = 'insert';

        $posData = (object)$posData;
        $positionList = [ $posData ];

        $data = Service::request([
            'method'  => 'PUT',
            'url'     => Service::url('hr','positions/orderPositionAbolish/' . $orderCommonId , false),
            'options' => [
                'headers' => [
                    'TableName' => ''
                ],
                'json' => [
//                    'id'          => $request->id,
                    'orderDate' =>(int)date("U" , strtotime($request->orderDate)),
                    'orderNum'  =>$request->orderNumber,
                    'basis'     =>$request->orderBasis,
                    'listOrderTypeId' =>[
                        'id' =>$request->listOrderTypeId
                    ],
                    'positionList' => $positionList
                ]
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

        $data1 = Service::request([
            'method'  => 'PUT',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'UserDisciplinaryAction'
                ],
                'json' => [
                    'id'          => $request->id,
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

        if($data1->hasError){

            return eH($data1);
        }

        $orderTypeId = OrderTypeController::getOrderTypeNameById($request->listOrderTypeId);

        $data->data->listOrderTypeId->name = $orderTypeId;

        return $data;
    }
}
