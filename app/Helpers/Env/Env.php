<?php

declare(strict_types=1);

namespace App\Helpers\Env;

use App\Interfaces\Env\EnvInterface;;

final readonly class Env implements EnvInterface
{
    public function __construct(
        private EnvValidator $envValidator,
    ) {
    }

    public function get(string|array $name): string|array|null
    {
        $items = null;
        $fallback = '.env не прошёл валидацию. Проверьте обязательные поля';

        if ($this->envValidator->validate() === false) {
            logger()->error($fallback);

            return $fallback;
        }

        if (is_array($name)) {
            foreach ($name as $item) {
                $items[strtoupper($item)] = $_ENV[strtoupper($item)];
            }

            return $items;
        }

        return $_ENV[strtoupper($name)] ?? null;
    }
}