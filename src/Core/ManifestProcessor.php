<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\ResourceMaker\AbstractResourceMaker;
use Dealroadshow\K8S\Framework\ResourceMaker\ResourceMakerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class ManifestProcessor
{
    /**
     * @var ResourceMakerInterface[]
     */
    private array $makers = [];

    /**
     * @param ResourceMakerInterface[] $makers
     */
    public function __construct(EventDispatcherInterface $dispatcher, iterable $makers)
    {
        foreach ($makers as $maker) {
            if ($maker instanceof AbstractResourceMaker) {
                $maker->setEventDispatcher($dispatcher);
            }
            $this->makers[] = $maker;
        }
    }

    public function process(ManifestInterface $manifest, AppInterface $app): void
    {
        $manifest->setConfig($app->manifestConfig($manifest::shortName()));
        foreach ($this->makers as $maker) {
            if ($maker->supports($manifest, $app)) {
                $resource = $maker->make($manifest, $app);
                $app->addManifestFile($manifest->fileNameWithoutExtension(), $resource);

                return;
            }
        }
    }
}
