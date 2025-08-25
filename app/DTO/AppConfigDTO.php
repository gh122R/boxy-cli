<?php

declare(strict_types=1);

namespace App\DTO;

final class AppConfigDTO
{
    public array $config;

    public function mount(): void
    {
        $this->config = require CONFIG_DIR . '/app.php';
    }

    public function __get(string $name): mixed
    {
        if (!isset($this->config)) {
            $this->mount();
        }

        return $this->config[$name] ?? null;
    }
}