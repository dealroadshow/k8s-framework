<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Dumper;

use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Renderer\RendererInterface;

class AppDumper
{
    public function __construct(private RendererInterface $renderer, private AppRegistry $appRegistry)
    {
    }

    public function dump(string $appAlias, string $appDir): void
    {
        @mkdir($appDir, 0o777, true);
        $app = $this->appRegistry->get($appAlias);
        foreach ($app->manifestFiles() as $file) {
            $rendered = $this->renderer->render($file->resource());
            $filePath = $appDir.DIRECTORY_SEPARATOR.$file->fileNameWithoutExtension().$this->renderer->fileExtension();
            file_put_contents($filePath, $rendered);
        }
    }
}
