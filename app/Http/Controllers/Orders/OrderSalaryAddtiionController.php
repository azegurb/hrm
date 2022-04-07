<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Service\Service;

class OrderSalaryAddtiionController extends Controller
{
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


    public static function insertOrder(Request $request){

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

        $orderCommonid = $data->body['data']['id'];

        $userId = $request->userId;

        $getDataRelUserPayment= Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id'],
                'filter' => '"isClosed" : {"=":false}, "paymentTypeId.id" : { "=" : "3" }, "userId.id" : { "=" : "' . $userId . '" }'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserPayments'
                ]
            ]
        ]);

        if(isset($getDataRelUserPayment->data) && is_array($getDataRelUserPayment->data)){

            foreach ($getDataRelUserPayment->data as $dataRel){

                $dataRelUserPayment = Service::request([
                    'method'  => 'PUT',
                    'url'     => Service::url('hr','crud'),
                    'options' => [
                        'headers' => [
                            'TableName' => 'RelUserPayments'
                        ],
                        'json' => [
                            'id'=>$dataRel->id,
                            'isClosed' => true,

                        ]
                    ]
                ]);

            }

        }

        if(isset($request->percentSum)){

            $sum=$request->percentSum;
            $isPercent=1;
        }
        else {
            $sum=$request->numberSum;
            $isPercent=0;
        }

        $dataRelUserPayment = Service::request([
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
                        'id' => 3
                    ],
                    'valus' => $sum,
                    'isPercent'=>$isPercent,
                    'startDate'      => date("Y-m-d", strtotime($request->startDate)),
                    'endDate'        => date("Y-m-d", strtotime($request->endDate))
                ]
            ]
        ]);

        $dataOrderSalaryAddition = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderSalaryAddition'
                ],
                'json' => [
                    'orderCommonId'         => [
                        'id' => $orderCommonid
                    ],
                    'relUserPaymentsId' => [
                        'id' => $dataRelUserPayment->body['data']['id']
                    ]
                ]
            ]
        ]);


        return $dataRelUserPayment;

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public static function updateOrder(Request $request, $id){

//        dd($id);

//        dd($request->all());
        $getDataRelUserPayment= Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'relUserPaymentsId.id'],
                'filter' => '"orderCommonId.id" : { "=" : "' . $id . '" }'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderSalaryAddition'
                ]
            ]
        ]);



        $data = Service::request([
            'method' => 'PUT',
            'url' => Service::url('hr', 'crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderCommon'
                ],
                'json' => [
                    'id'          => $id,
                    'listOrderTypeId' => [
                        'id' => $request->get('listOrderTypeId')
                    ],
                    'orderNum' => $request->get('orderNumber'),
                    'orderDate' => date('U', strtotime($request->get('orderDate'))) * 1000,
                    'basis' => $request->get('orderBasis')

                ]
            ]
        ]);
//        dd($id, $request->get('listOrderTypeId'));
        $userId = $request->userId;

        if(isset($getDataRelUserPayment->data[0]->relUserPaymentsIdId)){

            $relUserId=$getDataRelUserPayment->data[0]->relUserPaymentsIdId;

        }

        $getDataRelUserPayment= Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id'],
                'filter' => '"id" : { "=" : "' . $relUserId . '" }'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserPayments'
                ]
            ]
        ]);

        if(isset($request->percentSum)){

            $sum=$request->percentSum;
            $isPercent=true;

        }
        else {
            $sum=$request->numberSum;
            $isPercent=false;
        }



        if(isset($getDataRelUserPayment->data) && is_array($getDataRelUserPayment->data)){

            foreach ($getDataRelUserPayment->data as $dataRel){

                $dataRelUserPayment = Service::request([
                    'method'  => 'PUT',
                    'url'     => Service::url('hr','crud'),
                    'options' => [
                        'headers' => [
                            'TableName' => 'RelUserPayments'
                        ],
                        'json' => [
                            'id'=>$dataRel->id,
                            'userId'         => [
                                'id' => $request->userId
                            ],
                            'valus' => $sum,
                            'isPercent'=>$isPercent,
                            'startDate'      => date("Y-m-d", strtotime($request->startDate)),
                            'endDate'        => date("Y-m-d", strtotime($request->endDate))

                        ]
                    ]
                ]);


            }

        }

        return $dataRelUserPayment;

    }
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
}
