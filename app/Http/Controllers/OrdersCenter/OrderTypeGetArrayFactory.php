<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Http\Controllers\HelperLists\NonWorkDaysController;
use App\Http\Controllers\PersonalCards\UserEducationController;
use App\Http\Controllers\StaffTable\RelPositionPaymentController;
use App\Http\Controllers\StaffTable\RelUserPaymentsController;
use App\Library\Service\Service;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PersonalCards\UserVacationController;
use App\Http\Controllers\StaffTable\PositionController;

class OrderTypeGetArrayFactory extends Controller
{
    /**
     * Take key and order common id and return fields by that key
     * @param $childKey
     * @param $orderCommonId
     * @return array
     */
    public function getChildFields($childKey, $orderCommonId)
    {


        switch ($childKey) {
            case 'businessTrip':
                $childFields = $this->getBusinessTripFields($orderCommonId);
                break;

            case 'vacation':
                $childFields = $this->getVacationFields($orderCommonId);
                break;

            case 'dismissal':
                $childFields = $this->getDismissalFields($orderCommonId);
                break;

            case 'appointment' :
                $childFields = $this->getAppointmentFields($orderCommonId);
                break;

            case 'assignment' :
                $childFields = $this->getAssignmentFields($orderCommonId);
                break;

            case 'replacement' :
                $childFields = $this->getReplacementFields($orderCommonId);
                break;

            case 'financialAid':
                $childFields = $this->getFinancialAidFields($orderCommonId);
                break;

            case 'nonWorkingDaysSelection':
                $childFields = $this->getNonWorkingDaysFields($orderCommonId);
                break;

            case 'orderTransfer':
                $childFields = $this->getOrderTransferFields($orderCommonId);
                break;

            case 'discipline':
                $childFields = $this->getDisciplineFields($orderCommonId);
                break;

            case 'warning':
                $childFields = $this->getWarningFields($orderCommonId);
                break;

            case 'staffOpening':
                $childFields = $this->getStaffOpeningFields($orderCommonId);
                break;

            case 'additionalWorkTime':
                $childFields = $this->getAddWorkFields($orderCommonId);
                break;

            case 'staffCancellation':
                $childFields = $this->getStaffCancellationFields($orderCommonId);
                break;

            case 'Reward':
                $childFields = $this->getRewardFields($orderCommonId);
                break;

            case 'QualificationDegree':
                $childFields = $this->getQualificationDegreeFields($orderCommonId);
                break;

            default:
                $childFields = [];
                break;
        }

        return $childFields;

    }

