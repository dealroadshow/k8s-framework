<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\ServiceAccount;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\ServiceAccount\Configurator\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\ServiceAccount\Configurator\SecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\ServiceAccount\ServiceAccountInterface;
use Dealroadshow\K8S\Framework\Event\ServiceAccountGeneratedEvent;
use Dealroadshow\K8S\Framework\Util\ManifestReferenceUtil;

class ServiceAccountMaker extends AbstractResourceMaker
{
    public function __construct(private readonly ManifestReferenceUtil $manifestReferenceUtil)
    {
    }

    protected function supportsClass(): string
    {
        return ServiceAccountInterface::class;
    }

    protected function makeResource(ManifestInterface|ServiceAccountInterface $manifest, AppInterface $app): APIResourceInterface
    {
        $serviceAccount = new ServiceAccount();
        $app->metadataHelper()->configureMeta($manifest, $serviceAccount);

        $imagePullSecrets = new ImagePullSecretsConfigurator($this->manifestReferenceUtil, $serviceAccount->imagePullSecrets());
        $secrets = new SecretsConfigurator($this->manifestReferenceUtil, $serviceAccount->secrets());

        $manifest->imagePullSecrets($imagePullSecrets);
        $manifest->secrets($secrets);

        if ($automount = $manifest->automountServiceAccountToken()) {
            $serviceAccount->setAutomountServiceAccountToken($automount);
        }

        $manifest->configureServiceAccount($serviceAccount);

        $this->dispatcher->dispatch(
            new ServiceAccountGeneratedEvent($manifest, $serviceAccount, $app),
            ServiceAccountGeneratedEvent::NAME
        );

        return $serviceAccount;
    }
}
