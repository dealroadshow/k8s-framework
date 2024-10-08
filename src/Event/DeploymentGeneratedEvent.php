<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Api\Apps\V1\Deployment;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Deployment\DeploymentInterface;

class DeploymentGeneratedEvent implements ManifestGeneratedEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest_generated.deployment';

    public function __construct(private DeploymentInterface $manifest, private Deployment $deployment, private AppInterface $app)
    {
    }

    public function manifest(): DeploymentInterface
    {
        return $this->manifest;
    }

    public function apiResource(): APIResourceInterface
    {
        return $this->deployment;
    }

    public function deployment(): Deployment
    {
        return $this->deployment;
    }

    public function app(): AppInterface
    {
        return $this->app;
    }
}
