<?php

namespace App\Http\Controllers\OrdersCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library\Service\Service;

class OrderNonWorkDaysController extends Controller
{

    /**
     * @var string
     */
    private $tableName = 'OrderDismissalNote';

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
    public function getNonWorkDaysId($orderNonWorkDaysId)
    {

//        try {

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id','dayOffId','note','orderCommonId'],
                    'filter' => '"orderCommonId.id":%7B"=":"'.$orderNonWorkDaysId.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderRestDay'
                    ]
                ]
            ]);
            if($data->hasError){

                return eH($data);
            }
//dd($data);
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
                    ]
                ]
            ]
        ]);

        if($data->hasError){

            return eH($data);
        }
        $orderId = $data->body['data']['id'];

        $data2 = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'ListDayOff'
                ],
                'json' => [
                    'name'           => $request->input_name,
                    'isDayOff'       => true,
                    'startDate'      => date("Y-m-d", strtotime($request->input_startDate)),
                    'endDate'        => date("Y-m-d", strtotime($request->input_endDate))
                ]
            ]
        ]);
        if($data2->hasError){

            return eH($data2);
        }

        $dayOffId = $data2->body['data']['id'];

        $data3 = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderRestDay'
                ],
                'json' => [
                    'orderCommonId'  => [
                        'id' => $request->input_name
                    ],
                    'dayOffId'       => [
                        'id' => $dayOffId
                    ],
                    'note'      => $request->input_note
                ]
            ]
        ]);

        if($data3->hasError){

            return eH($data3);
        }
        return $data;
    }
}
