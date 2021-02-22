<?php

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Data\ObjectMeta;

class MonitorApiResource implements APIResourceInterface
{
    public function __construct(private \ArrayObject $data)
    {
    }

    function metadata(): ObjectMeta
    {
        return $this->data['metadata'];
    }

    public function jsonSerialize()
    {
        return $this->data;
    }
}
