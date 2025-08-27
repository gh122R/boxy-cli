<?php

declare(strict_types = 1);

namespace Boxy\Facades\Kernel;

use Boxy\Facades\Facade;

class AppFacade extends Facade
{
    protected static function getAccessor(): string
    {
        return 'App';
    }
}