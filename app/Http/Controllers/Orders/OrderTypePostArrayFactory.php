<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;

class OrderTypePostArrayFactory extends Controller
{

    /**
     * @param $orderLabel
     * @param $request
     * @param null $id
     * @return array
     */
    public function getPostArray($orderLabel, $request, $id=null) {


        switch ($orderLabel) {

            case 'businessTrip':
                $array = $this->getBusinessTripPostArray($request);
                break;

            case 'vacation' :
                $array = $this->getVacationPostArray($request);
                break;

            case 'staff-add' :
                $array = $this->getStaffAddPostArray($request);
                break;

            case 'appointment':
                $array = $this->getAppointmentPostArray($request);
                break;

            case 'assignment':
                $array = $this->getAssignmentPostArray($request);
                break;

            case 'dismissal':
                $array = $this->getDismissalPostArray($request);
                break;

            case 'replacement':
                $array = $this->getReplacementPostArray($request);
                break;

            case 'nonWorkingDaysSelection':
                $array = $this->getNonWorkingDaysArray($request);
                break;

            case 'appointmentDTO':

                $array = $this->getAppointmentDTOPostArray($request);
                break;

            case 'staffOpening':
                $array = $this->getstaffOpeningArray($request);
                break;

            case 'staffCancellation':
                $array = $this->getstaffCancellationArray($request);
                break;

            case 'additionalWorkTime':
                $array = $this->getAddWorkTimeArray($request);
                break;

            case 'vacationRecall':
                $array = $this->getVacationRecallArray($request, $id);

                break;

            case 'damageCompensation':
                $array = $this->getDamageCompensationArray($request, $id);

                break;


            case 'damageCompensation':
                $array = $this->getDamageCompensationArray($request, $id);
                break;

            case 'Reward':
                $array = $this->getRewardArray($request);
                break;

            default:
                $array = [];
                break;

        }

        return $array;

    }

    /**
     * @param $request
     * @return array
     */
    private function getBusinessTripPostArray($request) {

        $orderBusinessTripList = [];
        $relUserInOrderBusinessTripList = [];

        for ($i = 0; $i < count($request->orderBusinessTripList); $i++) {

            //index for users array, usually a uniqid()
            $index = $request->orderBusinessTripList[$i];

            for ($j = 0; $j < count($request->userId[$index]); $j++) {

                if (isset($request->relUserInOrderBusinessTripId[$index][$request->userId[$index][$j]])) {

                    $relUserInOrderBusinessTripList[] = [
                        'id' => $request->relUserInOrderBusinessTripId[$index][$request->userId[$index][$j]],
                        'userId' => [
                            'id' => $request->userId[$index][$j]
                        ]
                    ];

                } else {

                    $relUserInOrderBusinessTripList[] = [
                        'userId' => [
                            'id' => $request->userId[$index][$j]
                        ]
                    ];

                }

            }

            $orderBusinessTripList[] = [
                'id' => $request->orderBusinessTripId[$i],
                'positionId' => [
                    'id' => $request->positionId[$i]
                ],
                'listRegionsId' => [
                    'id' => (int)$request->regionId[$i]
                ],
                'tripDay' => (int)$request->duration[$i],
                'tripReason' => $request->tripReason[$i],
                'comment' => $request->comment[$i],
                'startDate' => date('U', strtotime($request->startDate[$i])) * 1000,
                'endDate' => date('U', strtotime($request->endDate[$i])) * 1000,
                'relUserInOrderBusinessTripList' => $relUserInOrderBusinessTripList
            ];

            $relUserInOrderBusinessTripList = [];

        }

        return $orderBusinessTripList;

    }

