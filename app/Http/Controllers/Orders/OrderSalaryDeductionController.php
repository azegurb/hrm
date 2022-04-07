<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;
use function GuzzleHttp\Psr7\str;

class OrderSalaryDeductionController extends Controller
{

    /**
     * get order dismissal by providing order common id
     * @param $orderCommonId
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
                    'orderDate'      => date("Y-m-d", strtotime($request->orderDate)),
                    'orderNum'      => $request->orderNumber,
                    'listOrderTypeId' => [
                        'id' => $request->listOrderTypeId,
                        'name' => OrderFinancialAidController::givename_orderType($request->listOrderTypeId)
                    ]
                ]
            ]
        ]);

        $orderId = $data->body['data']['id'];

        $data1 = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserPayments'
                ],
                'json' => [
                    'userId'         => [
                        'id' => $request->userId
                    ],
                    'paymentTypeId' => [
                        'id' => 33
                    ],
                    'valus' => $request->aidAmount,
                    'startDate'      => date("Y-m-d", strtotime($request->input_startDate)),
                    'endDate'        => date("Y-m-d", strtotime($request->input_endDate))
                ]
            ]
        ]);

        $UserPaymentId = $data1->body['data']['id'];


        $data2 = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderFinancialAssistance'
                ],
                'json' => [
                    'orderCommonId'  => [
                        'id' => $orderId
                    ],
                    'relUserPaymentsId' => [
                        'id' => $UserPaymentId
                    ],
                    'userId'         => [
                        'id' => $request->userId
                    ]
                ]
            ]
        ]);

        return $data;

    }

    public static function updateOrder($request){
//dd($request->all());
        $data = Service::request([
            'method'  => 'PUT',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderCommon'
                ],
                'json' => [
                    'id'          => $request->orderCommonId,
                    'orderDate' =>date("Y-m-d" , strtotime($request->orderDate)),
                    'orderNum'  =>$request->orderNumber,
                    'basis'     =>$request->orderBasis,
                    'listOrderTypeId' =>[
                        'id' =>$request->listOrderTypeId
                    ],
                ]
            ]
        ]);

        $orderId = $data->data->id;

        $data1 = Service::request([
            'method'  => 'PUT',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserPayments'
                ],
                'json' => [
                    'id'          => $request->relUserPaymentId,
                    'userId'         => [
                        'id' => $request->userId
                    ],
                    'paymentTypeId' => [
                        'id' => 38
                    ],
                    'valus' => $request->aidAmount,
                    'startDate'      => date("Y-m-d", strtotime($request->input_startDate)),
                    'endDate'        => date("Y-m-d", strtotime($request->input_endDate))
                ]
            ]
        ]);

        $orderFinancialAssistanceId = OrderFinancialAidController::getOrderFinancialAid($request->orderCommonId);

        $orderFAId = $orderFinancialAssistanceId->{'data'}[0]->id;

        $data2 = Service::request([
            'method'  => 'PUT',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderFinancialAssistance'
                ],
                'json' => [
                    'id'          => $orderFAId,
                    'orderCommonId'  => [
                        'id' => $request->orderCommonId
                    ],
                    'relUserPaymentsId' => [
                        'id' => $request->relUserPaymentId
                    ],
                    'userId'         => [
                        'id' => $request->userId
                    ]
                ]
            ]
        ]);

        $orderTypeId = OrderTypeController::getOrderTypeNameById($request->listOrderTypeId);

        $data->data->listOrderTypeId->name = $orderTypeId;

        return $data;

    }

    public static function givename_orderType($id){
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'id'      => $id,
                'sc'      => ['id','name']
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListOrderType',
                ]
            ]
        ]);
        return($data->data->name);
    }

}
