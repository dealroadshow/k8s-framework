<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Proxy;

use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Event\ContainerMethodCalledEvent;
use Dealroadshow\K8S\Framework\Event\ContainerMethodEvent;
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

    public function beforeMethodBody(ProxyInterface $proxy, object $object, string $methodName, array $methodArgs): BodyInterceptionResult|null
    {
        if ($proxy instanceof ManifestInterface) {
            $event = new ManifestMethodEvent($proxy, $methodName, $methodArgs);
            $eventName = ManifestMethodEvent::NAME;
        } elseif ($proxy instanceof ContainerInterface) {
            $event = new ContainerMethodEvent($proxy, $methodName, $methodArgs);
            $eventName = ContainerMethodEvent::NAME;
        } else {
            return null;
        }

        $this->dispatcher->dispatch($event, $eventName);
        if ($event->returnValueHasChanged()) {
            return new BodyInterceptionResult(true, $event->getReturnValue());
        }

        return null;
    }

    public function afterMethodBody(ProxyInterface $proxy, object $object, string $methodName, array $methodArgs, InterceptionContext $context): void
    {
        if ($proxy instanceof ManifestInterface) {
            $event = new ManifestMethodCalledEvent($proxy, $methodName, $methodArgs, $context->returnValue);
            $eventName = ManifestMethodCalledEvent::NAME;
        } elseif ($proxy instanceof ContainerInterface) {
            $event = new ContainerMethodCalledEvent($proxy, $methodName, $methodArgs, $context->returnValue);
            $eventName = ContainerMethodCalledEvent::NAME;
        } else {
            return;
        }

        $this->dispatcher->dispatch($event, $eventName);
        if ($event->returnValueHasChanged()) {
            $context->returnValue = $event->getReturnValue();
        }
    }
}
