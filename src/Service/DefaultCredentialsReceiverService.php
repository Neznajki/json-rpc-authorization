<?php


namespace JsonRpcAuthorizationBundle\Service;


use JsonRpcAuthorizationBundle\Contract\CredentialsInterface;
use JsonRpcAuthorizationBundle\Contract\CredentialsReceiverInterface;
use JsonRpcAuthorizationBundle\Exception\AuthNotGrantedException;
use JsonRpcAuthorizationBundle\Object\Credentials;
use Symfony\Component\HttpFoundation\Request;

class DefaultCredentialsReceiverService implements CredentialsReceiverInterface
{

    /**
     * @param Request $request
     * @return CredentialsInterface
     * @throws AuthNotGrantedException
     */
    public function getCredentials(Request $request): CredentialsInterface
    {

        $userName = $request->headers->get('userName');
        if ($userName === null) {
            throw new AuthNotGrantedException('userName is required');
        }
        $password = $request->headers->get('password');
        if ($password === null) {
            throw new AuthNotGrantedException('password is required');
        }
        $generationTime = $request->headers->get('generationTime');
        if ($generationTime === null) {
            throw new AuthNotGrantedException('generationTime is required');
        }

        return new Credentials($userName, $password, $generationTime);
    }
}
