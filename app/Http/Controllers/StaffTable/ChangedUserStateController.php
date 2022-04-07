<?php

namespace App\Http\Controllers\StaffTable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Service\Service;
class ChangedUserStateController extends Controller
{
    //

    public function index()
    {
       $changedStatePerson = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'users/userChanges?max=100&offset=0', false),
            'params' => [],
            'options' => [
                'headers' => ['TableName' => '']
            ]
        ]);

    }

}
