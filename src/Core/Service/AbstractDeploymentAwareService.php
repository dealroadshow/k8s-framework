<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Service;

abstract class AbstractDeploymentAwareService extends AbstractService implements DeploymentAwareServiceInterface
{
    final public static function shortName(): string
    {
        throw new \BadMethodCallException(sprintf('Method shortName() must not be used in instances of %s, because it\'s derived from Deployment.', static::class));
    }
}
