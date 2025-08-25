<?php

namespace App\DTO;

class ParsedCommandsDTO
{
    public function __construct(
        public string $command,
        public array|string|null $option,
        public array $flags,
    ) {
    }
}