<?php

declare(strict_types=1);

namespace Core\Dependencies\Common\Http;

use Core\Dependencies\Entity\RequestEntity;
use Core\Dependencies\Entity\ResponseEntity;

interface SendRequestGateway
{
    public function get(RequestEntity $request): ResponseEntity;
}
