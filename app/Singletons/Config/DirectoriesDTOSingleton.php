<?php

declare(strict_types=1);

namespace Boxy\Singletons\Config;

use Boxy\DTO\Config\DirectoriesDTO;

final class DirectoriesDTOSingleton
{
    private static ?DirectoriesDTO $instance = null;

    private function __construct()
    {
    }

    protected function __clone()
    {
    }

    public static function getInstance(): DirectoriesDTO
    {
        if (self::$instance === null) {
            self::$instance = new DirectoriesDTO;
        }

        return self::$instance;
    }
}