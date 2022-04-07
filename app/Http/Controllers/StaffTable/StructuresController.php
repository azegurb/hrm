<?php

namespace App\Http\Controllers\StaffTable;

use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class StructuresController extends Controller
{


    public function tree($type='')

    {
//        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','tree'),
                'params'  => [
                    'sc'     => [],

                    'isClosed'=> 'false'

                ],
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ]
                ]
            ]);
            if(Input::get('refresh')){
                return response()->json($data->data);
            }
            if(Input::get('bool')==true){
                return response()->json($data->data);

            }
            return $data->data;
//        }catch (\Exception $e){
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//        }
    }


    public function treea(Request $request)

    {


        $data = Service::request([
            'method'  => 'GET',
            'url'     => Service::url('hr','tree'),
            'params'  => [
                'sc'     => [],
            ],
            'options' => [
                'headers' => [
                    'TableName' => ''
                ]
            ]
        ]);


        if(Input::get('refresh')){
            return response()->json($data->data);
        }
        if(Input::get('bool')==true){
            return response()->json($data->data);

        }
        return $data->data;
//        }catch (\Exception $e){
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//        }
    }

    public function store(Request $request)
    {
//        try{
            $requestData = [
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'Structures'
                    ],
                    'json' => [
                        'name' => $request->name,
                        'structuretypeid' => [
                            'id'    => $request->structurestype
                        ]
                    ]
                ]
            ];
            if(!empty($request->structures) && $request->structures != null){
                $requestData['options']['json']['parentId']['id'] = $request->structures;
            }else{
                $requestData['options']['json']['parentId'] = null;
            }
            $data = Service::request($requestData);

            return response()->json($data);
//        }catch (\Exception $e){
//            exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//        }
    }

    //Get Data By Id
    public function edit($id)
    {
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'id'  => $id,
                    'sc'     => ['id','name','parentId.name','parentId.id','structuretypeid.id','structuretypeid.name'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'Structures'
                    ]
                ]
            ]);
            $response = [
                'fields' => [
                    'structures' => [
                        'id' => $data->data->parentIdId,
                        'text' => $data->data->parentIdName
                    ],
                    'structurestype' => [
                        'id' => $data->data->structuretypeidId,
                        'text' => $data->data->structuretypeidName
                    ],
                    'name' => $data->data->name,
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('structures.update', $data->data->id)
            ];
            return response()->json($response);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function update(Request $request , $id)
    {
        try{

//            dd($id, $request->name, $request->structurestype);
        $requestData = [
            'method'  => 'PUT',
            'url'     => Service::url('hr','crud'),
            'options' => [
                'headers' => [
                    'TableName' => 'Structures'
                ],
                'json' => [
                    'id'    => $id,
                    'name' => $request->name,
                     'structuretypeid' => [
                        'id'    => $request->structurestype
                    ]
                ]
            ]
        ];
            if(!empty($request->structures) && $request->structures != null){
                $requestData['options']['json']['parentId']['id'] = $request->structures;
            }else{
                $requestData['options']['json']['parentId'] = null;
            }
        $data = Service::request($requestData);

        return response()->json($data);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $requestData = Service::request([
                'method' => 'PUT',
                'url'    => Service::url('hr','structures/structuresClose/'.$id, false),
                'params' => [],
                'options'=> [
                    'headers' => ['TableName' => 'Structures'],
                ]
            ]);


            return response()->json($requestData);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

}
