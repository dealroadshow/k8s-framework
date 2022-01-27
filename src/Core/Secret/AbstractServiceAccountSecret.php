<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Secret;

use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\MetadataConfigurator;

abstract class AbstractServiceAccountSecret extends AbstractSecret
{
    private const ANNOTATION_KEY = 'kubernetes.io/service-account.name';

    abstract protected function serviceAccountName(): string;

    final public function data(StringMap $data): void
    {
        $this->extraData($data);
    }

    final public function stringData(StringMap $stringData): void
    {
    }

    public function metadata(MetadataConfigurator $meta): void
    {
        $meta->annotations()->add(self::ANNOTATION_KEY, $this->serviceAccountName());
    }

    final public function type(): SecretType
    {
        return SecretType::ServiceAccountToken;
    }

    protected function extraData(StringMap $data): void
    {
    }
}
