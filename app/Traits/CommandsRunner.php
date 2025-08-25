<?php

declare(strict_types=1);

namespace App\Traits;

use App\DTO\MatchedCommandDTO;

trait CommandsRunner
{
    private mixed $action;
    private mixed $parameters;
    private array|null $option;
    private array|null $flags;

    public function run(MatchedCommandDTO $dto): mixed
    {
        $this->action = $dto->action;
        $this->parameters = $dto->parameters;
        $this->option = $dto->option;
        $this->flags = $dto->flags;

        if ($this->flags !== null) {
            $this->runFlags();
        }

        if ($this->option !== null) {
            return $this->runOption();
        }

        if ($this->parameters !== null) {
            return $this->runActionWithParam();
        }

        if (is_array($this->action)) {
            [$class, $method] = $this->action;

            $instance = new $class();
            return $instance->$method();
        }

        if (is_string($this->action)) {
            if (class_exists($this->action) && method_exists($this->action, '__invoke')) {
                $action = new $this->action();

                return $action();
            }
        }

        if (is_callable($this->action)) {
            $callback = $this->action;

            return $callback();
        }

        return null;
    }

    private function runActionWithParam()
    {
        if (is_array($this->action)) {
            [$class, $method] = $this->action;

            $instance = new $class();

            return is_array($this->parameters)
                ? $instance->$method(...$this->parameters)
                : $instance->$method($this->parameters);
        }

        if (is_string($this->action)) {
            if (class_exists($this->action) && method_exists($this->action, '__invoke')) {
                $action = new $this->action();

                return is_array($this->parameters)
                    ? $action(...$this->parameters)
                    : $action($this->parameters);
            }
        }

        if (is_callable($this->action)) {
            $callback = $this->action;

            return is_array($this->parameters)
                ? $callback(...$this->parameters)
                : $callback($this->parameters);
        }

        return null;
    }

    private function runFlags()
    {
        foreach ($this->flags as $flag) {
            [$class, $action] = $flag;

            if (is_string($class)) {
                if (!class_exists($class)) {
                    return null;
                }

                new $class()->$action();
            }

             $class->$action();
        }
    }

    private function runOption()
    {
        [$class, $action] = $this->option[0];

        if (is_string($class)) {
            if (!class_exists($class)) {
                return null;
            }

            return new $class()->$action();
        }

        return $class->$action();
    }
}