<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;
use Throwable;

final class InvalidCommandOptionException extends RuntimeException
{
    public function __construct(string $commandName, string $commandOption = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = "Опция '$commandOption' не зарегистрирована в команде '$commandName'";

        parent::__construct($message, $code, $previous);
    }
}