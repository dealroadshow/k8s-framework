<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

use LogicException;

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

    private const SUFFIX_MULTIPLIERS  = [
        self::SUFFIX_KIBIBYTES => 1024,
        self::SUFFIX_MEBIBYTES => 1024 * 1024,
        self::SUFFIX_GIBIBYTES => 1024 * 1024 * 1024,
        self::SUFFIX_TEBIBYTES => 1024 * 1024 * 1024 * 1024,
        self::SUFFIX_PEBIBYTES => 1024 * 1024 * 1024 * 1024 * 1024,
        self::SUFFIX_EXBIBYTES => 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
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

    public function greaterThan(Memory $memory): bool
    {
        return $this->bytesNumber() > $memory->bytesNumber();
    }

    public function lowerThan(Memory $memory): bool
    {
        return $this->bytesNumber() < $memory->bytesNumber();
    }

    public function equals(Memory $memory): bool
    {
        return $this->bytesNumber() === $memory->bytesNumber();
    }

    public function bytesNumber(): int
    {
        if (is_numeric($this->value)) {
            return (int)$this->value;
        }

        $pattern = '/(\d+)([a-z]+)/ui';
        preg_match($pattern, $this->value, $matches);
        $number = (int)$matches[1];
        $suffix = $matches[2] ?? null;
        if (!$suffix || !array_key_exists($suffix, self::SUFFIX_MULTIPLIERS)) {
            throw new LogicException(sprintf('Invalid Memory value format: "%s"', $this->value));
        }

        return $number * self::SUFFIX_MULTIPLIERS[$suffix];
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
