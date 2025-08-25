<?php

declare(strict_types=1);

namespace App\Helpers\Env;

use App\Interfaces\Env\EnvValidatorInterface;
use Exception;

final readonly class EnvValidator implements EnvValidatorInterface
{
    public function __construct(
        private EnvLoader $envLoader
    ) {
    }

    public function validate(): bool
    {
        try {
            $this->envLoader->get()
                ->required(
                    [
                        'APP_NAME',
                        'APP_VERSION',
                        'COMMAND_SEPARATOR',
                        'FLAG_POINTER',
                        'BASIC_COMMAND'
                    ]
                )
                ->notEmpty();

            return true;
        } catch (Exception) {
            return false;
        }
    }
}