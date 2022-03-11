<?php

declare(strict_types=1);

namespace Tests\InfraEstructure\Modules\DataLoader;

use App\Adapters\Modules\DataLoader\FindExternalNfeAdapter;
use App\Dependencies\Http\Adapter\SendRequestAdapter;
use Core\Dependencies\Entity\RequestEntity;
use Core\Dependencies\Entity\ResponseEntity;
use Core\Modules\DataLoader\Entity\GetNfeFilterEntity;
use Core\Modules\DataLoader\Entity\NfeEntity;
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
        $expectedRequestEntity = new RequestEntity(
            url: 'baseUri/v1/nfe/received',
            queryParams: [
                'limit' => 10,
                'cursor' => 50,
            ],
            headers: [
                'x-api-id' => 'apiId',
                'x-api-key' => 'apiKey',
                'Content-Type' => 'application/json',
            ],
        );

        $this->sendRequestMock
            ->expects($this->once())
            ->method('get')
            ->with($expectedRequestEntity)
            ->willReturn(new ResponseEntity(
                200,
                json_encode([
                    'data' => []
                ])
            ));

        $adapter = new FindExternalNfeAdapter(
            $this->sendRequestMock,
            'baseUri',
            'apiId',
            'apiKey',
        );

        $this->assertEmpty($adapter->get(new GetNfeFilterEntity(10, 50)));
    }

    public function testShouldReturnOndeNfe()
    {

        $this->sendRequestMock
            ->method('get')
            ->willReturn(new ResponseEntity(
                200,
                json_encode([
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
            $this->sendRequestMock,
            '',
            '',
            '',
        );

        $nfes = $adapter->get(new GetNfeFilterEntity());

        $this->assertCount(1, $nfes);
        $this->assertEquals($expectNfeEntity, reset($nfes));
    }
}
