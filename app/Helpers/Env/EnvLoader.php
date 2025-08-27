<?php

declare(strict_types=1);

namespace Boxy\Helpers\Env;

use Boxy\Interfaces\Env\EnvLoaderInterface;
use Dotenv\Dotenv;

final readonly class EnvLoader implements EnvLoaderInterface
{
    private Dotenv $dotenv;

    public function __construct()
    {
        $this->dotenv = Dotenv::createImmutable(ROOT_DIR);
        $this->dotenv->load();
    }

    public function get(): Dotenv
    {
        return $this->dotenv;
    }
}