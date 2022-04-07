<?php

namespace App\Http\Controllers\StaffTable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library\Service\Service;

class RelPositionPaymentController extends Controller
{
    /**
     * @var string
     */
    private $tableName = 'RelPositionPayment';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     *
     * Get payments by position id
     *
     * @param $positionNameId
     * @param $structureId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPositionPaymentsByPositionNameId($positionNameId, $structureId)
    {
        try {

            /* position salaries */
            $paymentTypeLabel = 'position_salary';

            /* new position controller  */
            $positionController = new PositionController();

            /* get position ids by position name id */
            $positionIds = $positionController->getPositionsByPositionNameId($positionNameId, $structureId);

            /* generate array for "in" query */
            $inArray = '';

            foreach ($positionIds as $key => $positionId)
            {
                $inArray .= $positionId->id;
                /* append comma if it is not the end */
                if ($key != count($positionIds)-1)
                    $inArray .= ',';
            }

            /* filter param  */
            $queryString = '"paymentTypeId.label":%7B"=": "'.$paymentTypeLabel.'"%7D,"positionId.id":%7B"in":"'.$inArray.'"%7D';

            /* make service call */
            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => [ 'id', 'value', 'positionId.id'],
                    'filter' => $queryString
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            $select = [];

            /* generate select2 array */
            if ($data->totalCount > 0) {

                foreach ($data->data as $item) {

                    $select[] = (object)[
                        'id'   => $item->positionIdId,
                        'text' => $item->value
                    ];

                }

            }
            
            /* return json object */
            return response()->json($select);

        } catch (\Exception $e){

            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());

        }
    }

    /**
     * Get position payments by position id
     * @param $positionId
     * @param $paymentTypeId
     * @return object
     */
    public function getPaymentsByPositionId($positionId, $paymentTypeId = 4)
    {
        try {

            $filter = '"paymentTypeId.id":%7B"=":"'.$paymentTypeId.'"%7D, "positionId.id":%7B"=":"'.$positionId.'"%7D';

            /* set payment type null if you want to get all posiiton payments */
            if ($paymentTypeId == null)
            {
                $filter = '"positionId.id":%7B"=":"'.$positionId.'"%7D';

            } else if ($paymentTypeId != null && !is_numeric($paymentTypeId)) {

                $filter = '"paymentTypeId.label":%7B"=":"'.$paymentTypeId.'"%7D, "positionId.id":%7B"=":"'.$positionId.'"%7D';

            }

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id', 'paymentTypeId.id','value'],
                    'filter' => $filter
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            return $data;

        } catch (\Exception $e){

            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());

        }
    }

    public function getPosData($positionId){
        $dataSalary = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id', 'paymentTypeId.id','value'],
                'filter' => '"paymentTypeId.id":%7B"=":"1"%7D, "positionId.id":%7B"=":"'.$positionId.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => $this->tableName
                ]
            ]
        ]);


        if(isset($dataSalary->data[0]->value)){
            $data['salary'] = $dataSalary->data[0]->value;
        }else{
            $data['salary'] = null;
        }

        $dataCount = Service::request([
            'method' => 'GET',
            'url'    => Service::url('hr', 'crud'),
            'params' => [
                'sc'     => ['id','count'],
                'filter' => '"id":%7B"=":"'.$positionId.'"%7D'
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Position'
                ]
            ]
        ]);

        if(isset($dataCount->data[0]->count)){
            $data['count'] = $dataCount->data[0]->count;
        }else{
            $data['count'] = null;
        }
        return $data;

    }
}
