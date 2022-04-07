<?php

namespace App\Service;

use App\Library\Pagination;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;

class ServiceOLD
{
    protected static $code;
    protected static $message;

    /**
     * Sending request to API
     *
     * @param $data
     * @param $url
     * @param $method
     * @param null $type
     * @return mixed
     */
    public static function send($data, $url, $method, $type = null)
    {
        $parsedData = self::parseData($data, $type);

        $result     = self::callService($parsedData, $url, $method);

        return $result;
    }

    /**
     * Parsing data to JSON Object
     *
     * @param $data
     * @param null $type
     * @return string
     */
    private static function parseData($data, $type = null)
    {
        switch ($type){
            case "JSON_FORCE_OBJECT":
                return json_encode($data, JSON_FORCE_OBJECT);
                break;
            default:
                return json_encode($data);
                break;
        }
    }

    /**
     * Calling service
     *
     * @param $data
     * @param $url
     * @param $requestMethod
     * @return mixed
     */
    private static function callService($data, $url, $requestMethod)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestMethod);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );

        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);

        if($result == null || (isset($result->code) && $result->code != 400)){
            dd([
                "Request-[data]"  => $data,
                "Request-[url]" => $url,
                "Response from api" => $result
            ]);
        }

        if(isset($result->code) && $result->code == 400){

            return \Redirect::to(route('index'))->with('expiredToken', $result->message)->send();

        }else{
            return $result;
        }
    }

    public static function paginate($params = ['controller'=>null,'app'=>null,'count'=>null,'filters'=>[],'entity'=>[]])
    {
        $pageCount  = null;
        $start      = null;
        $pageNum    = null;

        $paginate   = new Pagination();
        $filter     = $paginate->filter([
            'filters' => $params['filters']
        ]);

        $page = $paginate->paginate(Input::get('page'),$params['count']);

        $data       = null;
        $requestNum = uniqid();

        $request = [
            'requestNumber' => $requestNum,
            'entity'        => array_merge($params['entity'], $filter),
            'page'          => $page,
            'token'         => User::objectToken()
        ];

        $url    = config('url')->$params['app'] . $params['controller'];

        $result = Service::send($request, $url, 'POST', 'JSON_FORCE_OBJECT');

        if ($result->res->code == '200') {

            self::$code = 200;
            self::$message = 'ok';

            $data = $result->data;
            $pageCount  = ceil($result->count->total/$params['count']);

        } else {

            self::$code = $result->res->code;
            self::$message = $result->res->msg;

            $data = isset($result->data) ? $result->data : null;

        }

        $response = [
            'data'  => collect($data)->sortByDesc('creationDate'),
            'code'  => self::$code,
            'msg'   => self::$message,
            'count' => $pageCount,
            'page'  => Input::get('page')
        ];

        return (object)$response;
    }
}