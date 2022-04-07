<?php

namespace App\Http\Controllers\PersonalCards;

use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalCards\SpecialWorkGraphicsRequest;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;

class SpecialWorkGraphicsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try{
            if(!empty(selected()) && selected()->userId != null){
                $data = null;
                $userShiftId = $this->getRelUserInShift();
                if($userShiftId != false){
                    $periodic = $this->getShiftList($userShiftId->id);
                    if(!$periodic){
                        $data = $this->shiftInWeekDay($userShiftId->id);
                    }elseif ($periodic){
                        $data = $this->periodicShift();
                    }
                    $page = $this->page;
                    if ($request->ajax() && $this->load != true) {
                        $data->page = $this->page;
                        return response()->json($data);
                    }elseif($this->load == true){
                        return view('pages.personal_cards.special_work_graphics.index' , compact('data','userShiftId','periodic'));
                    }else{
                        return redirect(url('/personal-cards'));
                    }
                }else{
                    $periodic = 'not';
                    $page = $this->page;
                    if ($request->ajax() && $this->load != true) {
                        $data->page = $this->page;
                        return response()->json($data);
                    }elseif($this->load == true){
                        return view('pages.personal_cards.special_work_graphics.index' , compact('data','userShiftId','periodic'));
                    }else{
                        return redirect(url('/personal-cards'));
                    }
                }
            }else{
                return redirect(url('/personal-cards'));
            }
        }catch(Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }


    public function getCustomMonth(){

        try{
            if(!empty(selected()) && selected()->userId != null){
                $data = null;
                $userShiftId = $this->getRelUserInShift();
                if($userShiftId != false){
                    $periodic = $this->getShiftList($userShiftId->id);
                    if(!$periodic){
                        $data = $this->shiftInWeekDay($userShiftId->id);
                    }elseif ($periodic){
                        $data = $this->periodicShift();
                    }
                    $page = $this->page;
                    if ($request->ajax() && $this->load != true) {
                        $data->page = $this->page;
                        return response()->json($data);
                    }elseif($this->load == true){
                        return view('pages.personal_cards.special_work_graphics.index' , compact('data','userShiftId','periodic'));
                    }else{
                        return redirect(url('/personal-cards'));
                    }
                }else{
                    $periodic = 'not';
                    $page = $this->page;
                    if ($request->ajax() && $this->load != true) {
                        $data->page = $this->page;
                        return response()->json($data);
                    }elseif($this->load == true){
                        return view('pages.personal_cards.special_work_graphics.index' , compact('data','userShiftId','periodic'));
                    }else{
                        return redirect(url('/personal-cards'));
                    }
                }
            }else{
                return redirect(url('/personal-cards'));
            }
        }catch(Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }


    }

    /**
     * Get by User Id for periodic check.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRelUserInShift()
    {
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','shiftId.id','shiftId.restDay','shiftId.workDay','shiftId.periodic','shiftId.name','restDay' ,'workDay','shift'],
                'offset' => '',
                'max'    => '',
                'filter' => ['userId.id' => selected()->userId]
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserInShift'
                ]
            ]
        ]);
        if($data->code == 200 && $data->totalCount > 0){
            $userShiftId = (object)[
                'id' => $data->data[0]->shiftIdId,
                'name' => $data->data[0]->shiftIdName,
                'reluserid' => $data->data[0]->id,
                'restDay' => $data->data[0]->shiftIdRestDay,
                'workDay' => $data->data[0]->shiftIdWorkDay,
                'periodic' => $data->data[0]->shiftIdPeriodic,
                'checkrestDay' => $data->data[0]->restDay,
                'checkworkDay' => $data->data[0]->workDay
            ];
        }else{
            $userShiftId = false;
        }
        return $userShiftId;
    }



    /**
     * Get ShiftList for periodic check.
     *
     * @return \Illuminate\Http\Response
     */
    public function getShiftList($userShiftId)
    {
        $periodic = null;
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','periodic','workDay','restDay'],
                'offset' => '',
                'max'    => '',
                'filter' => []
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListShift'
                ]
            ]
        ]);
        foreach ($data->data as $value){
            if ($value->id == $userShiftId){
                $periodic = $value->periodic;
            }
        }
        return $periodic;
    }


    /**
     * For periodic false.
     *
     * @return \Illuminate\Http\Response
     */
    public function shiftInWeekDay($userShiftId)
    {
        $response = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','startTime','endTime','shiftId.id','weekDay'],
                'offset' => $this->offset,
                'max'    => $this->limit,
                'filter' => "'shiftId.id':%7B'=':$userShiftId%7D"
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ShiftInWeekDay'
                ]
            ]
        ]);

        return $response;

    }

    /**
     * For periodic true.
     *
     * @return \Illuminate\Http\Response
     */
    public function periodicShift()
    {
        $month = date('m');
        $year  = date('Y');
        $nextMonth = date('m' , strtotime('+1month'));
        $startDate = $year.'-'.$month.'-01';
        $endDate = $year.'-'. $nextMonth .'-02';
        $response = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','userId.id','startDate','endDate'],
                'filter' => '"userId.id":%7B"=":"'.selected()->userId.'"%7D,"startDate":%7B">":"'.$startDate.'"%7D,"endDate":%7B"<":"'.$endDate.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'PeriodicShiftUsersWorkday'
                ]
            ]
        ]);
        if($response->totalCount > 0){
            foreach ($response->data as $value){
                $value->start = date('Y-m-d H:i:s',$value->startDate/1000);
                $value->end = date('Y-m-d H:i:s',$value->endDate/1000);
            }
            return json_encode($response);
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
    public function store(SpecialWorkGraphicsRequest $request)
    {
        try{
            $start  = date('U' , strtotime($request->start));
            $end    = date('U' , strtotime($request->end));
            $userId = !empty(selected()->userId) ? selected()->userId : null;
            $requestData = [
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'PeriodicShiftUsersWorkday'
                    ],
                    'json' => [
                        'startDate' => $start*1000,
                        'endDate'   => $end*1000,
                        "userId"    => [
                            "id" => $userId
                        ]
                    ]
                ]
            ];

            $data = Service::request($requestData);

            $data = (object)[
              'code' => $data->code,
              'data' => (object)[
                  'id' => $data->body['data']['id'],
                  'start' => $start*1000,
                  'end'   => $end*1000,
              ]
            ];
            if($data->code == 201){
                $data->data->startTime = date('H:i' , gmdate($data->data->start)/1000);
                $data->data->start = date('Y-m-d H:i:s' , gmdate($data->data->start)/1000);
                $data->data->endTime = date('H:i' , gmdate($data->data->end)/1000);
                $data->data->end = date('Y-m-d H:i:s' , gmdate($data->data->end)/1000);
            }
            return response()->json($data);
        }catch(Exception $e){
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SpecialWorkGraphicsRequest $request, $id)
    {
        try{
            $start  = date('U' , strtotime($request->start));
            $end    = date('U' , strtotime($request->end));
            $userId = !empty(selected()->userId) ? selected()->userId : null;
            $requestData = [
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'PeriodicShiftUsersWorkday'
                    ],
                    'json' => [
                        'startDate' => $start*1000,
                        'endDate'   => $end*1000,
                        "userId"    => [
                            "id" => $userId
                        ],
                        'id'        => (int)$id
                    ]
                ]
            ];

            $data = Service::request($requestData);


            $data = (object)[
                'code' => $data->code,
                'data' => (object)[
                    'id' => $id,
                    'start' => $start*1000,
                    'end'   => $end*1000,
                ]
            ];

            if($data->code == 200){
                $data->data->startTime = date('H:i' , gmdate($data->data->start)/1000);
                $data->data->start = date('Y-m-d H:i:s' , gmdate($data->data->start)/1000);
                $data->data->endTime = date('H:i' , gmdate($data->data->end)/1000);
                $data->data->end = date('Y-m-d H:i:s' , gmdate($data->data->end)/1000);
            }
            return response()->json($data);
        }catch(Exception $e){
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
                        'TableName' => 'PeriodicShiftUsersWorkday'
                    ]
                ]
            ]);

            if($data->code == 200){
                $id = $id;
            }else{
                $id = '';
            }
            return $id;
        }catch(Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function getShift()
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
                'sc'     => ['id','periodic','workDay','restDay','name'],
                'filter' => $search,
                'offset' => '',
                'max'    => '',
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListShift'
                ]
            ]
        ]);

        $select = [];
        if($data->totalCount > 0){
            foreach ($data->data as $item){
                $select[] = (object)[
                    'text' => $item->name,
                    'id'   => $item->id,
                    'all' => $item
                ];
            }
        }


        return response()->json($select);
    }

    public function userShift(Request $request)
    {

        $user  = !empty(selected()->userId) ? selected()->userId : null;
        $shift = $request->shift;
        $beforeDate=$request->beforeDate;
        if (!empty(json_decode($request->checkers)->work)){
            $work = json_decode($request->checkers)->work;
            $rest = false;
        }elseif(!empty(json_decode($request->checkers)->rest)){
            $rest = json_decode($request->checkers)->rest;
            $work = false;
        }else{
            $work = false;
            $rest  = false;
        }
        $requestData = [
            'method'  => 'POST',
            'url'     => Service::url('hr','relUserInShift/shifts', false),
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserInShift'
                ],
                'json' => [
                    "userId"    => [
                        "id" => $user
                    ],
                    "shiftId"    => [
                        "id" => (int)$shift
                    ],
                    "workDay" => $work != false ? (int)$work : 0,
                    "restDay" => $rest != false ? (int)$rest : 0,
                    "shift"   => $work != false ? true  : false,
                    "beforeDate"=>$beforeDate
                ]
            ]
        ];

        $data = Service::request($requestData);

        return $data->code;

    }

    public function userShiftRe(Request $request)
    {
//        dd($request->all());
        $beforeDate=$request->beforeDate;
        $id = $request->id;
        $user  = !empty(selected()->userId) ? selected()->userId : null;
        $shift = $request->shift;

        if (!empty(json_decode($request->checkers)->work)){
            $work = json_decode($request->checkers)->work;
            $rest = false;
        }elseif(!empty(json_decode($request->checkers)->rest)){
            $rest = json_decode($request->checkers)->rest;
            $work = false;
        }else{
            $work = false;
            $rest  = false;
        }
        $requestData = [
            'method'  => 'PUT',
            'url'     => Service::url('hr','relUserInShift/shifts/'.$id, false),
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserInShift'
                ],
                'json' => [
                    "userId"    => [
                        "id" => $user
                    ],
                    "shiftId"    => [
                        "id" => (int)$shift
                    ],
                    "workDay" => $work != false ? (int)$work : 0,
                    "restDay" => $rest != false ? (int)$rest : 0,
                    "shift"   => $work != false ? true  : false,
                    "beforeDate"=>$beforeDate
                ]
            ]
        ];

        $data = Service::request($requestData);
        return $data->code;

    }

    public function getMonth(Request $request)
    {

        $date=date('Y-m-d', strtotime(Input::get('obj')));
        $date_end=date("Y-m-t", strtotime($date));

        $userid=Input::get('userid');

//        return ['firstdate'=>$date, 'lastdate'=>$date_end];

        $checkVacationDay= Service::request([
            'method'  => 'GET',
            'url'    => Service::url('hr', 'relUserInShift/getMonthlyWorkDay?startDate='.$date.'&endDate='.$date_end.'&userId='.$userid, false),
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        if(isset($checkVacationDay->data) && count($checkVacationDay->data)>0) {
            foreach ($checkVacationDay->data as $arr) {

                $arr->userIdId = $userid;
                $arr->end = date('Y-m-d H:i:s', $arr->endDate / 1000);
                $arr->start = date('Y-m-d H:i:s', $arr->startDate / 1000);

            }
        }
        if ($request->ajax() && $this->load != true) {

            return response()->json($checkVacationDay);
        }
//        return ['firstdate'=>$date, 'lastdate'=>$date_end];

    }
}
