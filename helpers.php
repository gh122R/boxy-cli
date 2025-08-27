<?php

declare(strict_types=1);

use Boxy\Container\Container;
use Boxy\Facades\Facade;
use Boxy\Repositories\RegisteredCommandsRepository;
use Boxy\Services\CommandService;
use Boxy\Singletons\LoggerSingleton;
use Monolog\Logger;

if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        $container = Facade::getContainer();

        if ($container && $container->singletonHas('Env')) {
            return $container->get('Env')->get($key) ?? $default;
        }

        return $default;
    }
}

if (!function_exists('container')) {
    function container(): Container|null
    {
        return Facade::getContainer();
    }
}

if (!function_exists('commandRepository')) {
    function commandRepository(): RegisteredCommandsRepository|null
    {
        return Facade::getContainer()->get('RegisteredCommandsRepository');
    }
}

if (!function_exists('commandService')) {
    function commandService(): CommandService|null
    {
        return Facade::getContainer()->get('CommandService');
    }
}

if (!function_exists('logger')) {
    function logger(): Logger|null
    {
        return LoggerSingleton::getInstance();
    }
}