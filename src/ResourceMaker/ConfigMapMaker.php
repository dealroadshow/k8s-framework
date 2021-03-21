<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\ConfigMap;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ConfigMap\ConfigMapInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\ResourceMaker\Traits\PrefixMapKeysTrait;
use Dealroadshow\K8S\Framework\ResourceMaker\Traits\ValueToStringTrait;

class ConfigMapMaker extends AbstractResourceMaker
{
    use PrefixMapKeysTrait;
    use ValueToStringTrait;

    public function makeResource(ManifestInterface|ConfigMapInterface $manifest, AppInterface $app): ConfigMap
    {
        $configMap = new ConfigMap();

        $app->metadataHelper()->configureMeta($manifest, $configMap);
        $data = $configMap->data();
        $manifest->data($data);
        $binaryData = $configMap->binaryData();
        $manifest->binaryData($binaryData);

        if ($prefix = $manifest->keysPrefix()) {
            $this->prefixMapKeys($prefix, $data);
            $this->prefixMapKeys($prefix, $binaryData);
        }

        foreach ($data as $key => $value) {
            $data->add($key, $this->valueToString($value));
        }

        $manifest->configureConfigMap($configMap);

        return $configMap;
    }

    public function supportsClass(): string
    {
        return ConfigMapInterface::class;
    }
}
