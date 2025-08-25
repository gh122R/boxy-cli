<?php

namespace App\Interfaces\Env;

interface EnvValidatorInterface
{
    public function validate(): bool;
}