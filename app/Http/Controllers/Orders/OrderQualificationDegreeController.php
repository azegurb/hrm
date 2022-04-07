<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library\Service\Service;

class OrderQualificationDegreeController extends Controller
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
    public function getQualificationDegree()
    {

        try {

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id','qualificationId','startDate','orderCommonId','userId'],
                    'filter' => '"orderCommonId.id":%7B"=":"'.$orderCommonId.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserQualificationDegree'
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

        $orderId = $data->body['data']['id'];

        $data2 = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'UserQualificationDegree'
                ],
                'json' => [
                    'orderCommonId'     => [
                        'id'    => $orderId
                    ],
                    'qualificationId'   => [
                        'id'    => $request->listQualDegree
                    ],
                    'userId'            => [
                        'id'    => $request->userId
                    ],
                    'startDate'      => date("Y-m-d", strtotime($request->input_startDate))
                ]
            ]
        ]);

        return $data;
    }
}
