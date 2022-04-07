<?php

namespace App\Http\Controllers\OrdersCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library\Service\Service;

class OrderWarningController extends Controller
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
                    ],
                    'basis'             => $request->orderBasis
                ]
            ]
        ]);

        if($data->hasError){

            return eH($data);
        }
        $orderId = $data->body['data']['id'];

        if(isset($request->WorkerS[0])){
            $workerS = true;
        }else{
            $workerS = false;
        }

        foreach ($request->userId as $item) {

            $data2 = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserWarning'
                    ],
                    'json' => [
                        'userId'            => [
                            'id' => $item
                        ],
                        'executorUserId'    => [
                            'id' => $request->userId2
                        ],
                        'orderCommonId'     => [
                            'id' => $orderId
                        ],
                        'isExplanation' => $workerS
                    ]
                ]
            ]);
            if($data2->hasError){

                return eH($data2);
            }
        }

        return $data;
    }

    public static function getOrder($orderCommonId){

        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id','userId','executorUserId','isExplanation'],
                'filter' => '"orderCommonId.id":%7B"=":"'.$orderCommonId.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserWarning'
                ]
            ]
        ]);

        if($data->hasError){

            return eH($data);
        }
        foreach ($data->data as $single){
            $pos = UserPositionController::getPosByUserId2($single->userId->id);
            $single->posData = $pos;
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
        if(isset($request->WorkerS)){
            $workerS = true;
        }else{
            $workerS = false;
        }

        $orderId = $data->data->id;

        $data1 = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id','orderCommonId'],
                'filter' => '"orderCommonId.id":%7B"=":"' . $request->orderCommonId . '"%7D',

            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserWarning'
                ]
            ]
        ]);

        if($data1->hasError){

            return eH($data1);
        }
       foreach ($data1->data as $single_data){

           $delete = Service::request([
               'method'  => 'DELETE',
               'url'     => Service::url('hr','crud'),
               'params'  => [
                   'id'  => $single_data->id
               ],
               'options' => [
                   'headers' => [
                       'TableName' => 'UserWarning'
                   ]
               ]
           ]);

           if($delete->hasError){

               return eH($delete);
           }

       }


        foreach ($request->userId as $item) {

            $data2 = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserWarning'
                    ],
                    'json' => [
                        'userId'            => [
                            'id' => $item
                        ],
                        'executorUserId'    => [
                            'id' => $request->userId2
                        ],
                        'orderCommonId'     => [
                            'id' => $orderId
                        ],
                        'isExplanation' => $workerS
                    ]
                ]
            ]);

            if($data2->hasError){

                return eH($data2);
            }
        }





        $orderTypeId = OrderTypeController::getOrderTypeNameById($request->listOrderTypeId);

        $data->data->listOrderTypeId->name = $orderTypeId;

        return $data;
    }
}
