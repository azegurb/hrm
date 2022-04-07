<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;

class UserRewardIndividualController extends Controller
{

    /**
     * @var string
     */
    private $tableName = 'UserRewardIndividual';

    /**
     * get order by order common id
     * @param $orderCommonId
     * @return object
     */
    public function getUserRewardIndividual($orderCommonId)
    {
//        try {

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => [
                        'id', 'issueDate', 'reason', 'rowState', 'isTaxes',
                        'userId.firstName', 'userId.lastName', 'userId.patronymic', 'userId.id',
                        'relUserPaymentsId.valus', 'relUserPaymentsId.id'
                    ],
                    'filter' => '"orderCommonId.id":%7B"=":"'.$orderCommonId.'"%7D'
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
//                'code'    => $e->getCode(),
//                'message' => $e->getMessage()
//            ];
//
//            return response()->json($response);
//        }
    }
}
