<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StaffTable\RelPositionPaymentController;
use App\Library\Service\Service;

class OrderAppointmentController extends Controller
{
    /**
     * @var string
     */
    private static $tableName = 'OrderAppointment';

    /**
     * @param $orderCommonId
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function getOrderAppointmentList($orderCommonId) {

//        try {

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id', 'appointmentMonth', 'endDate', 'startDate', 'civilService', 'positionId',
                                 'listContractTypeId.id','positionId.salary' ,'listContractTypeId.name', 'isPercent', 'isFree', 'valueSum',
                                 'appointmentType', 'appointmentMonth','fromPositionId.id', 'fromPositionId.posNameId.name',
                                 'fromPositionId.structureId.parentId.name', 'fromPositionId.structureId.name', 'trialPeriodMonth'],
                    'filter' => '"orderCommonId.id":%7B"=":"'.$orderCommonId.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => self::$tableName
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

    public static function insertOrderTransfer($request,$postArray){

        $json = self::generateInsertForm($request,$postArray);

        $data = Service::request([
            'method' => 'POST',
            'url' => Service::url('hr', 'orderCommons/orderTransfer', false),
            'options' => [
                'headers' => [
                    'TableName' => ''
                ],
                'json' => $json
            ]
        ]);

        if($data->hasError){
            eH($data);
        }
//else{
//
//        }

        $data->body['data']['listOrderTypeId']->name = OrderTypeController::getOrderTypeNameById($request->listOrderTypeId);

        return $data;

    }

    public static function generateInsertForm($request,$postArray){

        /* */
        $arr = array();

        $arr["orderNum"] = $request->orderNumber;
        $arr["orderDate"] = date('U', strtotime($request->orderDate)) * 1000;
        $arr["basis"] = $request->orderBasis;

        /* */
        $arr2 = array();
        $arr2["id"] = $request->listOrderTypeId;
        $arr2 = (object)$arr2;

        $arr["listOrderTypeId"] = $arr2;

//        /* */
//        $listContractTypeId = array();
//
//        $listContractTypeId["id"] = 'ddsxcz';


        /* */
        $userPositions = array();

        $userPositions["userPosition1"] = $request->userPosition1;
        $userPositions["userPosition2"] = $request->userPosition2;

        $userPositions = (object)$userPositions;

        /* */
        $transferDTOS = array();

        $transferDTOS["0"] = $userPositions;




        /* */
        $orderAppointmentDTO = array();

        $orderAppointmentDTO["startDate"]       = date('U', strtotime($request->startDate)) * 1000;
        if($request->endDate > 5){
            $orderAppointmentDTO["endDate"]         = date('U', strtotime($request->endDate)) * 1000;
        }
        $orderAppointmentDTO["transferDTOS"]    = $transferDTOS;
        $orderAppointmentDTO["appointmentType"] = "3";

        $orderAppointmentDTO = (object)$orderAppointmentDTO;

        $arr["orderAppointmentDTO"] = $orderAppointmentDTO;




        $arr = (object)$arr;

        return $arr;
    }

    /* edit */
    public static function getOrder($orderCommonId){
        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id','orderAppointmentId.id','orderAppointmentId.appointmentType','orderAppointmentId.orderCommonId','userPosition1','userPosition2','orderAppointmentId.startDate', 'orderAppointmentId.endDate'],
                'filter' => '"orderAppointmentId.orderCommonId.id":%7B"=":"'.$orderCommonId.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'MutualTransfer'
                ]
            ]
        ]);

        if($data->hasError){
            return eH($data);
        }

        return $data;
    }

    /* update */
    public static function updateOrder($request){



        /* */
        $arr = array();

        $arr["orderNum"] = $request->orderNumber;
        $arr["orderDate"] = date('U', strtotime($request->orderDate)) * 1000;
        $arr["basis"] = $request->orderBasis;

        /* */
        $arr2 = array();
        $arr2["id"] = $request->listOrderTypeId;
        $arr2 = (object)$arr2;

        $arr["listOrderTypeId"] = $arr2;

//        /* */
//        $listContractTypeId = array();
//
//        $listContractTypeId["id"] = 'ddsxcz';


        /* */
        $userPositions = array();

        $userPositions["userPosition1"] = $request->userPosition1;
        $userPositions["userPosition2"] = $request->userPosition2;

        $userPositions = (object)$userPositions;

        /* */
        $transferDTOS = array();

        $transferDTOS["0"] = $userPositions;




        /* */
        $orderAppointmentDTO = array();

        $orderAppointmentDTO["startDate"]       = date('U', strtotime($request->startDate)) * 1000;
        if($request->endDate > 5){
            $orderAppointmentDTO["endDate"]         = date('U', strtotime($request->endDate)) * 1000;
        }
        $orderAppointmentDTO["transferDTOS"]    = $transferDTOS;
        $orderAppointmentDTO["appointmentType"] = "3";

        $orderAppointmentDTO["id"] = $request->orderAppointmentId;


        $orderAppointmentDTO = (object)$orderAppointmentDTO;


        $arr["orderAppointmentDTO"] = $orderAppointmentDTO;




        $arr = (object)$arr;

        $data = Service::request([
            'method' => 'PUT',
            'url' => Service::url('hr', 'orderCommons/orderTransfer/' . $request->orderCommonId, false),
            'options' => [
                'headers' => [
                    'TableName' => ''
                ],
                'json' => $arr
            ]
        ]);

        if($data->hasError){
           return  eH($data);
        }
    }
}
