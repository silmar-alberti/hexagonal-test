<?php

declare(strict_types=1);

use Core\Modules\GetNfeValue\Entity\NfeEntity;
use Core\Modules\GetNfeValue\Gateway\GetNfeGateway;
use Core\Modules\GetNfeValue\Rule\GetNfeByKeyRule;
use PHPUnit\Framework\TestCase;

class GetNfeByKeyRuleTest extends TestCase
{

    public function returnValueProvider()
    {
        return [
            'withValue' => [
                new NfeEntity(
                    key: '',
                    totalValue: 55.20,
                ),
                55.20
            ],
            'notFoundNfe' => [
                null,
                null
            ],
        ];
    }

    /**
     * @dataProvider returnValueProvider
     */
    public function testApply(?NfeEntity $fakeValue, ?float $expectedValue)
    {

        $gatewayMock = $this->createMock(GetNfeGateway::class);

        $gatewayMock->expects($this->once())
            ->method('getOneByKey')
            ->willReturn($fakeValue);

        $rule = new GetNfeByKeyRule($gatewayMock);
        ($rule)('');

        $this->assertEquals($expectedValue, $rule->apply());
    }
}
