<?php

declare(strict_types=1);

namespace App\Adapters\Modules\DataLoader;

use App\Dependencies\Http\Adapter\SendRequestAdapter;
use Core\Dependencies\Entity\RequestEntity;
use Core\Modules\DataLoader\Entity\GetNfeFilterEntity;
use Core\Modules\DataLoader\Entity\NfeEntity;
use Core\Modules\DataLoader\Gateway\FindExternalNfeGateway;

class FindExternalNfeAdapter implements FindExternalNfeGateway
{
    public function __construct(
        private SendRequestAdapter $httpClient,
        private string $baseUri,
        private string $apiId,
        private string $apiKey,
    ) {
    }

    public function get(GetNfeFilterEntity $filter): array
    {

        $filters =  $this->getRequestFilters($filter);

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

    private function getRequestFilters(GetNfeFilterEntity $filter)
    {
        $filterArray = [];
        if ($filter->limit !== null) {
            $filterArray['limit'] = $filter->limit;
        }

        $filterArray['cursor'] = $filter->cursor;

        return $filterArray;
    }
}
