<?php

namespace App\Http\Controllers\PersonalCards;
use App\Http\Requests\PersonalCards\AttestationRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class AttestationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        try{
            $sc = ['id','listAttestationTypeId','organName','dateOff','listAttestationResultId','notes'];
            if($this->search != ''){
                $search = '"listAttestationTypeId.name":%7B"=":"'.$this->search.'"%7D,';
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
                        'TableName' => 'UserAttestation'
                    ]
                ]
            ]);

//            $nc = nc($data,$sc, 'UserAttestationNC');
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
//                                "name" => "/crud/UserAttestation/insert",
//                                "type" =>  "POST"
//                            ]
//
//                        ]
//                    ]
//
//                ]
//            ]);
//            $data->permission = false;
//            if(is_array($checkButtons->data->permissions)){
//                $data->permission = $checkButtons->data->permissions;
//            }

            if ($data->totalCount != 0 || $data->totalCount !="" ){
                foreach($data->data as $value){
                    $value->dateOff =  date('d.m.Y',strtotime( $value->dateOff));
                }
            }
            $page = $this->page;
//            $checkConfirm =  $this->confirmation();
//            $data->ccon = $checkConfirm;
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;
//                $data->new = $new;
                return response()->json($data);
//                dd($data,$new);
            }elseif($this->load == true){
                return view('pages.personal_cards.attestation.index', compact('data','page'));
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
    public function store(AttestationRequest $request)
    {
        try{
            $dcarbon = date('U', strtotime($request->dateoff));
            $data = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserAttestation'
                    ],
                    'json' => [
                        'listAttestationTypeId' => [
                            'id'    => $request->listattestationtype
                        ],
                        'organName' => $request->organname,
                        'dateOff' => $dcarbon*1000,
                        'listAttestationResultId' => [
                            'id'    => $request->listattestationresult
                        ],
                        'notes' => $request->notes,

                        'userId' => [
                            'id'    => 'F8D79021-DBAA-4024-9872-000ACBAFF2BA'
                        ]
                    ]
                ]
            ]);
            $data->body['data']['dateOff'] = $request->dateoff;
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
                    'sc'     => ['id','listAttestationTypeId','organName','dateOff','listAttestationResultId','notes'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserAttestation'
                    ]
                ]
            ]);
            $response = [
                'fields' => [
                    'listattestationtype' => [
                        'id'   => $data->data->listAttestationTypeId->id,
                        'text' => $data->data->listAttestationTypeId->name
                    ],
                    'organname' => $data->data->organName,
                    'dateoff'   => date('d.m.Y',strtotime( $data->data->dateOff)),
                    'listattestationresult'=> [
                        'id' => $data->data->listAttestationResultId->id,
                        'text' => $data->data->listAttestationResultId->name
                    ],
                    'notes' => $data->data->notes,
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('attestation.update', $data->data->id)
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
    public function update(AttestationRequest $request, $id)
    {
        try{
            $dcarbon = date('U', strtotime($request->dateoff));
            $data = Service::request([
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserAttestation'
                    ],
                    'json' => [
                        'id'          => $id,
                        'listAttestationTypeId' => [
                            'id'    => $request->listattestationtype
                        ],
                        'organName' => $request->organname,
                        'dateOff'   => $dcarbon*1000,
                        'listAttestationResultId' => [
                            'id'    => $request->listattestationresult
                        ],
                        'notes' => $request->notes,
                        'userId' => [
                            'id'    => 'F8D79021-DBAA-4024-9872-000ACBAFF2BA'
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
                'method' => 'DELETE',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'id' => $id
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserAttestation'

                    ]
                ]
            ]);

            return $data->code;
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function attestationResults()

    {
//        $search = !empty(Input::get('q')) ? Input::get('q') : '';
//        if($search != ''){
//            $search = '"name":%7B"contains":"'.$search.'"%7D';
//        }else{
//            $search = '';
//        }
        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id','name']
//                'filter' => $search
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListAttestationResult'
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

    public function attestationTypes()
    {
//        $search = !empty(Input::get('q')) ? Input::get('q') : '';
//        if($search != ''){
//            $search = '"name":%7B"contains":"'.$search.'"%7D';
//        }else{
//            $search = '';
//        }
        //'filter' => $search
        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id','name']
//                'filter' => $search
            ],
            'options' => [
                'headers' =>
                    [
                        'TableName' => 'ListAttestationType'
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

                'headers' => ['TableName' => 'UserAttestationNC'],
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


