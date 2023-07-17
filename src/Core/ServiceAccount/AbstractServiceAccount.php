<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\ServiceAccount;

use Dealroadshow\K8S\API\ServiceAccount;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\ServiceAccount\Configurator\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\ServiceAccount\Configurator\SecretsConfigurator;

abstract class AbstractServiceAccount extends AbstractManifest implements ServiceAccountInterface
{
    public function automountServiceAccountToken(): bool
    {
        return false;
    }

    public function imagePullSecrets(ImagePullSecretsConfigurator $imagePullSecrets): void
    {
    }

    public function secrets(SecretsConfigurator $secrets): void
    {
    }

    public function configureServiceAccount(ServiceAccount $serviceAccount): void
    {
    }

    public static function kind(): string
    {
        return ServiceAccount::KIND;
    }
}
