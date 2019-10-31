# json-rpc-authorization
makes authorization for json rpc

# bundle installation
* composer require neznajki/json-rpc-authorization
* services.yaml
```yaml
imports:
    - { resource: '@JsonRpcAuthBundle/Resources/config/services.yaml' }

```
* security.yaml
```yaml
    providers:
        #...
        jsonRpcProvider:
            id: JsonRpcAuthorizationBundle\Service\DefaultUserProviderService

    firewalls:
        #...
        jsonRpc:
            pattern: ^/jsonRpc
            provider: jsonRpcProvider
            guard:
                authenticators:
                    - JsonRpcAuthorizationBundle\Service\AuthenticationService

    access_control:
        #...
        - { path: '^/jsonRpc', roles: ROLE_RPC_USER}
```
* parameters.yaml
```yaml
pareameters:
    server.json.rpc.user.name: authorization
    server.json.rpc.user.password: qwerty

```
