<?php
namespace App\Http\Controllers\PersonalCards;

use App\Http\Requests\PersonalCards\UserSicklistRequest;
use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class UserSicklistController extends Controller
{

    private $tableName = 'UserSickList';
    /**
     * Display a listing of the resource.

     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        try{
            $sc = ['id','sickStartDate','sickEndDate','organizationName','sickNote'];
            $search = !empty($this->search) ? '"sickNote":%7B"contains":"'.$this->search.'"%7D,':'';

            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('hr','crud'),
                'params'  => [
                    'sc'     => $sc,
                    'offset' => $this->offset,
                    'max'    => $this->limit,
                    'filter' => $search.'"userId.id" : %7B "=" : "'.selected()->userId.'" %7D'
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

//            if($data->totalCount > 0){
//                $nc = nc($data,$sc, 'UserSickListNC');
//
//                $data = $nc->data;
//                $new  = $nc->newNC;
//            }

//            $checkButtons = Service::request([
//                'method' => 'POST',
//                'url'    => Service::url('csec','Token/checkTokenMany', false),
//                'params' => [],
//                'options'=> [
//
//                    'headers' => ['TableName' => 'ListApplication'],
//                    'json'    => [
//                        "services" => [
//                            0 => [
//                                "name" => "/crud/UserSickList/insert",
//                                "type" =>  "POST"
//                            ]
//
//                        ]
//                    ]
//
//                ]
//            ]);
//
//            if(is_array($checkButtons->data->permissions)){
//
//                $data->permission=$checkButtons->data->permissions;
//            }

            if ($data->totalCount != 0){
                foreach ($data->data as $value){
                    $value->sickStartDate = date('d.m.Y' , strtotime($value->sickStartDate));
                    $value->sickEndDate = date('d.m.Y' , strtotime($value->sickEndDate));
                }
            }

            $page = $this->page;
            if ($request->ajax() && $this->load != true) {
                $data->page = $this->page;

                return response()->json($data);
            }elseif($this->load == true){
                return view('pages.personal_cards.sicklist.index' , compact('data','page'));
            }else{
                return redirect(url('/personal-cards'));
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
    public function store(UserSicklistRequest $request)
    {
        try{
            $data = Service::request([
                'method' => 'POST',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName,
                    ],
                    'json' => [
                        'organizationName' => $request->organizationName,
                        'sickStartDate' => date('U',strtotime($request->startDate))*1000,
                        'sickEndDate' =>date('U', strtotime($request->endDate))*1000,
                        'sickNote' => $request->note,
                        'userId' => [
                            'id'    => selected()->userId
                        ]
                    ]
                ]
            ]);
            if ($data->code == 201){
                $data->body['data']['sickStartDate'] = !empty($data->body['data']['sickStartDate']) ? date('d.m.Y' , gmdate($data->body['data']['sickStartDate']/1000)) : '';
                $data->body['data']['sickEndDate'] = !empty($data->body['data']['sickEndDate']) ? date('d.m.Y' , gmdate($data->body['data']['sickEndDate']/1000)) : '';
                return response()->json($data);
            }
            return 500;
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
                'method' => 'GET',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'id' => $id,
                    'sc' => ['id','sickStartDate','sickEndDate','organizationName','sickNote']
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName,
                    ]
                ]
            ]);

            $response = [
                'fields' => [

                    'startDate' => !empty($data->data->sickStartDate) ? date('d.m.Y' , strtotime($data->data->sickStartDate)) : '',
                    'endDate' =>   !empty($data->data->sickEndDate) ? date('d.m.Y' , strtotime($data->data->sickEndDate)) : '',
                    'organizationName' => $data->data->organizationName,
                    'note' => $data->data->sickNote,

                ],
                'id' => $data->data->id,
                'code' => $data->code,
                'url' => route('sicklist.update', $data->data->id)
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
    public function update(UserSicklistRequest $request, $id)
    {
        try{
            $data= Service::request([
                'method' => 'PUT',
                'url' => Service::url('hr', 'crud'),
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName,
                    ],
                    'json' => [
                        'id' => $id,
                        'organizationName' => $request->organizationName,
                        'sickStartDate' => date('U',strtotime($request->startDate))*1000,
                        'sickEndDate' =>date('U', strtotime($request->endDate))*1000,
                        'sickNote' => $request->note,
                        'userId' => [
                            'id' => selected()->userId
                        ]
                    ]
                ]
            ]);
            $data->data->sickStartDate = !empty($data->data->sickStartDate) ? date('d.m.Y' , gmdate($data->data->sickStartDate)) : '';
            $data->data->sickEndDate = !empty($data->data->sickEndDate) ? date('d.m.Y' , gmdate($data->data->sickEndDate)) : '';

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
                'method' => 'DELETE',
                'url' => Service::url('hr', 'crud'),
                'params' => [
                    'id' => $id
                ],
                'options' => [
                    'headers' => [
                        'TableName' => $this->tableName
                    ]
                ]
            ]);

            return $data->code;
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

}

