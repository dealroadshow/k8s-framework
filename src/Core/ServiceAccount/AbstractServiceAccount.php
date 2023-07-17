<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\ServiceAccount;

use Dealroadshow\K8S\API\ServiceAccount;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;

abstract class AbstractServiceAccount extends AbstractManifest implements ServiceAccountInterface
{
    public function automountServiceAccountToken(): bool
    {
        return false;
    }

    public function configureServiceAccount(ServiceAccount $serviceAccount): void
    {
    }

    public static function kind(): string
    {
        return ServiceAccount::KIND;
    }
}
