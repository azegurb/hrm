<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\UserQualificationDegreeRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserQualificationDegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $sc = ['id','startDate','qualificationId.listPositionClassificationId','qualificationId.id','qualificationId.listQualificationTypeId'];
            if($this->search != ''){
                $search = '"listQualificationTypeId":%7B"=":"'.$this->search.'"%7D,';
            }else{
                $search = '';
            }


            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'     => $sc,
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => $search.'"userId.id" : %7B "=" : "'.selected()->userId.'" %7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserQualificationDegree'
                    ]
                ]
            ]);

//            $nc = nc($data,$sc, 'UserQualificationDegreeNC');
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
//                                "name" => "/crud/UserQualificationDegree/insert",
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

            if($data->totalCount > 0){
                foreach($data->data as $key =>$value){
                    $value->startDate =  date('d.m.Y',strtotime( $value->startDate));
//                    $value->docDate =  date('d.m.Y',strtotime( $value->docDate));
                }
            }
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;
//                $data->new = $new;
                return response()->json($data);
            }elseif($this->load == true){
                return view('pages.personal_cards.qualification-degree.index', compact('data','page'));
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
    public function store(UserQualificationDegreeRequest $request)
    {
        try{
            $data = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserQualificationDegree'
                    ],
                    'json' => [
                        'startDate'             => date('U', strtotime($request->startdate))*1000,
                        'qualificationId'       => [
                            'id'    => $request->listqualificationtype
                        ],
                        'docDate'               => date('U', strtotime($request->docdate))*1000,
                        'docInfo'               => $request->docinfo,
                        'userId'                => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ]);


            $data->body['data']['docDate'] = !empty($data->body['data']['docDate']) ? date("d.m.Y", $data->body['data']['docDate'] / 1000) : '';
            $data->body['data']['startDate'] = !empty($data->body['data']['startDate']) ? date("d.m.Y", $data->body['data']['startDate'] / 1000) : '';

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
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'id' => $id,
                    'sc' => ['id','startDate','qualificationId.listPositionClassificationId','qualificationId.listQualificationTypeId','qualificationId.id','docDate','docInfo'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserQualificationDegree'
                    ]
                ]
            ]);

            $response = [
                'fields' => [
                    'startdate'   => date('d.m.Y',strtotime( $data->data->startDate)),
                    'listpositionclassification' => [
                        'id' => $data->data->qualificationIdListPositionClassificationId->id,
                        'text' => $data->data->qualificationIdListPositionClassificationId->name
                    ],
                    'listqualificationtype' => [
                        'id'    => $data->data->qualificationIdId,
                        'ty_id' => $data->data->qualificationIdListQualificationTypeId->id,
                        'text'  => $data->data->qualificationIdListQualificationTypeId->name
                    ],
                    'docinfo'   => $data->data->docInfo,
                    'docdate'   => date('d.m.Y',strtotime( $data->data->docDate)),

                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('qualification-degree.update', $data->data->id)
            ];

            return response()->json($response);
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
    public function update(Request $request, $id)
    {
        try{
            $startdate = date('U', strtotime($request->startdate));
            $docdate = date('U', strtotime($request->docdate));

            $data = Service::request([
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserQualificationDegree'
                    ],
                    'json' => [
                        'id'          => $id,
                        'startDate' => $startdate*1000,
                        'qualificationId' => [
                            'id'    => $request->listqualificationtype,
                        ],
                        'docInfo'   => $request->docinfo,
                        'docDate' => $docdate*1000,
                        'userId' => [
                            'id' => selected()->userId
                        ]
                    ]
                ]
            ]);

            $data->data->startDate =  date("d.m.Y" , $data->data->startDate/1000);
            $data->data->docDate =  date("d.m.Y" , $data->data->docDate/1000);

            $data->data->qualificationId->listPositionClassificationId = UserQualificationDegreeController::name_pos_class($data->data->qualificationId->id);
            $data->data->qualificationId->listQualificationTypeId      = UserQualificationDegreeController::name_qual_type($data->data->qualificationId->id);

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

            $data = Service::request([
                'method' => 'DELETE',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'id' => $id
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserQualificationDegree'
                    ]
                ]
            ]);
            return $data->code;

    }

    public function positionClassifications()
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
                'params' => [
                    'sc' => ['id','name'],
                    'filter' => $search
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListPositionClassification'
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
        }catch (\Exception $e){
            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return response()->json($response);
        }
    }

    public function qualificationTypes($id)
    {

        try{
            if($id != null){
                $search = '"listPositionClassificationId.id":%7B"=":"'.$id.'"%7D';
            }else{
                $search = '';
            }
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params' => [
                    'sc'     => ['id','listQualificationTypeId.name'],
                    'filter' => $search
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'Qualification'
                    ],
                ]

            ]);

            $select = [];
            if ($data->totalCount > 0 ){

                foreach ($data->data as $item) {

                    $select[] = (object)[
                        'id' => $item->id,
                        'text' => $item->listQualificationTypeIdName
                    ];

                }
            }
            return response()->json($select);
        }catch (\Exception $e){
            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return response()->json($response);
        }
    }

    public function name_pos_class($id)
    {
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'      => $id,
                    'sc'      => ['id','listPositionClassificationId.name','listPositionClassificationId.id']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'Qualification',
                    ]
                ]
            ]);
            return($data->data->listPositionClassificationIdName);
        }catch (\Exception $e){
            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return response()->json($response);
        }
    }

    public function name_qual_type($id)
    {
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'      => $id,
                    'sc'      => ['id','listQualificationTypeId.name','listQualificationTypeId.id']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'Qualification',
                    ]
                ]
            ]);

            return($data->data->listQualificationTypeIdName);
        }catch (\Exception $e){
            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return response()->json($response);
        }
    }


    public function confirmation(){
        $checkButtons = Service::request([

            'method' => 'POST',
            'url'    => Service::url('csec','Token/checkTokenMany', false),
            'params' => [

            ],
            'options'=> [

                'headers' => ['TableName' => 'UserQualificationDegreeNC'],
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
