<?php

namespace App\Library\Ws;


class Model
{
    /**
     * @var string AppName
     */
    protected static $app = 'hr';
    /**
     * @var string TableName
     */
    protected static $table;
    /**
     * Get all records in table
     * @param $options
     * @return null|object
     */
    public static function fetch($options)
    {
        $queryString = ServiceFactory::makeQueryString($options);
        $url         = ServiceFactory::makeUrl(static::$app, 'crud/', $queryString);
        $headers     = ServiceFactory::setHeaders(['TableName' => static::$table]);
        $response    = ServiceFactory::makeRequest('GET', $url, [], $headers, false);

        return $response;
    }
    /**
     * Store object
     * @param $body
     * @return null|object
     */
    public static function store($body)
    {
        $url      = ServiceFactory::makeUrl(static::$app, 'crud/');
        $headers  = ServiceFactory::setHeaders(['TableName' => static::$table]);
        $response = ServiceFactory::makeRequest('POST', $url, $body, $headers);

        return $response;
    }
    /**
     * Update object
     * @param $body
     * @return null|object
     */
    public static function update($body) {

        $url         = ServiceFactory::makeUrl(static::$app, 'crud/');
        $headers     = ServiceFactory::setHeaders(['TableName' => static::$table]);
        $response    = ServiceFactory::makeRequest('PUT', $url, $body, $headers, false);

        return $response;

    }
    /**
     * Delete object
     * @param $id
     * @return null|object
     */
    public static function destroy($id)
    {
        $queryString = ServiceFactory::makeQueryString(['id' => $id]);
        $url         = ServiceFactory::makeUrl(static::$app, 'crud/', $queryString);
        $headers     = ServiceFactory::setHeaders(['TableName' => static::$table]);
        $response    = ServiceFactory::makeRequest('DELETE', $url, [], $headers, false);

        return $response;
    }
    /**
     * Check if response has data
     * @param $data
     * @return bool
     */
    public static function hasData($data)
    {
        return isset($data->data) && $data->data != null;
    }
    /**
     * Check if response data has entities
     * @param $data
     * @return bool
     */
    public static function hasEntities($data)
    {
        return isset($data->data->entities) && !empty($data->data->entities);
    }

    /**
     * Check if response data has error
     * @param $response
     * @return bool
     */
    public static function hasErrorIn($response) {
        return $response->error != null || ($response->code != 200 && $response->code != 201);
    }
}