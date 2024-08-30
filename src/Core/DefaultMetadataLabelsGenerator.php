<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Util\ManifestAppFinder;
use Dealroadshow\K8S\Framework\Util\ManifestShortName;
use Dealroadshow\K8S\Framework\Util\PropertyAccessor;

readonly class DefaultMetadataLabelsGenerator
{
    public function __construct(private AppRegistry $appRegistry, private ManifestAppFinder $appFinder)
    {
    }

    public function byManifestClass(string $manifestClass, string|null $appAlias = null): array
    {
        $app = null === $appAlias
            ? $this->appFinder->appByManifestClass($manifestClass)
            : $this->appRegistry->get($appAlias);

        if (!$app->ownsManifest($manifestClass)) {
            throw new \LogicException(sprintf('Manifest "%s" does not belong to app "%s"', $manifestClass, $app->alias()));
        }

        $manifest = $app->getManifest($manifestClass);

        return self::labels($manifest, $app);
    }

    public function byManifestInstance(ManifestInterface $manifest): array
    {
        /** @var AppInterface $app */
        $app = PropertyAccessor::get($manifest, 'app');

        return self::labels($manifest, $app);
    }

    private static function labels(ManifestInterface $manifest, AppInterface $app): array
    {
        return [
            'app' => $app->alias(),
            'component' => ManifestShortName::getFrom($manifest),
        ];
    }
}
