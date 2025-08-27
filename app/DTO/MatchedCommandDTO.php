<?php

declare(strict_types=1);

namespace Boxy\DTO;

class MatchedCommandDTO
{
    public function __construct(
        public string $name,
        public mixed $action,
        public mixed $option,
        public array|null $flags,
        public mixed $parameters = null,
    ) {
    }
}