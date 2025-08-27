<?php

namespace Boxy\Facades\Repositories;

use Boxy\Facades\Facade;

class RegisteredCommandsRepositoryFacade extends Facade
{
    protected static function getAccessor(): string
    {
        return 'RegisteredCommandsRepository';
    }
}