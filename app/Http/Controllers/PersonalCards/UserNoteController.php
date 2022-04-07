<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\UserNoteRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Service\Service;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class UserNoteController extends Controller
{
    private $tableName = 'UserNotes';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try{
            $sc = ['id',' issueDate','note'];
            if($this->search != ''){
                $search = '"note":%7B"contains":"'.$this->search.'"%7D,';
            }else{
                $search = '';
            }
            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => $sc,
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => $search.'"userId.id" : %7B "=" : "'.selected()->userId.'" %7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);


//                $nc = nc($data,$sc, 'UserNotesNC');
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
//
//                    'headers' => ['TableName' => 'ListApplication'],
//                    'json'    => [
//                        "services" => [
//                            0 => [
//                                "name" => "/crud/UserNotes/insert",
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
                return view('pages.personal_cards.note.index' , compact('data','page'));
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
    public function store(UserNoteRequest $request)
    {
        try{
            $request->noteDate = !empty($request->noteDate) ? date('Y-m-d' , strtotime($request->noteDate)) : '';
            $requestData = [
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ],
                    'json' => [
                        'issueDate' => $request->noteDate,
                        'note' => $request->note,
                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ];
            $data = Service::request($requestData);
            $data->body['data']['issueDate'] = date('d.m.Y' , $data->body['data']['issueDate'] / 1000);
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
                    'sc' => ['id','issueDate','note']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);


            $response = [
                'fields' => [
                    'noteDate' => !empty($data->data->issueDate) ? date('d.m.Y' , strtotime($data->data->issueDate)) : '',
                    'note' => $data->data->note,
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('note.update', $data->data->id)
            ];

            return response()->json($response);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function update(UserNoteRequest $request, $id)
    {
        try{
            $request->noteDate = !empty($request->noteDate) ? date('Y-m-d' , strtotime($request->noteDate)) : '';
            $requestData = [
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ],
                    'json' => [
                        'id' => $id,
                        'issueDate' => $request->noteDate,
                        'note' => $request->note,
                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ];
            $data = Service::request($requestData);
            if ($data->code == 200) {
                $data->data->issueDate = date('d.m.Y', $data->data->issueDate / 1000);
                return response()->json($data);
            }
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
                'url' => Service::url('hr', 'crud'),
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


