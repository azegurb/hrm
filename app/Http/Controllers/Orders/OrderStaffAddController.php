<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library\Service\Service;

class OrderStaffAddController extends Controller
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

    public static function makeArray($request, $key, $paymentTypeId){

        $posNameId = (object) ['id' => $request->posNameId[$key]];

        $strId = (object)['id' => $request->strId[$key]];

        $paymentI = (object)['paymentTypeId' => $paymentTypeId, 'isPercent'=> false, 'value'=>(int) $request->salary[$key]];

        $paymentInside = [0 => $paymentI];

        $arr = [
            'structureId'   => $strId,
            'posNameId'     => $posNameId,
            'notStuff'      => false,
            'isCivilService'=> false,
            'vacationDay'   => $request->vacation[$key],
            'count'         => $request->countStaff[$key],
            'isclosed'      => false,
            'relPositionPaymentList'    => $paymentInside
        ];

        return (object)$arr;

    }

    public static function makeUpdateArray($request, $key, $paymentTypeId){

        $posNameId = (object) ['id' => $request->posNameId[$key]];

        $strId = (object)['id' => $request->strId[$key]];

        $paymentI = (object)['paymentTypeId' => $paymentTypeId, 'isPercent'=> false, 'value'=>(int) $request->salary[$key]];

        $paymentInside = [0 => $paymentI];

        $arr = [
            'structureId'   => $strId,
            'posNameId'     => $posNameId,
            'vacationDay'   => $request->vacation[$key],
            'count'         => $request->countStaff[$key],
            'relPositionPaymentList'    => $paymentInside
        ];

        return (object)$arr;

    }

    public static function insertOrder($request){

            $result=[];

            $paymentTypeId = (object)['id' => 1];

            foreach ($request->posNameId as $key=>$val){
                $result[] = self::makeArray($request, $key, $paymentTypeId);

            }


        $data = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','positions/positionAdd',false),
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
                    'positionList'      => $result
                ]
            ]
        ]);

            return $data;

    }

    public static function getOrder($orderCommonId){

        $fields=[];

        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id','posNameId','orderCommonId','vacationDay','structureId ','count'],
                'filter' => '"orderCommonId.id":%7B"=":"'.$orderCommonId.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Position'
                ]
            ]
        ]);


        $posId = $data->data[0]->id;

        foreach ($data->data as $K=>$V){

            $data2 = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id','value'],
                    'filter' => '"positionId.id":%7B"=":"'.$data->data[$K]->id.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'RelPositionPayment'
                    ]
                ]
            ]);

            $data->data[$K]->value = $data2->data[0];
        }

        foreach ($data->data as $dat){

            $fields[0][] = $dat;
        }


        return $fields;

    }

    public static function updateOrder($request){

        $result=[];

//        dd($request->orderCommonId);

        $paymentTypeId =(object) ['id' => 1];

        foreach ($request->posNameId as $key=>$val){

            $result[] = self::makeUpdateArray($request, $key, $paymentTypeId);

        }

        $orderId=$request->orderCommonId[0];
        $data = Service::request([
            'method'  => 'PUT',
            'url'     => Service::url('hr','positions/position/' . $orderId,false),
            'options' => [
                'headers' => [
                    'TableName' => ''
                ],
                'json' => [
                    'id'                => $request->orderCommonId[0],
                    'orderDate'         => date('Y-m-d', strtotime($request->orderDate)),
                    'orderNum'          => $request->orderNumber,
                    'basis'             => $request->orderBasis,
                    'listOrderTypeId'   => [
                        'id' => $request->listOrderTypeId,
                        'name' => OrderFinancialAidController::givename_orderType($request->listOrderTypeId)
                    ],
                    'positionList'      => $result
                ]
            ]
        ]);

        dd('here');
        $data->data->orderDate = date("d.m.Y", strtotime($data->data->orderDate));

        $orderTypeId = OrderTypeController::getOrderTypeNameById($request->listOrderTypeId);

        $data->data->listOrderTypeId->name = $orderTypeId;

        return $data;
    }
}
