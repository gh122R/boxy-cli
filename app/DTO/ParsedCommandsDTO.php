<?php

declare(strict_types=1);

namespace Boxy\DTO;

class ParsedCommandsDTO
{
    public function __construct(
        public string $command,
        public array|string|null $option,
        public array $flags,
        public array $parameters,
    ) {
    }
}