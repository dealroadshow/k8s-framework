<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Service;

interface DeploymentAwareServiceInterface extends ServiceInterface
{
    public static function deploymentClass(): string;
}
