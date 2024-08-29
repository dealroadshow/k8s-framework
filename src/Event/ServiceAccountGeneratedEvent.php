<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Api\Core\V1\ServiceAccount;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\ServiceAccount\ServiceAccountInterface;

readonly class ServiceAccountGeneratedEvent implements ManifestGeneratedEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest_generated.service_account';

    public function __construct(
        private ServiceAccountInterface $manifest,
        private ServiceAccount $apiResource,
        private AppInterface $app
    ) {
    }

    public function manifest(): ManifestInterface
    {
        return $this->manifest;
    }

    public function apiResource(): APIResourceInterface
    {
        return $this->apiResource;
    }

    public function app(): AppInterface
    {
        return $this->app;
    }

    public function serviceAccount(): ServiceAccount
    {
        return $this->apiResource;
    }
}
