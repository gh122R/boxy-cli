<?php

declare(strict_types=1);

namespace Boxy\Traits;

use Boxy\DTO\ParsedCommandsDTO;

trait CommandsParser
{
    public function parseCommand(array $argv): ParsedCommandsDTO
    {
        if (count($argv) < 3) {
            $argv[] = env('basic_command');
        }

        $separator = env('command_separator');
        $flagPointer = env('flag_pointer');
        $flags = [];

        array_shift($argv);

        $commandData = explode($separator, $argv[0]);

        if (count($commandData) === 2) {
            [$command, $parameter] = $commandData;
        } else {
            $command = $commandData[0];
            $parameter = null;
        }

        foreach ($argv as $item) {
            if ($item == str_starts_with($item, $flagPointer)) {
                $item = str_replace($flagPointer, "", $item);

                $flags[] = $item;
            }
        }

        return new ParsedCommandsDTO(
            command: $command,
            option: $parameter,
            flags: $flags
        );
    }
}