<?php

declare(strict_types=1);

namespace App\Traits;

use ReflectionProperty;
use Throwable;

trait CommandInfo
{
    protected function getCommandProperties($command): array
    {
        try {
            $instance = new $command();

            $commandName = property_exists($instance, 'command')
                ? new ReflectionProperty($instance, 'command')->getValue($instance)
                : null;

            $commandDescription = property_exists($instance, 'description')
                ? new ReflectionProperty($instance, 'description')->getValue($instance)
                : null;

            $commandOptions = property_exists($instance, 'options')
                ? new ReflectionProperty($instance, 'options')->getValue($instance)
                : [];

            $commandFlags = property_exists($instance, 'flags')
                ? new ReflectionProperty($instance, 'flags')->getValue($instance)
                : [];

            return [
                'command' => $commandName,
                'description' => $commandDescription,
                'options' => $commandOptions,
                'flags' => $commandFlags,
                'callback' => $command
            ];

        } catch (Throwable) {
            return [
                'command' => $command,
                'description' => 'Ошибка при получении свойств',
                'options' => [],
                'flags' => [],
            ];
        }
    }
}