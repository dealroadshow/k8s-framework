<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\ServiceAccount;

use Dealroadshow\K8S\Api\Core\V1\ServiceAccount;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\ServiceAccount\Configurator\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\ServiceAccount\Configurator\SecretsConfigurator;

interface ServiceAccountInterface extends ManifestInterface
{
    public function automountServiceAccountToken(): bool|null;

    public function imagePullSecrets(ImagePullSecretsConfigurator $imagePullSecrets): void;

    public function secrets(SecretsConfigurator $secrets): void;

    public function configureServiceAccount(ServiceAccount $serviceAccount): void;
}
