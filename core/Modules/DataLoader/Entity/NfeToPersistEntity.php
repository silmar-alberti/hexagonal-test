<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Entity;

class NfeToPersist
{
    public function __construct(
        private readonly string $key,
        private readonly float $value,
    ) {
    }
}
