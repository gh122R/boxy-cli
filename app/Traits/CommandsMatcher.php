<?php

declare(strict_types=1);

namespace Boxy\Traits;

use Boxy\DTO\MatchedCommandDTO;
use Boxy\DTO\ParsedCommandsDTO;
use Boxy\Exceptions\CommandNotFoundException;
use Boxy\Exceptions\InvalidCommandOptionException;
use Boxy\Repositories\RegisteredCommandsRepository;
use Boxy\Services\MessageService;

trait CommandsMatcher
{
    private MessageService $messageService;

    public function initCommandsMatcher(MessageService $messageService): void
    {
        $this->messageService = $messageService;
    }

    public function match(RegisteredCommandsRepository $repository, ParsedCommandsDTO $dto): MatchedCommandDTO
    {
        $foundCommand = $repository->getCommand($dto->command);
        $flags = null;

        if ($foundCommand === null) {
            throw new CommandNotFoundException($dto->command);
        }

        $foundCommandFlags = $foundCommand['flags'];
        $foundCommandOptions = $foundCommand['options'];

        foreach ($dto->flags as $flag) {
            if (!array_key_exists($flag, $foundCommandFlags)) {
                $this->messageService->warning("Флаг $flag не зарегистрирован в команде $dto->command");
            } else {
                $flags[$flag] = $foundCommandFlags[$flag];
            }
        }

        if ($dto->option !== null && !array_key_exists($dto->option, $foundCommandOptions)) {
            throw new InvalidCommandOptionException($dto->command, $dto->option);
        }

        $name = $foundCommand['name'];
        $action = $foundCommand['action'];

        $preliminaryOption = $foundCommandOptions[$dto->option] ?? null;

        if ($preliminaryOption !== null) {
            $option = [
                $preliminaryOption
            ];
        } else {
            $option = null;
        }

        $parameters = $foundCommand['parameters'] ?? null;

        return new MatchedCommandDTO(
            name: $name,
            action: $action,
            option: $option,
            flags: $flags,
            parameters: $parameters
        );
    }
}