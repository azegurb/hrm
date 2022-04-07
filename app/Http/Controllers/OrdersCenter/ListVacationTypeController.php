<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListVacationTypeController extends Controller
{
    /**
     * Instance TableName
     * @var string
     */
    private $tableName = 'ListVacationType';

    /**
     * Get Vacation Types
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListVacationTypes(Request $request) {

        $term = $request->get('q') ? $request->get('q') : '';

        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id', 'name', 'label'],
                'filter' => ['name' => $term]
            ],
            'options' => [
                'headers' => [
                    'TableName' => $this->tableName
                ]
            ]
        ]);

        $select = [];

        foreach ($data->data as $item) {

            $select[] = [
                'id'   => $item->id,
                'text' => $item->name,
                'label'=>$item->label
            ];

        }

        return response()->json($select);

    }
}
