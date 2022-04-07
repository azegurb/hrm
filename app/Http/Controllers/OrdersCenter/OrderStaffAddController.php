<?php

namespace App\Http\Controllers\OrdersCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library\Service\Service;

class OrderStaffAddController extends Controller
{

    /**
     * Generates array for POST request body
     *
     * @param $request
     * @return array
     */
    public static function makeArray($request)
    {
        $requestBody      = array();

        $listStaffOpening = $request->get('listStaffOpening');

        foreach ($listStaffOpening as $i => $id) {

            $requestBody[$i]['structureId']['id']        = $request->get('listStructureId')[$id];

            $requestBody[$i]['posNameId']['id']          = $request->get('positionNameId')[$id];

            $requestBody[$i]['vacationDay']              = $request->get('vacation')[$id];

            $requestBody[$i]['count']                    = $request->get('countStaff')[$id];

            $requestBody[$i]['notStuff']                 = false;

            $requestBody[$i]['isCivilService']           = false;

            $requestBody[$i]['isclosed']                 = false;

            if (isset($request->get('relatedStructureId')[$id]) && !empty($request->get('relatedStructureId')[$id]))
                $requestBody[$i]['relatedStructureId']['id'] = $request->get('relatedStructureId')[$id];

            $requestBody[$i]['relPositionPaymentList'][0]['paymentTypeId']['id'] = 1;

            $requestBody[$i]['relPositionPaymentList'][0]['isPercent']           = false;

            $requestBody[$i]['relPositionPaymentList'][0]['value']               = $request->get('salary')[$id];

        }

        return $requestBody;

    }

    /**
     * Generates array for PUT request body
     *
     * @param $request
     * @return array
     */
    public static function makeUpdateArray($request)
    {

        $requestBody      = array();

        $listStaffOpening = $request->get('listStaffOpening');

        foreach ($listStaffOpening as $i => $id) {

            if (isset($request->get('positionId')[$id]) && !empty($request->get('positionId')[$id]))
                $requestBody[$i]['id'] = $request->get('positionId')[$id];

            $requestBody[$i]['structureId']['id']        = $request->get('listStructureId')[$id];

            $requestBody[$i]['posNameId']['id']          = $request->get('positionNameId')[$id];

            $requestBody[$i]['vacationDay']              = $request->get('vacation')[$id];

            $requestBody[$i]['count']                    = $request->get('countStaff')[$id];

            $requestBody[$i]['notStuff']                 = false;

            $requestBody[$i]['isCivilService']           = false;

            $requestBody[$i]['isclosed']                 = false;

            if (isset($request->get('relatedStructureId')[$id]) && !empty($request->get('relatedStructureId')[$id]))
                $requestBody[$i]['relatedStructureId']['id'] = $request->get('relatedStructureId')[$id];

            $requestBody[$i]['relPositionPaymentList'][0]['paymentTypeId']['id'] = 1;

            $requestBody[$i]['relPositionPaymentList'][0]['isPercent']           = false;

            $requestBody[$i]['relPositionPaymentList'][0]['value']               = $request->get('salary')[$id];

        }

        return $requestBody;

    }

    /**
     * Inserts order to db
     *
     * @param $request
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function insertOrder($request)
    {
        $arr     = self::makeArray($request);

        $options = [
            'method' => 'POST',
            'url'    => Service::url('hr', 'positions/positionAdd', false),
            'options' => [
                'headers' => [
                    'TableName' => ''
                ],
                'json' => [
                    'orderDate' => date('U', strtotime($request->get('orderDate'))) * 1000,
                    'orderNum'  => $request->orderNumber,
                    'basis'     => $request->orderBasis,
                    'listOrderTypeId' => [
                        'id'   => $request->listOrderTypeId,
                        'name' => OrderFinancialAidController::givename_orderType($request->listOrderTypeId)
                    ],
                    'positionList' => $arr
                ]
            ]
        ];

        $data    = Service::request($options);

        return $data;

    }

    /**
     * Gets order for edit view
     *
     * @param $orderCommonId
     * @return array|\Illuminate\Http\JsonResponse
     */
    public static function getOrder($orderCommonId)
    {
        $fields = [];

        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => [
                    'id',
                    'relatedStructureId.id',
                    'relatedStructureId.name',
                    'posNameId.id',
                    'posNameId.name',
                    'vacationDay',
                    'structureId.id',
                    'structureId.name',
                    'structureId.parentId.name',
                    'count'
                ],
                'filter' => '"orderCommonId.id":%7B"=":"' . $orderCommonId . '"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Position'
                ]
            ]
        ]);

        if ($data->hasError) {

            return eH($data);
        }

        $posId = $data->data[0]->id;

        foreach ($data->data as $K => $V) {

            $data2 = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'value'],
                    'filter' => '"positionId.id":%7B"=":"' . $data->data[$K]->id . '"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'RelPositionPayment'
                    ]
                ]
            ]);

            if ($data2->hasError) {

                return eH($data2);
            }

            $data->data[$K]->value = $data2->data[0];
        }

        foreach ($data->data as $dat) {

            $fields[] = $dat;
        }

        return $fields;

    }

    /**
     * Updates order in db
     *
     * @param $request
     * @param $orderId
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function updateOrder($request, $orderId)
    {
        $arr     = self::makeUpdateArray($request);

        $options = [
            'method' => 'PUT',
            'url'    => Service::url('hr', 'positions/position/' . $orderId, false),
            'options' => [
                'headers' => [
                    'TableName' => ''
                ],
                'json' => [
                    'orderDate' => javaDate($request->orderDate),
                    'orderNum'  => $request->orderNumber,
                    'basis'     => $request->orderBasis,
                    'listOrderTypeId' => [
                        'id'   => $request->listOrderTypeId,
                        'name' => OrderFinancialAidController::givename_orderType($request->listOrderTypeId)
                    ],
                    'positionList' => $arr
                ]
            ]
        ];

        $data    = Service::request($options);

        $data->data->orderDate = HRDate($data->data->orderDate);

        $orderTypeId = OrderTypeController::getOrderTypeNameById($request->listOrderTypeId);

        $data->data->listOrderTypeId->name = $orderTypeId;

        return $data;
    }

}
