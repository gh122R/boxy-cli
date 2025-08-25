<?php

declare(strict_types=1);

namespace App\Traits;

trait BootstrapLoader
{
    protected function getBootClasses(): array
    {
        $files = scandir(BOOTSTRAP_DIR, SCANDIR_SORT_NONE);
        $foundBootClasses = [];

        foreach ($files as $file) {
            if (str_ends_with($file, ".php")) {
                $className = pathinfo($file, PATHINFO_FILENAME);
                $fullClassName = "App\\Bootstrap\\$className";

                if (class_exists($fullClassName)) {
                    $foundBootClasses[] = $fullClassName;
                }
            }
        }

        return $foundBootClasses ?? [];
    }

    protected function runBootClass($bootClass): void
    {
        if (!method_exists($bootClass, "run")) {
            logger()->error("Загрузчик $bootClass не реализует метод run");

            return;
        }

        new $bootClass()->run();
    }

    protected function runAllBootClasses(array $bootClasses): bool
    {
        if (empty($bootClasses)) {
            logger()->error("Нет Boostrap - загрузчиков в директории: " . BOOTSTRAP_DIR);

            return false;
        }

        foreach ($bootClasses as $bootClass) {
            $this->runBootClass($bootClass);
        }

        return true;
    }
}