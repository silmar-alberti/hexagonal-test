<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Entity;

class NfeToPersistEntity
{
    public function __construct(
        public readonly string $key,
        public readonly float $totalValue,
    ) {
    }
}
