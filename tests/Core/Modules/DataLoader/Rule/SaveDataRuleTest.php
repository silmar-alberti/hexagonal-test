<?php

declare(strict_types=1);

namespace Tests\Core\Modules\GetNfeValue\Rule;

use Core\Modules\DataLoader\Entity\NfeEntity;
use Core\Modules\DataLoader\Entity\NfeToPersistEntity;
use Core\Modules\DataLoader\Gateway\SaveNfeGateway;
use Core\Modules\DataLoader\Rule\SaveDataRule;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class SaveDataRuleTest extends TestCase
{
    public function testMapEntitiesAndCallSave()
    {
        $nfesToSave = [
            $this->createNfeEntity('123', 10.50),
            $this->createNfeEntity('456', 15.50),
        ];

        $nfesPersistObjects = [
            new NfeToPersistEntity('123', 10.50),
            new NfeToPersistEntity('456', 15.50),
        ];

        $saveNfeGatewayMock = $this->createMock(SaveNfeGateway::class);
        $saveNfeGatewayMock->expects($this->once())
            ->method('save')
            ->with($nfesPersistObjects);

        $rule = new SaveDataRule(
            $saveNfeGatewayMock
        );

        $rule($nfesToSave);

        $rule->apply();
    }


    private function createNfeEntity(string $key, float $totalValue): NfeEntity
    {
        $xml = <<<XML
            <xml>
                <NFe>
                    <infNFe>
                        <total>
                            <ICMSTot>
                                <vNF>
                                    $totalValue
                                </vNF>
                            </ICMSTot>
                        </total>
                    </infNFe>
                </NFe>
            </xml>
        XML;

        return new NfeEntity($key, new SimpleXMLElement($xml));
    }
}
