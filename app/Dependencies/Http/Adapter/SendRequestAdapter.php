<?php

declare(strict_types=1);

namespace App\Dependencies\Http\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class SendRequestAdapter
{
    public function __construct(
        private Client $httpClient
    ) {
    }

    public function request(Request $request): Response
    {
        return $this->httpClient->sendRequest($request);
    }
}
