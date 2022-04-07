<?php

namespace App\Library\Ws;

use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

class ServiceFactory
{
    /**
     * Generate query string from given $options array
     * @param $options
     * @return string
     */
    public static function makeQueryString($options)
    {
        $url = '';
        /* counting uri parameters */
        $paramCount = 0;

        foreach ($options as $key => $value) {

            /* if param is id, it will be passed after slash e.g. http://host/service/{id} */
            if ($key == 'id') {

               $url .= $value;

            } else {

                /* if 'this' is the first param we need to add question sign */
                if ($paramCount == 0) $url .= '?';
                /* add '&' sign after each parameter, unless it is the last one */
                $separator = $paramCount != count($options) - 1 ?  '&' : '';


                /* if 'sc' */
                if ($key == 'sc') {

                    /* sc parameter will contain column names e.g. ?sc=[id,name,label] */

                    $url .= 'sc=[';
                    $columnCount = 0;

                    foreach ($value as $column) {

                        /* add column names */
                        $url .= $column;

                        /* seperate with comma */
                        if ($columnCount != count($value) - 1) { $url .= ','; }

                        /* increment column count */
                        $columnCount++;

                    }

                    $url .= ']';

                } else if ($key == 'filter' && is_array($value)) {

                    /* filter parameter will be used to filter result e.g ?filter={"column":{"=":"value"}} */
                    $url .= 'filter=%7B';
                    $filterCount = 0;

                    foreach ($value as $filter) {

                        $url .= '"'    . $filter['field'] . '"';
                        $url .= ':';
                        $url .= '%7B"' . $filter['type']  . '":' . $filter['value'] . '%7D';

                        if ($filterCount != count($value) - 1) { $url .= ','; }

                        $filterCount++;

                    }

                    $url .= '%7D';


                } else {

                    /* other basic parameters e.g ?key=value*/
                    $url .= $key.'='.$value;

                }

                /* seperator '' or '&' */
                $url .= $separator;

                $paramCount++;

            }

        }

        return $url;
    }
    /**
     * Get default headers common for most service calls
     * @return array
     */
    private static function defaultHeaders()
    {
        return [
            'Content-Type'      => 'application/json;charset=UTF-8',
            'Authorization'     => 'Basic '.User::tokenObject(env('API_URL'))['token'],
            'RequestNumber'     => User::tokenObject(env('API_URL'))['RequestNumber'],
            'AppName'           => User::tokenObject(env('API_URL'))['AppName'],
            'IpAddress'         => User::tokenObject(env('API_URL'))['IpAddress'],
            'Accept-Language'   => User::tokenObject(env('API_URL'))['Accept-Language'],
            'UserGroupTypeId'   => User::tokenObject(env('API_URL'))['UserGroupTypeId'],
            'Origin'            => User::tokenObject(env('API_URL'))['Origin']
        ];
    }
    /**
     * Set headers
     * @param $headers
     * @param bool $mergeWithDefault
     * @return array
     */
    public static function setHeaders($headers = [], $mergeWithDefault = true)
    {
        if ($mergeWithDefault) {
            return array_merge($headers, static::defaultHeaders());
        } else {
            return $headers;
        }
    }
    /**
     * Make request url
     * @param string $app
     * @param string $service
     * @param $queryString
     * @return string
     */
    public static function makeUrl($app = 'hr', $service = 'crud/', $queryString = '')
    {
        return config('api')->$app.$service.$queryString;
    }
    /**
     * Make request to service
     * @param $method
     * @param $url
     * @param array $body
     * @param $headers
     * @param bool $timeout
     * @return null|object
     */
    public static function makeRequest($method, $url, $body = [], $headers, $timeout = true)
    {
        /* guzzle http client */
        $client = new Client();

        try {
            /* guzzle request options */
            $options = [
                'headers' => $headers,
                'json'    => $body
            ];

            /* if timeout set to true add timeout to options */
            if ($timeout) {
                $options = array_merge($options, [
                    'connect_timeout' => 15,
                    'timeout'         => 15
                ]);
            }

            /* send GuzzleClient request */
            $request = $client->request($method, $url, $options);

            $response = null;

            /* get response body */
            $content = json_decode($request->getBody()->getContents());

            #dd($content);

            /* if response code is OK */
            if ($request->getStatusCode() == 200) {

                /* if error field from central is not empty */
                if ($content->error != null) {

                    $code    = $content->error->code;
                    $message = $content->error->message;
                    $message = array_key_exists($code, config('messages.api')) ? config('messages.api.'.$code) : $message;

                    $response = (object)[

                        'error'   => $content->error,
                        'data'    => $content->data,
                        'total'   => 0,
                        'code'    => $code,
                        'message' => $message

                    ];

                } else {

                    /* if request was PUT or GET then message will be http.200 message */
                    $response = (object)[

                        'error'   => $content->error,
                        'data'    => $content->data,
                        'total'   => isset($content->data->totalCount) ? $content->data->totalCount : 0,
                        'code'    => $request->getStatusCode(),
                        'message' => config('messages.http.200')

                    ];

                }

                /* if response code is CREATED */
            } else if ($request->getStatusCode() == 201) {

                /* if request was POST then message will be different */
                $response = (object)[

                    'error'   => $content->error,
                    'data'    => $content->data,
                    'code'    => $request->getStatusCode(),
                    'message' => config('messages.http.201')

                ];

            }

            /* return response */
            return $response;
        }
        catch (\Exception $ex) {

            return self::handleException($ex);

        }
    }
    /**
     * Handle Exceptions
     * @param $ex
     * @return object|\stdClass
     */
    public static function handleException($ex)
    {
        #if (env('APP_ENV')) dd($ex);

        $exception = new \stdClass();

        switch ($ex) {

            case ($ex instanceof ConnectException):

                $code    = $ex->getHandlerContext()['errno'];
                $message = 'CURL Xətası: '.$code;
                $message = array_key_exists($code, config('messages.curl')) ? config('messages.curl.'.$code) : $message;

                $exception = (object)[

                    'error'   => null,
                    'data'    => null,
                    'total'   => -1,
                    'code'    => $code,
                    'message' => $message

                ];

                break;

            case ($ex instanceof ServerException):

                $code    = $ex->getCode();
                $message = $ex->getMessage();
                $message = array_key_exists($code, config('messages.http')) ? config('messages.http.'.$code) : $message;

                $exception = (object)[

                    'error'   => null,
                    'data'    => null,
                    'total'   => -1,
                    'code'    => $code,
                    'message' => $message

                ];

                break;

            case ($ex instanceof ClientException):

                $code    = $ex->getCode();
                $message = $ex->getMessage();
                $message = array_key_exists($code, config('messages.http')) ? config('messages.http.'.$code) : $message;

                $exception = (object)[

                    'error'   => null,
                    'data'    => null,
                    'total'   => -1,
                    'code'    => $code,
                    'message' => $message

                ];

                break;

        }

        return $exception;
    }
}