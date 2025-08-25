<?php

declare(strict_types=1);

namespace App\Traits;

trait ProvidersLoader
{
    protected function getProviders(): array
    {
        $files = scandir(PROVIDERS_DIR, SCANDIR_SORT_NONE);

        foreach ($files as $file) {
            if (str_ends_with($file, "Provider.php")) {
                $className = pathinfo($file, PATHINFO_FILENAME);
                $fullClassName = "App\\Providers\\$className";

                if (class_exists($fullClassName)) {
                    $foundProviders[] = $fullClassName;
                }
            }
        }

        return $foundProviders ?? [];
    }

    protected function runProvider($provider): void
    {
        if (!method_exists($provider, "boot")) {
            logger()->error("Провайдер $provider не реализует метод boot");

            return;
        }

        new $provider()->boot();
    }

    protected function runAllProviders(array $providers): bool
    {
        foreach ($providers as $provider) {
            $this->runProvider($provider);
        }

        return true;
    }
}