<?php

namespace App\Http\Controllers\Rating;

use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class RatingPagesController extends Controller
{
    protected $path = 'pages.rating.';

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $getDate = !empty(Input::get('date')) ? Input::get('date') : '';
        if($getDate == '') {
            $month = date('m');
            $year = date('Y');
            $date = '01-' . $month . '-' . $year;
        }else{
            $date = $getDate;
        }
        $date = date('U' , strtotime($date))*1000;
        $employees = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','/assessment/employeeList?date='.$date,false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        $notification = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','assessment/waitForConfirmCount',false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

//        dd($notification);

        if($request->ajax()) {
            return response()->json($employees);
        }
        return view($this->path.'index' , compact('employees' ,'notification'));
    }

    public function criterias()
    {
        $userId = !empty(Input::get('employee')) ? Input::get('employee') : '';
        $getDate = !empty(Input::get('date')) ? Input::get('date') : '';
        if($getDate == '') {
            $month = date('m');
            $year = date('Y');
            $date = '01-' . $month . '-' . $year;
        }else{
            $date = $getDate;
        }
        $date = date('U' , strtotime($date))*1000;

        $criterias = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','assessment/criterionList?date='.$date.'&employeeId='.$userId,false),
            'params'  => [],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);
        $director = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','assessment/getValuers?date='.$date.'&userId='.$userId,false),
            'params'  => [],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);
        if(!empty($criterias) && count($criterias->data) > 0){
            $collection = collect($criterias->data);
//            dd($collection);
            $sorted = $collection->sortBy('sort');
            $criterias->data = $sorted->values()->all();

            foreach ($criterias->data as $sub){
                if(count($sub->criterias) > 0) {
                    $subcollection = collect($sub->criterias);
                    $subsorted = $subcollection->sortBy('sort');
                    $sub->criterias = $subsorted->values()->all();
                }
            }
        }
        $response = (object)[
            'criterias' => $criterias,
            'director'  => $director
        ];
        return response()->json($response);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        $criteriaId = !empty(Input::get('criteriaId')) ? Input::get('criteriaId') : '';
        $details = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','assessment/criteriaDetails?criteriaId='.$criteriaId,false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        if(!empty($details) && count($details->data->childs) > 0){
            $collection = collect($details->data->childs);
//            dd($collection);
            $sorted = $collection->sortBy('sort');

            $details->data->childs = $sorted->values()->all();
        }
        return response()->json($details);
    }

    public function post(Request $request)
    {
        $rease = '';
        if(!empty($request->rater) && $request->rater != '0'){
            $rated = explode(",", $request->rater);
            $operant = $rated[0];
            $value = $rated[1];
        }
        $data = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','assessment/doAssessment', false),
            'options' => [
                'headers' => [
                    'TableName' => ''
                ],
                'json' => [
                    'userId' => $request->userId,
                    'criteriaId' => $request->criteriaId,
                    'increase' => !empty($operant) && $operant == '+' ? $value : null,
                    'decrease' => !empty($operant) && $operant == '-' ? $value : null,
                    'excused'  => $request->rater == '0' ? true : false,
                    'note'     => $request->note,
                    'innerCriterions' => !empty($request->inner_text) && count($request->inner_text) > 0 ? $request->inner_text : null
                ]
            ]
        ]);
        return response()->json($data);
    }

    public function getDetails()
    {
        $userId = !empty(Input::get('userId')) ? Input::get('userId') : '';
        $criteriaId = !empty(Input::get('criteriaId')) ? Input::get('criteriaId') : '';
        $getDate = !empty(Input::get('date')) ? Input::get('date') : '';
        if($getDate == '') {
            $month = date('m');
            $year = date('Y');
            $date = '01-' . $month . '-' . $year;
        }else{
            $date = $getDate;
        }
        $date = date('U' , strtotime($date))*1000;
        $url = 'assessment/userValues?date='.$date.'&userId='.$userId.'&criteriaId='.$criteriaId;

        $info = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr',$url,false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        if(count($info->data) > 0 ){
            foreach ($info->data as $in){
                $in->valueDate = date('d.m.Y' , $in->valueDate/1000);
            }
        }

        return response()->json($info);

    }

    public function assessment()
    {
        $assessmentId = !empty(Input::get('assessmentId')) ? Input::get('assessmentId') : '';

        if($assessmentId!= ''){
            $search = '"assessmentId":%7B"=":"'.$assessmentId.'"%7D,';
        }else{
            $search = '';
        }

        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','crud'),
            'params'  => [
                'sc'     => ['listAssessmentCriterionId.name'],
                'filter' => $search
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'RelAssessmentDetail'
                ]
            ]
        ]);

        return response()->json($data);

    }

    public function yearly()
    {
        $criteriaId = !empty(Input::get('criteriaId')) ? Input::get('criteriaId') : '';
        $userId = !empty(Input::get('userId')) ? Input::get('userId') : '';
        $getDate = !empty(Input::get('date')) ? Input::get('date') : '';
        if($getDate == '') {
            $month = date('m');
            $year = date('Y');
            $date = '01-' . $month . '-' . $year;
        }else{
            $date = $getDate;
        }
        $date = date('U' , strtotime($date))*1000;

        $yearly = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','/assessment/userValuesYearly?date='.$date.'&userId='.$userId.'&criteriaId='.$criteriaId,false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);
        return response()->json($yearly);
    }

    public function yearlyView()
    {
        $yearly = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','assessment/yearly',false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        return response()->json($yearly);
    }

    public function getNot()
    {
        $notifications = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','assessment/waitForConfirm',false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        return response()->json($notifications);
    }
    public function confirmation()
    {
        $assessmentId = !empty(Input::get('assessmentId')) ? Input::get('assessmentId') : '';
        $confirmation = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','assessment/confirm?assessmentId='.$assessmentId,false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);
        return response()->json($confirmation);
    }
    public function rejection()
    {
        $assessmentId = !empty(Input::get('assessmentId')) ? Input::get('assessmentId') : '';
        $rejection = Service::request([
            'method'  => 'POST',
            'url'     => Service::url('hr','assessment/reject?assessmentId='.$assessmentId,false),
            'params'  => [
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);
        return response()->json($rejection);
    }
}