<?php

declare(strict_types=1);

namespace Core\Dependencies\Entity;

class ResponseEntity
{
    public function __construct(
        public readonly int $statusCode,
        public readonly string $body = '',
        public readonly array $headers = [],
    ) {
    }
}
