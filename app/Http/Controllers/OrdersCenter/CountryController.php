<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Http\Controllers\Controller;
use App\Library\Service\Service;
use App\Library\Ws\Filter;
use App\Regions;

class CountryController extends Controller
{
    /**
     * Getting country list for select2
     * @return \Illuminate\Http\JsonResponse
     */
    public function listCountries() {

        $options = [
            'sc' => ['id', 'name'],
            'filter' => [
                [
                    'field' => 'listRegionTypeId.id',
                    'type'  => Filter::TYPE_EQUALS,
                    'value' => 1
                ]
            ]
        ];

        // get countries from ListRegionsTable
        $data = Regions::fetch($options);

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
