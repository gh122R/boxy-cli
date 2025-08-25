<?php

declare(strict_types=1);

namespace App\Singletons;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

final class LoggerSingleton
{
    private static ?Logger $instance = null;

    private function __construct()
    {
    }

    protected function __clone()
    {
    }

    public static function getInstance(): Logger
    {
        $container = container();
        $handler = new RotatingFileHandler(
            filename: DEBUG_DIR . '/runtime.log',
            maxFiles: 2
        );

        if (self::$instance === null) {

            if ($container !== null) {
                $handler = $container->get('LoggerHandler');
            }

            self::$instance = new Logger('app');
            self::$instance->pushHandler($handler);
        }

        return self::$instance;
    }
}