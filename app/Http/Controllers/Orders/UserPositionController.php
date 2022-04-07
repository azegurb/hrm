<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;

class UserPositionController extends Controller
{
    /**
     * @var string
     */
    private $tableName = 'UserPosition';

    /**
     * Getting Users by position id
     * @param $positionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function listUsers($positionId='')
    {

        $params = [
            'sc' => ['id', 'userId.id','userId.firstName', 'userId.lastName'],
        ];

        if(!empty($positionId)) {
            $params = [
                'sc' => ['id', 'userId.id', 'userId.firstName', 'userId.lastName'],
                'filter' => '"positionId.id":{"=":"'.$positionId.'"}'
            ];
        }

        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => $params,
            'options' => [
                'headers' => [
                    'TableName' => $this->tableName
                ]
            ]

        ]);

//        $dataPosition = Service::request([
//            'method' => 'GET',
//            'url'    => Service::url('hr', 'crud'),
//            'params' => [
//                'sc'     => ['id'],
//                'filter' => '"isclosed": { "=": false },"structureId.id": { "=":"'.$listStruktureid.'" }, "posNameId.id" : {"=" : "'.$listPositionNamesid.'"}'
//            ],
//            'options' => [
//                'headers' => [
//                    'TableName' => 'Position'
//                ]
//            ]
//        ]);



        $select = [];

        if ($data->totalCount > 0) {

            foreach ($data->data as $item) {

                $select[] = (object)[
                    'id' => $item->userIdId,
                    'text' => $item->userIdLastName.' '.$item->userIdFirstName
                ];

            }

        }

        return response()->json($select);

    }

    public function listUsersByStructures($positionId='', $structureId='')
    {

        $dataPosition = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id'],
                'filter' => '"isclosed": { "=": false },"structureId.id": { "=":"'.$structureId.'" }, "posNameId.id" : {"=" : "'.$positionId.'"}'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Position'
                ]
            ]
        ]);

        $params = [
            'sc' => ['id', 'userId.id','userId.firstName', 'userId.lastName'],
        ];

//        dd($dataPosition->data);
        $str='';
        $delimeter='';

       foreach ($dataPosition->data as $data){

           $str=$str.$delimeter.$data->id;
           $delimeter=',';

       }

        if(!empty($positionId)) {
            $params = [
                'sc' => ['id', 'userId.id', 'userId.firstName', 'userId.lastName'],
                'filter' => '"positionId.id":{"in":"'.$str.'"}'
            ];
        }

        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => $params,
            'options' => [
                'headers' => [
                    'TableName' => $this->tableName
                ]
            ]

        ]);

        $select = [];

        if ($data->totalCount > 0) {

            foreach ($data->data as $item) {

                $select[] = (object)[
                    'id' => $item->userIdId,
                    'text' => $item->userIdLastName.' '.$item->userIdFirstName
                ];

            }

        }

        return response()->json($select);

    }

    public static function getPosByUserId($id, $type='json'){

        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id','positionId','isclosed'],
                'filter' =>'"userId.id":%7B"=":"'.$id.'"%7D,"isclosed":%7B"=":"false"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPosition'
                ]
            ]
        ]);

        if(isset($data->data) && is_array($data->data) && isset($data->data[0]->positionId)){


            $dataRelPosPayment = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id','value'],
                    'filter' =>'"paymentTypeId.label":%7B"=":"position_salary"%7D, "positionId.id":%7B"=":"'.$data->data[0]->positionId->id.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'RelPositionPayment'
                    ]
                ]
            ]);


            $data->data[0]->payment=$dataRelPosPayment->data;

        }


        if($data->totalCount > 0 && $type=='json'){

            return response()->json($data->data[0]);

        }
        else if($data->totalCount > 0 && $type!='json'){

            return $data->data[0];
        }
        else {

            return $data->data;

        }
    }

    public static function getPosByUserId2($id){

        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id','positionId','isclosed'],
                'filter' =>'"userId.id":%7B"=":"'.$id.'"%7D,"isclosed":%7B"=":"false"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPosition'
                ]
            ]
        ]);

        if($data->totalCount > 0){

            return $data->data[0];

        }
    }

}
