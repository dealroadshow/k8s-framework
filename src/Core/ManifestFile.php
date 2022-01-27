<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\APIResourceInterface;

class ManifestFile
{
    private string $fileName;
    private APIResourceInterface $resource;

    /**
     * @param string               $fileNameWithoutExtension
     * @param APIResourceInterface $resource
     */
    public function __construct(string $fileNameWithoutExtension, APIResourceInterface $resource)
    {
        $this->fileName = $fileNameWithoutExtension;
        $this->resource = $resource;
    }

    public function fileNameWithoutExtension(): string
    {
        return $this->fileName;
    }

    public function resource(): APIResourceInterface
    {
        return $this->resource;
    }
}
