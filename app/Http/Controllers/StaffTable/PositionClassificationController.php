<?php

namespace App\Http\Controllers\StaffTable;

use App\Library\Service\Service;
use App\Http\Controllers\Controller;

class PositionClassificationController extends Controller
{
    /**
     * Instance TableName
     * @instance string
     */
    private $tableName = 'ListPositionClassification';

    /**
     * Get PositionClassificationNames for select2
     * @return \Illuminate\Http\JsonResponse
     */
    public function listPositionClassifications(){

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

    }
}
