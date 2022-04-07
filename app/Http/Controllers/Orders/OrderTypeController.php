<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;
use Illuminate\Support\Facades\Input;

class OrderTypeController extends Controller
{
    /**
     * private TableName instance variable
     * @var string
     */
    private $tableName = 'ListOrderType';


    /**
     * Get OrderTypeNames from $this->tableName
     * @return \Illuminate\Http\JsonResponse
     */
    public function listOrderTypes(){

        try {

            $term = Input::get('q') ? Input::get('q') : '';

            $filter = !empty(Input::get('type')) ? '"isUserPosition" : %7B"=":true%7D,' : '';
            $search = '"name" : %7B "contains" : "'.$term.'" %7D';

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'name', 'label'],
                    'filter' => $filter.$search
                ],
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
                        'id'   => $item->id,
                        'text' => $item->name,
                        'sLabel' => $item->label
                    ];

                }

            }

        } catch (\Exception $e) {

            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];

            return response()->json($response);
        }

        return response()->json($select);

    }

    /**
     * Get orderTypeName by id
     * @param $id
     * @return mixed
     */
    public static function getOrderTypeNameById($id) {

        try {

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'name'],
                    'filter' => '"id":%7B"=":"'.$id.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListOrderType'
                    ]
                ]
            ]);

            return $data->data[0]->name;

        } catch (\Exception $e) {

            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];

            return response()->json($response);
        }

    }
}