<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;

class RelUserInOrderAppointmentController extends Controller
{
    /**
     * @var string
     */
    private $tableName = 'UserPosition';

    /**
     * Get users in order appointment using order appointment id
     * @param $orderAppointmentId
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function getRelUserInOrderAppointment($orderAppointmentId) {

        try {
            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id', 'userId', 'positionId.id'],
                    'filter' => '"orderAppointmentId.id":%7B"=":"'.$orderAppointmentId.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            return $data;


        } catch (\Exception $e) {

            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }

    }
}
