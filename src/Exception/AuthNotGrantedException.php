<?php


namespace JsonRpcAuthorizationBundle\Exception;


use Exception;
use JsonRpcServerContracts\Contract\JsonRpcException;
use Throwable;

class AuthNotGrantedException extends Exception implements JsonRpcException
{
    const EXCEPTION_CODE = -32099;

    /**
     * AuthNotGrantedException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, self::EXCEPTION_CODE, $previous);
    }
}
