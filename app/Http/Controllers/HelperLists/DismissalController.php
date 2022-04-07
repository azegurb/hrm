<?php

namespace App\Http\Controllers\HelperLists;


use App\Http\Requests\HelperLists\DismissalRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DismissalController extends Controller
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
                    'sc'     => ['id,name'],
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => ['name' => $this->search]
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListDismissalType'
                    ]
                ]
            ]);

            $page = $this->page;
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;

                return response()->json($data);
            }elseif($this->load == true){
                return view('pages.helper_lists.dismissal.index' , compact('data','page'));
            }else{
                return redirect(url('/helper-lists'));
            }
        }catch (\Exception $e){
            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return response()->json($response);
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
    public function store(DismissalRequest $request)
    {
        try{
            $data = Service::request([
                'method'  => 'POST',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'ListDismissalType'
                    ],
                    'json' => [
                        'name'      => $request->input_dismissal
                    ]
                ]
            ]);
            return response()->json($data);
        }catch (\Exception $e){
            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return response()->json($response);
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
                    'sc'     => ['id','name'],
                ],
                'options' => [
                    'headers' => [
                        'TableName' => 'ListDismissalType'
                    ]
                ]
            ]);
            $response = [
                'fields' => [
                    'input_dismissal'     => $data->data->name
                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('dismissal.update', $data->data->id)
            ];

            return response()->json($response);
        }catch (\Exception $e){
            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DismissalRequest $request, $id)
    {
        try{
            $data = Service::request([
                'method'  => 'PUT',
                'url'     => Service::url('hr','crud'),
                'options' => [
                    'headers' => [
                        'TableName' => 'ListDismissalType'
                    ],
                    'json' => [
                        'id'   => $id,
                        'name' => $request->input_dismissal
                    ]
                ]
            ]);

            return response()->json($data);
        }catch (\Exception $e){
            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return response()->json($response);
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
                        'TableName' => 'ListDismissalType'
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
            $response = (object)[
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return response()->json($response);
        }
    }
}
