<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Entity;

class GetNfeFilterEntity
{
    public function __construct(
        public readonly ?int $limit = null,
        public readonly int $cursor = 1,
    ) {
    }
}
