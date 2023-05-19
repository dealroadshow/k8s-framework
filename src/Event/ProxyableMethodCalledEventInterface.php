<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

interface ProxyableMethodCalledEventInterface extends ProxyableMethodEventInterface
{
    public function returnedValue(): mixed;
}
