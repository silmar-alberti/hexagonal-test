<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Exception;

use Core\Dependencies\Entity\ResponseEntity;
use Exception;
use Throwable;

class ExternalApiException extends Exception
{
    private ResponseEntity $response;

    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function setResponse(ResponseEntity $response)
    {
        $this->response = $response;
    }
}
