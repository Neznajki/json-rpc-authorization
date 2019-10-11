<?php


namespace JsonRpcAuthorizationBundle\Service;


use JsonRpcAuthorizationBundle\Contract\PasswordEncryptInterface;

class DefaultPasswordEncryptService implements PasswordEncryptInterface
{
    /** @var string */
    protected $salt;

    /**
     * DefaultPasswordEncryptService constructor.
     * @param string $salt
     */
    public function __construct(string $salt = null)
    {
        if ($salt === null) {
            $salt = self::SALT;
        }

        $this->salt = $salt;
    }

    public function encryptPassword(string $rawPassword, int $generationTime): string
    {
        return hash('sha256', $rawPassword . $generationTime . $this->salt);
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }
}
