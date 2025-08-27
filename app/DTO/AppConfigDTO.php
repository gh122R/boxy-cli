<?php

declare(strict_types=1);

namespace Boxy\DTO;

use Boxy\Interfaces\DTO\DTOInterface;
use Boxy\ParentClasses\ConfigDTO;

final class AppConfigDTO extends ConfigDTO implements DTOInterface
{
    public function mount(): void
    {
        $this->config = require CONFIG_DIR . '/app.php';
    }
}