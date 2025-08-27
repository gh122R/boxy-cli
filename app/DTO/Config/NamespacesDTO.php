<?php

declare(strict_types=1);

namespace Boxy\DTO\Config;

use Boxy\Interfaces\DTO\DTOInterface;
use Boxy\ParentClasses\ConfigDTO;

final class NamespacesDTO extends ConfigDTO implements DTOInterface
{
    public function mount(): void
    {
        $this->config = require CONFIG_DIR . '/namespaces.php';
    }
}