<?php

declare(strict_types=1);

namespace App\Adapters\Modules\DataLoader\Repository;

use App\Dependencies\Http\Adapter\SendRequestAdapter;
use Core\Dependencies\Entity\RequestEntity;
use Core\Modules\DataLoader\Entity\GetNfeFilterEntity;
use Core\Modules\DataLoader\Entity\NfeEntity;
use Core\Modules\DataLoader\Gateway\FindNfeGateway;

class FindNfeAdapter implements FindNfeGateway
{
    public function __construct(
        private SendRequestAdapter $httpClient,
        private string $baseUri,
        private string $apiId,
        private string $apiKey,
    ) {
    }

    public function get(?GetNfeFilterEntity $filter = null): array
    {
        $filters = [];
        if ($filter !== null && $filter->limit !== null) {
            $filters['limit'] = $filter->limit;
        }

        $response = $this->httpClient->get(new RequestEntity(
            url: $this->baseUri . '/v1/nfe/received',
            queryParams: $filters,
            headers: [
                'x-api-id' => $this->apiId,
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ));

        if ($response->statusCode !== 200) {
            // TODO Exception here
        }

        $data = json_decode($response->body);

        return array_map(function (object $nfeData) {
            $xmlString = base64_decode($nfeData->xml);
            $xmlObject = simplexml_load_string($xmlString);
            return new NfeEntity(
                key: $nfeData->access_key,
                xml: $xmlObject,
            );
        }, $data->data);
    }
}
