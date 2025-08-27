<?php

declare(strict_types=1);

namespace Boxy\Traits;

use Boxy\Repositories\RegisteredCommandsRepository;
use Boxy\Singletons\Config\DirectoriesDTOSingleton;
use Boxy\Singletons\Config\NamespacesDTOSingleton;
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
        $commandsDirectory = DirectoriesDTOSingleton::getInstance()->commandsDirectory;
        $commandsNamespace = NamespacesDTOSingleton::getInstance()->commandsNamespace;
        $foundCommands = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($commandsDirectory)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && str_ends_with($file->getFilename(), 'Command.php')) {
                $relativePath = str_replace($commandsDirectory . DIRECTORY_SEPARATOR, '', $file->getPathname());

                $className = str_replace([DIRECTORY_SEPARATOR, '.php'], ['\\', ''], $relativePath);
                $fullClassName = $commandsNamespace . $className;

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