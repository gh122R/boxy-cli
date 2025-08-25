<?php

namespace App\Container;

use Exception;

final class Container
{
    protected array $bindings = [];
    protected array $singletons = [];

    public function bind(string $key, callable $action): void
    {
        $this->bindings[$key] = $action;
    }

    public function singleton(string $key, callable $action): void
    {
        $this->singletons[$key] = $action();
    }

    public function singletonHas(string $key): bool
    {
        return array_key_exists($key, $this->singletons);
    }

    public function bindingsHas(string $key): bool
    {
        return array_key_exists($key, $this->bindings);
    }

    public function make(string $key)
    {
        return call_user_func($this->bindings[$key]);
    }

    public function get(string $key): object|null
    {
        try {
            return $this->singletons[$key];
        } catch (Exception) {
            logger()->emergency("Не найден объект по ключу $key");
        }

        return null;
    }
}