<?php

namespace App\Http\Controllers\Dashboard;

use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // Get DashBoard
    public function index()
    {

        try{
            $request = [
                'method'  => 'GET',
                'url'     => Service::url('hr','users/byBirthday' , false),
                'params'  => [],
                'options' => [
                    'headers' => []
                ]
            ];
            $data = Service::request($request);
            $data->page = $this->page;
            return view('pages.dashboard.index' , compact('data'));
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function show($id)
    {
        $userInfo = app('App\Http\Controllers\Auth\UsersController')->getUserById($id,'http');
        return view('pages.dashboard.show' , compact('userInfo'));
    }
}