    /**
     * @param $request
     * @return array
     */
    private function getDismissalPostArray($request) {

        $orderDismissalList = [];
        $relUserInOrderDismissalList = [];
        $orderNotes = [];

        for ($i = 0; $i < count($request->orderDismissalList); $i++) {

            for ($j = 0; $j < count($request->userId[$request->orderDismissalList[$i]]); $j++) {

                /*
                 * if order dismissal id is sent by user then resource is being updated
                 * send order dismissal id to update
                 * PUT request
                 * */
                if (isset($request->relUserInOrderDismissalId[$request->orderDismissalList[$i]]
                    [$request->relUserInOrderDismissalList[$request->orderDismissalList[$i]][$j]])) {

                    $relUserInOrderDismissalList[] = [
                        'id' => $request->relUserInOrderDismissalId[$request->orderDismissalList[$i]]
                        [$request->relUserInOrderDismissalList[$request->orderDismissalList[$i]][$j]],
                        'userId' => [
                            'id' => $request->userId[$request->orderDismissalList[$i]][$j]
                        ]
                    ];

                } else {

                    /*
                     * if user is newly added then userInOrderDismissalId is going to be created
                     * POST request
                     * */

                    $relUserInOrderDismissalList[] = [
                        'userId' => [
                            'id' => $request->userId[$request->orderDismissalList[$i]][$j]
                        ]
                    ];

                }

            }

            if (isset($request['note']) && count($request['note']) > 0)
            {
                foreach ($request['note'] as $index => $note)
                {
                    if (isset($request['noteId'][$index]))
                    {
                        $orderNotes[] = ['id' => $request['noteId'][$index] ,'note' => $note ];
                    } else {
                        $orderNotes[] = ['note' => $note ];
                    }
                }
            }
            $orderDismissalList[] = [
                'id' => $request->orderDismissalId,
                'dismissalDate' => date('U', strtotime($request->dismissalDate[$i])) * 1000,
                'listDismissalTypeId' => [
                    'id' => $request->listDismissalTypeId[$i]
                ],
                'positionId' => [
                    'id' =>$request->positionId[$i]
                ],
                'relUserInOrderDismissalList' => $relUserInOrderDismissalList,
                'orderDismissalNoteList' => $orderNotes
            ];

            $relUserInOrderDismissalList = [];

        }

        return $orderDismissalList;

    }

