<?php

declare(strict_types=1);

use Core\Modules\DataLoader\Entity\NfeEntity;
use Core\Modules\DataLoader\Gateway\NfeExistsGateway;
use Core\Modules\DataLoader\Rule\FilterRule;
use PHPUnit\Framework\TestCase;

class FilterRuleTest extends TestCase
{

    public function filterTestDataProvider(): array
    {
        return [
            'testFilterOne' => [
                $this->createMockEntitiesByKeys(['123', '456', '789']),
                $this->createMockEntitiesByKeys(['123', '789']),
                ['456'],
            ],
            'testRemoveAll' => [
                $this->createMockEntitiesByKeys(['123', '456', '789']),
                $this->createMockEntitiesByKeys([]),
                ['123', '456', '789'],
            ],
            'testDontRemove' => [
                $this->createMockEntitiesByKeys(['123', '456', '789']),
                $this->createMockEntitiesByKeys(['123', '456', '789']),
                [],
            ]
        ];
    }


    /**
     * @dataProvider filterTestDataProvider
     */
    public function testFilter(array $receivedNfe, array $expectedAfterFilter, array $existentKeys): void
    {
        $gatewayMock = $this->createMock(NfeExistsGateway::class);
        $gatewayMock->method('getExistentKeys')
            ->willReturn($existentKeys);

        $rule = new FilterRule(
            nfeExistsGateway: $gatewayMock,
        );

        $rule($receivedNfe);

        $this->assertEquals(array_values($expectedAfterFilter), array_values($rule->apply()));
    }


    public function testShouldCallRepository()
    {
        $nfeKeys = [
            '123'
        ];

        $gatewayMock = $this->createMock(NfeExistsGateway::class);
        $gatewayMock->expects($this->once())
            ->method('getExistentKeys')
            ->with($nfeKeys)->willReturn([]);

        $rule = new FilterRule(
            nfeExistsGateway: $gatewayMock,
        );

        $rule($this->createMockEntitiesByKeys(['123']));

        $rule->apply();
    }

    private function createMockEntitiesByKeys(array $keys): array
    {
        return array_map(
            fn (string $key) => new NfeEntity($key, new SimpleXMLElement('<xml></xml>')),
            $keys
        );
    }
}
