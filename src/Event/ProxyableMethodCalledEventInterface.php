<?php

namespace Dealroadshow\K8S\Framework\Event;

interface ProxyableMethodCalledEventInterface extends ProxyableMethodEventInterface
{
    public function returnedValue(): mixed;
}
