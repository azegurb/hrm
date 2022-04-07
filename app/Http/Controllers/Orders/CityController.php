<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;
use App\Library\Ws\Filter;
use App\Regions;

class CityController extends Controller
{
    /**
     * private table name instance
     * @var string
     */
    private $tableName = 'ListCity';


    /**
     * Getting city list by id for select2
     * @param string $countryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function listCities($countryId='') {

        $params = [
            'sc' => ['id', 'name']
        ];

        if (!empty($countryId)) {

            $params = [
                'sc' => ['id', 'name'],
                'filter' => [
                    [
                        'field' => 'parentId.id',
                        'type'  => Filter::TYPE_EQUALS,
                        'value' => $countryId
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
