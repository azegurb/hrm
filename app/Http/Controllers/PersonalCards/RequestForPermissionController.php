<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\RequestForPermissionRequest;
use App\Library\Service\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class RequestForPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $sc = ['id','allowerUserId.firstName','allowerUserId.lastName','listRequestForPermissionReasonId.name','startDate','endDate','isApprowed','applicationDate','note'];
            if($this->search != ''){
                $search = '"listRequestForPermissionReasonId.name":%7B"contains":"'.$this->search.'"%7D,';
            }else{
                $search = '';
            }
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'     => $sc, ////usersByAllowerUserId
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => $search.'"userId.id" : %7B "=" : "'.selected()->userId.'" %7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRequestForPermission'
                    ]
                ]
            ]);

//            if($data->totalCount > 0){
//                $nc = nc($data,$sc, 'UserRequestForPermissionNC');
//                $data = $nc->data;
//                $new  = $nc->newNC;
//            }
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
//                                "name" => "/crud/UserRequestForPermission/insert",
//                                "type" =>  "POST"
//                            ]
//
//                        ]
//                    ]
//
//                ]
//            ]);
//
//            if(is_array($checkButtons->data->permissions)){
//
//                $data->permission=$checkButtons->data->permissions;
//            }

            $page = $this->page;
            if ($data->totalCount != 0 ){
                foreach ($data->data as $value) {
                    $value->endDate   = !empty($value->endDate) ? date('d.m.Y', gmdate($value->endDate / 1000)) : '';
                    $value->startDate = !empty($value->startDate) ? date('d.m.Y', gmdate($value->startDate / 1000))  : '';

                    if ($value->isApprowed == 1) {
                        $value->isApprowed = 'Baxılmayıb';
                    } elseif ($value->isApprowed == 2) {
                        $value->isApprowed = 'Təsdiqlənib';
                    } elseif ($value->isApprowed == 3) {
                        $value->isApprowed = 'İmtina edilib';
                    }
                }
            }
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;
                return response()->json($data);
            }elseif($this->load == true){
                return view('pages.personal_cards.permission.index' , compact('data','page'));
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
    public function store(RequestForPermissionRequest $request)
    {
        try{
            $bdate = date('U', strtotime($request->startdate));
            $ddate = date('U', strtotime($request->enddate));
            $applicationdate = date('U', strtotime($request->applicationdate));

            $data = Service::request([
                'method'  => 'POST',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRequestForPermission'
                    ],
                    'json' => [
                        'allowerUserId' => [
                            'id'    => $request->alloweruser
                        ],
                        'listRequestForPermissionReasonId' => [
                            'id'    => $request->listrequestforpermissionreason
                        ],
                        'startDate'      => $bdate*1000,
                        'endDate' => $ddate*1000,
                        'isApprowed' => $request->isapprowed,
                        'applicationDate'      => $applicationdate*1000,
                        'note' => $request->note,

                        'userId' => [
                        'id'    => selected()->userId
                        ]
                    ]
                ]
            ]);

            $data->body['data']['startDate'] =  date("d.m.Y", $data->body['data']['startDate']/1000);
            $data->body['data']['endDate'] =  date("d.m.Y", $data->body['data']['endDate']/1000);

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
                    'sc'     => ['id','allowerUserId','listRequestForPermissionReasonId','startDate','endDate','isApprowed','applicationDate','note'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRequestForPermission'
                    ]
                ]
            ]);

            $response = [
                'fields'   =>[
                    'alloweruser' => [
                        'id' => $data->data->allowerUserId->id,
                        'text' => $data->data->allowerUserId->firstName ." ". $data->data->allowerUserId->lastName
                    ],
                    'listrequestforpermissionreason' => [
                        'id'   => $data->data->listRequestForPermissionReasonId->id,
                        'text' => $data->data->listRequestForPermissionReasonId->name
                    ],
                    'startdate'        => !empty($data->data->startDate)? date("d.m.Y",  gmdate($data->data->startDate /1000) ) : '',
                    'enddate'          => !empty($data->data->endDate) ? date( 'd.m.Y' , gmdate($data->data->endDate /1000) ) : '',
                    'applicationdate'  => !empty($data->data->applicationDate) ? date("d.m.Y", strtotime($data->data->applicationDate) ) : '',
                    'note'            => $data->data->note,
                    'isApprowed'       => $data->data->isApprowed

                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url'  => route('permission.update' , $data->data->id )
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
    public function update(RequestForPermissionRequest $request, $id)
    {
        try{
            $bdate = date('U', strtotime($request->startdate));
            $ddate = date('U', strtotime($request->enddate));
            $applicationdate = date('U', strtotime($request->applicationdate));
            $data = Service::request([
                'method'  => 'PUT',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRequestForPermission'
                    ],
                    'json' => [
                        'id'          => $id,
                        'allowerUserId' => [
                            'id'    => $request->alloweruser,
                            'firstName' => RequestForPermissionController::givename_allower_fname($request->alloweruser),
                            'lastName'  => RequestForPermissionController::givename_allower_lname($request->alloweruser)
                        ],
                        'listRequestForPermissionReasonId' => [
                            'id'    => $request->listrequestforpermissionreason,
                            'name'  => RequestForPermissionController::givename_reason($request->listrequestforpermissionreason)
                        ],
                        'startDate'      => $bdate*1000,
                        'endDate' => $ddate*1000,
                        'isApprowed' => $request->isapprowed,
                        'applicationDate' => $applicationdate*1000,
                        'note' => $request->note,

                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ]);
            $data->data->startDate =  date("d.m.Y", $data->data->startDate/1000);
            $data->data->endDate =  date("d.m.Y", $data->data->endDate/1000);
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
                'url'     => Service::url('hr','crud'),
                'params' => [
                    'id' => $id
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRequestForPermission'
                    ]
                ]
            ]);

            return $data->code;
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    /**
     * Permission Reasons List
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function permissionReasons()
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
                        'TableName' => 'ListRequestForPermissionReason'
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
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function givename_reason($id)
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
                        'TableName' => 'ListRequestForPermissionReason',
                    ]
                ]
            ]);
            return($data->data->name);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function givename_allower_fname($id)
    {
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'      => $id,
                    'sc'      => ['id','firstName']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'Users',
                    ]
                ]
            ]);
            return($data->data->firstName);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function givename_allower_lname($id)
    {
        try{
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'id'      => $id,
                'sc'      => ['id','lastName']
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Users'
                ]
            ]
        ]);
        return($data->data->lastName);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }
}
