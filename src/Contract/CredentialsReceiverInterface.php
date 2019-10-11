<?php


namespace JsonRpcAuthorizationBundle\Contract;


use Symfony\Component\HttpFoundation\Request;

interface CredentialsReceiverInterface
{
    /**
     * @param Request $request
     * @return CredentialsInterface
     */
    public function getCredentials(Request $request): CredentialsInterface;
}
