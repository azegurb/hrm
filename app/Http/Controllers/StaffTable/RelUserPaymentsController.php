<?php

namespace App\Http\Controllers\StaffTable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library\Service\Service;
use Illuminate\Support\Facades\Request as RequestFacede;

class RelUserPaymentsController extends Controller
{
    /**
     * @var string
     */
    private $tableName = 'RelUserPayments';

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

    /**
     * get user payment by user id
     * @param $userId
     * @param $paymentTypeLabel
     * @return \Illuminate\Http\JsonResponse|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public function getUserPaymentByUser($userId, $paymentTypeLabel = null)
    {
        try {

            $filterByUser = '"userId.id":{"=":"' . $userId . '"}';

            $filterByUserAndLabel = '"userId.id":{"=":"' . $userId . '"}, "paymentTypeId.label":{"=":"' . $paymentTypeLabel . '"}';

            $filter = $paymentTypeLabel != null ? $filterByUserAndLabel : $filterByUser;

            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => ['id', 'paymentTypeId.id', 'paymentTypeId.label', 'valus', 'isPercent', 'isClosed'],
                    'filter' => $filter
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            if (RequestFacede::ajax()) {
                return response()->json($data);
            } else {
                return $data;
            }

        } catch (\Exception $exception) {

            return exceptionH(\Request::ajax(), $exception->getCode(), $exception->getMessage());

        }
    }

    /**
     * Get all user payments for
     * @param $userId
     * @return object
     */
    public function getAllUserPayments($userId)
    {
        try {

            $filterByUser = '"userId.id":{"=":"' . $userId . '"}';

            $data = Service::request([
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'sc' => [
                        'id',
                        'valus',
                        'isClosed',
                        'isPercent',
                        'paymentTypeId.id',
                        'paymentTypeId.label',
                        'paymentTypeId.itemName'
                    ],
                    'filter' => $filterByUser
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            return $data;

        } catch (\Exception $exception) {

            return exceptionH(\Request::ajax(), $exception->getCode(), $exception->getMessage());

        }
    }
}
