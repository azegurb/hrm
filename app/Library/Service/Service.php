<?php
namespace App\Library\Service;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Service
{
    protected static $url;
    protected static $method;
    protected static $options;
    /**
     * Creating request params
     *
     * @param array $request
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function request($request = ['method' => null, 'url' => null, 'options' => null])
    {
        self::$url = $request['url'];
        self::$method = $request['method'];
        self::$options = $request['options'];
        if (array_key_exists('method', $request) && array_key_exists('params', $request)) {
            if ($request['method'] == 'GET' || $request['method'] == 'DELETE' && is_array($request['params']) && !is_null($request['params'])) {
                foreach ($request['params'] as $key => $value) {
                    if($key == 'id' && !is_null($value))
                    {
                        self::$url .= '/'.$value;
                    }elseif($key == 'sc'){
                        self::$url .= "?sc=[";
                        for($i=0; $i < count($value); $i++)
                        {
                            self::$url .= $value[$i];
                            if($i < count($value)-1){
                                self::$url .= ",";
                            }
                        }
                        self::$url .= "]";
                    }elseif ($key == "filter") {
                        if(is_array($value) && !is_null($value)){
                            self::$url .= "&filter=%7B";
                            foreach ($value as $k => $v)
                            {
                                if($v != "") {
                                    self::$url .= "$k:%7B\"contains\":$v%7D";
                                }
                            }
                            self::$url .= "%7D";
                        }elseif (is_string($value) && !is_null($value)){
                            self::$url .= '&filter=%7B'.$value.'%7D';
                        }
                    }else {
                        self::$url .= "&$key=$value";

                    }
                }
            }
        }

        return self::call();
    }
    /**
     * Calling service via guzzle
     *
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    private static function call()
    {
        $client = new Client();
        if (!empty(static::$options['headers'])){
            static::$options['headers'] = array_merge(static::$options['headers'], static::defaultHeaders());
        }else{
            static::$options['headers'] = static::defaultHeaders();
        }
//        dd(self::$method);
//        var_dump(json_encode(self::$options), self::$url);
//        die;



//        if(self::$method=='PUT'){
//            dd(self::$method, self::$url, json_encode(static::$options));
//        }


//        dump(self::$method, self::$url, json_encode(static::$options));

        # \Debugbar::info(self::$method, self::$url, json_encode(static::$options));
//         dump(self::$method, self::$url, json_encode(static::$options));
        $response = $client->request(self::$method, self::$url, static::$options);
//        dump(json_decode($response->getBody(), true));
        $logger = new Logger('Request Logger');

        $logger->pushHandler(new StreamHandler( app()->storagePath().'/hrm_logs/log.log', Logger::INFO));

        $logger->addInfo('REQUEST URI  =>  ' . self::$method . ' ' . self::$url);

        $logger->addInfo('REQUEST BODY =>  ' . json_encode(static::$options));

        if ($response->getStatusCode() != 200) {

            $res = (object)[
                'code'      => $response->getStatusCode(),
                'headers'   => $response->getHeaders(),
                'body'      => json_decode($response->getBody(), true)
            ];
            $custom_log = new Logger('Custom Logs');

            $custom_log->pushHandler(new StreamHandler( app()->storagePath().'/hrm_logs/log.log', Logger::INFO));

            $custom_log->addInfo('----Response != 200 : ' . json_encode(json_decode($response->getBody())));

            return $res;
        }

        if($response->getStatusCode() == 200 && json_decode($response->getBody())->error != null) {

            if(json_decode($response->getBody())->error->code == 1103 ){
                $custom_log = new Logger('Custom Logs');

                $custom_log->pushHandler(new StreamHandler( app()->storagePath().'/hrm_logs/log.log', Logger::INFO));

                $custom_log->addInfo('----Response 1103 : ' . json_encode(json_decode($response->getBody())));


                abort(403);
            }
            if(json_decode($response->getBody())->error->code == 1102){
                $custom_log = new Logger('Custom Logs');

                $custom_log->pushHandler(new StreamHandler( app()->storagePath().'/hrm_logs/log.log', Logger::INFO));

                $custom_log->addInfo('----Response 1103 : ' . json_encode(json_decode($response->getBody())));


                abort(403);
            }
            elseif(json_decode($response->getBody())->error->code == 1401 ){
                $custom_log = new Logger('Custom Logs');

                $custom_log->pushHandler(new StreamHandler( app()->storagePath().'/hrm_logs/log.log', Logger::INFO));

                $custom_log->addInfo('----Response 1401 : ' . json_encode(json_decode($response->getBody())));
                Cookie::queue(Cookie::forget('SSO-TOKEN', '/', '.portofbaku.com'));
                session()->forget('authUser');
                return redirect('/');
                abort(403);
            }
            elseif(json_decode($response->getBody())->error->code == 1102 ){
                $custom_log = new Logger('Custom Logs');

                $custom_log->pushHandler(new StreamHandler( app()->storagePath().'/hrm_logs/log.log', Logger::INFO));

                $custom_log->addInfo('----Response 1102 : ' . json_encode(json_decode($response->getBody())));

                abort(403);
            }
        }
        if($response->getStatusCode() == 200 && !is_null(json_decode($response->getBody())->error)) {
            $custom_log = new Logger('Custom Logs');

            $custom_log->pushHandler(new StreamHandler( app()->storagePath().'/hrm_logs/log.log', Logger::INFO));

            $custom_log->addInfo('----Response == 200 error != null : ' . json_encode(json_decode($response->getBody())));

            $res = [
                'error' => json_decode($response->getBody())->error
            ];
            abort(500, $res['error']->message);
        }
        if ($response->getStatusCode() == 500) {
            $custom_log = new Logger('Custom Logs');

            $custom_log->pushHandler(new StreamHandler( app()->storagePath().'/hrm_logs/log.log', Logger::INFO));

            $custom_log->addInfo('----Response == 500 : ' . json_encode(json_decode($response->getBody())));

            abort(500);
        }
        if ($response->getStatusCode() == 401) {
            $custom_log = new Logger('Custom Logs');

            $custom_log->pushHandler(new StreamHandler( app()->storagePath().'/hrm_logs/log.log', Logger::INFO));

            $custom_log->addInfo('----Response == 401 : ' . json_encode(json_decode($response->getBody())));

            abort(401);
        }
        $res = (object)[
            'totalCount' => !empty(json_decode($response->getBody())->data->totalCount) ? json_decode($response->getBody())->data->totalCount : 0,
            'code'       => $response->getStatusCode(),
            'headers'    => $response->getHeaders()
        ];
        $r = json_decode($response->getBody());

        if( !empty( $r->data ) && !empty($r->data->entities)){
            $res->data = $r->data->entities;
        }elseif (!empty( $r->data ) && empty($r->data->entities)){
            if(isset($r->data->entities)){
                $res->data = [];
            }else{
                $res->data = $r->data;
            }
        }else if(empty($res->data)){
            $res->data = [];
        }

//        $res = (object)[
//            'totalCount' => !empty(json_decode($response->getBody())->data->totalCount) ? json_decode($response->getBody())->data->totalCount : 0,
//            'data'       => !empty(json_decode($response->getBody())->data->entities) ? json_decode($response->getBody())->data->entities : json_decode($response->getBody())->data,
//            'code'       => $response->getStatusCode(),
//            'headers'    => $response->getHeaders()
//        ];

        return $res;
    }
    /**
     * Getting default request header properties
     *
     * @return array
     */
    protected static function defaultHeaders()
    {

        return [
            'Content-Type'      => 'application/json;charset=UTF-8',
            'Authorization'     => 'Basic '.User::tokenObject(env('API_URL'))['token'],
//            'appId'             => User::tokenObject(env('API_URL'))['appId'],
            'RequestNumber'     => User::tokenObject(env('API_URL'))['RequestNumber'],
            'AppName'           => User::tokenObject(env('API_URL'))['AppName'],
            'IpAddress'         => User::tokenObject(env('API_URL'))['IpAddress'],
            'Accept-Language'   => User::tokenObject(env('API_URL'))['Accept-Language'],
            'UserGroupTypeId'   => User::tokenObject(env('API_URL'))['UserGroupTypeId'],
            'Origin'            => User::tokenObject(env('API_URL'))['Origin']
        ];
    }
    /**
     * Generating request url for services
     *
     * @param $app
     * @param $url
     * @param bool $staticUrl
     * @return string
     */
    public static function url($app,$url,$staticUrl = true)
    {
        if(! $staticUrl)
        {
            return config('api')->$app.$url;
        }
        return config('api')->$app . config("links.$app.$url");
    }
    protected static function urlSearch()
    {
        return 'test';
    }
}