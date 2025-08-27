<?php

namespace Boxy\Interfaces\Env;

use Dotenv\Dotenv;

interface EnvLoaderInterface
{
    public function get(): Dotenv;
}