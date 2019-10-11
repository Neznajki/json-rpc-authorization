<?php


namespace JsonRpcAuthorizationBundle\Exception;


use Exception;
use Throwable;

class MethodNotFoundException extends Exception
{
    const ERROR_CODE = -32601;

    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, self::ERROR_CODE, $previous);
    }
}
