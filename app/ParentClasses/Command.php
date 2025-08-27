<?php

declare(strict_types=1);

namespace Boxy\ParentClasses;

class Command
{
    protected string $command;
    protected string $description;
    protected array $options = [];
    protected array $flags = [];
}