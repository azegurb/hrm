<?php

namespace App\Http\Controllers\Accounting;

use App\UserAdvancePayment;
use App\Payment;
use Illuminate\Http\Request;
use App\Library\Ws\Filter;
use App\Http\Controllers\Controller;

class AdvanceController extends Controller
{
    /**
     * List contents of your page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $year     = \Request::has('year')  ? \Request::get('year') : date('Y');

        $month    = \Request::has('month') ? \Request::get('month') : date('m');

        $options  = [
            'sc' => [
                'userId.id',
                'userId.firstName',
                'userId.lastName',
                'userId.patronymic',
                'salary',
                'totalPaymentSum',
                'isPercent',
                'percentSum',
                'workDayFact',
                'workDayNorm',
                'workDayHourFact',
                'workDayHourNorm',
                'paymentDate',
                'isPaid'
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
            ],
            'max'    => $this->limit,
            'offset' => $this->offset
        ];

        $filter   = [
            'filter' => [
                [
                    'field' => 'userId.firstName',
                    'type'  => Filter::TYPE_CONTAINS,
                    'value' => \Request::get('q')
                ]
            ]
        ];

        $options  = \Request::has('q') ? array_merge($options, $filter) : $options;

        $response = UserAdvancePayment::fetch($options);

        $users    = UserAdvancePayment::hasEntities($response) ? $response->data->entities : [];

        if (\Request::ajax() && \Request::has('async')) {
            return response()->json($response);
        }

        $page     = $this->page;

        $limit    = $this->limit;

        $total    = $response->total;

        return view('pages.accounting.advance.advance', compact('users', 'page', 'total', 'limit'));
    }

    /**
     * Refresh user list
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $users           = \Request::get('users');

        $body            = [];

        $body['userIds'] = $users;

        $body['date']    = \Request::get('date') ? \Request::get('date') : date('Y-m-d');

        $data            = UserAdvancePayment::refresh($body);

        return response()->json($data);
    }

    /**
     * Refresh user list
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate()
    {
        $body         = [];

        $body['date'] = \Request::get('date') ? \Request::get('date') : date('Y-m-d');

        $data         = UserAdvancePayment::calculate($body);

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

        $body['tableName'] = 'UserAdvancePayment';

        $data              =  Payment::close($body);

        return response()->json($data);
    }
}
