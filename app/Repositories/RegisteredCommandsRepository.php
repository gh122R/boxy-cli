<?php

declare(strict_types=1);

namespace Boxy\Repositories;

class RegisteredCommandsRepository
{
    private array $commands = [];

    public function addCommand(
        string $name,
        callable|string|array $action,
        array $options = [],
        array $flags = [],
        mixed $actionParameter = null,
        string $description = ''
    ): bool {
        if (array_key_exists($name, $this->commands)) {
            logger()->error("Команда уже зарегистрирована");

            return false;
        }

        $actionParameter === null
            ? $this->commands[$name] =
            [
                'name' => $name,
                'action' => $action,
                'description' => $description,
                'options' => $options,
                'flags' => $flags,
            ]

            : $this->commands[$name] =
            [
                'name' => $name,
                'action' => $action,
                'parameters' => $actionParameter,
                'description' => $description,
                'options' => $options,
                'flags' => $flags,
            ];

        return true;
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

    public function getCommand(string $commandName): mixed
    {
        return $this->commands[$commandName] ?? null;
    }

    public function hasCommand(string $commandName): bool
    {
        return array_key_exists($commandName, $this->commands);
    }
}