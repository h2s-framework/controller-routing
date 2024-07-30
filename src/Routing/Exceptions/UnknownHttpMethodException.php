<?php

namespace Siarko\ActionRouting\Routing\Exceptions;

use Throwable;

class UnknownHttpMethodException extends \Exception
{
    public function __construct($method = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Unknown HTTP Method: ".$method, $code, $previous);
    }


}