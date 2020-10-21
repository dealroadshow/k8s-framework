<?php

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\ResourceMaker\ResourceMakerInterface;

class ManifestProcessor
{
    /**
     * @var ResourceMakerInterface[]|iterable
     */
    private iterable $makers;

    /**
     * @param ResourceMakerInterface[] $makers
     */
    public function __construct(iterable $makers)
    {
        $this->makers = $makers;
    }

    public function process(ManifestInterface $manifest, AppInterface $app): void
    {
        foreach ($this->makers as $maker) {
            if ($maker->supports($manifest, $app)) {
                $resource = $maker->make($manifest, $app);
                $app->addManifestFile($manifest->fileNameWithoutExtension(), $resource);
            }
        }
    }
}