    /**
     * @param $request
     * @return array
     */
    private function getVacationPostArray($request) {
        $orderVacationDetailList = [];
        $orderVacationList       = [];

        $orderVacationId    = $request->orderVacationId;
        $listVacationTypeId = $request->listVacationTypeId;
        $positionId         = $request->positionId;
        $userId             = $request->userId;
        $vacationComment    = $request->vacationComment;

        $vacationWorkPeriodFrom = $request->vacationWorkPeriodFrom;
        $vacationWorkPeriodTo   = $request->vacationWorkPeriodTo;
        $start                  = $request->start;
        $end                    = $request->end;
        $vacationDay            = $request->difference_time;
        $vacationDetailId       = $request->vacationDetailId;

        /*get position id */

        $posId = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     =>  ['id', 'positionId.id'],
                'filter' =>  '"isclosed" : {"=":false}, "userId.id" : { "=" : "'.$userId.'" }'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPosition'
                ]
            ]
        ]);

        $positionId=$posId->data[0]->positionIdId;

        $orderVacationList[] = [
            'id'  =>$orderVacationId,
            'listVacationTypeId' =>[
                'id' => $listVacationTypeId
            ],
            'positionId' =>[
                'id' => $positionId
            ],
            'userId' =>[
                'id' => $userId
            ],
            'vacationComment'       =>$vacationComment,
            'workStartDate'         => date('U', strtotime($request->wsDate)) * 1000

        ];

        if(isset($vacationWorkPeriodFrom)){
            foreach ($vacationWorkPeriodFrom as $key=>$value)
            {
                if(isset($vacationDetailId)){
                    $vacationDetail=$vacationDetailId[$key];
                }
                else {
                    $vacationDetail=null;
                }

                if(isset($request->hiddenEdit)) {


                    if(isset($request->radditionalVacation)){

                        $vac=$request->radditionalVacation[$key];
                    }
                    else {
                        $vac=$request->additionalVacation[$key];
                    }
                    $orderVacationDetailList[] = [
                        'startDate' => date('U', strtotime($request->vacationStartDate[$key])) * 1000,
                        'endDate' => date('U', strtotime($request->vacationEndDate[$key])) * 1000,
                        'vacationWorkPeriodFrom' => date('U', strtotime($vacationWorkPeriodFrom[$key])) * 1000,
                        'vacationWorkPeriodTo' => date('U', strtotime($vacationWorkPeriodTo[$key])) * 1000,
                        'totalVacationDay' => $request->chosenAmount[$key],
                        'mainVacationDay' => $request->rmainVacation[$key],
                        'mainRemainderVacationDay' => abs($request->currentMainVacation[$key] - $request->rmainVacation[$key]),
                        'additionVacationDay' => $vac,
                        'additionRemainderVacationDay' => abs($request->additionalRemainderVacationDay[$key] - $request->radditionalVacation[$key]),
                        'workStartDate' => date('U', strtotime($request->wsDate)) * 1000,
                        'totalMainVacationDay' => $request->mainVacationDayForPerson[$key],
                        'totalAdditionVacationDay' => $request->currentAdditionalVacation[$key]

                    ];

                }
                else {

                    if(isset($request->hiddenFrom)){

                        if(isset($request->radditionalVacation)){

                            $vac=$request->radditionalVacation[$key];
                        }
                        else {
                            $vac=$request->additionalVacation[$key];
                        }
                        $orderVacationDetailList[] = [
                            'startDate' => date('U', strtotime($request->vacationStartDate[$key])) * 1000,
                            'endDate' => date('U', strtotime($request->vacationEndDate[$key])) * 1000,
                            'vacationWorkPeriodFrom' => date('U', strtotime($vacationWorkPeriodFrom[$key])) * 1000,
                            'vacationWorkPeriodTo' => date('U', strtotime($vacationWorkPeriodTo[$key])) * 1000,
                            'totalVacationDay' => $request->chosenAmount[$key],
                            'mainVacationDay' => $request->rmainVacation[$key],
                            'mainRemainderVacationDay' => abs($request->currentMainVacation[$key] - $request->rmainVacation[$key]),
                            'additionVacationDay' => $vac,
                            'additionRemainderVacationDay' => abs($request->additionalRemainderVacationDay[$key] - $request->radditionalVacation[$key]),
                            'workStartDate' => date('U', strtotime($request->wsDate)) * 1000,
                            'totalMainVacationDay' => $request->mainVacationDayForPerson[$key],
                            'totalAdditionVacationDay' => $request->currentAdditionalVacation[$key]

                        ];
                    }
                    else {
                        $orderVacationDetailList[] = [
                            'startDate' => date('U', strtotime($request->vacationStartDate[$key])) * 1000,
                            'endDate' => date('U', strtotime($request->vacationEndDate[$key])) * 1000,
                            'vacationWorkPeriodFrom' => date('U', strtotime($vacationWorkPeriodFrom[$key])) * 1000,
                            'vacationWorkPeriodTo' => date('U', strtotime($vacationWorkPeriodTo[$key])) * 1000,
                            'totalVacationDay' => $request->mainRemainderVacationDay[$key] + $request->additionalVacationDay[$key],
                            'mainVacationDay' => $request->mainRemainderVacationDay[$key],
                            'mainRemainderVacationDay' => $request->currentMainVacation[$key],
                            'additionVacationDay' => $request->additionalVacationDay[$key],
                            'additionRemainderVacationDay' => $request->additionalRemainderVacationDay[$key],
                            'workStartDate' => date('U', strtotime($request->wsDate)) * 1000,
                            'totalMainVacationDay' => $request->mainVacationDayForPerson[$key],
                            'totalAdditionVacationDay' => $request->currentAdditionalVacation[$key]

                        ];
                    }
                }
            }
        }


        $orderVacationList[0]['orderVacationDetailList'] = $orderVacationDetailList;

        return $orderVacationList;

    }

    /**
     * @param $request
     * @return array
     */
    private function getStaffAddPostArray($request)
    {
        $arr = array();

        /*
       * if this is update, there must be orderAppointmentId
       * */
        $arr[]=(object)[];

        $arr[0]->structureId=(object)['id'=>$request->struktureId];

        $arr[0]->posNameId=(object)['id'=>$request->posNameId];

        $arr[0]->notStuff=false;

        $arr[0]->isCivilService=false;

        $arr[0]->vacationDay=$request->vacationDay;

        $arr[0]->count=$request->count;
        $arr[0]->isclosed="false";

        return $arr;
    }

    /**
     * @param $request
     * @return array
     */
    private function getAppointmentPostArray($request)
    {
        $arr = array();

        /*
       * if this is update, there must be orderAppointmentId
       * */

        $appointments = $request['appointmentList'];

        foreach ($appointments as $index => $appointment)
        {
            if (isset($request['orderAppointmentId'][$appointment])) {
                $arr[$index]['id'] = $request['orderAppointmentId'][$appointment];
            }

            $arr[$index]['positionId']         = ['id' => $request['positionId'][$appointment]];

            $arr[$index]['startDate']          = date('U', strtotime($request['startDate'][$appointment])) * 1000;

            $arr[$index]['appointmentMonth']   = isset($request['duration'][$appointment]) ? $request['duration'][$appointment] : null;

            $arr[$index]['civilService']       = isset($request['civilService'][$appointment]) && $request['civilService'][$appointment] == 'on' ? true : false;

            $arr[$index]['listContractTypeId'] = ['id' => $request['contract_type'][$appointment]];

            $arr[$index]['appointmentType']    = $request['appointmentType'][$appointment];

            $arr[$index]['isFree']             = isset($request['isFree'][$appointment]) ? false : true;

            if (isset($request['isPercent'][$appointment]))
                $arr[$index]['isPercent'] = $request['isPercent'][$appointment] == 'true';

            if (isset($request['valueSum'][$appointment]))
                $arr[$index]['valueSum']  = $request['valueSum'][$appointment];


            if (isset($request['fromPositionId'][$appointment]) && $request['fromPositionId'][$appointment] != null)
            {
                $arr[$index]['fromPositionId'] = ['id' => $request['fromPositionId'][$appointment]];
            }

            if (isset($request['trialPeriodMonth'][$appointment]))
                $arr[$index]['trialPeriodMonth'] = $request['trialPeriodMonth'][$appointment];


            if (isset($request['userPositionId'][$request['employee'][$appointment]])) {

                $arr[$index]['userPositionList'][] = [
                    'id'     => $request['userPositionId'][$request['employee'][$appointment]],
                    'userId' => ['id' => $request['employee'][$appointment]]
                ];

            } else {
                /*
                 * request is POST request
                 * resource is going to be created (hopefully)
                 * */
                $arr[$index]['userPositionList'][] = ['userId' => ['id' => $request['employee'][$appointment]] ];
            }

        }

        return $arr;
    }

    /**
     * @param $request
     * @return array
     */
    private function getAppointmentDTOPostArray($request)
    {

        $arr = array();

        $arr['orderAppointmentDTO']['transferDTOSList'][0]['userPosition1']     = $request->user1Id;
        $arr['orderAppointmentDTO']['transferDTOSList'][0]['userPosition2']     = $request->user2Id;

        return $arr;
    }

    /**
     * @param $request
     * @return array
     */
    private function getAssignmentPostArray($request)
    {
        $arr = array();

        /*
        * if this is update, there must be orderAppointmentId
        * */

        if (isset($request['orderAppointmentId'])) { $arr[0]['id'] = $request['orderAppointmentId']; }

        $arr[0]['positionId']           = ['id'=>$request['position_name']];

        $arr[0]['startDate']            = date('U', strtotime($request['startDate'])) * 1000;

        $arr[0]['endDate']              = date('U', strtotime($request['endDate'])) * 1000;

        $arr[0]['isFree']               = isset($request['isFree']) ? $request['isFree'] : true;

        $arr[0]['isPercent']            = $request['isPercent'];

        $arr[0]['valueSum']             = $request['valueSum'];

        /*
           * if userPositionId exists then send its id
           * this is PUT request
           * */
        if (isset($request['userPositionId'][$request['employee']])) {
            $arr[0]['userPositionList'][] = [
                'id'     => $request['userPositionId'][$request['employee']],
                'userId' => ['id' => $request['employee']]
            ];
        } else {
            /*
             * userPositionId does not exist, POST request
             * */
            $arr[0]['userPositionList'][] = ['userId' => ['id' => $request['employee']] ];
        }

        return $arr;
    }

    /**
     * @param $request
     * @return array
     */
    private function getReplacementPostArray($request)
    {
        $arr = array();

        /*
         * if this is update, there must be orderAppointmentId
         * */

        if (isset($request['orderAppointmentId'])) { $arr[0]['id'] = $request['orderAppointmentId']; }

        $arr[0]['positionId']           = ['id'=>$request['position_name']];

        $arr[0]['startDate']            = date('U', strtotime($request['startDate'])) * 1000;

        $arr[0]['endDate']              = date('U', strtotime($request['endDate'])) * 1000;

        $arr[0]['isFree']               = isset($request['isFree']) ? $request['isFree'] : true;

        $arr[0]['isPercent']            = $request['isPercent'];

        $arr[0]['valueSum']             = $request['valueSum'];

        /*
         * if both userReplacementId and userPositionId exists then send id of both of them
         * */
        if (isset($request['userPositionId'][$request['replacedUserId']]) && isset($request['userReplacementId'][$request['employee']])) {

            $arr[0]['userPositionList'][]   = [
                'id'                  => $request['userPositionId'][$request['replacedUserId']],
                'userId'              => ['id' => $request['employee'] ],
                'userReplacementList' => [
                    [
                        'id'     => $request['userReplacementId'][$request['employee']],
                        'userId' => $request['replacedUserId']
                    ]
                ] ];

            /*
             * if userPositionId exists only then send its id but don't send userReplacementId
             * */
        } else if (isset($request['userPositionId'][$request['replacedUserId']])) {

            $arr[0]['userPositionList'][]   = [
                'id'                  => $request['userPositionId'][$request['replacedUserId']],
                'userId'              => ['id' => $request['employee'] ],
                'userReplacementList' => [
                    [
                        'userId' => $request['replacedUserId']
                    ]
                ] ];

            /*
             * if userReplacementId exists only then send its id but don't send userPositionId
             * */
        } else if (isset($request['userReplacementId'][$request['employee']])) {

            $arr[0]['userPositionList'][]   = [
                'userId'              => ['id' => $request['employee'] ],
                'userReplacementList' => [
                    [
                        'id'     => $request['userReplacementId'][$request['employee']],
                        'userId' => $request['replacedUserId']
                    ]
                ] ];

            /*
             * else don't send any of them
             * resource is going to be created
             * */
        } else {

            $arr[0]['userPositionList'][]   = ['userId'              => ['id' => $request['employee'] ],
                'userReplacementList' => [ ['userId' => $request['replacedUserId'] ] ] ];
        }

        return $arr;
    }

    /**
     * @param $request
     * @return array
     */
    private function getNonWorkingDaysArray($request)
    {
        $arr = array();

        /*
        * if this is update, there must be orderAppointmentId
        * */

        if (isset($request['dayOffId']) && isset($request['orderRestDayId'])){

            $arr[0]['id'] = $request['orderRestDayId'];

            $dayOffId = $request['dayOffId'];

        }else{
            $dayOffId = null;
        }

        $arr[0]['dayOffId']           = [
            'id' =>         $dayOffId,
            'name'=>        $request['input_name'],
            'startDate'=>   date("Y-m-d" , strtotime($request['input_startDate'])),
            'endDate'=>     date("Y-m-d" , strtotime($request['input_endDate'])),
            'isDayOff'=>    true
        ];

        $arr[0]['dayOffId'] = (object)$arr[0]['dayOffId'];
        return $arr;
    }

    /**
     * @param $request
     * @return array
     */
    private function getstaffOpeningArray($request){

        $arr   = array();

        $strId = array();
        $strId = [ 'id' =>    $request['structureId'] ];
        $strId = (object)$strId;

        $posNameId = array();
        $posNameId = [ 'id' =>    $request['listPositionNameId'] ];
        $posNameId = (object)$posNameId;

        $paymentType = array();
        $paymentType = [ 'id' =>  1 ];
        $paymentType = (object)$paymentType;


        $addSal = array();
        $addSal = [ 'paymentTypeId' =>   $paymentType , 'isPercent' => false , 'value' => $request['salary'] ];
        $addSal = (object)$addSal;

        /*
        * if this is update, there must be orderAppointmentId
        * */
        $arr2 = array();
        
        $arr2['notStuff']       = false;
        $arr2['isCivilService'] = false;
        $arr2['vacationDay']    = $request['vacation'];
        $arr2['count']          = $request['stateNum'];
        $arr2['salary']         = $request['salary'];
        $arr2['isclosed']       = false;
        $arr2['structureId']    = $strId;
        $arr2['posNameId']      = $posNameId;

        $arr2['relPositionPaymentList'] = [
            '0' =>  $addSal
        ];

        $arr2 = (object)$arr2;


        return $arr;
    }

    /**
     * @param $request
     * @return array
     */
    private function getstaffCancellationArray($request){


        $arr   = array();

        $strId = array();
        $strId = [ 'id' =>    $request['structureId'] ];
        $strId = (object)$strId;

        $posNameId = array();
        $posNameId = [ 'id' =>    $request['listPositionNameId'] ];
        $posNameId = (object)$posNameId;

        $paymentType = array();
        $paymentType = [ 'id' =>  1 ];
        $paymentType = (object)$paymentType;


        $addSal = array();
        $addSal = [ 'paymentTypeId' =>   $paymentType , 'isPercent' => false , 'value' => $request['salary'] ];
        $addSal = (object)$addSal;

        /*
        * if this is update, there must be orderAppointmentId
        * */
        $arr2 = array();

        $arr2['notStuff']       = false;
        $arr2['isCivilService'] = false;
        $arr2['vacationDay']    = $request['vacation'];
        $arr2['count']          = $request['stateNum'];
        $arr2['salary']         = $request['salary'];
        $arr2['isclosed']       = false;
        $arr2['structureId']    = $strId;
        $arr2['posNameId']      = $posNameId;

        $arr2['relPositionPaymentList'] = [
            '0' =>  $addSal
        ];

        $arr2 = (object)$arr2;


        return $arr;
    }

    /**
     * @param $request
     * @return object
     */
    private function getAddWorkTimeArray($request){
        $date        = date("Y-m-d" ,strtotime($request['input_startDate']));
        $orderNumber = $request['orderNumber'];
        $orderDate   = date('U', strtotime($request['orderDate'])) * 1000;
        $basis       = $request['orderBasis'];
        $basis       = $request['orderBasis'];
        $listOrderTypeId = (object)["id" => $request['listOrderTypeId']];
        $listExcessWorkTypeId[0] = (object)["id" => $request['additionalWorkTimeType']];
        $orderExcessWorkList = [];
        $relUserExcessWorkList = [];
        foreach ($request['additionalWorkDateStart'] as $key => $value) {
            $orderExcessWorkList[$key] = [
                "startDate"             => $date.' '.$value,
                "endDate"               => $date.' '.$request['additionalWorkDateEnd'][$key],
                "listExcessWorkTypeId"  => (object)["id" => $request['additionalWorkTimeType']],
                "relUserExcessWorkList" =>  [ 0 => (object)[
                    "positionId" => (object)[
                        "id" => UserPositionController::getPosByUserId2($request['userId'][$key])->positionId->id
                    ],
                    "userId" => (object)[
                        "id" => $request['userId'][$key]
                    ]
                ]
                ]
            ];
        }

        $data = (object)[
            "listOrderTypeId"       => $listOrderTypeId,
            "orderNum"              => $orderNumber,
            "orderDate"             => $orderDate,
            "basis"                 => $basis,
            "orderExcessWorkList"   => $orderExcessWorkList,
        ];
        return $data;
    }

    /**
     * @param $request
     * @return array
     */
    private function getVacationRecallArray($request, $orderCommonId){

        $orderNumber = $request['orderNumber'];
        $orderDate   = date('U', strtotime($request['orderDate'])) * 1000;
        $basis       = $request['orderBasis'];
        $listOrderTypeId = (object)["id" => $request['listOrderTypeId']];
        $orderVacationReturnList=array();
        $returnType=(int)$request->returnType;
        if($request->meth=="PUT"){
            $vacationReeturn= Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id','orderCommonId.id', 'orderVacationId.id'],
                    'filter' => '"orderCommonId.id" : { "=" : "' . $orderCommonId . '"}'

                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacationReturn'
                    ]
                ]
            ]);

