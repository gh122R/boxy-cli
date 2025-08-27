<?php

declare(strict_types=1);

namespace Boxy\Singletons\Config;

use Boxy\DTO\Config\NamespacesDTO;

class NamespacesDTOSingleton
{
    private static ?NamespacesDTO $instance = null;

    private function __construct()
    {
    }

    protected function __clone()
    {
    }

    public static function getInstance(): NamespacesDTO
    {
        if (self::$instance === null) {
            self::$instance = new NamespacesDTO;
        }

        return self::$instance;
    }
}