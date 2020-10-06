<?php

namespace Dealroadshow\K8S\Framework\Core\Pod\Affinity;

use Dealroadshow\K8S\Framework\Core\LabelSelector\LabelSelectorExpression;

class PodAffinityExpression extends LabelSelectorExpression
{
    const TARGET_LABEL = 'label';
    const TARGET_FIELD = 'field';

    protected string $target;

    protected function __construct(string $target, string $key)
    {
        $this->target = $target;
        parent::__construct($key);
    }

    public function target(): string
    {
        return $this->target;
    }

    /**
     * @param string $key
     *
     * @return static
     */
    public static function field(string $key): self
    {
        return new static(self::TARGET_FIELD, $key);
    }

    /**
     * @param string $key
     *
     * @return static
     */
    public static function label(string $key): self
    {
        return new static(self::TARGET_LABEL, $key);
    }
}
