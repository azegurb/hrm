<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;

class UserReplacementController extends Controller
{
    /**
     * @var string
     */
    private $tableName = 'UserReplacement';

    /**
     * Get users replacement list from UserReplacement table by providing UserPositionId
     * @param $userPositionId
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function getRelUserInOrderReplacement($userPositionId) {

//        try {
            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id', 'userId'],
                    'filter' => '"userpositionId.id":%7B"=":"'.$userPositionId.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            return $data;


//        } catch (\Exception $e) {
//
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//        }

    }
}
