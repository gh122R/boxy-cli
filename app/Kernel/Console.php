<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Exceptions\CommandNotFoundException;
use App\Exceptions\InvalidCommandOptionException;
use App\Interfaces\Kernel\ConsoleInterface;
use App\Services\MessageService;
use App\Traits\CommandsMatcher;
use App\Traits\CommandsParser;
use App\Traits\CommandsRunner;

final class Console implements ConsoleInterface
{
    use CommandsParser;
    use CommandsMatcher;
    use CommandsRunner;

    private MessageService $messageService;

    public function __construct()
    {
        $this->messageService = container()->get('MessageService');
    }

    public function handle(array $argv): mixed
    {
        $repository = container()->get('RegisteredCommandsRepository');
        $parsedCommandData = $this->parseCommand($argv);

        $this->initCommandsMatcher(container()->get('MessageService'));

        try {
            $commandData = $this->match($repository, $parsedCommandData);
        } catch (CommandNotFoundException|InvalidCommandOptionException $exception) {
            $this->messageService->error($exception->getMessage());

            return null;
        }

        return $this->run($commandData);
    }
}