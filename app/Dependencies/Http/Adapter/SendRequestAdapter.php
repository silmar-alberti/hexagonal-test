<?php

declare(strict_types=1);

namespace App\Dependencies\Http\Adapter;

use Core\Dependencies\Common\Http\SendRequestGateway;
use Core\Dependencies\Entity\RequestEntity;
use Core\Dependencies\Entity\ResponseEntity;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class SendRequestAdapter implements SendRequestGateway
{
    public function __construct(
        private Client $httpClient
    ) {
    }

    public function get(RequestEntity $request): ResponseEntity
    {
        $response = $this->httpClient->request('GET', $request->url, [
            RequestOptions::HEADERS => $request->headers,
            RequestOptions::QUERY => $request->queryParams,
        ]);

        return new ResponseEntity(
            statusCode: $response->getStatusCode(),
            body: (string) $response->getBody(),
            headers: $response->getHeaders(),
        );
    }
}
