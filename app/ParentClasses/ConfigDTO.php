<?php

namespace Boxy\ParentClasses;

class ConfigDTO
{
    public array $config;

    public function mount(): void
    {
    }

    public function __get(string $name): mixed
    {
        if (!isset($this->config)) {
            $this->mount();
        }

        return $this->config[$name] ?? null;
    }
}