<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\API\ConfigMap;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ConfigMap\ConfigMapInterface;

class ConfigMapGeneratedEvent implements ManifestGeneratedEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest_generated.configMap';

    public function __construct(private ConfigMapInterface $manifest, private ConfigMap $configMap, private AppInterface $app)
    {
    }

    public function manifest(): ConfigMapInterface
    {
        return $this->manifest;
    }

    public function apiResource(): APIResourceInterface
    {
        return $this->configMap;
    }

    public function configMap(): ConfigMap
    {
        return $this->configMap;
    }

    public function app(): AppInterface
    {
        return $this->app;
    }
}
