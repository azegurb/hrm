<?php

namespace App\Http\Controllers\Salary;

use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalaryVacationController extends Controller
{
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
                'url'     => Service::url('hr','users/vacationUsers',false),
                'params'  => [
                    'sc'     => [],
                    'offset' => $this->offset,
                    'max'    => $this->limit
                ],
                'options' => [
                    'headers' => []
                ]
            ]);

            $page = $this->page;


            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;
                return response()->json($data);
            }elseif($this->load == true){

                return view('pages.salary.salary_vacation.index' , compact('data','page'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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


        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','users/userPayments',false),
            'params'  => [
                'sc'     => [],
                'offset' => $this->offset,
                'max'    => $this->limit,
                'userId'  => $id
            ],
            'options' => [
                'headers' => []
            ]
        ]);
//        dd($data);
//        $userId = $data->data->payments[0]->userId;
//        $this->giveUser($userId);

        $date1 = date("Y-m", strtotime($data->data->startDate));
        $date2 = date("Y-m", strtotime($data->data->reportingMonth));

        $to = \Carbon\Carbon::createFromFormat('Y-m', $date1);
        $from = \Carbon\Carbon::createFromFormat('Y-m', $date2);
        $diff_in_months = $to->diffInMonths($from);
        $monthCount = $diff_in_months - 1;
//        dd($diff_in_months);
        $date1_m = (int)date("n",strtotime($date1));
        $date2_m = (int)date("n",strtotime($date2));
//        dd($date1_m , $date2_m);


        $months = [ 'Dekabr' ,'Yanvar','Fevral','Mart','Aprel','May','İyun','İyul','Avqust','Sentyabr','Oktyabr','Noyabr','Dekabr','Yanvar','Fevral','Mart','Aprel','May','İyun','İyul','Avqust','Sentyabr','Oktyabr','Noyabr','Dekabr'];
//        dd($months[$date2_m+10]);
//        dd($date1_m,$date2_m);
        $data->data->sending = [
            "1" => [
                "label" => $months[$date2_m],
                "disabled" => $date2_m-11>$date1_m ? false : true,
                "value" => ""
            ],
            "2" => [
                "label" => $months[$date2_m+1],
                "disabled" => $date2_m-10>$date1_m ? false : true,
                "value" => ""
            ],
            "3" => [
                "label" => $months[$date2_m+2],
                "disabled" => $date2_m-9>$date1_m ? false : true,
                "value" => ""
            ],
            "4" => [
                "label" => $months[$date2_m+3] ,
                "disabled" => $date2_m-8>$date1_m ? false : true,
                "value" => ""
            ],
            "5" => [
                "label" => $months[$date2_m+4],
                "disabled" => $date2_m-7>$date1_m ? false : true,
                "value" => ""
            ],
            "6" => [
                "label" => $months[$date2_m+5],
                "disabled" => $date2_m-6>$date1_m ? false : true,
                "value" => ""
            ],
            "7" => [
                "label" => $months[$date2_m+6],
                "disabled" => $date2_m-5>$date1_m ? false : true,
                "value" => ""
            ],
            "8" => [
                "label" => $months[$date2_m+7],
                "disabled" => $date2_m-4>$date1_m ? false : true,
                "value" => ""
            ],
            "9" => [
                "label" => $months[$date2_m+8],
                "disabled" => $date2_m-3>$date1_m ? false : true,
                "value" => ""
            ],
            "10" => [
                "label" => $months[$date2_m+9],
                "disabled" => $date2_m-2>$date1_m ? false : true,
                "value" => "400"
            ],
            "11" => [
                "label" => $months[$date2_m+10],
                "disabled" => $date2_m-1>$date1_m ? false : true,
                "value" => "400"
            ],
            "12" => [
                "label" => $months[$date2_m+11],
                "disabled" => $date2_m>$date1_m ? false : true,
                "value" => "400"
            ]
        ];




//        $response = [
//            'fields' => [
//                'asdf' => 'test',
//                'aaaa' => 111
//            ],
//            'id' => $data->data->payments[0]->userId,
//            'code' => $data->code,
//            'url' => route('contest-types.update', $data->data->payments[0]->id)
//        ];

        return view('pages.salary.salary_vacation.modal-content.modal-content' , compact('data'));
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

//    public function calculate($data){
//
//        foreach ($data->data as $key=>$single_data) {
//
//            $this_data= [$single_data->salary, $single_data->paymentDate];
//            $last_data = [];
//
//            array_push($last_data,$this_data);
//
//        }
//
//    }
//
//    public function giveUser($id){
//
//        $data = Service::request([
//            'method'  => 'GET',
//            'url'     => Service::url('hr','crud'),
//            'params'  => [
//                'id'      => $id,
//                'sc'      => ['id','name']
//            ],
//            'options' => [
//                'headers' => [
//                    'TableName' => 'Users',
//                ]
//            ]
//        ]);
//        return($data->data->name);
//    }
}