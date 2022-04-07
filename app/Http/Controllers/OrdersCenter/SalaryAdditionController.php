<?php

namespace App\Http\Controllers\OrdersCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        if($data->hasError){

            return eH($data);
        }
//        $data->body['data']['orderDate'] = date('d.m.Y', $data->body['data']['orderDate'] / 1000);
//        $data->body['data']['listOrderTypeId']['name'] = OrderTypeController::getOrderTypeNameById($request->get('listOrderTypeId'));

        $orderCommonid = $data->body['data']['id'];

        $userId = $request->userId;

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
}
