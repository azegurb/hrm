<?php

namespace App\Http\Controllers\Orders;

use App\Library\Service\Service;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\queue;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Input;

class OrderVacationController extends Controller
{
    /**
     * Instance TableName
     * @var string
     */
    private $tableName = 'OrderVacation';

    /**
     * Getting OrderBusinessTripList by orderCommonId.id
     * @param $id
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function getOrderVacation($id)
    {
        $childData = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [

                'sc' => ['id', 'listVacationTypeId.name','vacationComment','listVacationTypeId.id','userId.id','userId.firstName','userId.lastName','userId.patronymic','positionId.id'],

                'filter' => '"orderCommonId.id":{"=":"'.$id.'"}'
            ],
            'options' => [
                'headers' => [
                    'TableName' => $this->tableName
                ]
            ]
        ]);

        $wsData = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [

                'sc' => ['id','workStartDate','startDate'],

                'filter' => '"orderVacationId.id":{"=":"'. $childData->data[0]->id .'"}'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'OrderVacationDetail'
                ]
            ]
        ]);

//        $childData->data[0]->workStartDate = $wsData->data[0]->workStartDate;
        return $childData;

    }


    public function getStructurePosition($id)
    {

        $childData = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc' => ['id','structureId.id','structureId.name','posNameId.id','posNameId.name'],
                'filter' => '"id":%7B"=":"'.$id.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => "Position"
                ]
            ]
        ]);
        return $childData;
    }

    public function vacationReturnTypes(){

        $search=Input::get('q');
        $data = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [

                'sc' => ['id', 'name'],

                'filter' => '"name":{"contains":"'.$search.'"}'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'ListReturnType'
                ]
            ]
        ]);
        if ($data->totalCount > 0) {
            foreach ($data->data as $item) {
                $select[] = (object)[
                    'id' => $item->id,
                    'text' => $item->name
                ];

            }
            return response()->json($select);
        } else {
            return 404;
        }

    }

    public function getVacationDateByUser($userId, $recallDate){

        $recallDate=date('Y-m-d', strtotime($recallDate));

        $orderVacationByReturnDate= Service::request([
            'method'  => 'GET',
            'url'    => Service::url('hr', 'orderCommons/orderVacationByReturnDate?userId='.$userId.'&returnDate='.$recallDate, false),

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        if(count((array)$orderVacationByReturnDate->data)=='0'){

            return response()->json(['code'=>'Xəta', 'notselected'=>'Seçilmiş əməkdaş məzuniyyətdə deyil']);

        }
        else {

            return response()->json($orderVacationByReturnDate->data);

//            dd(json_encode($orderVacationByReturnDate->data));
        }
    }

    public function calculateVacationDayForRecall($totalday, $vacationStartDate, $userid){

        if($totalday=='0'){

            return response()->json(['code'=>'Xəta', 'notselected'=>'Xahiş olunur aralıq dövrünü düzgün seçəsiniz']);

        }
        else {

            $vacationEndDate=date('Y-m-d', strtotime($vacationStartDate)+$totalday*86400);

            $vacationStartDate=date('Y-m-d', strtotime($vacationStartDate));

        }

        $checkVacationDay= Service::request([
            'method'  => 'GET',
            'url'    => Service::url('hr', 'orderCommons/restDays?startDate='.$vacationStartDate.'&endDate='.$vacationEndDate, false),

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        $days=0;

        foreach ($checkVacationDay->data as $key=>$val){

            if(strtotime($vacationStartDate)>strtotime($checkVacationDay->data[$key]->startDate)){

                $reminderDay=(strtotime($checkVacationDay->data[$key]->endDate)-strtotime($vacationStartDate))/86400;

            }
            else {
                $reminderDay=(strtotime($checkVacationDay->data[$key]->endDate)-strtotime($checkVacationDay->data[$key]->startDate))/86400;

            }

            $days=$days+$reminderDay;
        }

        $latestEndDate=(object)['data'=>date('d.m.Y', strtotime($vacationEndDate)-86400)];

        $lastendDate=date('Y-m-d', strtotime($vacationEndDate)-86400);

//        dd($lastendDate, $vacationStartDate);
//        ddip($checkVacationDay, '192.168.35.14');


        $controlVacationDay= Service::request([
            'method'  => 'GET',
            'url'    => Service::url('hr', 'orderCommons/vacationControl?userId='.$userid.'&fromDate='.$vacationStartDate.'&toDate='.$lastendDate, false),

            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);

        return response()->json($latestEndDate);

    }

}
