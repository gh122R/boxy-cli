<?php

namespace Boxy\Interfaces\Kernel;
interface AppInterface
{
    public function setName(string $name): void;
    public function getName(): string;

    public function setVersion(string $version): void;
    public function getVersion(): string;

}