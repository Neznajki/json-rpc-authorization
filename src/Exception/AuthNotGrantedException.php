<?php


namespace JsonRpcAuthorizationBundle\Exception;


use Throwable;

class AuthNotGrantedException extends ServerErrorException
{
    const EXCEPTION_CODE = -32099;

    /**
     * AuthNotGrantedException constructor.
     * @param string $message
     * @param Throwable|null $previous
     * @throws InternalErrorException
     */
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, self::EXCEPTION_CODE, $previous);
    }
}
