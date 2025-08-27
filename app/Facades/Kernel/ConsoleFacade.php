<?php

declare(strict_types=1);

namespace Boxy\Facades\Kernel;

use Boxy\Facades\Facade;

/**
 * @method static handle(string[] $argv)
 */
class ConsoleFacade extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Console';
    }
}