<?php

namespace App;

use App\Library\Ws\Model;
use App\Library\Ws\ServiceFactory;

class UserAdvancePayment extends Model
{
    /* TableName */
    protected static $table = 'UserAdvancePayment';

    /**
     * Calculate user advance
     * @param $options
     * @return mixed
     */
    public static function calculate($body)
    {
        $url      = ServiceFactory::makeUrl(static::$app, 'payments/getPaymentAdvance');
        $headers  = ServiceFactory::setHeaders();
        $response = ServiceFactory::makeRequest('POST', $url, $body, $headers);

        return $response;
    }

    /**
     * Refresh user advances
     * @param $options
     * @return mixed
     */
    public static function refresh($body)
    {
        $url      = ServiceFactory::makeUrl(static::$app, 'payments/paymentAdvanceStep1');
        $headers  = ServiceFactory::setHeaders();
        $response = ServiceFactory::makeRequest('POST', $url, $body, $headers);

        return $response;
    }
}