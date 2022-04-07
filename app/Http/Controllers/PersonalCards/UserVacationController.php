<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\UserVacationRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserVacationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        try{



            $sc = ['id','orderCommonId.orderNum','orderCommonId.orderDate','listVacationTypeId.name'];
            $search = !empty($this->search) ? '"orderCommonId.orderNum":%7B"=":"'.$this->search.'"%7D,':'';

            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'     => $sc,
                    'offset' => $this->offset,
                    'max'    => 100,
                    'filter' => $search.'"userId.id" : %7B "=" : "'.selected()->userId.'" %7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacation',
                    ]
                ]
            ]);



//            if($data->totalCount > 0){
//                $nc = nc($data,$sc, 'OrderVacationNC');
//
//                $data = $nc->data;
//                $new  = $nc->newNC;
//            }

            if($data->totalCount > 0){

                foreach($data->data as $vacation){
                    $data2 = Service::request([
                        'method'  => 'GET',
                        'url'     => Service::url('hr','crud'),
                        'params'  => [
                            'sc'     => ['id','startDate','endDate','workStartDate','mainVacationDay','additionVacationDay','mainRemainderVacationDay','additionRemainderVacationDay','vacationWorkPeriodFrom','vacationWorkPeriodTo'],
                            'offset' => $this->offset,
                            'max'    => 100,
                            'filter' => $search.'"orderVacationId.id" : %7B "=" : "'.$vacation->id.'" %7D',
                            'sort'   => 'startDate',
                            'order'  => 'asc'
                        ],
                        'options' => [
                            'headers' => [
                                'TableName' => 'OrderVacationDetail',
                            ]
                        ]
                    ]);

                    $vacation->details = $data2->data;

                    $vacation->detailsAdd=[];

                    $vacation->detailsCollective=[];

                    $vacation->firstDate=$data2->data[0]->startDate;

                    $vacation->lastDate='';
//                    dd($data->data[0]->details);
                    if(isset($vacation->details)) {


                        foreach ($vacation->details as $single_data) {

                            $dataOrderVacationDetailAdd = Service::request([
                                'method' => 'GET',
                                'url' => Service::url('hr', 'crud'),
                                'params' => [
                                    'sc' => ['id', 'orderVacationDetailId.id', 'orderVacationDetailId.vacationWorkPeriodFrom', 'orderVacationDetailId.vacationWorkPeriodTo', 'totalExperienceDay', 'totalWorkConditionDay', 'totalChild142', 'totalChild143', 'remaindeChild142', 'remaindeChild143', 'remaindeExperienceDay', 'remaindeWorkConditionDay', 'workConditionDay', 'child142', 'child143', 'experienceDay'],
                                    'filter' => '"orderVacationDetailId.id":%7B"=":"' . $single_data->id . '"%7D',
                                    'sort'   => 'id',
                                    'order'  => 'asc'
                                ],
                                'options' => [
                                    'headers' => [
                                        'TableName' => 'OrderVacationDetailAdd'
                                    ]
                                ]
                            ]);

                            $vacation->detailsAdd[]=$dataOrderVacationDetailAdd->data[0];//aa

                            $dataOrderVacationCollectiveDetail = Service::request([
                                'method' => 'GET',
                                'url' => Service::url('hr', 'crud'),
                                'params' => [
                                    'sc' => ['id', 'orderVacationDetailId.id', 'orderVacationDetailId.vacationWorkPeriodFrom', 'orderVacationDetailId.vacationWorkPeriodTo', 'allWomenDay', 'chernobylAccidenDay', 'child142', 'child143', 'remaindeChild142', 'remaindeChild143', 'remaindeAllWomenDay', 'remaindeChernobylAccidenDay', 'totalAllWomenDay', 'totalChernobylAccidenDay', 'totalChild142', 'totalChild143'],
                                    'filter' => '"orderVacationDetailId.id":%7B"=":"' . $single_data->id . '"%7D',
                                    'sort'   => 'id',
                                    'order'  => 'asc'
                                ],
                                'options' => [
                                    'headers' => [
                                        'TableName' => 'OrderVacationCollectiveDetail'
                                    ]
                                ]
                            ]);

                            $vacation->detailsCollective[]=$dataOrderVacationCollectiveDetail->data[0];

                            $single_data->orderCommonIdOrderDate = date("d.m.Y", strtotime($data->data[0]->orderCommonIdOrderDate));
                            $single_data->endDate = date("d.m.Y", strtotime($single_data->endDate));
                            $single_data->startDate = date("d.m.Y", strtotime($single_data->startDate));
                            $single_data->vacationWorkPeriodTo = date("d.m.Y", strtotime($single_data->vacationWorkPeriodTo));
                            $single_data->vacationWorkPeriodFrom = date("d.m.Y", strtotime($single_data->vacationWorkPeriodFrom));
                            $single_data->workStartDate = date("d.m.Y", strtotime($single_data->workStartDate));
                        }

                        $vacation->lastDate = $single_data->endDate;
                    }
                }

            }


            $page = $this->page;
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;
                return response()->json($data);
            }elseif($this->load == true){
//                dd($data);
//                dd($data);
                return view('pages.personal_cards.vocation.index',compact('data' ,'page', 'new'));
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
    public function store(UserVacationRequest $request)
    {
//        dd($request->all());
        try{
            $listvacationtype = [];
            foreach ($request->start as $key => $value){
                $end = date('Y-m-d' , strtotime($request->end[$key]));
                $vac_start = date('Y-m-d' , strtotime($request->vac_start[$key]));
                $vac_end = date('Y-m-d' , strtotime($request->vac_end[$key]));

                $listvacationtype[] =  (object)[
                    'startDate' => $value = date('Y-m-d' , strtotime($value)),
                    'endDate'   => $end ,
                    'vacationDay' => (int)$request->trip_day[$key],
                    'vacationWorkPeriodFrom' => $vac_start ,
                    'vacationWorkPeriodTo' => $vac_end
                ];
            }

            $request = [
                'method'  => 'POST',
                'url'     => Service::url('hr','orderCommons/orderVacations' , false),
                'options' => [
                    'headers' => [
                    ],
                    'json' => [
                        'vacationComment'    => $request->comment,
                        'orderCommonId' => [
                            'id' => $request->order,
                            'orderNum' => UserVacationController::givename_ord_num($request->order),
                            'orderDate' => $vac_start
                        ],
                        'listVacationTypeId' => [
                            'id' => $request->listvacationtype,
                            'name' => UserVacationController::givename_appo_type($request->listvacationtype)
                        ],
                        'userId'    => [
                            'id' => selected()->userId
                        ],
                        'orderVacationDetailList' => $listvacationtype
//                        'order_date' =>  $request->start
                    ]
                ]
            ];

            $data = Service::request($request);

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
                    'sc' => ['id', 'listVacationTypeId', 'orderCommonId','vacationComment'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacation'
                    ]
                ]
            ]);

            $response = [
                'fields' => [
                    'listvacationtype' => [
                        'id' => $data->data->listVacationTypeId->id,
                        'text' => $data->data->listVacationTypeId->name
                    ],
                    'order' => [
                        'id' => $data->data->orderCommonId->id,
                        'text' => $data->data->orderCommonId->orderNum
                    ],
                    'comment'   => $data->data->vacationComment,
                    'workYears' => $this->orderVocationDetail($id , 'raw')
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('vocation.update', $data->data->id)
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
    public function update(UserVacationRequest $request, $id)
    {
        try{
            $listvacationtype = [];
            foreach ($request->start as $key => $value){
                $end = date('Y-m-d' , strtotime($request->end[$key]));
                $vac_start = date('Y-m-d' , strtotime($request->vac_start[$key]));
                $vac_end = date('Y-m-d' , strtotime($request->vac_end[$key]));

                $listvacationtype[] =  (object)[
                    'startDate' => $value = date('Y-m-d' , strtotime($value)),
                    'endDate'   => $end ,
                    'vacationDay' => (int)$request->trip_day[$key] ,
                    'vacationWorkPeriodFrom' => $vac_start ,
                    'vacationWorkPeriodTo' => $vac_end
                ];
            }

            $request = [
                'method'  => 'PUT',
                'url'     => Service::url('hr','orderCommons/orderVacations/'.$id , false),
                'options' => [
                    'headers' => [
                    ],
                    'json' => [
                        'vacationComment'    => $request->comment,
                        'orderCommonId' => [
                            'id' => $request->order,
                            'orderNum' => UserVacationController::givename_ord_num($request->order)
                        ],
                        'listVacationTypeId' => [
                            'id' => $request->listvacationtype,
                            'name' => UserVacationController::givename_appo_type($request->listvacationtype)
                        ],
                        'userId'    => [
                            'id' => selected()->userId
                        ],
                        'orderVacationDetailList' => $listvacationtype
                    ]
                ]
            ];
            $data = Service::request($request);

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
                'params' => [
                    'id' => $id
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'OrderVacation'
                    ]
                ]
            ]);

            if ($data->code == 200 && !empty($data->data) ){
                foreach ($data->data as $value){
                    $datas = Service::request([
                        'method'  => 'DELETE',
                        'url'     => Service::url('hr','crud'),
                        'params' => [
                            'id' => $value->rowId
                        ],
                        'options' => [
                            'headers' => [
                                'TableName' => $value->tableName
                            ]
                        ]
                    ]);
                }
                $data = Service::request([
                    'method'  => 'DELETE',
                    'url'     => Service::url('hr','crud'),
                    'params' => [
                        'id' => $id
                    ],
                    'options' => [
                        'headers' => [
                            'TableName' => 'OrderVacation'
                        ]
                    ]
                ]);
            }
            return $data->code;
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }



    public function vocationTypes()
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
            'params' => [
                'sc' => ['id','name'],
                'filter' => $search
            ],
            'options' => [
                'headers' =>
                    [
                        'TableName' => 'ListVacationType'
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

    public function orderVocationDetail($id , $type = 'json')
    {

        $search = !empty(Input::get('q')) ? Input::get('q') : '';
        if($search != ''){
            $search = '"name":%7B"contains":"'.$search.'"%7D,';
        }else{
            $search = '';
        }
        //'filter' => $search

        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','vacationWorkPeriodFrom','vacationWorkPeriodTo','mainVacationDay','startDate','endDate', 'workStartDate'],
                'filter' => $search.'"orderVacationId.id" : %7B "=" : "'.$id.'" %7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderVacationDetail',
                ]
            ]
        ]);

//        dd($data);
        if(!empty($data->data)){
            foreach ($data->data as $value){
                if(!empty($value->vacationWorkPeriodFrom)){
                    $value->vacationWorkPeriodFrom = date('d.m.Y' , strtotime($value->vacationWorkPeriodFrom));
                    $value->vacationWorkPeriodTo = date('d.m.Y' , strtotime($value->vacationWorkPeriodTo));
                    $value->startDate = date('d.m.Y' , strtotime($value->startDate));
                    $value->endDate = date('d.m.Y' , strtotime($value->endDate));
                }
            }
        }

//        dd($data);
        if ($type == 'json'){
            return response()->json($data);
        }elseif($type == 'raw'){
            return $data;
        }


    }

    public function givename_appo_type($id){

        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'id'      => $id,
                'sc'      => ['id','name']
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListVacationType',
                ]
            ]
        ]);
        return($data->data->name);
    }

    public function givename_ord_num($id){

        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'id'      => $id,
                'sc'      => ['id','orderNum']
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderCommon',
                ]
            ]
        ]);

        return($data->data->orderNum);
    }
}
