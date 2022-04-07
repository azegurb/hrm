<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\UserProvisionRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserProvisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd($this->checker());
        try{
//            dd(selected()->userId);
            $url =  Service::url('hr','userProvisions/userProvisionNCByUserId?userId='.selected()->userId , false);
//            Service::url('hr','userProvisions/'.selected()->userId , false),
            $dataNC = Service::request([
                'method'  => 'GET',
                'url'     => $url,
                'params'  => [
                ],
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ]
                ]
            ]);
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','userProvisions/'.selected()->userId , false),
                'params'  => [
                ],
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ]
                ]
            ]);
//            dd($data);
            $data->totalCount = count($data->data);
            $page = $this->page;
//            dd($data);
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;
                return response()->json($data);
            }elseif($this->load == true){
                $nc = $this->confirmation();
                return view('pages.personal_cards.provision.index' , compact('data','page','dataNC','nc'));
            }else{
                return redirect(url('/personal-cards'));
            }
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function confirmationPOST($id,$isc,$ccID)
    {
//        dd($id,$isc,$ccID);/
        $url =  Service::url('hr','crud');
        $userGroup = Service::request([
            'method'  => 'GET',
            'url'     => $url,
                'params'  => [
                    'sc'     => ['userGroupId'],
                    'filter'  => '"confirmId":%7B"=":'.$ccID.'%7D,"isConfirmed":%7B"=":false%7D,"isCustomConfirm":%7B"=":true%7D',
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
//        dd($userGroupId);
        $url =  Service::url('hr','userProvisions/confirmation/userProvisionProfileNC', false);
//            Service::url('hr','userProvisions/'.selected()->userId , false),
        $requestConfirmation = Service::request([
            'method'  => 'POST',
            'url'     => $url,
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserProvisionNC'
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
     * @param UserProvisionRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserProvisionRequest $request)
    {
        try{
            $hA = $this->checker();

            $status = $request->status;
            $replaced = $request->replaced;
            if ($status == 'true' && $replaced == 'true') {
                $mainStatus = 2;
            } elseif ($status == 'true' && $replaced == 'false') {
                $mainStatus = 1;
            }

            $replacedProvisionId = $mainStatus == 2 ? (int)$request->replacedProvisionId : '';
            if ($replacedProvisionId != '') {
                $ar = (array)[['replacedProvisionId' => ['id' => $replacedProvisionId]]];
            }else{
                $ar = [];
            }
            if($hA){
                $url = Service::url('hr', 'userProvisions/provision', false);
            }else{
                $url = Service::url('hr', 'userProvisions/provisionNC', false);
            }
            $requestData = [
                'method' => 'POST',
                'url' => $url,
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ],
                    'json' => [
                        'status' => $mainStatus,
                        'provisionId' => [
                            'id' => $request->provision
                        ],
                        "replacedProvisionList" => $ar,
                        'userId' => [
                            'id' => selected()->userId
                        ],
                    ]
                ]
            ];

            $response = Service::request($requestData);
            return response()->json($response);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserProvisionRequest $request, $id)
    {
        try{
            if($request->type == 'edit') {
                $status = $request->status;
                $replaced = $request->replaced;
                if ($status == 'true' && $replaced == 'true') {
                    $mainStatus = 2;
                } elseif ($status == 'true' && $replaced == 'false') {
                    $mainStatus = 1;
                } else {
                    $mainStatus = 0;
                }

                $replacedProvisionId = $mainStatus == 2 ? (int)$request->replacedProvisionId : '';

                if ($replacedProvisionId != '') {
                    $idofPro = '';
                    if(!empty($request->reId)){
                        $idofPro = $request->reId;
                    }

                    $ar = (array)[[
                        'id'  => (int)$idofPro,
                        'replacedProvisionId' => [
                                'id' => $replacedProvisionId
                        ],
                        'userProvisionId' => [
                                'id' => (int)$id
                        ]
                    ]];
                }else{
                    $ar = [];
                }

                $requestData = [
                    'method' => 'PUT',
                    'url' => Service::url('hr', 'userProvisions/' . (int)$id, false),
                    'options' => [
                        'headers' => [
                            'TableName' => ''
                        ],
                        'json' => [
                            'status' => $mainStatus,
                            "replacedProvisionList" => $ar,
                        ]
                    ]
                ];

                $response = Service::request($requestData);
                return response()->json($response);
            }elseif ($request->type == 'add'){
                return $this->store($request);
            }
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
        //
    }

    public function listProvision()
    {
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
                    'TableName' => 'ListProvision'
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


        return response()->json($select);

    }

    public function checker(){
        $checkButtons = Service::request([

            'method' => 'POST',
            'url'    => Service::url('csec','Token/checkTokenMany', false),
            'params' => [

            ],
            'options'=> [

                'headers' => ['TableName' => ''],
                'json'    => [
                    "services" => [
                        0 => [
                            "name" => "/userProvisions/provision",
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

    public function confirmation(){
        $checkButtons = Service::request([

            'method' => 'POST',
            'url'    => Service::url('csec','Token/checkTokenMany', false),
            'params' => [

            ],
            'options'=> [

                'headers' => ['TableName' => ''],
                'json'    => [
                    "services" => [
                        0 => [
                            "name" => "/userProvisions/confirmation/userProvisionProfileNC",
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
}