    /**
     * Get businessTrip data and return field name associative array
     * @param $orderCommonId
     * @return array
     */
    private function getBusinessTripFields($orderCommonId)
    {
        $userInBusinessTrip = [];
        $fields = [];
        $userSelect = [];
        $userPositions = [];

        $orderBusinessTripController = new OrderBusinessTripController();
        $relUserInOrderBusinessTripController = new RelUserInOrderBusinessTripController();

        $childData = (array)$orderBusinessTripController->getOrderBusinessTripList($orderCommonId);

        for ($i = 0; $i < count($childData['data']); $i++) {

            $userInBusinessTrip[] = (array)$relUserInOrderBusinessTripController->getRelUserInOrderBusinessTripList($childData['data'][$i]->id);

            for ($j = 0; $j < count($userInBusinessTrip[$i]['data']); $j++) {

                $userSelect[] = [
                    'id'   => $userInBusinessTrip[$i]['data'][$j]->userIdId,
                    'text' => $userInBusinessTrip[$i]['data'][$j]->userIdLastName . ' '
                        . $userInBusinessTrip[$i]['data'][$j]->userIdFirstName
                ];

                $userPositions[] = $userInBusinessTrip[$i]['data'][$j]->id;

            }

            if($childData['data'][$i]->positionIdStructureId->parentId != null){
                $parent = $childData['data'][$i]->positionIdStructureId->parentId->name;
            }else{
                $parent = ' ';
            }

            if($childData['data'][$i]->listVillageIdId != null && $childData['data'][$i]->listVillageIdName != null){
                $villageId = $childData['data'][$i]->listVillageIdId;
                $villageName = $childData['data'][$i]->listVillageIdName;
            }else{
                $villageId = null;
                $villageName = null;
            }

            $fields[] = [
                'id'             => $childData['data'][$i]->id,
                'startDate'      => date('d.m.Y', strtotime($childData['data'][$i]->startDate)),
                'endDate'        => date('d.m.Y', strtotime($childData['data'][$i]->endDate)),
                'duration'       => trim($childData['data'][$i]->tripDay),
                'tripReason'     => $childData['data'][$i]->tripReason,
                'comment'        => $childData['data'][$i]->comment,
                'positionId'     => $childData['data'][$i]->positionIdId,
                'listStructures' => [
                    'id'   => $childData['data'][$i]->positionIdStructureId->id,
                    'text' => $parent . ' '
                        . $childData['data'][$i]->positionIdStructureId->name
                ],
                'listPositionNames' => [
                    'id'   => $childData['data'][$i]->positionIdId,
                    'text' => $childData['data'][$i]->positionIdPosNameId->name
                ],
                'listEmployees'  => $userSelect,
                'userPositionId' => $userPositions,
                'listCountries' => [
                    'id'   => $childData['data'][$i]->listCountryId->id,
                    'text' => $childData['data'][$i]->listCountryId->name
                ],
                'listCities' => [
                    'id'   => $childData['data'][$i]->listCityId->id,
                    'text' => $childData['data'][$i]->listCityId->name
                ],
                'listVillages' => [
                    'id'   => $villageId,
                    'text' => $villageName
                ]

            ];

            $userPositions = [];
            $userSelect = [];
        }

        return $fields;

    }

    /**
     * get order vacation form fields
     * @param $orderCommonId
     * @return array
     */
    private function getVacationFields($orderCommonId)
    {
        $fields = [];

        $orderVacationController = new OrderVacationController();
        $orderVacationDetailController = new UserVacationController();


        $childData = $orderVacationController->getOrderVacation($orderCommonId);


        $orderVacationId = $childData->data[0]->id;
        $positionIdId = $childData->data[0]->positionIdId;
//        dd($orderVacationId);

           $childDataDetail = (array)$orderVacationDetailController->orderVocationDetail($orderVacationId, 'raw');

//           dd($childDataDetail);

        $childDataStructure = $orderVacationController->getStructurePosition($positionIdId);
//        dd($childDataDetail);
        $fields[] = [
            'posNameIdId'            => $positionIdId,
            'structureIdId'          => $childDataStructure->data[0]->structureIdId,
            'posNameIdName'          => $childDataStructure->data[0]->posNameIdName,
            'structureIdName'        => $childDataStructure->data[0]->structureIdName,
            'vacationComment'        => $childData->data[0]->vacationComment,
            'listVacationTypeIdName' => $childData->data[0]->listVacationTypeIdName,
            'listVacationTypeIdId'   => $childData->data[0]->listVacationTypeIdId,
            'userIdLastName'         => $childData->data[0]->userIdLastName,
            'userIdFirstName'        => $childData->data[0]->userIdFirstName,
            'userIdPatronymic'        => $childData->data[0]->userIdPatronymic,
            'userIdId'               => $childData->data[0]->userIdId,
            'orderVacationId'        => $childData->data[0]->id,
            'wsDate'                 => $childDataDetail['data'][0]->workStartDate
//            'wsDate'                 => $childDataDetail['data'][0]->workStartDate
        ];


//        foreach ($childDataDetail['data'] as $key => $value) {
//            $fields[0]['dates'][$key]['vacationDetailId'] = $value->id;
//            $fields[0]['dates'][$key]['endDate'] = $value->endDate;
//            $fields[0]['dates'][$key]['startDate'] = $value->startDate;
//            $fields[0]['dates'][$key]['vacationWorkPeriodFrom'] = $value->vacationWorkPeriodFrom;
//            $fields[0]['dates'][$key]['vacationWorkPeriodTo'] = $value->vacationWorkPeriodTo;
//            $fields[0]['dates'][$key]['vacationDay'] = $value->vacationDay;
//        }

        return $fields;
    }

