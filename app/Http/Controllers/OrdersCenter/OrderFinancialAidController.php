<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;
use function GuzzleHttp\Psr7\str;

class OrderFinancialAidController extends Controller
{

    /**
     * get order dismissal by providing order common id
     * @param $orderCommonId
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function getOrderFinancialAid($orderCommonId) {

//        try {

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id', 'relUserPaymentsId'],
                    'filter' => '"orderCommonId.id":%7B"=":"'.$orderCommonId.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderFinancialAssistance'
                    ]
                ]
            ]);
        if($data->hasError){

            return eH($data);
        }

            return $data;


//        } catch (\Exception $e) {
//
//            $response = (object)[
//                'code' => $e->getCode(),
//                'message' => $e->getMessage()
//            ];
//
//            return response()->json($response);
//        }

    }


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
                    ],
                    'basis'     =>$request->orderBasis,
                ]
            ]
        ]);

        if($data->hasError){

            return eH($data);
        }

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
                        'id' => 38
                    ],
                    'valus' => $request->aidAmount,
                    'startDate'      => date("Y-m-d", strtotime($request->input_startDate)),
                    'endDate'        => date("Y-m-d", strtotime($request->input_endDate))
                ]
            ]
        ]);

        if($data1->hasError){

            return eH($data1);
        }
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

        if($data2->hasError){

            return eH($data2);
        }
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

        if($data->hasError){

            return eH($data);
        }

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

        if($data1->hasError){

            return eH($data1);
        }
        $orderFinancialAssistanceId = OrderFinancialAidController::getOrderFinancialAid($request->orderCommonId);

        $orderFAId = $orderFinancialAssistanceId->data[0]->id;

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

        if($data2->hasError){

            return eH($data2);
        }
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
        if($data->hasError){

            return eH($data);
        }
        return($data->data->name);
    }

}
