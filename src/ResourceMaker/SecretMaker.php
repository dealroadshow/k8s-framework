<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Secret;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Secret\SecretInterface;
use Dealroadshow\K8S\Framework\ResourceMaker\Traits\PrefixMapKeysTrait;
use Dealroadshow\K8S\Framework\ResourceMaker\Traits\ValueToStringTrait;

class SecretMaker extends AbstractResourceMaker
{
    use PrefixMapKeysTrait;
    use ValueToStringTrait;

    public function makeResource(ManifestInterface|SecretInterface $manifest, AppInterface $app): Secret
    {
        $secret = new Secret();

        $app->metadataHelper()->configureMeta($manifest, $secret);
        $data = $secret->data();
        $manifest->data($data);
        $stringData = $secret->stringData();
        $manifest->stringData($stringData);

        if ($prefix = $manifest->keysPrefix()) {
            $this->prefixMapKeys($prefix, $data);
            $this->prefixMapKeys($prefix, $stringData);
        }

        foreach ($data->all() as $key => $value) {
            $value = $this->valueToString($value);
            $data->add($key, base64_encode($value));
        }

        foreach ($stringData->all() as $key => $value) {
            $stringData->add($key, $this->valueToString($value));
        }

        $manifest->configureSecret($secret);

        return $secret;
    }

    protected function supportsClass(): string
    {
        return SecretInterface::class;
    }
}
