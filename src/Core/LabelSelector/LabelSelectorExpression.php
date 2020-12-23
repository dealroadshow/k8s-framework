<?php

namespace Dealroadshow\K8S\Framework\Core\LabelSelector;

use Dealroadshow\K8S\Data\LabelSelectorRequirement;

class LabelSelectorExpression
{
    protected string $key;
    protected ?string $operator = null;
    protected ?array $values = null;

    protected function __construct(string $key)
    {
        $this->key = $key;
    }

    public function toLabelSelectorRequirement(): LabelSelectorRequirement
    {
        $selector = new LabelSelectorRequirement($this->key, $this->operator());
        if (null !== $this->values) {
            $selector->values()->addAll($this->values);
        }

        return $selector;
    }

    public function in(array $values): self
    {
        $this->ensureImmutableOperator();
        $this->operator = Operator::IN;
        $this->values = array_values($values);

        return $this;
    }

    public function notIn(array $values): self
    {
        $this->ensureImmutableOperator();
        $this->operator = Operator::NOT_IN;
        $this->values = array_values($values);

        return $this;
    }

    public function exists(): self
    {
        $this->ensureImmutableOperator();
        $this->operator = Operator::EXISTS;

        return $this;
    }

    public function doesNotExist(): self
    {
        $this->ensureImmutableOperator();
        $this->operator = Operator::DOES_NOT_EXIST;

        return $this;
    }

    public static function withKey(string $key): static
    {
        return new self($key);
    }

    protected function operator(): string
    {
        if (null === $this->operator) {
            throw new \LogicException(
                sprintf(
                    'Operator is not set on %s instance for key "%s"',
                    get_class($this),
                    $this->key
                )
            );
        }

        return $this->operator;
    }

    protected function ensureImmutableOperator()
    {
        if (null === $this->operator) {
            return;
        }
        throw new \LogicException(
            sprintf(
                'Repeated attempt to set operator on %s instance. Rule must be set only once.',
                get_class($this)
            )
        );
    }
}
