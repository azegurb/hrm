<?php

namespace App\Library\Ws;


abstract class Filter
{
    const TYPE_EQUALS   = '=';

    const TYPE_CONTAINS = 'contains';

    const TYPE_GREATER  = '>';

    const TYPE_SMALLER  = '<';

    const TYPE_IN       = 'in';
}