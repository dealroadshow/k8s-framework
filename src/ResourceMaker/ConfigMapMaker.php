<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\Api\Core\V1\ConfigMap;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ConfigMap\ConfigMapInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Event\ConfigMapGeneratedEvent;
use Dealroadshow\K8S\Framework\ResourceMaker\Traits\PrefixMapKeysTrait;
use Dealroadshow\K8S\Framework\Util\StringMapProxy;

class ConfigMapMaker extends AbstractResourceMaker
{
    use PrefixMapKeysTrait;

    protected function makeResource(ManifestInterface|ConfigMapInterface $manifest, AppInterface $app): ConfigMap
    {
        $configMap = new ConfigMap();

        $app->metadataHelper()->configureMeta($manifest, $configMap);
        $data = StringMapProxy::make($configMap->data());
        $manifest->data($data);
        $binaryData = $configMap->binaryData();
        $manifest->binaryData($binaryData);

        if ($prefix = $manifest->keysPrefix()) {
            $this->prefixMapKeys($prefix, $data);
            $this->prefixMapKeys($prefix, $binaryData);
        }

        $manifest->configureConfigMap($configMap);

        $this->dispatcher->dispatch(new ConfigMapGeneratedEvent($manifest, $configMap, $app), ConfigMapGeneratedEvent::NAME);

        return $configMap;
    }

    protected function supportsClass(): string
    {
        return ConfigMapInterface::class;
    }
}
