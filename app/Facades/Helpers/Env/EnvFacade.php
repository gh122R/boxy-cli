<?php

declare(strict_types = 1);

namespace App\Facades\Helpers\Env;

use App\Facades\Facade;

class EnvFacade extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Env';
    }
}