<?php

declare(strict_types=1);

namespace Boxy\Traits;

trait CommandsRegister
{
    public function register(
        string $command,
        array|string|callable $action,
        array $options = [],
        array $flags = [],
        mixed $actionParameter = null,
        string $description = ''
    ): void {
        container()->get('RegisteredCommandsRepository')->addCommand(
            name: $command,
            action: $action,
            options: $options,
            flags: $flags,
            actionParameter: $actionParameter,
            description: $description
        );
    }
}