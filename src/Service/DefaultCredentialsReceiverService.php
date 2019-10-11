<?php


namespace JsonRpcAuthorizationBundle\Service;


use JsonRpcAuthorizationBundle\Contract\CredentialsInterface;
use JsonRpcAuthorizationBundle\Contract\CredentialsReceiverInterface;
use JsonRpcAuthorizationBundle\Object\Credentials;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;

class DefaultCredentialsReceiverService implements CredentialsReceiverInterface
{

    /**
     * @param Request $request
     * @return CredentialsInterface
     */
    public function getCredentials(Request $request): CredentialsInterface
    {

        $userName = $request->headers->get('userName');
        if ($userName === null) {
            throw new RuntimeException('userName is required');
        }
        $password = $request->headers->get('password');
        if ($password === null) {
            throw new RuntimeException('password is required');
        }
        $generationTime = $request->headers->get('generationTime');
        if ($generationTime === null) {
            throw new RuntimeException('generationTime is required');
        }

        return new Credentials($userName, $password, $generationTime);
    }
}
