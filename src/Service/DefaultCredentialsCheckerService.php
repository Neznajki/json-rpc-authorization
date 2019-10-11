<?php


namespace JsonRpcAuthorizationBundle\Service;


use JsonRpcAuthorizationBundle\Contract\CredentialsCheckerInterface;
use JsonRpcAuthorizationBundle\Contract\CredentialsInterface;
use JsonRpcAuthorizationBundle\Contract\PasswordEncryptInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultCredentialsCheckerService implements CredentialsCheckerInterface
{
    const TOKEN_LIFE_TIME = 3600;

    /** @var string */
    protected $userName;
    /** @var string */
    protected $password;
    /** @var PasswordEncryptInterface */
    protected $passwordEncrypt;

    /**
     * DefaultCredentialsCheckerService constructor.
     * @param string $userName
     * @param string $rawPassword
     * @param PasswordEncryptInterface $passwordEncrypt
     */
    public function __construct(string $userName, string $rawPassword, PasswordEncryptInterface $passwordEncrypt)
    {
        $this->userName = $userName;
        $this->password = $rawPassword;
        $this->passwordEncrypt = $passwordEncrypt;
    }

    /**
     * @param CredentialsInterface $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentialsAccess(CredentialsInterface $credentials, UserInterface $user): bool
    {
        $generationTime = $credentials->getGenerationTime();

        return
            $credentials->getUserName() === $this->getUserName() &&
            $credentials->getPassword() === $this->getEncryptedPassword((int)$generationTime) &&
            $generationTime >= (time() - self::TOKEN_LIFE_TIME);
    }

    /**
     * @return string
     */
    protected function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    protected function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return PasswordEncryptInterface
     */
    public function getPasswordEncrypt(): PasswordEncryptInterface
    {
        return $this->passwordEncrypt;
    }

    /**
     * @param int $generationTime
     * @return string
     */
    public function getEncryptedPassword(int $generationTime): string
    {
        return $this->getPasswordEncrypt()->encryptPassword($this->getPassword(), $generationTime);
    }
}
