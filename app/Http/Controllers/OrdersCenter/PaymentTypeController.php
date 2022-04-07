<?php

namespace App\Http\Controllers\OrdersCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library\Service\Service;

class PaymentTypeController extends Controller
{

    /**
     * @var string
     */
    private $tableName = 'ListPaymentTypes';
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
     * Get id by label 'individaul payment'
     * @param $label
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIndividualPaymentId($label)
    {

//        try {

            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'label'],
                    'filter' => '"label":%7B"=":"'.$label.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            if($data->hasError){

                return eH($data);
            }
            return response()->json($data);

//        } catch (\Exception $e){
//
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//
//        }
    }
}