    /**
     * get order dismissal form fields
     * @param $orderCommonId
     * @return array
     */
    private function getDismissalFields($orderCommonId)
    {

        $userInOrderDismissal = [];
        $fields = [];
        $userSelect = [];
        $userInOrderDismissalId = [];
        $notes = [];

        $orderDismissalList = new OrderDismissalController();
        $relUserIndOrderDismissal = new RelUserInOrderDismissal();
        $orderDismissalNoteController = new OrderDismissalNoteController();

        $childData = (array)$orderDismissalList->getOrderDismissal($orderCommonId);

        for ($i = 0; $i < count($childData['data']); $i++) {

            $userInOrderDismissal[] = (array)$relUserIndOrderDismissal->getRelUserInOrderDismissal($childData['data'][$i]->id);

            $dismissalNotes = (array)$orderDismissalNoteController->getNotesByOrderDismissalId($childData['data'][$i]->id);
            if (isset($dismissalNotes['totalCount']) && $dismissalNotes['totalCount'] > 0)
            {
                    $notes[0] = [
                        'id'   => $dismissalNotes['data'][0]->id,
                        'note' => $dismissalNotes['data'][0]->note
                    ];
            }

            for ($j = 0; $j < count($userInOrderDismissal[$i]['data']); $j++) {

                $userSelect[] = [
                    'id'   => $userInOrderDismissal[$i]['data'][$j]->userId->id,
                    'text' => $userInOrderDismissal[$i]['data'][$j]->userId->lastName  . ' '
                            . $userInOrderDismissal[$i]['data'][$j]->userId->firstName . ' '
                            . $userInOrderDismissal[$i]['data'][$j]->userId->patronymic
                ];

                $userInOrderDismissalId[] = $userInOrderDismissal[$i]['data'][$j]->id;

            }

            $fields[] = [
                'dismissalDate' => date('d.m.Y', strtotime($childData['data'][$i]->dismissalDate)),
                'listDismissalTypeId' => [
                    'id'   => $childData['data'][$i]->listDismissalTypeId->id,
                    'text' => $childData['data'][$i]->listDismissalTypeId->name,
                ],
                'listStructures' => [
                    'id' => $childData['data'][$i]->structureIdId,
                    'text' => $childData['data'][$i]->structureIdName
                ],
                'relatedStructure' => [
                    'id' => $childData['data'][$i]->relatedStructureIdId,
                    'text' => $childData['data'][$i]->relatedStructureIdName
                ],
                'listPositionNames' => [
                    'id' => $childData['data'][$i]->positionIdId,
                    'text' => $childData['data'][$i]->posNameIdName
                ],
                'relUserInOrderDismissalList' => $userSelect,
                'orderDismissalId'            => $childData['data'][$i]->id,
                'userInOrderDismissalId'      => $userInOrderDismissalId,
                'orderDismissalNotes'         => $notes
            ];

        }

        return $fields;

    }

