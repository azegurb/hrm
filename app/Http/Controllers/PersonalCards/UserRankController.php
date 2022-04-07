<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\UserRankRequest;
use App\Library\Service\Service;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserRankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $sc = ['id','startDate','listSpecialRankId','docDate','docInfo'];
            if($this->search != ''){
                $search = '"listSpecialRank.listSpecialRankType.name":%7B"=":"'.$this->search.'"%7D,';
            }else{
                $search = '';
            }
       
            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => $sc,
                    'offset' => $this->offset,
                    'max' => $this->limit,
                    'filter' => $search.'"userId.id" : %7B "=" : "'.selected()->userId.'" %7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRank'
                    ]
                ]
            ]);



            if($data->totalCount > 0){
                $nc = nc($data,$sc, 'UserRankNC');

                $data = $nc->data;
                $new  = $nc->newNC;
            }

            $page = $this->page;
            if($data->totalCount > 0){
                foreach($data->data as $key =>$value){
                    $value->startDate =  date('d.m.Y',strtotime( $value->startDate));
                    $value->docDate =  date('d.m.Y',strtotime( $value->docDate));
                }
            }
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;
                return response()->json($data);
            } elseif ($this->load == true) {
                return view('pages.personal_cards.user-rank.index', compact('data', 'page', 'new'));
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
        return view('pages.personal_cards.user-rank.modal-inside');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRankRequest $request)
    {
        try{
            $data = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRank'
                    ],
                    'json' => [
                        'startDate' =>date('U', strtotime($request->input_given_date))*1000,
                        'listSpecialRankId' =>
                            [
                                'id' => $request->listspecialrank
                            ],
                        'docDate' =>date('U', strtotime($request->input_doc_date))*1000,
                        'docInfo' => $request->input_docinfo,
                        'userId' => [
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
                    'sc' => ['id,startDate,listSpecialRankId,docDate,docInfo'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRank'
                    ]
                ]
            ]);

            $response = (object)[
                'fields' => (object)[
                    'input_given_date'   => date('d.m.Y', strtotime($data->data->startDate)),
                    'listspecialrank' => (object)[
                            'id' => $data->data->listSpecialRankId->id,
                            'text' => $data->data->listSpecialRankId->name
                   ],
                    'listspecialranktype' => (object)[
                        'id' => $data->data->listSpecialRankId->listSpecialRankTypeId->id,
                        'text' => $data->data->listSpecialRankId->listSpecialRankTypeId->name
                    ],
                    'input_docinfo' => $data->data->docInfo,
                    'input_doc_date'   => date('d.m.Y',strtotime($data->data->docDate))
                ],
                'id' => $data->data->id,
            ];
            return view('pages.personal_cards.user-rank.modal-inside' , compact('response'));
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
    public function update(UserRankRequest $request, $id)
    {
        try{
           $data =  Service::request([
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserRank'
                    ],
                    'json' => [
                        'id'              => $id,
                        'startDate'       => date('U', strtotime($request->input_given_date))*1000,
                        'docInfo'         => $request->input_docinfo,
                        'docDate'         => date('U', strtotime($request->input_doc_date))*1000,
                        'listSpecialRankId' => [
                                'id' => $request->listspecialrank,
                        ],
                        'userId'          => [
                                'id' => selected()->userId
                        ]
                    ]
                ]
            ]);

            $data->data->startDate =  date("d.m.Y" , $data->data->startDate/1000);
            $data->data->docDate =  date("d.m.Y" , $data->data->docDate/1000);

            $data->data->listSpecialRankId->name = $this->name_rank($request->listspecialrank)->data->name;
            $data->data->listSpecialRankId->listSpecialRankTypeId = $this->name_rank($request->listspecialrank)->data->listSpecialRankTypeIdName;

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
                        'TableName' => 'UserRank'

                    ]
                ]
            ]);

            return $data->code;
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }


    public function specialRankTypes()
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
                        'TableName' => 'ListSpecialRankType'
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

    public function specialRanks($id = null)
    {
        try{
            $search = !empty(Input::get('q')) ? Input::get('q') : '';
            if($search != ''){
                $filter = '"name":%7B"contains":"'.$search.'"%7D,';
            }else{
                $filter = '';
            }
            //'filter' => $search
            if($id != null){
                $search = '"listSpecialRankTypeId.id":%7B"=":"'.$id.'"%7D';
            }else{
                $search = '';
            }
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params' => [
                    'sc' => ['id','name'],
                    'filter' => $filter.$search
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListSpecialRank'
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

    /**
     * @param $id
     * @return object
     */
    public function name_rank($id)
    {
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'      => $id,
                    'sc'      => ['id','name','listSpecialRankTypeId.name']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListSpecialRank',
                    ]
                ]
            ]);

            return($data);
        }catch (\Exception $e){
           return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }
}
