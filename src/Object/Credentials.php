<?php


namespace JsonRpcAuthorizationBundle\Object;


use JsonRpcAuthorizationBundle\Contract\CredentialsInterface;

class Credentials implements CredentialsInterface
{
    /** @var string */
    protected $userName;
    /** @var string */
    protected $password;
    /** @var int */
    protected $generationTime;

    /**
     * Credentials constructor.
     * @param string $userName
     * @param string $password
     * @param int $generationTime
     */
    public function __construct(string $userName, string $password, int $generationTime)
    {
        $this->userName       = $userName;
        $this->password       = $password;
        $this->generationTime = $generationTime;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getGenerationTime(): int
    {
        return $this->generationTime;
    }
}
