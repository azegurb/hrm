<?php

namespace App\Http\Controllers\Salary;

use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrivilegesController extends Controller
{
    private $val;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'     => ['id','privilegeId.value','userId.id','userId.firstName','userId.lastName'],
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => ['userId.firstName' => $this->search]
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'RelUserPrivilege'
                    ]
                ]
            ]);
            $page = $this->page;


            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;
                return response()->json($data);
            }elseif($this->load == true){
                return view('pages.salary.privileges.index' , compact('data','page'));
            }else{
                return redirect(url('/salary'));
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
        $data;

        $dataListHead = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','/privileges/privilegesGrouped', false),
            'params'  => [
                'sc'     => ['id'],
                'offset' => $this->offset,
                'max'    => $this->limit,
                'filter' => ['name' => $this->search]
            ],
            'options' => [
                'headers' => []
            ]
        ]);

        $dataList = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id,name,value'],
                'offset' => $this->offset,
                'filter' => ['value' => $this->search]
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Privilege'
                ]
            ]
        ]);

        foreach ($dataListHead->data as $key=>$single_data) {

            $data->forModal[$key] = $single_data;

            $this->val = $single_data->value;

            foreach ($dataList->data as $key2=>$single_data2){
                if($single_data2->value == $this->val){
                    $data->forModal[$key]->options[$key2] = $single_data2;
                }

            }

        }


        return view('pages.salary.privileges.modal-content' , compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
//            $dataList = Service::request([
//                'method'  => 'GET',
//                'url'     => Service::url('hr','crud'),
//                'params'  => [
//                    'sc'     => ['id,name,value'],
//                    'offset' => $this->offset,
//                    'order'   => "desc",
//                    'sort' => "value",
//                ],
//                'options' => [
//                    'headers' => [
//                        'TableName' => 'HelperData'
//                    ]
//                ]
//            ]);
//            dd($dataList->data[0]->value);

            $date = date('Y-m-d', strtotime($request->input_date));


            $data = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'RelUserPrivilege'
                    ],
                    'json' => [
                        'privilegeId'      => [
                            'id' =>  $request->input_privilege
                        ],
                        'userId' => [
                            'id'    => $request->user
                        ],
                        'startDate' => $date
                    ]
                ]
            ]);






//
//            $data = Service::request([
//                'method'  => 'POST',
//                'url'     => Service::url('hr','crud'),
//                'options' => [
//                    'headers' => [
//                        'TableName' => 'RelUserPrivilege'
//                    ],
//                    'json' => [
//                        'privilegeId'      => [
//                            'id' =>  $request->input_privilege
//                        ],
//                        'userId' => [
//                            'id'    => $request->input_user
//                        ],
//                        'startDate' => date('U', strtotime($request->input_date)) * 1000
//                    ]
//                ]
//            ]);
//




            return response()->json($data);
        }catch (\Exception $e){
            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return response()->json($response);
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

//        $currtab = Service::request([
//            'method'  => 'GET',
//            'url'     => Service::url('hr','crud'),
//            'params'  => [
//                'sc'     => ['id','	paymentDate'],
//                'order'   => "desc",
//                'sort' => "	paymentDate",
//            ],
//            'options' => [
//                'headers' => [
//                    'TableName' => 'CurrentTable'
//                ]
//            ]
//        ]);
//
//        dd($currtab);

        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'id'  => $id,
                'sc'     => ['id','privilegeId.id','startDate','userId.firstName','userId.lastName','userId.id','startDate'],
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserPrivilege'
                ]
            ]
        ]);
//dd($data);
        $dataPos  =Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id','positionId.structureId.name','positionId.id'],
                'filter' => ['userId.id' =>  $data->data->userIdId]
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPosition'
                ]
            ]
        ]);

        $data->data->strName = $dataPos->data[0]->structureIdName;

        $dataListHead = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','/privileges/privilegesGrouped', false),
            'params'  => [
                'sc'     => ['id'],
                'offset' => $this->offset,
                'max'    => $this->limit,
                'filter' => ['name' => $this->search]
            ],
            'options' => [
                'headers' => []
            ]
        ]);

        $dataList = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id,name,value'],
                'offset' => $this->offset,
                'filter' => ['value' => $this->search]
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Privilege'
                ]
            ]
        ]);


        foreach ($dataListHead->data as $key=>$single_data) {

            $data->forModal[$key] = $single_data;

            $this->val = $single_data->value;

            foreach ($dataList->data as $key2=>$single_data2){

                if($single_data2->value == $this->val){
                    $data->forModal[$key]->options[$key2] = $single_data2;
                }

            }

        }
        $url = route('privileges.update' , $id);

        $data->data->startDate =  date('d.m.Y',strtotime( $data->data->startDate));
//dd($data->data->startDate);

//        dd($data);

        return view('pages.salary.privileges.modal-content' , compact('data','url'));
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
//        dd($id);
        //  CurrentTable / paymentDate

//        dd($request->input_date);
        $request->input_date = date("Y-m-d", strtotime($request->input_date));
//        dd($request->input_date);
//        dd($request->input_date);
//        $data->data->eduStartDate = date('Y-m-d', $data->data->eduStartDate / 1000);
//        dd($request->all());
        $data = Service::request([
            'method'  => 'PUT',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'RelUserPrivilege'
                ],
                'json' => [
                    'id' => $id,
                    'privilegeId' => [
                        'id'    => $request->input_privilege,
                        'value' => PrivilegesController::givePriVal($request->input_privilege)
                    ],
                    'startDate' => $request->input_date,
                ]
            ]
        ]);

        return response()->json($data);
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
                        'TableName' => 'RelUserPrivilege'
                    ]
                ]
            ]);

            return $data->code;
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }

    }


    public function give_list($value,$salary){


//dd($value,$salary);


    }

    public function getUserByStructure($id)
    {
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['id,userId.id,userId.firstName,userId.lastName, positionId.structureId.id'],
                'offset' => $this->offset,
                'filter' => '"positionId.structureId.id" : { "=" : "'.$id.'" }'
                //'83E56828-BB37-E711-A819-005056B83045'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'UserPosition'
                ]
            ]
        ]);

        $select = [];

        if($data->totalCount > 0){
            foreach ($data->data as $item){
                $select[] = (object)[
                    'text' => $item->userIdFirstName . ' ' . $item->userIdLastName,
                    'id'  => $item->userIdId,
                ];
            }
        }

        return response()->json($select);

    }


    public function givePriVal($id){
        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'id'  => $id,
                'sc'     => ['id','value'],
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Privilege'
                ]
            ]
        ]);

        return $data->data->value;
    }
}