<?php

namespace App\Http\Controllers\Accounting;

use App\UserAdvancePayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserPayments;
use App\Library\Ws\Filter;
use App\UserPositions;

class ExportController extends Controller
{
    /**
     * Return export page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.accounting.export.export');
    }

    /**
     * Return html to export as excel
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSalaryTemplate()
    {
        $year     = \Request::has('year')  ? \Request::get('year') : date('Y');

        $month    = \Request::has('month') ? \Request::get('month') : date('m');

        $options  = [
            'sc'     => [
                'userPaymentsId.userId.firstName',
                'userPaymentsId.userId.lastName',
                'userPaymentsId.userId.patronymic',
                'userPaymentsId.userId.bankAccount',
                'totalPaymentSum'
            ],
            'filter' => [
                [
                    'field' => 'userPaymentsId.year',
                    'type'  => Filter::TYPE_EQUALS,
                    'value' => $year
                ],
                [
                    'field' => 'userPaymentsId.month',
                    'type'  => Filter::TYPE_EQUALS,
                    'value' => $month
                ]
            ]
        ];

        $response = UserPayments::fetch($options);

        $users    = UserPayments::hasEntities($response) ? $response->data->entities : [];

        return view('pages.accounting.export.template', compact('users'));
    }

    /**
     * Returns payment template table for advance payments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdvanceTemplate()
    {
        $year     = \Request::has('year')  ? \Request::get('year') : date('Y');

        $month    = \Request::has('month') ? \Request::get('month') : date('m');

        $options  = [
            'sc'     => [
                'userId.firstName',
                'userId.lastName',
                'userId.patronymic',
                'userId.bankAccount',
                'totalPaymentSum'
            ],
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

        $response = UserAdvancePayment::fetch($options);

        $users    = UserAdvancePayment::hasEntities($response) ? $response->data->entities : [];

        return view('pages.accounting.export.template', compact('users'));
    }

    /**
     * Return html to export as PDF
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndividualTemplate()
    {
        $userId   = \Request::get('userId');

        $year     = \Request::has('year')  ? \Request::get('year') : date('Y');

        $month    = \Request::has('month') ? \Request::get('month') : date('m');

        $position = UserPositions::fetch([
            'sc'     => ['positionId.posNameId.name', 'positionId.structureId.name'],
            'filter' => [
                [
                    'field' => 'userId.id',
                    'type'  => Filter::TYPE_EQUALS,
                    'value' => $userId
                ],
                [
                    'field' => 'isclosed',
                    'type'  => Filter::TYPE_EQUALS,
                    'value' => 'false'
                ]
            ]
        ]);

        $position = UserPositions::hasEntities($position) ? $position->data->entities[0] : new \stdClass();

        $options  = [
            'sc'     => [
                'userPaymentsId.userId.id',
                'userPaymentsId.userId.firstName',
                'userPaymentsId.userId.lastName',
                'userPaymentsId.userId.patronymic',
                'userPaymentsId.userId.photo',
                'userPaymentsId.userId.docNumber',
                'userPaymentsId.userId.pin',
                'taxSum',
                'spfSum',
                'salary',
                'laborConditionsSum',
                'userPaymentsId.paymentDate',
                'addPaymentSum',
                'advanceSum',
                'tradeUnionSum',
                'totalPaymentSum',
                'userPaymentsId.workDayFact',
                'userPaymentsId.workDayNorm',
                'userPaymentsId.workDayHourNorm',
                'userPaymentsId.workHourFact',
                'workHourFactSum',
                'userPaymentsId.workHollidayDay',
                'userPaymentsId.workHollidayHour',
                'userPaymentsId.workNightHour',
                'userPaymentsId.workNightHour1',
                'userPaymentsId.workNightHour2',
                'workNightHourSum',
                'workHollidaySum',
                'privilegeSum',
                'endCalcSum',
                'totalDeductSum',
                'userPaymentsId.month',
                'userPaymentsId.year',
                'userPaymentsId.isPaid'
            ],
            'max'    => $this->limit,
            'offset' => $this->offset,
            'filter' => [
                [
                    'field' => 'userPaymentsId.year',
                    'type'  => Filter::TYPE_EQUALS,
                    'value' => $year
                ],
                [
                    'field' => 'userPaymentsId.month',
                    'type'  => Filter::TYPE_EQUALS,
                    'value' => $month
                ],
                [
                    'field' => 'userPaymentsId.userId.id',
                    'type'  => Filter::TYPE_EQUALS,
                    'value' => $userId
                ]
            ]
        ];

        $response = UserPayments::fetch($options);

        $payment  = UserPayments::hasEntities($response) ? $response->data->entities[0] : [];

        return view('pages.accounting.export.template-individual', compact('payment', 'position'));
    }
}
