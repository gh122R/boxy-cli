<?php

declare(strict_types=1);

namespace Boxy\Kernel;

use Boxy\Exceptions\CommandNotFoundException;
use Boxy\Exceptions\InvalidCommandOptionException;
use Boxy\Interfaces\Kernel\ConsoleInterface;
use Boxy\Services\MessageService;
use Boxy\Traits\CommandsMatcher;
use Boxy\Traits\CommandsParser;
use Boxy\Traits\CommandsRunner;

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