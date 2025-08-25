<?php

namespace App\Interfaces\Env;

use Dotenv\Dotenv;

interface EnvLoaderInterface
{
    public function get(): Dotenv;
}