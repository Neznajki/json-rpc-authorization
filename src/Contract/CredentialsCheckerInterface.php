<?php


namespace JsonRpcAuthorizationBundle\Contract;


use Symfony\Component\Security\Core\User\UserInterface;

interface CredentialsCheckerInterface
{
    public function checkCredentialsAccess(CredentialsInterface $credentials, UserInterface $user): bool ;
}
