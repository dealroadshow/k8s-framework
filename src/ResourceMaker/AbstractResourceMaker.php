<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

abstract class AbstractResourceMaker implements ResourceMakerInterface
{
    abstract protected function supportsClass(): string;
    abstract protected function makeResource(ManifestInterface $manifest, AppInterface $app): APIResourceInterface;

    public function make(ManifestInterface $manifest, AppInterface $app): APIResourceInterface
    {
        $this->ensureSupportedInstance($manifest, $app);

        return $this->makeResource($manifest, $app);
    }

    public function supports(ManifestInterface $manifest, AppInterface $app): bool
    {
        $supportedClass = $this->supportsClass();

        return $manifest instanceof $supportedClass;
    }

    protected function ensureSupportedInstance(ManifestInterface $manifest, AppInterface $app)
    {
        $supportedClass = $this->supportsClass();
        if (!$this->supports($manifest, $app)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s::process() only supports instances of %s, instance of %s was given',
                    get_class($this),
                    $supportedClass,
                    get_class($manifest)
                )
            );
        }
    }
}
