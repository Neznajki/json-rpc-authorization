# json-rpc-authorization
makes authorization for json rpc

# bundle installation
* composer install 
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
