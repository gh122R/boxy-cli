<?php

namespace Boxy\Interfaces\DTO;

interface DTOInterface
{
    public function mount(): void;

    public function __get(string $name): mixed;

}