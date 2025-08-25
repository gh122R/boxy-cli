<?php

namespace App\Interfaces\Env;

interface EnvInterface
{
    public function get(string|array $name): string|array|null;
}