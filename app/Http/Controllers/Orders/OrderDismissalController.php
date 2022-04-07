<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;

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
}
