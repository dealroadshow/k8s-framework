<?php

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Data\ObjectMeta;

abstract class AbstractPrometheusApiResource implements APIResourceInterface
{
    public function __construct(protected \ArrayObject $data)
    {
    }

    function metadata(): ObjectMeta
    {
        return $this->data['metadata'];
    }

    public function jsonSerialize(): \ArrayObject
    {
        return $this->data;
    }
}
