<?php

declare(strict_types=1);

namespace App\Exceptions\Modules\DataLoader;

use Exception;
use GuzzleHttp\Psr7\Response;
use Throwable;

class ExternalApiException extends Exception
{
    private Response $response;

    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
}