    /**
     * collect order appointment form fields
     * @param $orderCommonId
     * @return array
     */
    private function getAppointmentFields($orderCommonId)
    {
        /* empty arrays */
        $fields = [];
        $userSelect = [];
        $userPositions = [];
        $positionPayments = [];
        $relatedStr = [];

        /* controllers */
        $orderAppointmentList = new OrderAppointmentController();
        $relUserInOrderAppointment = new RelUserInOrderAppointmentController();
        $relPositionPaymentController =  new RelPositionPaymentController();
        $userPaymentController = new RelUserPaymentsController();

        /* get order appointments */
        $childData = (array)$orderAppointmentList->getOrderAppointmentList($orderCommonId);

        /* get position payments */
        $positionPayments[] = (array)$relPositionPaymentController->getPaymentsByPositionId($childData['data'][0]->positionId->id, 1);

        $payment = 0;

        /* collect position payments if there is one */
        if (isset($positionPayments[0]['totalCount']) && $positionPayments[0]['totalCount'] > 0)
        {
            /* collect payments */
            $payment = $positionPayments[0]['data'][0]->value;
        }

        /* iterate through each appointment */
        for ($i = 0; $i < count($childData['data']); $i++) {

            $userInOrderAppointment = (array)$relUserInOrderAppointment->getRelUserInOrderAppointment($childData['data'][$i]->id);

            if (isset($userInOrderAppointment['totalCount']) && $userInOrderAppointment['totalCount'] > 0)
            {

                /* iterate throught each user in order dismissal  */
                for ($j = 0; $j < count($userInOrderAppointment['data']); $j++) {

                    /* collect user info */
                    $userSelect[] = [
                        'id'            => $userInOrderAppointment['data'][$j]->userId->id,
                        'gender'        => $userInOrderAppointment['data'][$j]->userId->gender,
                        'text'          => $userInOrderAppointment['data'][$j]->userId->lastName  . ' '
                            . $userInOrderAppointment['data'][$j]->userId->firstName . ' '
                            . $userInOrderAppointment['data'][$j]->userId->patronymic
                    ];

                    /* collect position and user position id */
                    $userPositions[] = [
                        'positionId'     => $userInOrderAppointment['data'][$j]->positionIdId,
                        'userPositionId' => $userInOrderAppointment['data'][$j]->id
                    ];

                    $relatedStr[] = [
                        'id'   => $userInOrderAppointment['data'][$j]->relatedStructureIdId,
                        'name' => $userInOrderAppointment['data'][$j]->relatedStructureIdName
                    ];

                }

            }

            $userPayment = $userPaymentController->getUserPaymentByUser($userSelect[0]['id'], 'Individual');
            $conditionalPayment = $relPositionPaymentController->getPaymentsByPositionId($userPositions[0]['positionId'], 'conditions');

            $userPayment = (array)json_decode($userPayment->getContent());
            $conditionalPayment = (array)$conditionalPayment;

            if ($userPayment['totalCount'] > 0)
            {
                $userPayment = $userPayment['data'][0];

            } else {

                $userPayment = (object)[
                    'isClosed'  => true,
                    'isPercent' => false,
                    'valus'     => 0
                ];

            }

            # əmək şəraitinə görə əlavə əmək haqqı
            if ($conditionalPayment['totalCount'] > 0)
            {
                $conditionalPayment = $conditionalPayment['data'][0]->value;

            } else {

                $conditionalPayment = 0;
            }

            /* generate edit order fields */


            $fields[] = [
                'employees' => $userSelect,
                'structure' => [
                    'id'   => $childData['data'][$i]->positionId->structureId->id,
                    'text' => $childData['data'][$i]->positionId->structureId->name,
                    'parent' => $childData['data'][$i]->positionId->structureId->parentId != null ? $childData['data'][$i]->positionId->structureId->parentId->name : ''
                ],
                'position_name' => [
                    'id'   => $childData['data'][$i]->positionId->id,
                    'salary' => $childData['data'][$i]->positionIdSalary,
                    'text' => $childData['data'][$i]->positionId->posNameId->name
                ],
                'civilService' => $childData['data'][$i]->civilService,
                'startDate' => date('d.m.Y', strtotime($childData['data'][$i]->startDate)),
                'contract_type' => [
                    'id'   => $childData['data'][$i]->listContractTypeIdId,
                    'text' => $childData['data'][$i]->listContractTypeIdName
                ],
                'duration' => $childData['data'][$i]->appointmentMonth != null ? $childData['data'][$i]->appointmentMonth != null : '',
                'orderAppointmentId' => $childData['data'][$i]->id,
                'position'     => $userPositions,
                'appointmentType'    => $childData['data'][$i]->appointmentType,
                'appointmentMonth'   => $childData['data'][$i]->appointmentMonth,
                'isFree'    => $userPayment->isClosed,
                'isPercent' => $userPayment->isPercent,
                'valueSum'  => $userPayment->valus,
                'fromPositionId' => [
                    'id' => $childData['data'][$i]->fromPositionIdId,
                    'text' => $childData['data'][$i]->posNameIdName
                ],
                #'structureOld' => $childData['data'][$i]->parentIdName.' '.$childData['data'][$i]->structureIdName,
                'structureOld' => $childData['data'][$i]->structureIdName,
                'trialPeriodMonth' => $childData['data'][$i]->trialPeriodMonth,
                'wage' => $childData['data'][$i]->positionId->salary,
                'posAdditionalSalary' => $payment,
                'isPost'  => $childData['data']['0']->positionId->structureId->isPost,
                'positionPayment' => $payment,
                'conditionalPayment' => $conditionalPayment,
                'relatedStr' => $relatedStr

            ];

            /* reset user select */
            $userSelect = [];
            $userPositions = [];
        }

        /* return fields */
        return $fields;
    }

