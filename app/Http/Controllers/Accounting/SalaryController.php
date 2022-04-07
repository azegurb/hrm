<?php

namespace App\Http\Controllers\Accounting;

use App\Library\Ws\Filter;
use App\Payment;
use App\UserPayments;
use App\UserPositions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    /**
     * List cotents index page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $year     = \Request::has('year')  ? \Request::get('year') : date('Y');

        $month    = \Request::has('month') ? \Request::get('month') : date('m');

        $options  = [
            'sc'     => [
                'userPaymentsId.userId.id',
                'userPaymentsId.userId.firstName',
                'userPaymentsId.userId.lastName',
                'userPaymentsId.userId.patronymic',
                'taxSum',
                'spfSum',
                'salary',
                'laborConditionsSum',
                'userPaymentsId.paymentDate',
                'userPaymentsId.workDayNorm',
                'userPaymentsId.workDayHourNorm',
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
            'max'    => $this->limit,
            'offset' => $this->offset,
            'sort'   => 'userPaymentsId.isPaid',
            'order'  => 'asc',
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

        $byName   = [
            [
                'field' => 'userPaymentsId.userId.firstName',
                'type'  => Filter::TYPE_CONTAINS,
                'value' => \Request::get('q')
            ]
        ];

        $options['filter']  = \Request::has('q') ? array_merge($options['filter'], $byName) : $options['filter'];

        $response = UserPayments::fetch($options);

        $users    = UserPayments::hasEntities($response) ? $response->data->entities : [];

        if (\Request::ajax() && \Request::has('async')) {
            return response()->json($response);
        }

        $page     = $this->page;

        $limit    = $this->limit;

        $total    = $response->total;

        return view('pages.accounting.salary.salary', compact('users', 'page', 'total', 'limit'));
    }

    /**
     * Gets detailed info about payment
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetailedPaymentInfo()
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
            'filter' => [
                [
                    'field' => 'userPaymentsId.userId.id',
                    'type'  => Filter::TYPE_EQUALS,
                    'value' => $userId
                ],
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

        $user     = UserPayments::hasEntities($response) ? $response->data->entities[0] : new \stdClass();

        return view('pages.accounting.payment-info', compact('user', 'position', 'year', 'month'));
    }

    /**
     * Refresh user list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $users           = \Request::get('users');

        $body            = [];

        $body['userIds'] = $users;

        $body['date']    = \Request::has('date') ? \Request::get('date') : date('Y-m-d');

        $data            = Payment::refresh($body);

        return response()->json($data);
    }

    /**
     * Refresh user list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate()
    {
        $body         = [];

        $body['date'] = \Request::has('date') ? \Request::get('date') : date('Y-m-d');

        $data         = Payment::calculate($body);

        return response()->json($data);
    }

    /**
     * Closes payment for current month
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function close()
    {
        $body              = [];

        $body['year']      = \Request::has('year')   ? \Request::get('year') : date('Y');

        $body['month']     = \Request::has('month')  ? \Request::get('month') : date('m');

        $body['tableName'] = 'UserPayments';

        $data              =  Payment::close($body);

        return response()->json($data);
    }
}
