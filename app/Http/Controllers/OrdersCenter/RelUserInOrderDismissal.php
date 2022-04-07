<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;

class RelUserInOrderDismissal extends Controller
{
    /**
     * table name
     * @var string
     */
    private $tableName = 'RelUserInOrderDismissal';

    /**
     * get rel user in order dismissal by providing order dismissal id
     * @param $orderDismissalId
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function getRelUserInOrderDismissal($orderDismissalId) {

//        try {
            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id', 'userId'],
                    'filter' => '"orderDismissalId.id":%7B"=":"'.$orderDismissalId.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            if($data->hasError){

                return eH($data);
            }
            return $data;


//        } catch (\Exception $e) {
//
//            $response = (object)[
//                'code' => $e->getCode(),
//                'message' => $e->getMessage()
//            ];
//
//            return response()->json($response);
//        }

    }
}
