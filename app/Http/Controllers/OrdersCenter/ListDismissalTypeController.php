<?php

namespace App\Http\Controllers\OrdersCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Service\Service;

class ListDismissalTypeController extends Controller
{
    /**
     * private tableName
     * @var string
     */
    private $tableName = 'ListDismissalType';

    /**
     * List dismissal types for select2
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListDismissalTypes(Request $request) {

//        try {

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'name']
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
            $response = [];

            if ($data->totalCount > 0) {

                foreach ($data->data as $item) {

                    $response[] = (object)[
                        'id'   => $item->id,
                        'text' => $item->name
                    ];

                }

            }

            return response()->json($response);


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
