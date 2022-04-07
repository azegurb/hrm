<?php

namespace App;

use App\Library\Service\Service;

class Structure
{
    /**
     * Instance TableName
     * @instance string
     */
    private static $tableName = 'Structures';


    public static function all()
    {
        $term = \Request::has('q') ? \Request::get('q') : '';

        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id','name', 'parentId.name'],
                'filter' => ['name' => $term]
            ],
            'options' => [
                'headers' => [
                    'TableName' => static::$tableName
                ]
            ]
        ]);

        $select = [];

        if ($data->totalCount > 0) {

            foreach ($data->data as $item) {

                $select[] = (object)[
                    'id'   => $item->id,
                    'text' => $item->parentIdName.' '.$item->name
                ];

            }

        }

        return response()->json($select);
    }
}