    /**
     * get order assignment form fields
     * @param $orderCommonId
     * @return array
     */
    private function getAssignmentFields($orderCommonId)
    {
        $userInOrderAppointment = [];
        $fields = [];
        $userPositions = [];

        $orderAppointmentList = new OrderAppointmentController();
        $relUserInOrderAppointment = new RelUserInOrderAppointmentController();

        $childData = (array)$orderAppointmentList->getOrderAppointmentList($orderCommonId);

        for ($i = 0; $i < count($childData['data']); $i++) {

            $userInOrderAppointment[] = (array)$relUserInOrderAppointment->getRelUserInOrderAppointment($childData['data'][$i]->id);
            $userPositions[] = $userInOrderAppointment[$i]['data'][0]->id;

            $fields[] = [
                'employees' => [
                    'id'   => $userInOrderAppointment[$i]['data'][0]->userId->id,
                    'text' => $userInOrderAppointment[$i]['data'][0]->userId->lastName . ' '
                        . $userInOrderAppointment[$i]['data'][0]->userId->firstName
                ],
                'isFree'    => $childData['data'][$i]->isFree,
                'isPercent' => $childData['data'][$i]->isPercent,
                'valueSum'  => $childData['data'][$i]->valueSum,
                'structure' => [
                    'id'   => $childData['data'][$i]->positionId->structureId->id,
                    'text' => $childData['data'][$i]->positionId->structureId->name
                ],
                'position_name' => [
                    'id'   => $childData['data'][$i]->positionId->id,
                    'text' => $childData['data'][$i]->positionId->posNameId->name
                ],
                'startDate' => date('d.m.Y', strtotime($childData['data'][$i]->startDate)),
                'endDate'   => date('d.m.Y', strtotime($childData['data'][$i]->endDate)),
                'orderAppointmentId' => $childData['data'][$i]->id,
                'userPositionId'     => $userPositions
            ];

        }

        return $fields;
    }

    /**
     * replacement form fields
     * @param $orderCommonId
     * @return array
     */
    private function  getReplacementFields($orderCommonId)
    {
        $fields = [];

        $orderAppointmentList      = new OrderAppointmentController();
        $relUserInOrderAppointment = new RelUserInOrderAppointmentController();
        $userReplacementController = new UserReplacementController();

        $childData              = (array)$orderAppointmentList->getOrderAppointmentList($orderCommonId);
        $userInOrderAppointment = (array)$relUserInOrderAppointment->getRelUserInOrderAppointment($childData['data'][0]->id);
        $userReplacementList    = (array)$userReplacementController->getRelUserInOrderReplacement($userInOrderAppointment['data'][0]->id);
        $fields[] = [
            'replacedUserId' => [
                'id'   => $userReplacementList['data'][0]->userId->id,
                'text' => $userReplacementList['data'][0]->userId->lastName . ' '
                    . $userReplacementList['data'][0]->userId->firstName
            ],
            'employees' => [
                'id'   => $userInOrderAppointment['data'][0]->userId->id,
                'text' => $userInOrderAppointment['data'][0]->userId->lastName . ' '
                    . $userInOrderAppointment['data'][0]->userId->firstName
            ],
            'isFree'    => $childData['data'][0]->isFree,
            'isPercent' => $childData['data'][0]->isPercent,
            'valueSum'  => $childData['data'][0]->valueSum,
            'structure' => [
                'id'   => $childData['data'][0]->positionId->structureId->id,
                'text' => $childData['data'][0]->positionId->structureId->name
            ],
            'position_name' => [
                'id'   => $childData['data'][0]->positionId->id,
                'text' => $childData['data'][0]->positionId->posNameId->name
            ],
            'startDate' => date('d.m.Y', strtotime($childData['data'][0]->startDate)),
            'endDate'   => date('d.m.Y', strtotime($childData['data'][0]->endDate)),
            'userReplacementId'   => $userReplacementList['data'][0]->id,
            'userPositionId'      => $userInOrderAppointment['data'][0]->id,
            'orderAppointmentId'  => $childData['data'][0]->id
        ];
        return $fields;
    }


