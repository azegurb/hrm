<?php

namespace App;

use App\Library\Ws\Model;
use App\Library\Ws\ServiceFactory;

class Payment extends Model
{
    /**
     * Calculate payments
     * @param $options
     * @return mixed
     */
    public static function calculate($body)
    {
        $url      = ServiceFactory::makeUrl(static::$app, 'payments/getPayment');
        $headers  = ServiceFactory::setHeaders();
        $response = ServiceFactory::makeRequest('POST', $url, $body, $headers);

        return $response;
    }

    /**
     * Refresh user payments
     * @param $options
     * @return mixed
     */
    public static function refresh($body)
    {
        $url      = ServiceFactory::makeUrl(static::$app, 'payments/paymentStep1');
        $headers  = ServiceFactory::setHeaders();
        $response = ServiceFactory::makeRequest('POST', $url, $body, $headers);

        return $response;
    }

    /**
     * @param $body
     * @return null|object
     */
    public static function close($body)
    {
        $url      = ServiceFactory::makeUrl(static::$app, 'payments/paymentClosing');
        $headers  = ServiceFactory::setHeaders();
        $response = ServiceFactory::makeRequest('PUT', $url, $body, $headers);

        return $response;
    }
}