<?php
//
namespace App\Http\Controllers\Orders;
//
use App\Http\Controllers\Controller;
use App\Library\Service\Service;
//use function GuzzleHttp\Psr7\str;

class OrderDamageController extends Controller
{

    /**
     * get order dismissal by providing order common id
     * @param $orderCommonId
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function getOrderDamage($orderCommonId) {

        try {

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


            return $data;


        } catch (\Exception $e) {

            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];

            return response()->json($response);
        }

    }

    public function getDateDiff($startDate, $endDate, $amount){

        $startDate=explode('.', $startDate);
        $endDate=explode('.', $endDate);

        $difference=$endDate[0]-$startDate[0]+12*($endDate[1]-$startDate[1]);

        $singleAmount=round($amount/$difference,2);
        return $singleAmount;

    }
    public static function insertOrder($request){

//        dd($request->all());
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
                        'id' => $request->listOrderTypeId
                    ],
                    'basis' => $request->get('orderBasis'),
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
                    'valus' => $request->amountSingle,
                    'isClosed'=>false,
                    'isPercent'=>false,
                    'startDate'      => date("Y-m-d", strtotime('01.'.$request->input_startDate)),
                    'endDate'        => date("Y-m-d", strtotime('01.'.$request->input_endDate))
                ]
            ]
        ]);

        $UserPaymentId = $data1->body['data']['id'];

        $data2 = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserDamage'
                ],
                'json' => [
                    'orderCommonId'  => [
                        'id' => $orderId
                    ],
                    'relUserPaymentsId' => [
                        'id' => $UserPaymentId
                    ],
                    'valueTotal'=>(int)$request->amount,
                    'positionId'         => [
                        'id' => $request->positionId
                    ]
                ]
            ]
        ]);

        return $data;

    }

    public static function updateOrder($id, $request){

        $data = Service::request([
            'method'  => 'PUT',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderCommon'
                ],
                'json' => [
                    'id'=>$id,
                    'orderDate'      => date("Y-m-d", strtotime($request->orderDate)),
                    'orderNum'      => $request->orderNumber,
                    'listOrderTypeId' => [
                        'id' => $request->listOrderTypeId
                    ],
                    'basis' => $request->get('orderBasis'),
                ]
            ]
        ]);

        $relUserDamage = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'relUserPaymentsId.id'],
                'filter' => '"orderCommonId.id":%7B"=":"' . $id . '"%7D',
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserDamage'
                ]
            ]
        ]);


        $relUserPaymentId = $relUserDamage->data[0]->relUserPaymentsIdId;
        $relUserDamageId=$relUserDamage->data[0]->id;

        $data1 = Service::request([
            'method'  => 'PUT',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserPayments'
                ],
                'json' => [
                    'id'=>$relUserPaymentId,
                    'userId'         => [
                        'id' => $request->userId
                    ],
                    'paymentTypeId' => [
                        'id' => 33
                    ],
                    'valus' => $request->amountSingle,
                    'isClosed'=>false,
                    'isPercent'=>false,
                    'startDate'      => date("Y-m-d", strtotime('01.'.$request->input_startDate)),
                    'endDate'        => date("Y-m-d", strtotime('01.'.$request->input_endDate))
                ]
            ]
        ]);

//        dd(json_encode($data1));
        $UserPaymentId = $data1->data->id;

        $data2 = Service::request([
            'method'  => 'PUT',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserDamage'
                ],
                'json' => [
                    'id'=>$relUserDamageId,
                    'orderCommonId'  => [
                        'id' => $id
                    ],
                    'relUserPaymentsId' => [
                        'id' => $relUserPaymentId
                    ],
                    'valueTotal'=>(int)$request->amount,
                    'positionId'         => [
                        'id' => $request->positionId
                    ]
                ]
            ]
        ]);

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