    private function  getFinancialAidFields($orderCommonId)
    {
        $fields = [];

        $orderFinancialAidList      = new OrderFinancialAidController();


        $childData              = (array)$orderFinancialAidList->getOrderFinancialAid($orderCommonId);

        $fields[] = [
            'userId'    => [
                'id'        => $childData['data'][0]->relUserPaymentsId->userId->id,
                'firstName'      => $childData['data'][0]->relUserPaymentsId->userId->firstName,
                'lastName'      => $childData['data'][0]->relUserPaymentsId->userId->lastName,
                'patronymic'    => $childData['data'][0]->relUserPaymentsId->userId->patronymic
            ],
            'value'     => $childData['data'][0]->relUserPaymentsId->valus,
            'startDate' => date('d.m.Y', strtotime($childData['data'][0]->relUserPaymentsId->startDate)),
            'endDate'   => date('d.m.Y', strtotime($childData['data'][0]->relUserPaymentsId->endDate)),
            'orderCommonId' => $orderCommonId,
            'relUserPaymentId' => $childData['data'][0]->relUserPaymentsId->id
        ];
//        dd($fields);
        return $fields;
    }

    private function  getNonWorkingDaysFields($orderCommonId)
    {

        $fields = [];

        $orderNonWorkingDaysList      = new OrderNonWorkDaysController();


        $childData              = (array)$orderNonWorkingDaysList->getNonWorkDaysId($orderCommonId);

        $fields[] = [
            'orderRestDayId'  => $childData['data'][0]->id,
            'name'    => $childData['data'][0]->dayOffId->name,
            'note'     => $childData['data'][0]->note,
            'startDate' => date('d.m.Y', strtotime($childData['data'][0]->dayOffId->startDate)),
            'endDate'   => date('d.m.Y', strtotime($childData['data'][0]->dayOffId->endDate)),
            'orderCommonId' => $orderCommonId,
            'dayOffId' => $childData['data'][0]->dayOffId->id
        ];

        return $fields;
    }

    private function  getOrderTransferFields($orderCommonId)
    {

        $fields = [];

        $orderAppointmentList      = new OrderAppointmentController();


        $childData              = (array)$orderAppointmentList->getOrder($orderCommonId);
//        dd($childData);
        if($childData['data'][0]->orderAppointmentIdEndDate !=  null){
            $endDate = date("d.m.Y", strtotime($childData['data'][0]->orderAppointmentIdEndDate));
        }else{
            $endDate = null;
        }
//dd($childData['data'][0]);
        $fields[] = [
            'id'            => $childData['data'][0]->id,
            'orderAppointmentId'    => $childData['data'][0]->orderAppointmentIdId,
            'orderCommonId' => $orderCommonId,
            'startDate'     => date("d.m.Y", strtotime($childData['data'][0]->orderAppointmentIdStartDate)),
            'endDate'       => $endDate,
            'user1'         => $childData['data'][0]->userPosition1->userId->firstName . ' ' . $childData['data'][0]->userPosition1->userId->lastName . ' ' . $childData['data'][0]->userPosition1->userId->patronymic,
            'user1_id'      => $childData['data'][0]->userPosition1->userId->id,
            'user1_str'     => $childData['data'][0]->userPosition1->positionId->structureId->name,
            'user1_pos'     => $childData['data'][0]->userPosition1->positionId->posNameId->name,
            'user1_pos_id'  => $childData['data'][0]->userPosition1->id,
            'user2'         => $childData['data'][0]->userPosition2->userId->firstName . ' ' . $childData['data'][0]->userPosition2->userId->lastName . ' ' . $childData['data'][0]->userPosition2->userId->patronymic,
            'user2_id'      => $childData['data'][0]->userPosition2->userId->id,
            'user2_str'     => $childData['data'][0]->userPosition2->positionId->structureId->name,
            'user2_pos'     => $childData['data'][0]->userPosition2->positionId->posNameId->name,
            'user2_pos_id'  => $childData['data'][0]->userPosition2->id
        ];

        return $fields;
    }

