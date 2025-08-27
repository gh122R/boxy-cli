<?php

declare(strict_types = 1);

namespace Boxy\Facades\Helpers\Env;

use Boxy\Facades\Facade;

class EnvFacade extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Env';
    }
}