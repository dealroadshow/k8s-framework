<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Secret;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Secret\SecretInterface;

class SecretMaker extends AbstractResourceMaker
{
    /**
     * @param ManifestInterface|SecretInterface $manifest
     * @param AppInterface      $app
     *
     * @return Secret
     */
    public function makeResource(ManifestInterface $manifest, AppInterface $app): Secret
    {
        $secret = new Secret();

        $app->metadataHelper()->configureMeta($manifest, $secret);
        $manifest->data($secret->data());
        $manifest->stringData($secret->stringData());

        return $secret;
    }

    protected function supportsClass(): string
    {
        return SecretInterface::class;
    }
}
