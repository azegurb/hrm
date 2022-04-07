<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Library\Service\Service;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\queue;

class OrderVacationController extends Controller
{
    /**
     * Instance TableName
     * @var string
     */
    private $tableName = 'OrderVacation';

    /**
     * Getting OrderBusinessTripList by orderCommonId.id
     * @param $id
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function getOrderVacation($id)
    {
        $childData = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [

                'sc' => ['id', 'listVacationTypeId.name','vacationComment','listVacationTypeId.id','userId.id','userId.firstName','userId.lastName','userId.patronymic','positionId.id'],

                'filter' => '"orderCommonId.id":{"=":"'.$id.'"}'
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
        $wsData = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [

                'sc' => ['id','workStartDate','startDate'],

                'filter' => '"orderVacationId.id":{"=":"'. $childData->data[0]->id .'"}'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderVacationDetail'
                ]
            ]
        ]);

        if($wsData->hasError){

            return eH($wsData);
        }
//        $childData->data[0]->workStartDate = $wsData->data[0]->workStartDate;
        return $childData;

    }


    /**
     * @param $id
     * @return array
     */
    public function getStructurePosition($id)
    {

        $childData = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id','structureId.id','structureId.name','posNameId.id','posNameId.name'],
                'filter' => '"id":%7B"=":"'.$id.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => "Position"
                ]
            ]
        ]);
        if($childData->hasError){

            return eH($childData);
        }
        return $childData;
    }

}
