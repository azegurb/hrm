<?php

namespace App\Http\Controllers\OrdersCenter;

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


        if($data->hasError){

            return eH($data);
        }
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

        if($dataPosition->hasError){

            return eH($dataPosition);
        }

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

        if($data->hasError){

            return eH($data);
        }


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

    public static function getPosByUserId($id){

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

        if($data->hasError){

            return eH($data);
        }
        if($data->totalCount > 0){

            return response()->json($data->data[0]);

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

        if($data->hasError){

            return eH($data);
        }

        if($data->totalCount > 0){

            return $data->data[0];

        }
    }

}
