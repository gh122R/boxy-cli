<?php

namespace App\Interfaces\Kernel;

interface ConsoleInterface
{
    public function handle(array $argv): mixed;
}