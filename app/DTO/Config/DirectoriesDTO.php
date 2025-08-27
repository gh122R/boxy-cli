<?php

declare(strict_types=1);

namespace Boxy\DTO\Config;

use Boxy\Interfaces\DTO\DTOInterface;
use Boxy\ParentClasses\ConfigDTO;

final class DirectoriesDTO extends ConfigDTO implements DTOInterface
{
    public function mount(): void
    {
        $this->config = require CONFIG_DIR . '/directories.php';
    }
}