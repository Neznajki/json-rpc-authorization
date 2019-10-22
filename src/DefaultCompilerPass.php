<?php


namespace JsonRpcAuthorizationBundle;


use JsonRpcAuthorizationBundle\Contract\CredentialsCheckerInterface;
use JsonRpcServerCommon\Contract\PasswordEncryptInterface;
use JsonRpcAuthorizationBundle\Service\DefaultCredentialsCheckerService;
use JsonRpcServerCommon\Service\DefaultPasswordEncryptService;
use RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DefaultCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (! $container->has(CredentialsCheckerInterface::class)) {
            $this->setDefaultCredentialsChecker($container);
        }

        if (! $container->has(PasswordEncryptInterface::class)) {
            $this->setDefaultPasswordEncrypt($container);
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    public function setDefaultCredentialsChecker(ContainerBuilder $container): void
    {
        if (! $container->hasParameter('server.json.rpc.user.name')) {
            throw new RuntimeException(sprintf('server.json.rpc.user.name is required to use %s', DefaultCredentialsCheckerService::class));
        }

        if (! $container->hasParameter('server.json.rpc.user.password')) {
            throw new RuntimeException(sprintf('server.json.rpc.user.password is required to use %s', DefaultCredentialsCheckerService::class));
        }

        $container->setAlias(CredentialsCheckerInterface::class, DefaultCredentialsCheckerService::class);
    }

    /**
     * @param ContainerBuilder $container
     */
    public function setDefaultPasswordEncrypt(ContainerBuilder $container): void
    {
        $container->setAlias(PasswordEncryptInterface::class, DefaultPasswordEncryptService::class);
    }
}
