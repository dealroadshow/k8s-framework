<?php

namespace Dealroadshow\K8S\Framework\Dumper;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Renderer\YamlRenderer;

class AppDumper
{
    private YamlRenderer $renderer;

    public function __construct(YamlRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param string         $dir
     * @param AppInterface[] $apps
     */
    public function dumpAll(string $dir, iterable $apps): void
    {
        @mkdir($dir, 0777, true);
        foreach ($apps as $app) {
            $appDir = $dir.DIRECTORY_SEPARATOR.$app::name();
            $this->dump($app, $appDir);
        }
    }

    public function dump(AppInterface $app, string $appDir): void
    {
        @mkdir($appDir, 0777, true);
        foreach ($app->manifestFiles() as $file) {
            $yaml = $this->renderer->render($file->resource());
            $filePath = $appDir.DIRECTORY_SEPARATOR.$file->fileNameWithoutExtension().'.yaml';
            file_put_contents($filePath, $yaml);
        }
    }
}