//            dd($vacationReeturn->data[0]->id);
            $vacationReeturnId=(int)$vacationReeturn->data[0]->id;

            $vacationReplacementId= Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id','orderVacationReturnId.id'],
                    'filter' => '"orderVacationReturnId.id" : { "=" : "' . $vacationReeturnId . '"}'

                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'VacationReplacement'
                    ]
                ]
            ]);
            if(isset($vacationReplacementId->data[0])){

                $vacationReplacementId=(int)$vacationReplacementId->data[0]->id;

            }
            else {
                $vacationReplacementId=null;
            }


            if($request->returnType=='1'){
                if($vacationReplacementId==null){

                    $orderVacationReturnList[0]=[
                        "returnDate"=>date('Y-m-d', strtotime($request->recallDate)),
                        "listReturnTypeId"=> $returnType,
                        "orderVacationId"=>(object)[
                            "id"=> $request->vacationId
                        ],
                        "vacationReplacement"=>(object)[
                            "startDate"=>date('Y-m-d', strtotime($request->startDate)),
                            "endDate"=>date('Y-m-d', strtotime($request->endDate))
                        ]
                    ];
                }
                else {

                    $orderVacationReturnList[0]=[

                        "id"=>$vacationReeturnId,

                        "returnDate"=>date('Y-m-d', strtotime($request->recallDate)),
                        "listReturnTypeId"=> $returnType,
                        "orderVacationId"=>(object)[
                            "id"=> $request->vacationId
                        ],
                        "vacationReplacement"=>(object)[
                            "id"=>$vacationReplacementId,
                            "startDate"=>date('Y-m-d', strtotime($request->startDate)),
                            "endDate"=>date('Y-m-d', strtotime($request->endDate))
                        ]
                    ];

                }

            }
            else {

                $orderVacationReturnList[0]=[
                    "returnDate"=>date('Y-m-d', strtotime($request->recallDate)),
                    "listReturnTypeId"=> $returnType,
                    "orderVacationId"=>(object)[
                        "id"=> $request->vacationId
                    ]
                ];

            }

        }
        else {
            /*
             * if request is POST
             *
             */
            if($request->returnType=='1'){
                $orderVacationReturnList[0]=[
                    "returnDate"=>date('Y-m-d', strtotime($request->recallDate)),
                    "listReturnTypeId"=> $returnType,
                    "orderVacationId"=>(object)[
                        "id"=> $request->vacationId
                    ],
                    "vacationReplacement"=>(object)[
                        "startDate"=>date('Y-m-d', strtotime($request->startDate)),
                        "endDate"=>date('Y-m-d', strtotime($request->endDate))
                    ]
                ];
            }
            else {

                $orderVacationReturnList[0]=[
                    "returnDate"=>date('Y-m-d', strtotime($request->recallDate)),
                    "listReturnTypeId"=> $returnType,
                    "orderVacationId"=>(object)[
                        "id"=> $request->vacationId
                    ]
                ];

            }

        }


        $data = (object)[
            "listOrderTypeId"       => $listOrderTypeId,
            "orderNum"              => $orderNumber,
            "orderDate"             => $orderDate,
            "basis"                 => $basis,
            "orderVacationReturnList"   => $orderVacationReturnList,
        ];

        return $data;
    }

    /**
     * @param $request getVacationRecallArray
     * @return array
     */
    private function getRewardArray($request)
    {
        $paymentTypeId = 21;
        $isPercent     = false;
        $rowState      = 1;

        $array = [];

        foreach ($request['reward'] as $key => $id)
        {
            if (isset($request['id'][$id]))
                $array[$key]['id'] = $request['id'][$id];

            $array[$key]['issueDate']    = javaDate($request['rewardDate'][$id]);
            $array[$key]['reason']       = '';
            $array[$key]['rowState']     = $rowState;
            $array[$key]['isTaxes']      = isset($request['includingTaxes'][$id]) && $request['includingTaxes'][$id] == 'on';
            $array[$key]['userId']['id'] = $request['userId'][$id];

            if (isset($request['relUserPaymentsId'][$id]))
                $array[$key]['relUserPaymentsId']['id'] = $request['relUserPaymentsId'][$id];
            $array[$key]['relUserPaymentsId']['valus']               = $request['rewardAmount'][$id];
            $array[$key]['relUserPaymentsId']['isPercent']           = $isPercent;
            $array[$key]['relUserPaymentsId']['startDate']           = javaDate($request['rewardDate'][$id]);
//            $array[$key]['relUserPaymentsId']['endDate']             = javaDate($request['rewardDate'][$id]);
            $array[$key]['relUserPaymentsId']['userId']['id']        = $request['userId'][$id];
            $array[$key]['relUserPaymentsId']['paymentTypeId']['id'] = $paymentTypeId;

        }

        return $array;
    }


}
