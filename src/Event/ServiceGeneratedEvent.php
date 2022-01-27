<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\API\Service;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Service\ServiceInterface;

class ServiceGeneratedEvent implements ManifestGeneratedEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest_generated.service';

    public function __construct(private ServiceInterface $manifest, private Service $service, private AppInterface $app)
    {
    }

    public function manifest(): ServiceInterface
    {
        return $this->manifest;
    }

    public function apiResource(): APIResourceInterface
    {
        return $this->service;
    }

    public function service(): Service
    {
        return $this->service;
    }

    public function app(): AppInterface
    {
        return $this->app;
    }
}
