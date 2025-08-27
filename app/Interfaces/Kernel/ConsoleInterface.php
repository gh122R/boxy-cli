<?php

namespace Boxy\Interfaces\Kernel;

interface ConsoleInterface
{
    public function handle(array $argv): mixed;
}