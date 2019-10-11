<?php


namespace JsonRpcAuthorizationBundle\Exception;


use Throwable;

class UnknownCredentialsException extends ServerErrorException
{
    const EXCEPTION_CODE = -32098;

    /**
     * UnknownCredentialsException constructor.
     * @param string $message
     * @param Throwable|null $previous
     * @throws InternalErrorException
     */
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, self::EXCEPTION_CODE, $previous);
    }
}
