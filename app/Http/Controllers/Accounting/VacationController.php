<?php

namespace App\Http\Controllers\Accounting;

use App\UserPaymentVacation;
use App\Library\Ws\Filter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VacationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $year     = \Request::has('year')  ? \Request::get('year') : date('Y');

        $month    = \Request::has('month') ? \Request::get('month') : date('m');

        $options  = [
            'sc'     => [
                'userId.id',
                'userId.firstName',
                'userId.lastName',
                'userId.patronymic',
                'userId.bankAccount',
                'taxSum',
                'spfSum',
                'salary',
                'laborConditionsSum',
                'paymentDate',
                'addPaymentSum',
                'advanceSum',
                'tradeUnionSum',
                'totalPaymentSum',
                'workDayFact',
                'privilegeSum',
                'endCalcSum',
                'totalDeductSum',
                'isPaid'
            ],
            'max'    => $this->limit,
            'offset' => $this->offset,
            'filter' => [
                [
                    'field' => 'year',
                    'type'  => Filter::TYPE_EQUALS,
                    'value' => $year
                ],
                [
                    'field' => 'month',
                    'type'  => Filter::TYPE_EQUALS,
                    'value' => $month
                ]
            ]
        ];

        $byName   = [
            [
                'field' => 'userId.firstName',
                'type'  => Filter::TYPE_CONTAINS,
                'value' => \Request::get('q')
            ]
        ];

        $options['filter']  = \Request::has('q') ? array_merge($options['filter'], $byName) : $options['filter'];

        $response = UserPaymentVacation::fetch($options);

        $users    = UserPaymentVacation::hasEntities($response) ? $response->data->entities : [];

        if (\Request::ajax() && \Request::has('async')) {
            return response()->json($response);
        }

        $page     = $this->page;

        $limit    = $this->limit;

        $total    = $response->total;

        return view('pages.accounting.vacation.vacation', compact('users', 'page', 'total', 'limit'));
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
}
