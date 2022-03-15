<?php

declare(strict_types=1);

namespace Tests\Infraestructure\Modules\DataLoader;

use App\Adapters\Modules\DataLoader\FindExternalNfeAdapter;
use App\Dependencies\Http\Adapter\SendRequestAdapter;
use App\Exceptions\Modules\DataLoader\ExternalApiException;
use Core\Modules\DataLoader\Entity\GetNfeFilterEntity;
use Core\Modules\DataLoader\Entity\NfeEntity;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class FindExternalNfeAdapterTest extends TestCase
{
    private  $sendRequestMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->sendRequestMock = $this->createMock(SendRequestAdapter::class);
    }
    public function testApiRequest()
    {
        $uri = new Uri('baseUri/v1/nfe/received');
        $uri = URI::withQueryValues($uri, [
            'limit' => 10,
            'cursor' => 50,
        ]);

        $expectedRequestEntity = new Request(
            method:'GET',
            uri:  $uri,
            headers: [
                'x-api-id' => 'apiId',
                'x-api-key' => 'apiKey',
                'Content-Type' => 'application/json',
            ],
        );

        $this->sendRequestMock
            ->expects($this->once())
            ->method('request')
            ->with($expectedRequestEntity)
            ->willReturn(new Response(
                status: 200,
                body: json_encode([
                    'data' => []
                ])
            ));

        $adapter = new FindExternalNfeAdapter(
            httpClient: $this->sendRequestMock,
            baseUri: 'baseUri',
            apiId: 'apiId',
            apiKey: 'apiKey',
        );

        $this->assertEmpty($adapter->get(new GetNfeFilterEntity(10, 50)));
    }

    public function testShouldThrowExeption()
    {
        $this->sendRequestMock
            ->method('request')
            ->willReturn(new Response(
                status: 403,
                body: json_encode([
                    'error' => 'testError',
                ])
            ));


        $adapter = new FindExternalNfeAdapter(
            httpClient: $this->sendRequestMock,
            baseUri: '',
            apiId: '',
            apiKey: '',
        );
        $this->expectException(ExternalApiException::class);

        $adapter->get(new GetNfeFilterEntity());
    }

    public function testShouldReturnOneNfe()
    {

        $this->sendRequestMock
            ->method('request')
            ->willReturn(new Response(
                status: 200,
                body: json_encode([
                    'data' => [
                        [
                            'xml' => base64_encode('<xml></xml>'),
                            'access_key' => '789',
                        ]
                    ]
                ])
            ));

        $expectNfeEntity = new NfeEntity(
            '789',
            new SimpleXMLElement('<xml></xml>')
        );

        $adapter = new FindExternalNfeAdapter(
            httpClient: $this->sendRequestMock,
            baseUri: '',
            apiId: '',
            apiKey: '',
        );

        $nfes = $adapter->get(new GetNfeFilterEntity());

        $this->assertCount(1, $nfes);
        $this->assertEquals($expectNfeEntity, reset($nfes));
    }
}
