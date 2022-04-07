<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Library\Service\Service;
use App\Http\Controllers\Controller;

class OrderBusinessTripController extends Controller
{
    /**
     * Instance TableName
     * @var string
     */
    private $tableName = 'OrderBusinessTrip';

    /**
     * Getting OrderBusinessTripList by orderCommonId.id
     * @param $id
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function getOrderBusinessTripList($id)
    {
        $childData = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'startDate', 'endDate',    'tripDay', 'tripReason', 'comment',
                         'listCountryId',   'listCityId', 'listVillageId.name','listVillageId.id',
                         'positionId.posNameId',           'positionId.structureId', 'positionId.id'],
                'filter' => '"orderCommonId.id":{"=":"'.$id.'"}',
                'sort'   => 'dateCreated',
                'order'  => 'desc'
            ],
            'options' => [
                'headers' => [
                    'TableName' => $this->tableName
                ]
            ]
        ]);

        if($childData->hasError){
            return eH($childData);
        }

        return $childData;
    }
}
