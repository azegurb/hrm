<?php

namespace App;

use App\Library\Service;

class User
{
    public static function tokenObject($env)
    {
        if($env == 'dev') {
            return [


//                'token'             => '9f4ffeea84c243dbbe789f0ed7bec6e3',


//                'token'             => '662dd0e8069a4e64856b557a4d44a639',
//                'token'             => '39b289fac3cd49219b1f034c4c76c76e',
//                'token'             => 's.ismayilov',
//                'token'             => 'h.alekberov',
                'token'             => 'b9626bbfb900498c9158db074f17ac6a',
                'RequestNumber'     => uniqid(),
                'AppName'           => 'HR',
                'IpAddress'         => '192.168.1.238',
                'Accept-Language'   => 'az',
                'UserGroupTypeId'   => 1,
                'Content-Type'      => 'application/json',
                'Origin'            =>  'http://'.env('HTTP_ORIGIN')
            ];
        }elseif ($env == 'testserv'){

        }elseif ($env == 'prod'){
            if (array_key_exists('HTTP_X_FORWARDED_FOR', request()->server())) {

                $HTTP_X_FORWARDED_FOR = request()->server('HTTP_X_FORWARDED_FOR');
                $HTTP_X_FORWARDED_FOR = array_values(array_filter(explode(',',$HTTP_X_FORWARDED_FOR)));

                $clientIp = array_last($HTTP_X_FORWARDED_FOR);
            }else{
                $clientIp = request()->getClientIp();
            }
            return [
//                'token'             => session('authUser')['token'],
                'token'             => !empty(authUser()->api_token) ? authUser()->api_token : '',
//                'appId'             => session('authUser')['app'][0]->id,
                'RequestNumber'     => uniqid(),
                'AppName'           => 'HR',
                'IpAddress'         => $clientIp,
                'Accept-Language'   => 'az',
//                'usergroupTypeId'   => session('authUser')['user']->userGroupType[0]->id,
                'UserGroupTypeId'   => !empty(authUser()->user_data->userGroupType[0]->id) ? authUser()->user_data->userGroupType[0]->id : '',
                'Content-Type'      => 'application/json',
                'Origin'            => 'http://'.env('HTTP_ORIGIN')
            ];

        }
    }

    public static function search($param)
    {
//        $data = Service::createRequest([
//            'entity'        => [
//                'search'    => $param,
//                'isdeleted' => ['=' => false]
//            ]
//        ]);
//
//        $result  = Service::send([
//            'data'   => $data,
//            'url'    => ['hr','users.search'],
//            'method' => 'POST'
//        ]);
//
//        $code    = $result->res->code;
//        $data    = [];
//        $message = null;
//
//        if($code == 200) {
//
//            foreach ($result->data as $row)
//            {
//                $user = $row->name . ' ' . $row->surname . ' ' . $row->middleName;
//
//                array_push($data, ['id' => $row->id, 'text' => $user]);
//            }
//
//        } else {
//            $message = $result->res->msg;
//        }
//
//
//        $response = [
//            'code'  => $code,
//            'msg'   => $message,
//            'data'  => $data
//        ];
//
//        return $response;
    }
}
