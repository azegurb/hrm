<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\UserRewardGovRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserRewardGovController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $sc = ['id','listRewardGovNameId.name','issueDate','cardNumber','orderNum'];
            if($this->search != ''){
                $search = '"listRewardGovNameId.name":%7B"contains":"'.$this->search.'"%7D,';
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
                        'TableName' => 'UserRewardGov'
                    ]
                ]
            ]);

//            if($data->totalCount > 0){
//                $nc = nc($data,$sc, 'UserRewardGovNC');
//
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
//                                "name" => "/crud/UserAcademicDegree/insert",
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

            //
            if ($data->code == 200 && $data->totalCount > 0){
                foreach ($data->data as $value){
                    $value->issueDate = date('d.m.Y' , strtotime($value->issueDate));
                }
            }
            $page = $this->page;
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;

                return response()->json($data);
            }elseif($this->load == true){
                return view('pages.personal_cards.reward-gov.index' , compact('data','page'));
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
    public function store(UserRewardGovRequest $request)
    {
        try{
            $request->issueDate = !empty($request->issueDate) ? date('Y-m-d' , strtotime($request->issueDate)) : '';
            $requestData = [
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRewardGov'
                    ],
                    'json' => [
                        'cardNumber' => $request->cardNumber,
                        'orderNum' => $request->orderNum,
                        'issueDate' => $request->issueDate,
                        'listRewardGovNameId' => [
                            'id'    => $request->listRewardGovNameId
                        ],
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
                    'sc'     => ['id','listRewardGovNameId','issueDate','cardNumber','orderNum'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRewardGov'
                    ]
                ]
            ]);
            $response = [
                'fields' => [
                    'listRewardGovNameId' => [
                        'id' => $data->data->listRewardGovNameId->id,
                        'text' => $data->data->listRewardGovNameId->name
                    ],
                    'cardNumber' => $data->data->cardNumber,
                    'orderNum' => $data->data->orderNum,
                    'issueDate' => !empty($data->data->issueDate) ? date('d.m.Y' , strtotime($data->data->issueDate)) : '',
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('reward-gov.update', $data->data->id)
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
    public function update(UserRewardGovRequest $request, $id)
    {
        try{
            $request->issueDate = !empty($request->issueDate) ? date('Y-m-d' , strtotime($request->issueDate)) : '';
            $requestData = [
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRewardGov'
                    ],
                    'json' => [
                        'id'          => $id,
                        'cardNumber' => $request->cardNumber,
                        'orderNum' => $request->orderNum,
                        'issueDate' => $request->issueDate,
                        'listRewardGovNameId' => [
                            'id'    => $request->listRewardGovNameId
                        ],
                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ];
            $data = Service::request($requestData);
            $data->data->issueDate = date('d.m.Y' , gmdate($data->data->issueDate / 1000));
            $data->data->listRewardGovNameId->name = $request->listRewardGovNameIdName;

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
                        'TableName' => 'UserRewardGov'
                    ]
                ]
            ]);

            return $data->code;
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }

    }

    public function listRewardGovNameId()
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
                    'TableName' => 'ListRewardGovName'
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

}
