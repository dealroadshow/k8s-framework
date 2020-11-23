<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

class Memory implements \JsonSerializable
{
    private const SUFFIX_KIBIBYTES = 'Ki';
    private const SUFFIX_MEBIBYTES = 'Mi';
    private const SUFFIX_GIBIBYTES = 'Gi';
    private const SUFFIX_TEBIBYTES = 'Ti';
    private const SUFFIX_PEBIBYTES = 'Pi';
    private const SUFFIX_EXBIBYTES = 'Ei';
    private const VALID_SUFFIXES = [
       self::SUFFIX_KIBIBYTES,
       self::SUFFIX_MEBIBYTES,
       self::SUFFIX_GIBIBYTES,
       self::SUFFIX_TEBIBYTES,
       self::SUFFIX_PEBIBYTES,
       self::SUFFIX_EXBIBYTES,
    ];

    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function bytes(int $bytes): self
    {
        return new self(strval($bytes));
    }

    public static function kibibytes(int $kibibytes): self
    {
        $value = strval($kibibytes).self::SUFFIX_KIBIBYTES;

        return new self($value);
    }

    public static function mebibytes(int $mebibytes): self
    {
        $value = strval($mebibytes).self::SUFFIX_MEBIBYTES;

        return new self($value);
    }

    public static function gibibytes(int $gibibytes): self
    {
        $value = strval($gibibytes).self::SUFFIX_GIBIBYTES;

        return new self($value);
    }

    public static function tebibytes(int $gibibytes): self
    {
        $value = strval($gibibytes).self::SUFFIX_TEBIBYTES;

        return new self($value);
    }

    public static function pebibytes(int $gibibytes): self
    {
        $value = strval($gibibytes).self::SUFFIX_PEBIBYTES;

        return new self($value);
    }

    public static function exbibytes(int $gibibytes): self
    {
        $value = strval($gibibytes).self::SUFFIX_EXBIBYTES;

        return new self($value);
    }

    public static function fromString(string $string): self
    {
        if (is_numeric($string)) {
            return self::bytes($string);
        }

        $pattern = sprintf(
            '/^\d+(%s)$/',
            implode('|', self::VALID_SUFFIXES)
        );

        if (!preg_match($pattern, $string)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid Memory string "%s"', $string)
            );
        }

        return new self($string);
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }
}
