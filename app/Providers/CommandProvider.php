<?php

declare(strict_types=1);

namespace Boxy\Providers;

use Boxy\Interfaces\Provider\ProviderInterface;
use Boxy\Traits\CommandsLoader;
use Boxy\Traits\CommandsRegister;
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