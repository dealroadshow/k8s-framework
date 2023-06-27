<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Image;

class Image
{
    private string $name;
    private ?string $registryUrl;
    private ?string $tag;
    private ?string $prefix = null;

    private function __construct(string $name, ?string $registryUrl, ?string $tag)
    {
        $name = trim($name, '/');
        if (null !== $registryUrl) {
            $registryUrl = rtrim($registryUrl, '/');
        }

        $this->name = $name;
        $this->registryUrl = $registryUrl;
        $this->tag = $tag;
    }

    public function imageName(): string
    {
        return $this->name;
    }

    public function registryUrl(): string|null
    {
        return $this->registryUrl;
    }

    public function tag(): string|null
    {
        return $this->tag;
    }

    public function fullName(): string
    {
        $fullName = '';
        if ($this->registryUrl) {
            $fullName .= $this->registryUrl.'/';
        }
        if (null !== $this->prefix) {
            $fullName .= $this->prefix.'/';
        }
        $fullName .= $this->name;
        if (null !== $this->tag) {
            $separator = ':';
            if (str_contains($this->tag, ':')) {
                $separator = '@';
            }

            $fullName .= $separator.$this->tag;
        }

        return $fullName;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setRegistryUrl(string $registryUrl): self
    {
        $this->registryUrl = $registryUrl;

        return $this;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function setPrefix(string $prefix): self
    {
        $this->prefix = trim($prefix, '/');

        return $this;
    }

    public static function fromName(string $name): static
    {
        return new static($name, null, null);
    }

    public static function fromString(string $string): static
    {
        if (preg_match('#(.+)/(.+):(.+)#', $string, $matches)) {
            return new self($matches[2], $matches[1], $matches[3]);
        }
        if (preg_match('#(.+):(.+)#', $string, $matches)) {
            return new self($matches[1], null, $matches[2]);
        }
        return new static($string, null, null);
    }
}
