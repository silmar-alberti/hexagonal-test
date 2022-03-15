<?php

declare(strict_types=1);

namespace App\Adapters\Modules\DataLoader;

use App\Dependencies\Http\Adapter\SendRequestAdapter;
use App\Exceptions\Modules\DataLoader\ExternalApiException;
use Core\Modules\DataLoader\Entity\GetNfeFilterEntity;
use Core\Modules\DataLoader\Entity\NfeEntity;
use Core\Modules\DataLoader\Gateway\FindExternalNfeGateway;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

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

        $uri = new Uri($this->baseUri . '/v1/nfe/received');
        $uri = URI::withQueryValues($uri, $filters);
        $request = new Request(
            method:'GET',
            uri:  $uri,
            headers: [
                'x-api-id' => $this->apiId,
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        );
        $response = $this->httpClient->request($request);

        if ($response->getStatusCode() !== 200) {
            $exception = new ExternalApiException('Error on get new nfes');
            $exception->setResponse($response);

            throw $exception;
        }

        $data = json_decode((string) $response->getBody());

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

        $filterArray['limit'] = $filter->limit;
        $filterArray['cursor'] = $filter->cursor;

        return $filterArray;
    }
}
