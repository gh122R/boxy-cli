<?php

declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\Provider\ProviderInterface;
use App\Traits\CommandsLoader;
use App\Traits\CommandsRegister;
use Command\TestCommand;

final class CommandProvider implements ProviderInterface
{
    use CommandsRegister;
    use CommandsLoader;

    public function boot(): void
    {
        $this->register(
            command: 'testCommand',
            action:  [TestCommand::class, 'test'],
            actionParameter: [123,456]
        );

        $this->CommandsLoaderInit(
            commandRepository()
        );

        $commands =  $this->getCommands();

        $this->registerCommands($commands);
    }
}