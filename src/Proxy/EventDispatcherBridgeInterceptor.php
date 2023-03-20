<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Proxy;

use Dealroadshow\K8S\Framework\Event\ManifestMethodCalledEvent;
use Dealroadshow\K8S\Framework\Event\ManifestMethodEvent;
use Dealroadshow\Proximity\MethodsInterception\BodyInterceptionResult;
use Dealroadshow\Proximity\MethodsInterception\BodyInterceptorInterface;
use Dealroadshow\Proximity\MethodsInterception\InterceptionContext;
use Dealroadshow\Proximity\MethodsInterception\ResultInterceptorInterface;
use Dealroadshow\Proximity\ProxyInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

readonly class EventDispatcherBridgeInterceptor implements BodyInterceptorInterface, ResultInterceptorInterface
{
    public function __construct(private EventDispatcherInterface $dispatcher)
    {
    }

    public function beforeMethodBody(ProxyInterface $proxy, object $object, string $methodName, array $methodArgs): BodyInterceptionResult
    {
        $event = new ManifestMethodEvent($proxy, $methodName, $methodArgs);
        $this->dispatcher->dispatch($event, ManifestMethodEvent::NAME);
        if (null !== ($result = $event->getReturnValue())) {
            return new BodyInterceptionResult(true, $result);
        }

        return new BodyInterceptionResult();
    }

    public function afterMethodBody(ProxyInterface $proxy, object $object, string $methodName, array $methodArgs, InterceptionContext $context): void
    {
        $event = new ManifestMethodCalledEvent($proxy, $methodName, $methodArgs, $context->returnValue);
        $this->dispatcher->dispatch($event, ManifestMethodCalledEvent::NAME);
        if (null !== ($result = $event->getReturnValue())) {
            $context->returnValue = $result;
        }
    }
}
