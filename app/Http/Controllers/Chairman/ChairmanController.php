<?php

namespace App\Http\Controllers\Chairman;

use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ChairmanController extends Controller
{
    public $path = 'pages.chairman.';

    /**
     * Chariman page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','chairman/strOriginMainTypes/',false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);
        if(!empty($data) && count($data->data) > 0){
            $collection = collect($data->data);
//            dd($collection);
            $sorted = $collection->sortBy('orderPos');

            $data->data = $sorted->values()->all();
        }


        return view($this->path.'index',compact('data'));
    }

    /**
     * Get Component HTML for API
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function component()
    {
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','chairman/strOriginMainTypes/',false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);
        if(!empty($data) && count($data->data) > 0){
            $collection = collect($data->data);
//            dd($collection);
            $sorted = $collection->sortBy('orderPos');

            $data->data = $sorted->values()->all();
        }
        return view($this->path.'component.index',compact('data'));
    }

    /**
     * Get Stucture Data by Structure ID
     *
     * @param $id
     * @param $structure
     * @return $this
     */
    public function structure($id,$structure)
    {
        if($structure == 'vxsida') {
            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'chairman/strDetailsMain?strId=' . $id, false),
                'params' => [
                ],
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ]
                ]
            ]);
            $returnUser = [];
            if(count($data->data->users) > 0){
                foreach ($data->data->users as $user){
                    $name = !empty($user->firstName) ? $user->firstName : '';
                    $last = !empty($user->lastName) ? ' '.$user->lastName : '';
                    $patronymic = !empty($user->patronymic) ? ' '.$user->patronymic : '';
                    $userInfo = $name.$last.$patronymic;
                    $returnUser[] = (object)[
                        'id' => $user->id,
                        'text' => $userInfo
                    ];
                }
            }

        }
        else{
            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'chairman/strDetailsOthers?strId='.$id, false),
                'params' => [
                ],
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ]
                ]
            ]);

            if(count($data->data->relatedStructures) > 0){
                foreach ($data->data->relatedStructures as $relatedStructures){
                    if(count($relatedStructures->users) > 0)
                        foreach ($relatedStructures->users as $user){
                            $name = !empty($user->firstName) ? $user->firstName : '';
                            $last = !empty($user->lastName) ? ' '.$user->lastName : '';
                            $patronymic = !empty($user->patronymic) ? ' '.$user->patronymic : '';
                            $userInfo = $name.$last.$patronymic;
                            $user->full = $userInfo;
                        }
                }
            }
            $returnUser = $data->data->relatedStructures;

        }
        $returnData = [];
        $returnStr = [];
        if(count($data->data->childs) > 0){
            foreach ($data->data->childs as $child){
                $returnStr[] = (object)[
                    'id' => $child->id,
                    'text' => $child->name,
                    'rsId' => !empty($child->relatedStructureId) ? $child->relatedStructureId : '',
                    'type' => $structure
                ];
            }
        }
        
        $returnData = (object)[
            'childs' => $returnStr,
            'users'  => $returnUser
        ];

        return response()->json($returnData)
            ->header('Access-Control-Allow-Origin','http://localhost:9090',true)
            ->header('Access-Control-Allow-Headers','x-requested-with',true)
            ->header('Access-Control-Allow-Methods','OPTIONS',true)
            ->header('Allow','OPTIONS',true);
    }

    public function substructure($id)
    {
        $strId  = Input::get('strId') ? Input::get('strId') : null;
        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'chairman/strDetailsMain?strId='.$id.'&relatedStrId='.$strId, false),
            'params' => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);
        $returnUser = [];
        if(count($data->data->users) > 0){
            foreach ($data->data->users as $user){
                $name = !empty($user->firstName) ? $user->firstName : '';
                $last = !empty($user->lastName) ? ' '.$user->lastName : '';
                $patronymic = !empty($user->patronymic) ? ' '.$user->patronymic : '';
                $userInfo = $name.$last.$patronymic;
                $returnUser[] = (object)[
                    'id' => $user->id,
                    'text' => $userInfo
                ];
            }
        }

        $returnData = [];
        $returnStr = [];
        if(count($data->data->childs) > 0){
            foreach ($data->data->childs as $child){
                $returnStr[] = (object)[
                    'id' => $child->id,
                    'text' => $child->name,
                    'rsId' => !empty($child->relatedStructureId) ? $child->relatedStructureId : '',
                    'type' => 'vxsida',
                    'label' => $child->strOrTypeLabel
                ];
            }
        }

        $returnData = (object)[
            'childs' => $returnStr,
            'users'  => $returnUser
        ];

        return response()->json($returnData)
            ->header('Access-Control-Allow-Origin','http://localhost:9090',true)
            ->header('Access-Control-Allow-Headers','x-requested-with',true)
            ->header('Access-Control-Allow-Methods','OPTIONS',true)
            ->header('Allow','OPTIONS',true);

    }

    /**
     * Change User Group Type
     * # Not Tested in Prod
     * @param $id
     */
    public function change($id)
    {
        $SSO_TOKEN = isset($_COOKIE['SSO-TOKEN']) ? $_COOKIE['SSO-TOKEN']:null;
        $user = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('auth' , 'changeUserGroupType' , false),
            'options' => [
                'json' => [
                    'sso_token' => $SSO_TOKEN,
                    'userGroupTypeId' => (int)$id,
                    'appName' => 'HR'
                ]
            ]
        ]);
        $label = [];
        $appName = $user->data->login_params->appName;
        foreach ($user->data->user_data->userGroup as $priviligies){
            if($priviligies->application->name == $appName){
                $label[] = $priviligies->label;
            }
        }

        session()->forget('priviligies');
        session()->forget('authUser');

        session(['priviligies' => $label]);
        session(['authUser' => $user->data]);
        session()->save();
    }

    /**
     * Prepare CV for User
     * @param $id
     * @return string
     */
    public function usersCV($id)
    {
        $users = (string)'';

        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'chairman/userData?id='.$id, false),
            'params' => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);
        return response(view($this->path.'component.cv' , compact('data')))
            ->header('Access-Control-Allow-Origin','http://localhost:9090',true)
            ->header('Access-Control-Allow-Headers','x-requested-with',true)
            ->header('Access-Control-Allow-Methods','OPTIONS',true)
            ->header('Allow','OPTIONS',true);

    }

}
