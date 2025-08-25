<?php

declare(strict_types=1);

namespace App\Traits;

use App\Repositories\RegisteredCommandsRepository;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

trait CommandsLoader
{
    use CommandInfo;
    private RegisteredCommandsRepository $repository;

    public function CommandsLoaderInit(RegisteredCommandsRepository $repository): void
    {
        $this->repository = $repository;
    }

    protected function getCommands(): array
    {
        $foundCommands = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(COMMANDS_DIR)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && str_ends_with($file->getFilename(), 'Command.php')) {
                $relativePath = str_replace(COMMANDS_DIR . DIRECTORY_SEPARATOR, '', $file->getPathname());

                $className = str_replace([DIRECTORY_SEPARATOR, '.php'], ['\\', ''], $relativePath);
                $fullClassName = "Command\\$className";

                if (class_exists($fullClassName)) {
                    $foundCommands[] = $fullClassName;
                }
            }
        }

        return $foundCommands;
    }

    protected function registerCommands(array $commands): void
    {
        foreach ($commands as $command) {
            if (!method_exists($command, '__invoke')) {
                return;
            }

            $commandData = $this->getCommandProperties($command);

            $this->repository->addCommand(
                name: $commandData['command'],
                action: $command,
                options: $commandData['options'],
                flags: $commandData['flags'],
                description: $commandData['description'],
            );
        }
    }
}