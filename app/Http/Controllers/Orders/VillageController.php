<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;
use App\Library\Ws\Filter;
use App\Regions;

class VillageController extends Controller
{
    /**
     * private table name instance
     * @var string
     */
    private $tableName = 'ListVillage';


    /**
     * Getting city list by id for select2
     * @param string $cityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function listVillages($cityId='') {

        $params = [
            'sc' => ['id', 'name']
        ];

        if (!empty($cityId)) {

            $params = [
                'sc' => ['id', 'name'],
                'filter' => [
                    [
                        'field' => 'parentId.id',
                        'type'  => Filter::TYPE_EQUALS,
                        'value' => $cityId
                    ]
                ]
            ];

        }

        $data = Regions::fetch($params);

        $select = [];

        if ($data->total != -1) {

            foreach ($data->data->entities as $item) {

                $select[] = (object)[
                    'id'   => $item->id,
                    'text' => $item->name
                ];

            }

        } else {
            $select = $data;
        }

        return response()->json($select);

    }
}
