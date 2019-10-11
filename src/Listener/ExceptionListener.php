<?php


namespace JsonRpcAuthorizationBundle\Listener;


use JsonRpcAuthorizationBundle\Service\HelperService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var HelperService
     */
    protected $helperService;

    public function __construct(
        LoggerInterface $logger,
        HelperService $helperService
    )
    {
        $this->logger = $logger;
        $this->helperService = $helperService;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        if (! $this->getHelperService()->isJsonRpcRequest($event->getRequest())) {
            return;
        }

        $this->getLogger()->error((string) $event->getException());
    }


    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @return HelperService
     */
    public function getHelperService(): HelperService
    {
        return $this->helperService;
    }
}
