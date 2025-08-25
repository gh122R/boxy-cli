<?php

namespace App\Facades\Repositories;

use App\Facades\Facade;

class RegisteredCommandsRepositoryFacade extends Facade
{
    protected static function getAccessor(): string
    {
        return 'RegisteredCommandsRepository';
    }
}