# json-rpc-authorization
makes authorization for json rpc

# bundle installation
* composer require neznajki/json-rpc-authorization
* services.yaml
```yaml
imports:
    - { resource: '@JsonRpcAuthBundle/Resources/config/services.yaml' }

* security.yaml
```
```yaml
imports:
    { resource: '@JsonRpcAuthBundle/Resources/config/security.yaml' }
```
* parameters.yaml
```yaml
pareameters:
    server.json.rpc.user.name: authorization
    server.json.rpc.user.password: qwerty

```
