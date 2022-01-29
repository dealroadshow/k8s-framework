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

    /**
     * @param string         $dir
     * @param string[]       $appsAliases
     */
    public function dumpAll(string $dir, iterable $appsAliases): void
    {
        @mkdir($dir, 0o777, true);
        foreach ($appsAliases as $alias) {
            $appDir = $dir.DIRECTORY_SEPARATOR.$alias;
            $this->dump($alias, $appDir);
        }
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
