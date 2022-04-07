<?php

namespace App\Http\Controllers\OrdersCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library\Service\Service;

class OrderQualificationDegreeController extends Controller
{
    /**
     *
     * Get notes by order dismissal id
     * @param $orderDismissalId
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function getQualificationDegree($orderCommonId)
    {

        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id','qualificationId','startDate','orderCommonId','userId'],
                'filter' => '"orderCommonId.id":%7B"=":"'.$orderCommonId.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserQualificationDegree'
                ]
            ]
        ]);

        if($data->hasError){

            return eH($data);
        }

        return $data;
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function insertOrder($request){

        $listQualificationDegree = $request->listQualificationDegree;

        $orderCommon = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderCommon'
                ],
                'json' => [
                    'orderDate'       => date("Y-m-d", strtotime($request->orderDate)),
                    'orderNum'        => $request->orderNumber,
                    'listOrderTypeId' => [
                        'id'   => $request->listOrderTypeId,
                        'name' => OrderFinancialAidController::givename_orderType($request->listOrderTypeId)
                    ],
                    'basis' => $request->orderBasis
                ]
            ]
        ]);

        if($orderCommon->hasError){

            return eH($orderCommon);
        }

        $orderId = $orderCommon->body['data']['id'];

        foreach ($listQualificationDegree as $key => $id)
        {

            $qualificationDegree = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserQualificationDegree'
                    ],
                    'json' => [
                        'orderCommonId' => [
                            'id' => $orderId
                        ],
                        'qualificationId' => [
                            'id' => $request->listQualDegree[$id]
                        ],
                        'userId' => [
                            'id' => $request->userId[$id]
                        ],
                        'startDate' => javaDate($request->startDate[$id])
                    ]
                ]
            ]);

            if($qualificationDegree->hasError){

                return eH($qualificationDegree);
            }

        }

        return $orderCommon;
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function updateOrder($request){

        $listQualificationDegree = $request->listQualificationDegree;

        $orderCommon = Service::request([
            'method'  => 'PUT',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'OrderCommon'
                ],
                'json' => [
                    'id'                => $request->orderCommonId,
                    'orderDate'         => date("Y-m-d", strtotime($request->orderDate)),
                    'orderNum'          => $request->orderNumber,
                    'listOrderTypeId'   => [
                        'id'    => $request->listOrderTypeId,
                        'name'  => OrderFinancialAidController::givename_orderType($request->listOrderTypeId)
                    ],
                    'basis' => $request->orderBasis
                ]
            ]
        ]);

        if($orderCommon->hasError){

            return eH($orderCommon);
        }

        foreach ($listQualificationDegree as $key => $id)
        {
            $qualificationDegree = Service::request([
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserQualificationDegree'
                    ],
                    'json' => [
                        'id' => $request->id[$id],
                        'orderCommonId' => [
                            'id' => $request->orderCommonId
                        ],
                        'qualificationId' => [
                            'id' => $request->listQualDegree[$id]
                        ],
                        'userId' => [
                            'id' => $request->userId[$id]
                        ],
                        'startDate' => javaDate($request->startDate[$id])
                    ]
                ]
            ]);

            if($qualificationDegree->hasError){

                return eH($qualificationDegree);
            }
        }

        return $orderCommon;
    }
}
