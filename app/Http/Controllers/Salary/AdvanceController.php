<?php

namespace App\Http\Controllers\Salary;

use App\Library\Service\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdvanceController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'sc'     => ['id', 'userId.id', 'userId.firstName', 'userId.lastName', 'userId.patronymic', 'isClosed', 'isPercent', 'value'],
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => ['userId.firstName' => $this->search]
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserAdvance'
                    ]
                ]
            ]);

            $page = $this->page;

            if ($request->ajax() && $this->load != true) {

                $data->page = $this->page;

                return response()->json($data);

            } elseif ($this->load == true) {

                return view('pages.salary.advance.index', compact('data', 'page'));

            } else {

                return redirect(url('/salary'));

            }
        } catch (\Exception $e) {

            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());

        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {

            $isClosed  = !$request->has('isActive');

            $isPercent =  $request->has('isPercent');

            $data = Service::request([
                'method' => 'POST',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserAdvance'
                    ],
                    'json' => [
                        'userId'    => ['id' => $request['userId']],
                        'value'     => $request['value'],
                        'isPercent' => $isPercent,
                        'isClosed'  => $isClosed
                    ]
                ]
            ]);

            $data->body['data']['fullName'] = self::getFullNameByUserId($request['userId']);

            return response()->json($data);

        } catch (\Exception $e) {

            $response = (object)[
                'code'    => $e->getCode(),
                'message' => $e->getMessage()
            ];

            return response()->json($response);
        }
    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        try {

            $data = Service::request([
                'method' => 'GET',
                'url'    => Service::url('hr', 'crud'),
                'params' => [
                    'id' => $id,
                    'sc' => ['id', 'userId.id', 'userId.firstName', 'userId.lastName', 'userId.patronymic','isClosed', 'isPercent', 'value']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'UserAdvance'
                    ]
                ]
            ]);

            return response()->json($data);

        } catch (\Exception $e) {

            return exceptionH(\Request::ajax(), $e->getCode(), $e->getMessage());

        }
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        try {

            $isClosed  = !$request->has('isActive');

            $isPercent =  $request->has('isPercent');

            $data = Service::request([
                'method' => 'PUT',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'UserAdvance'
                    ],
                    'json' => [
                        'id'        => $id,
                        'userId'    => ['id' => $request['userId']],
                        'value'     => $request['value'],
                        'isPercent' => $isPercent,
                        'isClosed'  => $isClosed
                    ]
                ]
            ]);

            $data->data->fullName = self::getFullNameByUserId($request['userId']);

            return response()->json($data);

        } catch (\Exception $e) {

            $response = (object)[
                'code'    => $e->getCode(),
                'message' => $e->getMessage()
            ];

            return response()->json($response);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function getFullNameByUserId($id)
    {
        $data = Service::request([
            'method' => 'GET',
            'url' => Service::url('hr', 'crud'),
            'params' => [
                'id' => $id,
                'sc' => ['id', 'firstName', 'lastName', 'patronymic'],
            ],
            'options' => [
                'headers' => [
                    'TableName' => 'Users'
                ]
            ]
        ]);

        return $data->data->lastName . ' ' . $data->data->firstName . ' ' . $data->data->patronymic;
    }

}