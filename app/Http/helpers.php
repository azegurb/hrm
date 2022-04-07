<?php

if( ! function_exists('hidden_field'))
{
    function hidden_field($method)
    {
        return '<input type="hidden" name="_method" value="'.strtoupper($method).'">';
    }
    function dateChecker($count , $data)
    {
        $time = (object)[];
        for($j = 0; $j < count($data->date); $j++){
            if($data->date[$j] == $count){
                $time->start = $data->startDate[$j];
                $time->end = $data->endDate[$j];
            }
        }
        return $time;
    }
    function priviligies()
    {
        $userGroups = [2];
        if (in_array(12, $userGroups) || in_array(2, $userGroups)) {
            $usertype = 1;
        } elseif (in_array(1013, $userGroups)) {
            $usertype = 4;
        } elseif (in_array(1011, $userGroups) || in_array(1014, $userGroups) || in_array(1015, $userGroups) || in_array(2014, $userGroups)) {
            $usertype = 3;
        } elseif (in_array(1012, $userGroups)) {
            $usertype = 2;
        }
        return $usertype;
    }

    function authUser()
    {
        return !is_null(session('authUser')) ? session('authUser') : null;
    }

    function selected()
    {
        return !is_null(session('selected')) ? session('selected') : null;
    }

    function ip(){
        // Get IP
        if (array_key_exists('HTTP_X_FORWARDED_FOR', request()->server())) {

            $HTTP_X_FORWARDED_FOR = request()->server('HTTP_X_FORWARDED_FOR');
            $HTTP_X_FORWARDED_FOR = array_values(array_filter(explode(',',$HTTP_X_FORWARDED_FOR)));

            $clientIp = array_last($HTTP_X_FORWARDED_FOR);
            return $clientIp;
        }else{
            $clientIp = request()->getClientIp();
            return $clientIp;
        }
    }

    /**
     * DUMP DIE BY IP
     *
     * @param $var
     * @param string $ip
     */
    function ddip($var,$ip = '192.168.35.12'){
        if(ip() == $ip){
            dd($var);
        }
    }

    /**
     * Attach NC
     * @param array $data
     * @param array $sc
     * @param string $tableName
     * @return array
     */
    function nc($data = [],$sc = [], $tableName = ''){
//        dd($data,$sc);
        // Get NC Data

        if($tableName == '') {
            return [];
        }
        array_push($sc,'mainId','customConfirmId','');

        $dataNC = \App\Library\Service\Service::request([
            'method'  => 'GET',
            'url'     => \App\Library\Service\Service::url('hr','nc'),
            'params'  => [
                'sc'     => $sc,
                'tableName' => $tableName,
                'userId'  => selected()->userId
            ],
            'options' => [
                'headers' => [
                    'TableName' => $tableName
                ]
            ]
        ]);
        // Create NC Collection
        $collectionNC = '';
        $newNC = [];
        if(!empty($dataNC->data ) && count($dataNC->data) > 0) {
            foreach ($dataNC->data as $nc){
                $nc->mainIdId = !empty($nc->mainId) ? $nc->mainId->id : '';
                if(!empty($nc->mainId)){
                    $nc->mainIdId = $nc->mainId->id;
                }else{
                    $nc->mainIdId = '';
                    $newNC[] = $nc;
                }
            }

            if(!empty($data->data) && count($data->data) > 0) {
                $collectionNC = collect($dataNC->data);
                foreach ($data->data as $itemCheck) {
                    $foundNC = $collectionNC->filter(function ($item) use ($itemCheck) {
//                        dd($item);
                        return $item->mainIdId == $itemCheck->id;
                    })->first();
                    $itemCheck->nc = $foundNC;
                }
            }
        }

        $response = (object)[
            'data' => $data,
            'newNC' => $newNC
        ];

        return $response;
    }

    function rowG($data,$row)
    {
        $html = '';
        // Root Table
        if (strpos($row, '.')){
            $html .= '<td>'.iterator($data,$row).'</td>';
        }else{
            $html .= '<td>'.$data->$row.'</td>';
        }
        return $html;
    }

    function iterator($data,$row){
        $exploded = explode('.', $row);
        $count = count($exploded);
        $prop = $data;
        for($i = 0; $i < $count ; $i++ ){
            $propSt = $exploded[$i];
            $prop = $prop->$propSt;
        }
        return $prop;
    }

    function exceptionH($ajax,$code,$message){
        
        if($ajax){
            $response = (object)[
                'message' => !empty($message) ? $message : null,
                'code'  => $code
            ];
            return response()->json($response);
        }else{
            if ($code == 500){
                abort(500);
            }
            if($code == 401){
                abort(401);
            }
            if($code == 0){
                abort(500 , $message);
            }
            if($code == 404){
                abort(404);
            }
            abort(500);
        }
    }

    function javaDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    function milliseconds($date)
    {
        return date('U', strtotime($date));
    }

    function HRDate($date)
    {
        return date('d.m.Y', strtotime($date));
    }

    /**
     * view date from milli seconds
     * @param $date
     * @return false|string
     */
    function frommilliseconds($date)
    {
        return date('d.m.Y',  $date / 1000);
    }

    /**
     * view date from milli seconds
     * @param $date
     * @return false|string
     */
    function frommillisecondstohour($date)
    {
        return date('H:i',  $date / 1000);
    }
    /**
     * view date from milli seconds
     * @param $date
     * @return false|string
     */
    function frommillisecondstojavadate($date)
    {
        return date('Y-m-d',  $date / 1000);
    }

    /**
     * view date from java date
     * @param $date
     * @return false|string
     */
    function fromjavadate($date)
    {
        return date('d.m.Y', strtotime($date));
    }

    /**
     * Builds tree from flat array
     * @param $array
     * @param null $root
     * @param string $id
     * @param string $parent
     * @return array
     */
    function treeView($array, $root = null, $id = 'id', $parent = 'parentIdId')
    {
        $tree = array();

        foreach ($array as $el)
        {
            $el = (array)$el;

            if ($el[$parent] == $root)
            {
                $tree[] = array(
                    'text'  => $el['name'],
                    'nodes' => treeView($array, $el[$id])
                );
            }
        }

        return $tree;
    }

    /**
     * Build js tree data
     * @param $array
     * @param string $id
     * @param string $text
     * @param string $parent
     * @return array
     */
    function jstree($array, $id = 'id', $text = 'name', $parent = 'parentIdId') {

        $jstree = [];

        foreach ($array as $key => $el)
        {
            $jstree[$key]['id']     = $el->{$id};
            $jstree[$key]['text']   = $el->{$text};
            $jstree[$key]['parent'] = $el->{$parent} == null ? '#' : $el->{$parent};
            $jstree[$key]['state']['opened'] = true;
            $jstree[$key]['state']['selected'] = false;
        }

        return $jstree;

    }

    /**
     * @param $monthNumber
     * @return mixed
     */
    function getMonth($monthNumber) {

        $index = intval($monthNumber);

        $months = [
            'Yanvar', 'Fevral', 'Mart', 'Mart', 'Aprel', 'May', 'İyun', 'İyul', 'Avqust', 'Sentyabr', 'Oktyabr', 'Noyabr', 'Dekabr'
        ];

        return $months[$index];

    }
}