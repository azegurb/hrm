<?php

namespace App\Http\Controllers\PersonalCards;

use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalCards\UserTrainingNeedRequest;
use Illuminate\Support\Facades\Input;

class UserTrainingNeedController extends Controller
{
    /**
     * instance variable TableName
     * @instance string
     */
    private $tableName = 'UserTrainingNeed';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $sc = ['id','listTrainingNameId','note', 'isclosed'];
            if($this->search != ''){
                $search = '"note":%7B"contains":"'.$this->search.'"%7D,';
            }else{
                $search = '';
            }
            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => $sc,
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => $search.'"userId.id":%7B"=":"'.selected()->userId.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);


//                $nc = nc($data,$sc, 'UserTrainingNeedNC');
//
//                $data = $nc->data;
//                $new  = $nc->newNC;
//
//
//            $checkButtons = Service::request([
//                'method' => 'POST',
//                'url'    => Service::url('csec','Token/checkTokenMany', false),
//                'params' => [],
//                'options'=> [
//                    'headers' => ['TableName' => 'ListApplication'],
//                    'json'    => [
//                        "services" => [
//                            0 => [
//                                "name" => "/crud/UserAcademicDegree/insert",
//                                "type" =>  "POST"
//                            ]
//                        ]
//                    ]
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

            } elseif ($this->load == true) {

                return view('pages.personal_cards.training_needs.index', compact('data', 'page'));

            } else {

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
     * @param UserTrainingNeedRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserTrainingNeedRequest $request)
    {
        try{
            $data = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName,
                    ],
                    'json' => [
                        'listTrainingNameId' => [
                            'id' => $request->listTrainingNameId
                        ],
                        'note' => $request->note,
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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'id' => $id,
                    'sc' => ['id','listTrainingNameId.name','listTrainingNameId.id','note']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            $response = [
                'fields' => [
                    'listTrainingNameId' =>
                        [
                            'id'   => $data->data->listTrainingNameIdId,
                            'text' => $data->data->listTrainingNameIdName
                        ],
                    'note' => $data->data->note,
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('training-needs.update', $data->data->id)
            ];

            return response()->json($response);

        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserTrainingNeedRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserTrainingNeedRequest $request, $id)
    {
        try{
            $data =Service::request([
                'method'  => 'PUT',
                'url'     => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ],
                    'json' => [
                        'id' => $id,
                        'listTrainingNameId' => [
                            'id' => $request->listTrainingNameId
                        ],
                        'note' => $request->note,
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $data = Service::request([
                'method' => 'DELETE',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'id' => $id
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            return $data->code;
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    /**
     * get training names and pass it to select2
     * @return string
     */
    public function listTrainingNames()
    {
        $search = !empty(Input::get('q')) ? Input::get('q') : '';
        if($search != ''){
            $search = '"name":%7B"contains":"'.$search.'"%7D';
        }else{
            $search = '';
        }
        //'filter' => $search
        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id','name'],
                'filter' => $search
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListTrainingName'
                ]
            ]
        ]);

        $select = [];
        if($data->totalCount > 0){
            foreach ($data->data as $item) {

                $select[] = (object)[
                    'id' => $item->id,
                    'text' => $item->name
                ];
            }
        }


        return response()->json($select);
    }

    public function confirmation(){
        $checkButtons = Service::request([

            'method' => 'POST',
            'url'    => Service::url('csec','Token/checkTokenMany', false),
            'params' => [

            ],
            'options'=> [

                'headers' => ['TableName' => 'UserEducationNC'],
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
