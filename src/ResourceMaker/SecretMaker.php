<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\Api\Core\V1\Secret;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Secret\SecretInterface;
use Dealroadshow\K8S\Framework\Event\SecretGeneratedEvent;
use Dealroadshow\K8S\Framework\ResourceMaker\Traits\PrefixMapKeysTrait;
use Dealroadshow\K8S\Framework\Util\StringMapProxy;

class SecretMaker extends AbstractResourceMaker
{
    use PrefixMapKeysTrait;

    public function makeResource(ManifestInterface|SecretInterface $manifest, AppInterface $app): Secret
    {
        $secret = new Secret();

        $app->metadataHelper()->configureMeta($manifest, $secret);
        $data = StringMapProxy::make($secret->data());
        $manifest->data($data);
        $stringData = StringMapProxy::make($secret->stringData());
        $manifest->stringData($stringData);

        if ($prefix = $manifest->keysPrefix()) {
            $this->prefixMapKeys($prefix, $data);
            $this->prefixMapKeys($prefix, $stringData);
        }

        foreach ($data->all() as $key => $value) {
            $data->add($key, base64_encode($value));
        }

        $secret->setType($manifest->type()->value);

        $manifest->configureSecret($secret);

        $this->dispatcher->dispatch(new SecretGeneratedEvent($manifest, $secret, $app), SecretGeneratedEvent::NAME);

        return $secret;
    }

    protected function supportsClass(): string
    {
        return SecretInterface::class;
    }
}
