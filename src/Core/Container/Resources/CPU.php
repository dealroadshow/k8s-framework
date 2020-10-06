<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

class CPU implements \JsonSerializable
{
    private const MILLICORES_SUFFIX = 'm';

    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function millicores(int $millicoresNumber): self
    {
        $value = strval($millicoresNumber).self::MILLICORES_SUFFIX;

        return new self($value);
    }

    public static function cores(int $coresNumber): self
    {
        return new self(strval($coresNumber));
    }

    public function jsonSerialize()
    {
        return $this->toString();
    }
}
