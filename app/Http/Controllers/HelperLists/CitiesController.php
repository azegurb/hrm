<?php

namespace App\Http\Controllers\HelperLists;

use App\Http\Requests\HelperLists\CitiesRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'     => ['id,name,listCountyId'],
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => ['name' => $this->search]
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListCity'
                    ]
                ]
            ]);

            $page = $this->page;
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;

                return response()->json($data);
            }elseif($this->load == true){
                return view('pages.helper_lists.cities.index' , compact('data','page'));
            }else{
                return redirect(url('/helper-lists'));
            }
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
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
        try{
            $data = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'ListCity'
                    ],
                    'json' => [
                        'name'      => $request->input_city,
                        'listCountyId' => [
                            'id' => $request->input_country
                        ]
                    ]
                ]
            ]);

            return response()->json($data);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
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
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'  => $id,
                    'sc'     => ['id,name,listCountyId.name,listCountyId.id'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListCity'
                    ],
                ]
            ]);

            $response = [
                'fields' => [
                    'input_city'     => $data->data->name,
                    'input_country' => [
                        'text' => $data->data->listCountyIdName,
                        'id' => $data->data->listCountyIdId
                    ],
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('cities.update', $data->data->id)
            ];

            return response()->json($response);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
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
        try{
            $data = Service::request([
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'ListCity'
                    ],
                    'json' => [
                        'id'  => $id,
                        'name' => $request->input_city,
                        'listCountyId' => [
                            'id' => $request->input_country,
                            'name' => CitiesController::givename_country($request->input_country)
                        ],
                    ]
                ]
            ]);

            return response()->json($data);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $data = Service::request([
                'method'  => 'DELETE',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'  => $id
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListCity'
                    ]
                ]
            ]);
            if($data->data != null){
                $data->code = 999;

            }else if ($data->data == null){
                $data->code = $data->code;
            }

            return $data->code;
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function countries(){

        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'    => ['id','name']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListCountry'
                    ]
                ]
            ]);

            $select = [];

            foreach ($data->data as $item){
                $select[] = (object)[
                    'text' => $item->name,
                    'id'  => $item->id,
                ];
            }

            return response()->json($select);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function givename_country($id){
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'      => $id,
                    'sc'      => ['id','name']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListCountry',
                    ]
                ]
            ]);

            return($data->data->name);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

}