    private function  getDisciplineFields($orderCommonId)
    {

        $fields = [];

        $orderDisciplineList      = new OrderDisciplineController();


        $childData              = (array)$orderDisciplineList->getOrder($orderCommonId);

        $fields[] = [
            'userId'                    => $childData['data'][0]->userId,
            'executorUserId'            => $childData['data'][0]->executorUserId,
            'isExplanation'             => $childData['data'][0]->isExplanation,
            'listDisciplinaryActionId'  => $childData['data'][0]->listDisciplinaryActionId,
            'orderCommonId'             => $orderCommonId,
            'userDisciplinaryActionId'  => $childData['data'][0]->id
        ];

        return $fields;
    }

    private function  getWarningFields($orderCommonId)
    {

        $fields = [];

        $orderWarningList      = new OrderWarningController();

        $childData              = (array)$orderWarningList->getOrder($orderCommonId);

        if($childData['totalCount'] !=0){
            $fields[] = [
                'id'                        => $childData['data'][0]->id,
                'executorUserId'            => $childData['data'][0]->executorUserId,
                'isExplanation'             => $childData['data'][0]->isExplanation,
                'orderCommonId'             => $orderCommonId,

            ];

            foreach ($childData['data'] as $key => $single_data){

                $fields[0]['userId'][$key]['name'] = $single_data->userId->firstName . ' ' . $single_data->userId->lastName . ' ' . $single_data->userId->patronymic;
                $fields[0]['userId'][$key]['id']   = $single_data->userId->id;
                $fields[0]['userId'][$key]['userWarningId'] = $single_data->id;

            }
        }


        return $fields;
    }

    private function  getStaffOpeningFields($orderCommonId)
    {
        $fields = [];

        $orderAddStaffsList = new OrderStaffAddController();

        $childData = (array)$orderAddStaffsList->getOrder($orderCommonId);

        return $childData;
    }

    private function  getAddWorkFields($orderCommonId)
    {

        $fields = [];
        $orderAddWorkTimeList      = new OrderAddWorkTimeController();
        $childData              = (array)$orderAddWorkTimeList->getOrder($orderCommonId);
        if($childData['totalCount'] !=0){
            $fields['order']['id']                       = $childData['data'][0]->id;
            $fields['order']['date']                     = date("d.m.Y", strtotime($childData['data'][0]->orderExcessWorkId->startDate));
            $fields['order']['listExcessWorkTypeId']     = $childData['data'][0]->orderExcessWorkId->listExcessWorkTypeId->id;
            $fields['order']['listExcessWorkTypeName']   = $childData['data'][0]->orderExcessWorkId->listExcessWorkTypeId->name;
            foreach ($childData['data'] as $key => $single_data){
                $startTime = date("H:m", strtotime($single_data->orderExcessWorkId->startDate));
                $endTime = date("H:m", strtotime($single_data->orderExcessWorkId->endDate));
                $fields['order']['workers'][$key]['listExcessWorkId']   = $childData['data'][$key]->orderExcessWorkId->id;
                $fields['order']['workers'][$key]['relId']         = $single_data->id;
                $fields['order']['workers'][$key]['userId']     = $single_data->userId->id;
                $fields['order']['workers'][$key]['userName']   = $single_data->userId->firstName . ' ' . $single_data->userId->lastName . ' ' . $single_data->userId->patronymic ;
                $fields['order']['workers'][$key]['positionId'] = $single_data->positionId->id;
                $fields['order']['workers'][$key]['positionName'] = $single_data->positionId->posNameId->name;
                $fields['order']['workers'][$key]['structureName'] = $single_data->positionId->structureId->name;
                $fields['order']['workers'][$key]['startTime']  = $startTime;
                $fields['order']['workers'][$key]['endTime']    = $endTime;
            }
        }
        return $fields;
    }

