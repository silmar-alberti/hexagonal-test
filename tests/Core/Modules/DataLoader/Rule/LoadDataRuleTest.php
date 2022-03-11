<?php

declare(strict_types=1);

namespace Tests\Core\Modules\GetNfeValue\Rule;

use Core\Modules\DataLoader\Entity\GetNfeFilterEntity;
use Core\Modules\DataLoader\Gateway\FindExternalNfeGateway;
use Core\Modules\DataLoader\Gateway\IntegrationStatusGateway;
use Core\Modules\DataLoader\Rule\LoadDataRule;
use PHPUnit\Framework\TestCase;

class LoadDataRuleTest extends TestCase
{
    public function testFindFilterValues()
    {
        $findReturn = [1, 2, 3];

        $findNfeMock = $this->createMock(FindExternalNfeGateway::class);
        $findNfeMock->expects($this->once())->method('get')->with(
            new GetNfeFilterEntity(
                50,
                3
            )
        )->willReturn($findReturn);

        $integrationStatusMock = $this->createMock(IntegrationStatusGateway::class);
        $integrationStatusMock->method('getNextCursor')->willReturn(3);

        $rule = new LoadDataRule(
            findNfe: $findNfeMock,
            integrationStatus: $integrationStatusMock,
        );

        $this->assertEquals($findReturn, $rule->apply());
    }

    public function testUpdateCursorValue()
    {
        $findReturn = [1, 2, 3];

        $findNfeMock = $this->createMock(FindExternalNfeGateway::class);
        $findNfeMock->method('get')->willReturn($findReturn);

        $integrationStatusMock = $this->createMock(IntegrationStatusGateway::class);
        $integrationStatusMock->expects($this->once())->method('getNextCursor')->willReturn(3);
        $integrationStatusMock->expects($this->once())->method('updateNextCursor')->with(6);

        $rule = new LoadDataRule(
            findNfe: $findNfeMock,
            integrationStatus: $integrationStatusMock,
        );

        $this->assertEquals($findReturn, $rule->apply());
    }
}
