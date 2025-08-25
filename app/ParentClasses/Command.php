<?php

declare(strict_types=1);

namespace App\ParentClasses;

class Command
{
    protected string $command;
    protected string $description;
    protected array $options = [];
    protected array $flags = [];
}