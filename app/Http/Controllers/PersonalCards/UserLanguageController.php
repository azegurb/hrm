<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\UserLanguageRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class UserLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $sc = ['id','listLanguageId','listKnowledgeLevelId'];
            if($this->search != ''){
               $search = '"listLanguageId.name":%7B"contains":"'.$this->search.'"%7D,';
            }else{
               $search = '';
            }
            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr','crud'),
                'params'  => [
                    'sc'     => $sc,
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => $search.'"userId.id" : %7B "=" : "'.selected()->userId.'" %7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserLanguage'
                    ]
                ]
            ]);

//            $nc = nc($data,$sc, 'UserLanguageNC');
//            $data = $nc->data;
//            $new  = $nc->newNC;
//
//            $checkButtons = Service::request([
//
//                'method' => 'POST',
//                'url'    => Service::url('csec','Token/checkTokenMany', false),
//                'params' => [
//
//                ],
//                'options'=> [
//
//                    'headers' => ['TableName' => 'ListApplication'],
//                    'json'    => [
//                        "services" => [
//                            0 => [
//                                "name" => "/crud/UserLanguage/insert",
//                                "type" =>  "POST"
//                            ]
//
//                        ]
//                    ]
//
//                ]
//            ]);
//
//            $data->permission = false;
//            if(is_array($checkButtons->data->permissions)){
//                $data->permission = $checkButtons->data->permissions;
//            }
            $page = $this->page;
//            $checkConfirm =  $this->confirmation();
//            $data->ccon = $checkConfirm;
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;
//                $data->new = $new;
                return response()->json($data);
            }elseif($this->load == true){
                return view('pages.personal_cards.language.index' , compact('data','page'));
            }else{
                return redirect(url('/personal-cards'));
            }
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(UserLanguageRequest $request)
    {
        try {
            $data = Service::request([
                'method' => 'POST',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserLanguage',
                    ],
                    'json' => [
                        'listLanguageId' => [
                            'id' => $request->language
                        ],
                        'listKnowledgeLevelId' => [
                            'id' => $request->languageLevel
                        ],
                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ]);
            return response()->json($data);

        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'  => $id,
                    'sc'     => ['id','listLanguageId','listKnowledgeLevelId'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserLanguage',
                    ]
                ]
            ]);

            $response = [
                'fields'   =>[
                    'language' => [
                        'id' => $data->data->listLanguageId->id,
                        'text' => $data->data->listLanguageId->name
                    ],
                    'languageLevel' => [
                        'id' => $data->data->listKnowledgeLevelId->id,
                        'text' => $data->data->listKnowledgeLevelId->name
                    ],
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url'  => route('language.update', $data->data->id)
            ];

            return response() ->json($response);

        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserLanguageRequest $request, $id)
    {
        try{
            $data = Service::request([
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserLanguage'
                    ],
                    'json' => [
                        'id' => $id,
                        'listLanguageId' => [
                            'id'    => $request->language,
                            'name'  => UserLanguageController::givename_lang($request->language)
                        ],
                        'listKnowledgeLevelId' => [
                            'id'    => $request->languageLevel,
                            'name'  => UserLanguageController::givename_knlevel($request->languageLevel)
                        ],

                        'userId' => [
                            'id' => selected()->userId
                        ]
                    ]
                ]
            ]);

            return response()->json($data);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $data = Service::request([
                'method'  => 'DELETE',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'  => $id
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserLanguage'
                    ]
                ]
            ]);
            return $data->code;
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function languageList()
    {
        try{
            $search = !empty(Input::get('q')) ? Input::get('q') : '';
            if($search != ''){
                $search = '"name":%7B"contains":"'.$search.'"%7D';
            }else{
                $search = '';
            }
            //'filter' => $search
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'     => ['id,name'],
                    'filter' => $search
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListLanguage'
                    ]
                ]
            ]);
            $select = [];
            if($data->totalCount > 0){
                foreach ($data->data as $item){
                    $select[] = (object)[
                        'text' => $item->name,
                        'id'  => $item->id,
                    ];
                }
            }
            return response() ->json($select);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function knowledgeLevelList()
    {
        try{
            $search = !empty(Input::get('q')) ? Input::get('q') : '';
            if($search != ''){
                $search = '"name":%7B"contains":"'.$search.'"%7D';
            }else{
                $search = '';
            }
            //'filter' => $search
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'    => ['id','name'],
                    'filter' => $search
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListKnowledgeLevel'
                    ]
                ]
            ]);
            $select = [];
            if($data->totalCount > 0){
                foreach ($data->data as $item){
                    $select[] = (object)[
                        'text' => $item->name,
                        'id'  => $item->id,
                    ];
                }
            }

            return response() ->json($select);
        }catch (\Exception $e){
            exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function givename_lang($id)
    {
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'      => $id,
                    'sc'      => ['id','name']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListLanguage',
                    ]
                ]
            ]);

            return($data->data->name);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function givename_knlevel($id)
    {
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'      => $id,
                    'sc'      => ['id','name']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListKnowledgeLevel',
                    ]
                ]
            ]);
           return($data->data->name);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function confirmation(){
        $checkButtons = Service::request([

            'method' => 'POST',
            'url'    => Service::url('csec','Token/checkTokenMany', false),
            'params' => [

            ],
            'options'=> [

                'headers' => ['TableName' => 'UserLanguageNC'],
                'json'    => [
                    "services" => [
                        0 => [
                            "name" => "/crud/confirmation",
                            "type" =>  "POST"
                        ]

                    ]
                ]

            ]
        ]);
        $hasAccess = false;
        if(is_array($checkButtons->data->permissions)){
            $hasAccess = $checkButtons->data->permissions[0]->accesible;
        }
        return $hasAccess;
    }

    public function confirmationPOST($id,$isc)
    {
        $url =  Service::url('hr','crud');
        $userGroup = Service::request([
            'method'  => 'GET',
            'url'     => $url,
            'params'  => [
                'sc'     => ['userGroupId'],
                'filter'  => '"isConfirmed":%7B"=":false%7D,"isCustomConfirm":%7B"=":true%7D',
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'TableUserConfirmation'
                ]
            ]
        ]);
        $userGroupId = '';
        if(!empty($userGroup) && !empty($userGroup->data) && count($userGroup->data) > 0){
            $userGroupId = $userGroup->data[0]->userGroupId;
        }

        $url =  Service::url('hr','orderCommons/confirmation/orderAppointmentProfileNC', false);
//            Service::url('hr','userProvisions/'.selected()->userId , false),
        $requestConfirmation = Service::request([
            'method'  => 'POST',
            'url'     => $url,
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPositionNC'
                ],
                'json' => [
                    "id" => (int)$id,
                    "isConfirmed" => $isc == 'true' ? true : false,
                    "roleId" => $userGroupId
                ]
            ]
        ]);
//        dd($requestConfirmation);
        return $requestConfirmation->code;
    }

}
