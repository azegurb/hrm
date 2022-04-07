<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\UserRewardHonorRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserRewardHonorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $sc = ['id','listRewardHonorNameId.name','issueDate','cardNumber','orderNum'];
            if($this->search != ''){
                $search = '"listRewardHonorNameId.name":%7B"contains":"'.$this->search.'"%7D,';
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
                        'TableName' => 'UserRewardHonor'
                    ]
                ]
            ]);
            if($data->totalCount > 0){
                $nc = nc($data,$sc, 'UserRewardHonor');

                $data = $nc->data;
                $new  = $nc->newNC;
            }
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
                return view('pages.personal_cards.reward-honor.index' , compact('data','page', 'new'));
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
    public function store(UserRewardHonorRequest $request)
    {
        try{
            $request->issueDate = !empty($request->issueDate) ? date('Y-m-d' , strtotime($request->issueDate)) : '';
            $requestData = [
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRewardHonor'
                    ],
                    'json' => [
                        'cardNumber' => $request->cardNumber,
                        'orderNum' => $request->orderNum,
                        'issueDate' => $request->issueDate,
                        'listRewardHonorNameId' => [
                            'id'    => $request->listRewardHonorNameId
                        ],
                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ];
            $data = Service::request($requestData);
            $data->body['data']['issueDate'] = date('d.m.Y' , gmdate($data->body['data']['issueDate'] / 1000));

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
                    'sc'     => ['id','listRewardHonorNameId','issueDate','cardNumber','orderNum'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRewardHonor'
                    ]
                ]
            ]);
            $response = [
                'fields' => [
                    'listRewardHonorNameId' => [
                        'id' => $data->data->listRewardHonorNameId->id,
                        'text' => $data->data->listRewardHonorNameId->name
                    ],
                    'cardNumber' => $data->data->cardNumber,
                    'orderNum' => $data->data->orderNum,
                    'issueDate' => !empty($data->data->issueDate) ? date('d.m.Y' , strtotime($data->data->issueDate)) : '',
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('reward-honor.update', $data->data->id)
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
    public function update(UserRewardHonorRequest $request, $id)
    {
        try{
            $request->issueDate = !empty($request->issueDate) ? date('Y-m-d' , strtotime($request->issueDate)) : '';
            $requestData = [
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRewardHonor'
                    ],
                    'json' => [
                        'id'          => $id,
                        'cardNumber' => $request->cardNumber,
                        'orderNum' => $request->orderNum,
                        'issueDate' => $request->issueDate,
                        'listRewardHonorNameId' => [
                            'id'    => $request->listRewardHonorNameId
                        ],
                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ];
            $data = Service::request($requestData);

            $data->data->issueDate = date('d.m.Y' , $data->data->issueDate / 1000);
            $data->data->listRewardHonorNameId->name = $request->listRewardHonorNameIdName;

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
                        'TableName' => 'UserRewardHonor'
                    ]
                ]
            ]);

            return $data->code;

        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }

    }

    public function listRewardHonorNameId()
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
                    'TableName' => 'ListRewardHonorName'
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

