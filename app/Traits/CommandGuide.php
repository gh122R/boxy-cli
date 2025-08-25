<?php

declare(strict_types=1);

namespace App\Traits;

trait CommandGuide
{
    use CommandInfo;
    use CommandsLoader;
    use CommandsMatcher;

    public function guideAll(): array
    {
        $commands = commandRepository()->getCommands();


        foreach ($commands as $command) {

            $result[] = [
                'command' => $command['name'],
                'description' => $command['description'] ?? '-',
                'options' => $command['options'] ?? null,
                'flags' => $command['flags'],
                'action' => $command['action'],
                'parameters' => $command['parameters'] ?? null,
            ];
        }

        return $result;
    }
}