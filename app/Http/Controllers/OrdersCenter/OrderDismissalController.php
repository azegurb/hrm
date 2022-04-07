<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;
use Illuminate\Support\Facades\Input;

class OrderDismissalController extends Controller
{
    /**
     * table name
     * @var string
     */
    private $tableName = 'OrderDismissal';

    /**
     * get order dismissal by providing order common id
     * @param $orderCommonId
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function getOrderDismissal($orderCommonId)
    {

        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => [
                    'id',
                    'listDismissalTypeId',
                    'dismissalDate',
                    'positionId.id',
                    'positionId.structureId.parentId.name',
                    'positionId.structureId.name',
                    'positionId.structureId.id',
                    'positionId.relatedStructureId.name',
                    'positionId.relatedStructureId.id',
                    'positionId.posNameId.name'
                ],
                'filter' => '"orderCommonId.id":%7B"=":"' . $orderCommonId . '"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => $this->tableName
                ]
            ]
        ]);


        return $data;

    }

    /**
     * Gets user related position
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserRelatedData()
    {
        $uId = Input::get('uId');
        $static = Input::get('static');

        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => [
                    'id',
                    'positionId.id',
                    'positionId.posNameId.id',
                    'positionId.structureId.id',
                    'positionId.posNameId.name',
                    'positionId.structureId.name',
                    'positionId.relatedStructureId.id',
                    'positionId.relatedStructureId.name'
                ],
                'filter' => '"listOrderTypeId.label":%7B"=":"' . $static . '"%7D,"userId.id":%7B"=":"' . $uId . '"%7D,"isclosed":%7B"=":false%7D',
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPosition'
                ]
            ]
        ]);


        return response()->json(['data' => $data->data]);
    }
}
