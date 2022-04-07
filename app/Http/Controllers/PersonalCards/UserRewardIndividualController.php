<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\UserRewardIndividualRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRewardIndividualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $sc = ['id','listRewardIndividualNameId.name','issueDate','reason','orderNum'];
            if (!empty($this->search)){
                $filter = '"listRewardIndividualNameId.name":%7B"contains":"'.$this->search.'"%7D,';
            }else{
                $filter = '';
            }
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'     => $sc,
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => $filter.'"userId":%7B"=":"'.selected()->userId.'"%7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRewardIndividual'
                    ]
                ]
            ]);
            if($data->totalCount > 0){
                $nc = nc($data,$sc, 'UserRewardIndividualNC');

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
                return view('pages.personal_cards.reward-individual.index' , compact('data','page', 'new'));
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
    public function store(UserRewardIndividualRequest $request)
    {
        try{
            $request->issueDate = !empty($request->issueDate) ? date('Y-m-d' , strtotime($request->issueDate)) : '';
            $requestData = [
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRewardIndividual'
                    ],
                    'json' => [
                        'reason' => $request->reason,
                        'orderNum' => $request->orderNum,
                        'issueDate' => $request->issueDate,
                        'listRewardIndividualNameId' => [
                            'id'    => $request->listRewardIndividualNameId
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
                    'sc'     => ['id','listRewardIndividualNameId','issueDate','reason','orderNum'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRewardIndividual'
                    ]
                ]
            ]);
            $response = [
                'fields' => [
                    'listRewardIndividualNameId' => [
                        'id' => $data->data->listRewardIndividualNameId->id,
                        'text' => $data->data->listRewardIndividualNameId->name
                    ],
                    'reason' => $data->data->reason,
                    'orderNum' => $data->data->orderNum,
                    'issueDate' => !empty($data->data->issueDate) ? date('d.m.Y' , strtotime($data->data->issueDate)) : '',
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('reward-individual.update', $data->data->id)
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
    public function update(UserRewardIndividualRequest $request, $id)
    {
        try{
            $request->issueDate = !empty($request->issueDate) ? date('Y-m-d' , strtotime($request->issueDate)) : '';
            $requestData = [
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRewardIndividual'
                    ],
                    'json' => [
                        'id'          => $id,
                        'reason' => $request->reason,
                        'orderNum' => $request->orderNum,
                        'issueDate' => $request->issueDate,
                        'listRewardIndividualNameId' => [
                            'id'    => $request->listRewardIndividualNameId
                        ],
                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ];
            $data = Service::request($requestData);

            $data->data->issueDate = date('d.m.Y' , $data->data->issueDate / 1000);
            $data->data->listRewardIndividualNameId->name = $request->listRewardIndividualNameIdName;

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
                        'TableName' => 'UserRewardIndividual'
                    ]
                ]
            ]);

            return $data->code;

        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }

    }
    public function listRewardIndividualNameId()
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
                    'TableName' => 'ListRewardIndividualName'
                ]
            ]
        ]);

        $select = [];
        if($data->totalCount > 0 ){
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
