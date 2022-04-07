<?php

namespace App\Http\Controllers\Orders;

use App\Library\Service\Service;
use App\Http\Controllers\Controller;

class RelUserInOrderBusinessTripController extends Controller
{
    /**
     * Instance TableName
     * @var string
     */
    private $tableName = 'RelUserInOrderBusinessTrip';

    /**
     * Getting RelUserInOrderBusinessTripList by orderBusinessTripId.id
     * @param $id
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function getRelUserInOrderBusinessTripList($id)
    {
        $userInBusinessTrip = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id', 'userId.id', 'userId.firstName', 'userId.lastName'],
                'filter' => '"orderBusinessTripId.id":{"=":"'.$id.'"}'
            ],
            'options' => [
                'headers' => [
                    'TableName' => $this->tableName
                ]
            ]
        ]);

        return $userInBusinessTrip;
    }
}
