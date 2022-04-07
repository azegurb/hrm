<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckVacationController extends Controller
{
    //

    public function getVacation($userId){

        $getDataVacation= Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id', 'userId'],
                'filter' => '"userId.id" : { "=" : "' . $userId . '" }'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderVacation'
                ]
            ]
        ]);



    }
}
