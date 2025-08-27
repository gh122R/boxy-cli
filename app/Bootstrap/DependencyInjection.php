<?php

declare(strict_types=1);

namespace Boxy\Bootstrap;

use Boxy\Container\Container;

use Boxy\DTO\AppConfigDTO;
use Boxy\Facades\Facade;
use Boxy\Helpers\Env\Env;
use Boxy\Helpers\Env\EnvLoader;
use Boxy\Helpers\Env\EnvValidator;
use Boxy\Interfaces\Bootstrap\BootstrapInterface;
use Boxy\Kernel\Console;
use Boxy\Repositories\RegisteredCommandsRepository;
use Boxy\Services\CommandService;
use Boxy\Services\MessageService;
use League\CLImate\CLImate;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

final class DependencyInjection implements BootstrapInterface
{
    public function run(): void
    {
        $container = new Container();

        Facade::setContainer($container);

        $container->singleton('Logger', fn() => new Logger('app'));
        $container->singleton('LoggerHandler', fn() => new RotatingFileHandler(
            filename: DEBUG_DIR . '/runtime.log',
            maxFiles: 2
        ));

        $container->singleton('MessageService', fn() => new MessageService(
            new CLImate()
        ));

        $container->singleton('CommandService', fn() => new CommandService(
            new MessageService(
                new Climate()
            ),
            new CLImate()
        ));

        $container->singleton('Console', fn() => new Console());

        $container->singleton('Env', fn() => new Env(
            new EnvValidator(
                new EnvLoader()
            )
        ));

        $container->singleton('AppConfigDTO', fn() => new AppConfigDTO());

        $container->singleton('Console', fn() => new Console());

        $container->singleton('RegisteredCommandsRepository', fn() => new RegisteredCommandsRepository());
    }
}