<?php

declare(strict_types=1);

namespace Core\Dependencies\Entity;

class RequestEntity
{
    public function __construct(
        public readonly string $url,
        public readonly array $queryParams = [],
        public readonly array $headers = [],
    ) {
    }
}
