<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;
use Throwable;

final class CommandNotFoundException extends RuntimeException
{
    public function __construct(string $commandName = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = "Команда '$commandName' не найдена";

        parent::__construct($message, $code, $previous);
    }
}