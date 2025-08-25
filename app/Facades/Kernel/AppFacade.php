<?php

declare(strict_types = 1);

namespace App\Facades\Kernel;

use App\Facades\Facade;

class AppFacade extends Facade
{
    protected static function getAccessor(): string
    {
        return 'App';
    }
}