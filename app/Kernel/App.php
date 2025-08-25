<?php

declare(strict_types=1);

namespace App\Kernel;

use App\DTO\AppConfigDTO;
use App\Interfaces\Kernel\AppInterface;
use App\Traits\BootstrapLoader;
use App\Traits\ProvidersLoader;

class App implements AppInterface
{
    use BootstrapLoader;
    use ProvidersLoader;

    public string $name;
    public string $version;
    private AppConfigDTO $appConfigDTO;

    public function __construct()
    {
        $this->runAllBootClasses(
            $this->getBootClasses()
        );

        $this->appConfigDTO = container()->get('AppConfigDTO');

        $this->name = $this->appConfigDTO->appName;
        $this->version = $this->appConfigDTO->appVersion;

        $this->runAllProviders(
            $this->getProviders()
        );
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function getVersion(): string
    {
        return $this->version;
    }
}