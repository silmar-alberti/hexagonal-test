<?php

declare(strict_types=1);

namespace Core\Modules\GetNfeValue\Entity;

class NfeEntity
{
    public function __construct(
        public readonly string $key,
        public readonly float $totalValue,
    ) {
    }
}
