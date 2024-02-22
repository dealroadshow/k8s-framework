<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Toleration;

use Dealroadshow\K8S\Data\Collection\TolerationList;
use Dealroadshow\K8S\Data\Toleration;

class TolerationsConfigurator
{
    public function __construct(private TolerationList $tolerations)
    {
    }

    public function add(
        string|null $key,
        TolerationOperator $operator = TolerationOperator::Equal,
        string|null $value = null,
        TolerationEffect|null $effect = null,
        int|null $tolerationSeconds = null
    ): static {
        if (!$key && $operator !== TolerationOperator::Exists) {
            throw new \InvalidArgumentException('Operator must be "Exists" if $key is empty.');
        }

        if (null !== $tolerationSeconds && $effect !== TolerationEffect::NoExecute) {
            throw new \InvalidArgumentException('$effect must be "NoExecute" if $tolerationSeconds is set.');
        }

        if (null !== $value && $operator === TolerationOperator::Exists) {
            throw new \InvalidArgumentException('$value must be empty if $operator is "Exists".');
        }

        $toleration = new Toleration();

        if ($key) {
            $toleration->setKey($key);
        }
        $toleration->setOperator($operator->value);
        if ($value) {
            $toleration->setValue($value);
        }
        if ($effect) {
            $toleration->setEffect($effect);
        }
        if ($tolerationSeconds) {
            $toleration->setTolerationSeconds($tolerationSeconds);
        }

        $this->tolerations->add($toleration);

        return $this;
    }
}
