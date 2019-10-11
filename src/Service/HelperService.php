<?php


namespace JsonRpcAuthorizationBundle\Service;


use Symfony\Component\HttpFoundation\Request;

class HelperService
{

    public function isJsonRpcRequest(Request $request): bool
    {
        return preg_match('@/?jsonRpc@', $request->getRequestUri());
    }
}
