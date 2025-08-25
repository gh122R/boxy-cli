<?php

declare(strict_types=1);

namespace App\Bootstrap;

use App\Container\Container;
use App\DTO\AppConfigDTO;
use App\Facades\Facade;
use App\Helpers\Env\Env;
use App\Helpers\Env\EnvLoader;
use App\Helpers\Env\EnvValidator;
use App\Interfaces\Bootstrap\BootstrapInterface;
use App\Kernel\Console;
use App\Repositories\RegisteredCommandsRepository;
use App\Services\CommandService;
use App\Services\MessageService;
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