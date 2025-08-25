<?php

declare(strict_types=1);

namespace App\Services;

use League\CLImate\CLImate;

final readonly class MessageService
{
    public function __construct(
        private CLImate $climate
    ) {
    }

    public function success(string $message): void
    {
        $this->climate->backgroundGreen()->white()->bold()->out($message);
    }

    public function error(string $message): void
    {
        $this->climate->backgroundLightRed()->white()->bold()->out($message);
    }

    public function warning(string $message): void
    {
        $this->climate->backgroundYellow()->white()->out($message);
    }

    public function progressBar(callable $callback, int $totalPercent, string $resultMessage = ''): void
    {
        $progress = $this->climate->progress()->total($totalPercent);

        for ($i = 0; $i <= $totalPercent; $i++) {
            $progress->current($i);

            if ($i === $totalPercent) {
                $this->climate->info($resultMessage);
            }
            $callback();
        }
    }
}