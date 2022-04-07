<?php

namespace App\Http\Controllers\StaffTable;

use App\Library\Service\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StructureController extends Controller
{
    /**
     * Instance TableName
     * @instance string
     */
    private $tableName = 'Structures';

    /**
     * Getting structure names for select2
     * @param $request
     * @param $term
     * @return \Illuminate\Http\JsonResponse
     */
    public function listStructures(Request $request, $term = '') {

        try {

            $term = $request->get('q') ? $request->get('q') : $term;

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id','name', 'parentId.name'],
                    'filter' => ['name' => $term]
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
                        'text' => $item->parentIdName.'/'.$item->name
                    ];

                }

            }

            return response()->json($select);

        } catch (\Exception $e){

            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());

        }

    }

    /**
     * List structure types
     * @return \Illuminate\Http\JsonResponse
     */
    public function listStructureType()
    {
        try {

            $term = Input::get('q') ? Input::get('q') : '';

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id','name'],
                    'filter' => ['name' => $term]
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListStructureType'
                    ]
                ]
            ]);
            $select = [];

            if ($data->totalCount > 0) {

                foreach ($data->data as $item) {

                    $select[] = (object)[
                        'id'   => $item->id,
                        'text' => $item->name
                    ];

                }

            }

            return response()->json($select);

        } catch (\Exception $e){

            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());

        }
    }

    /**
     *
     * Change node parent by sending node id and its parent
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeParent(Request $request, $id) {

        if ($request->get('parentId') == '#') {

            $parenId = null;

        } else {

            $parenId = [
                'id' =>  $request->get('parentId')
            ];
        }

        try {
            $data = Service::request([
                'method' => 'PUT',
                'url'    => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ],
                    'json' => [
                        'id'       => $id,
                        'parentId' => $parenId
                    ]
                ]
            ]);

            return response()->json($data);

        } catch (\Exception $e){

            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());

        }

    }
}
