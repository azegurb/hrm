<?php

namespace App\Http\Controllers\PersonalCards;

use App\Http\Controllers\StaffTable\PositionController;
use App\Http\Controllers\StaffTable\RelPositionPaymentController;
use App\Http\Controllers\StaffTable\RelUserPaymentsController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Service\Service;

class SalaryPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {

            $data = new \stdClass();

            // -- // Güzəştlər Start // -- //

            $dataPriv = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'privilegeId.name', 'privilegeId.value'],
                    'offset' => $this->offset,
                    'max' => $this->limit,
                    'filter' => '"userId.id" : %7B "=" : "' . selected()->userId . '" %7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'RelUserPrivilege'
                    ]
                ]
            ]);

            $dataUserPayments = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => [
                        'taxSum',
                        'spfSum',
                        'salary',
                        'laborConditionsSum',
                        'userPaymentsId.paymentDate',
                        'userPaymentsId.workDayNorm',
                        'userPaymentsId.workDayHourNorm',
                        'userPaymentsId.year',
                        'userPaymentsId.month',
                        'addPaymentSum',
                        'advanceSum',
                        'tradeUnionSum',
                        'totalPaymentSum',
                        'workHourFactSum',
                        'workNightHourSum',
                        'workHollidaySum',
                        'privilegeSum',
                        'endCalcSum',
                        'totalDeductSum',
                        'userPaymentsId.isPaid'
                    ],
                    'filter' => '"userPaymentsId.userId.id" : %7B "=" : "' . selected()->userId . '" %7D',
                    'sort'  => 'userPaymentsId.month',
                    'order' => 'asc'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserPaymentsAdd'
                    ]
                ]
            ]);
            /* Start -> Əməkdaşın maaşı */

            $userPaymentsController = new RelUserPaymentsController();
            $positionPaymentsController = new RelPositionPaymentController();
            $positionController = new PositionController();

            $userPayment = 0; /* işçinin əlavə əmək haqqı */
            $positionPayment = 0; /* işçinin vəzifə maaşı */
            $conditionalPayment = 0; /* əmək şəraitinə görə əlavə əmək haqqı */

            $userPayments = $userPaymentsController->getAllUserPayments(selected()->userId);
            $positionId = $positionController->getPositionByUser(selected()->userId);
            $positionPayments = $positionPaymentsController->getPaymentsByPositionId($positionId, 1);
            $conditionalPayments = $positionPaymentsController->getPaymentsByPositionId($positionId, 'conditions');

            $userPayment = isset($userPayments->totalCount) && $userPayments->totalCount > 0 ?
                $userPayments->data[0]->valus : $userPayment;

            $positionPayment = isset($positionPayments->totalCount) && $positionPayments->totalCount > 0 ?
                $positionPayments->data[0]->value : $positionPayment;

            $conditionalPayment = isset($conditionalPayments->totalCount) && $conditionalPayments->totalCount > 0 ?
                ($positionPayment * $conditionalPayments->data[0]->value) / 100 : $conditionalPayment;

            $totalIncome = $userPayment + $positionPayment + $conditionalPayment;

            /* create payments objects  */
            $payments = (object)[
                'userPayment' => $userPayment,
                'positionPayment' => $positionPayment,
                'conditionalPayment' => $conditionalPayment,
                'totalIncome' => $totalIncome
            ];

            $data->payments = $payments; /* add payments property to data object */

            $data->salaryU = $dataUserPayments->data;

            /* End   -> Əməkdaşın maaşı */
            if (isset($dataPriv) && isset($dataPriv->totalCout) && $dataPriv->totalCount > 0) {

                $data->privileges = $dataPriv->data[0];
                $data->privileges->result = true;
            }

            $page = $this->page;

            if ($request->ajax() && $this->load != true) {

                $data->page = $this->page;

                return response()->json($data);

            } elseif ($this->load == true) {

                return view('pages.personal_cards.salaryperson.index', compact('data', 'page'));
            } else {

                return redirect(url('/personal-cards'));
            }

        } catch (\Exception $e) {

            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
