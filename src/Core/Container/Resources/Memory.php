<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

class Memory implements \JsonSerializable
{
    private const SUFFIX_MEBIBYTES = 'Mi';
    private const SUFFIX_MEGABYTES = 'M';
    private const SUFFIX_GIGABYTES = 'G';
    private const SUFFIX_GIBIBYTE = 'Gi';

    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function mebibytes(int $mebibytes): self
    {
        $value = \strval($mebibytes).self::SUFFIX_MEBIBYTES;

        return new self($value);
    }

    public static function megabytes(int $megabytes): self
    {
        $value = \strval($megabytes).self::SUFFIX_MEGABYTES;

        return new self($value);
    }

    public static function gigabytes(int $gigabytes): self
    {
        $value = strval($gigabytes).self::SUFFIX_GIGABYTES;

        return new self($value);
    }

    public static function gibibytes(int $gibibytes): self
    {
        $value = strval($gibibytes).self::SUFFIX_GIBIBYTE;

        return new self($value);
    }

    public function jsonSerialize()
    {
        return $this->toString();
    }
}