    private function getStaffCancellationFields($orderCommonId){

        $fields = [];

        $orderStaffCancellationList      = new OrderStaffCancellationController();
        $positionPaymentsController     = new RelPositionPaymentController();

        $childData              = (array)$orderStaffCancellationList->getOrder($orderCommonId);

        $posSalary    = $positionPaymentsController->getPaymentsByPositionId($childData['data'][0]->positionId->id, 1);

        if($childData['totalCount'] !=0){
            $fields['order']['id']   = $childData['data'][0]->id;
            $fields['order']['strId'] = $childData['data'][0]->positionId->structureId->id;
            $fields['order']['strName']  = $childData['data'][0]->positionId->structureId->name;
            $fields['order']['posId'] = $childData['data'][0]->positionId->id;
            $fields['order']['posName'] = $childData['data'][0]->positionId->posNameId->name;
            $fields['order']['count']   = $childData['data'][0]->positionId->count;
            $fields['order']['salary']   = $posSalary->data[0]->value;

        }else{
            $fields = null;
        }


        return $fields;

    }

    private function getRewardFields($orderCommonId)
    {

        $fields = [];

        $userRewardIndividualController = new UserRewardIndividualController();
        $positionController             = new PositionController();

        $userRewardIndividuals = $userRewardIndividualController->getUserRewardIndividual($orderCommonId);

        if (isset($userRewardIndividuals->totalCount) && $userRewardIndividuals->totalCount > 0 )
        {
            foreach ($userRewardIndividuals->data as $key => $userRewardIndividual)
            {
                $position = $positionController->getPositionDetailsByUserId($userRewardIndividual->userIdId,null,false);

                $structureName = null;
                $positionId    = null;
                $positionName  = null;

                if (isset($position->totalCount) && $position->totalCount > 0)
                {
                    $structureName = $position->data[0]->structureIdName;
                    $positionId    = $position->data[0]->positionIdId;
                    $positionName  = $position->data[0]->posNameIdName;
                }

                $fields[$key]['id']                      = $userRewardIndividual->id;
                $fields[$key]['relUserPaymentsId']['id'] = $userRewardIndividual->relUserPaymentsIdId;

                $fields[$key]['userId']['id']            = $userRewardIndividual->userIdId;
                $fields[$key]['userId']['text']          = $userRewardIndividual->userIdFirstName . ' ' .
                    $userRewardIndividual->userIdLastName  . ' ' .
                    $userRewardIndividual->userIdPatronymic;
                $fields[$key]['includingTaxes']          = $userRewardIndividual->isTaxes;
                $fields[$key]['rewardDate']              = HRDate($userRewardIndividual->issueDate);
                $fields[$key]['rewardAmount']            = $userRewardIndividual->relUserPaymentsIdValus;
                $fields[$key]['structure']               = $structureName;
                $fields[$key]['positionId']              = $positionId;
                $fields[$key]['positionName']            = $positionName;
            }
        }

        return $fields;
    }

    private function getQualificationDegreeFields($orderCommonId){
        $fields = [];

        $orderQualificationDegreeList = new OrderQualificationDegreeController();

        $childData = (array)$orderQualificationDegreeList->getQualificationDegree($orderCommonId);

        if (!$childData['hasError'])
        {
            foreach ($childData['data'] as $data)
            {
                $fields[] = [
                    'id'     => $data->id,
                    'userId' => [
                        'id'    => $data->userId->id,
                        'text'  => $data->userId->lastName .' '. $data->userId->firstName.' '.$data->userId->patronymic
                    ],
                    'startDate'     => date('d.m.Y', strtotime($data->startDate)),
                    'orderCommonId' => $data,
                    'posClassId'    => $data->qualificationId->listPositionClassificationId->id,
                    'posClassName'  => $data->qualificationId->listPositionClassificationId->name,
                    'QualTypeId'    => $data->qualificationId->id,
                    'QualTypeName'  => $data->qualificationId->listQualificationTypeId->name

                ];
            }
        }

        return $fields;
    }

}
