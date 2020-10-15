<?php

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Middleware\MiddlewareInterface;
use Dealroadshow\K8S\Framework\ResourceMaker\ResourceMakerInterface;

class ManifestProcessor
{
    /**
     * @var ResourceMakerInterface[]|iterable
     */
    private iterable $makers;
    /**
     * @var MiddlewareInterface[]|iterable
     */
    private iterable $middlewareHandlers;

    /**
     * @param ResourceMakerInterface[]|iterable
     * @param MiddlewareInterface[]|iterable
     */
    public function __construct(iterable $makers, iterable $middlewareHandlers)
    {
        $this->makers = $makers;
        $this->middlewareHandlers = $middlewareHandlers;
    }

    public function process(ManifestInterface $manifest, AppInterface $app): void
    {
        foreach ($this->makers as $maker) {
            if ($maker->supports($manifest, $app)) {
                foreach ($this->middlewareHandlers as $middleware) {
                    $middleware->before($manifest);
                }
                $resource = $maker->make($manifest, $app);
                foreach ($this->middlewareHandlers as $middleware) {
                    $middleware->after($manifest, $resource);
                }
                $app->addManifestFile($manifest->fileNameWithoutExtension(), $resource);
            }
        }
    }
}
