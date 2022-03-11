<?php

declare(strict_types=1);

namespace Tests\InfraEstructure\Modules\GetNfeValue;

use App\Adapters\Modules\GetNfeValue\GetNfeAdapter;
use Core\Modules\GetNfeValue\Entity\NfeEntity;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use PHPUnit\Framework\TestCase;
use stdClass;

class GetNfeAdapterTest extends TestCase
{
    public function testShouldReturnNullWhenEmpty()
    {
        $dbMock = $this->createMock(Connection::class);

        $builderMock = $this->createMock(Builder::class);
        $builderMock->method('select')->willReturn($builderMock);
        $builderMock->method('where')->willReturn($builderMock);
        $builderMock->method('limit')->willReturn($builderMock);
        $builderMock->method('get')->willReturn(
            new Collection([])
        );

        $dbMock->method('table')->willReturn(
            $builderMock
        );

        $adapter = new GetNfeAdapter(
            db: $dbMock
        );

        $this->assertEquals(null, $adapter->getOneByKey(''));
    }

    public function testDatabaseFilter()
    {
        $nfKey = '5487';

        $dbMock = $this->createMock(Connection::class);

        $builderMock = $this->createMock(Builder::class);
        $builderMock
            ->method('select')
            ->with(['key', 'total_value'])
            ->willReturn($builderMock);

        $builderMock->method('where')
            ->with('key', '=', $nfKey)
            ->willReturn($builderMock);

        $builderMock->method('limit')->willReturn($builderMock);
        $builderMock->method('get')->willReturn(
            new Collection([])
        );

        $dbMock->method('table')->willReturn(
            $builderMock
        );

        $adapter = new GetNfeAdapter(
            db: $dbMock
        );

        $this->assertEquals(null, $adapter->getOneByKey($nfKey));
    }

    public function testReturnEntity()
    {
        $nftotal_value = '58.90';
        $nfKey = '89465';

        $databaseObject = new stdClass();
        $databaseObject->key = $nfKey;
        $databaseObject->total_value = $nftotal_value;

        $dbMock = $this->createMock(Connection::class);

        $builderMock = $this->createMock(Builder::class);
        $builderMock->method('select')->willReturn($builderMock);
        $builderMock->method('where')->willReturn($builderMock);
        $builderMock->method('limit')->willReturn($builderMock);
        $builderMock->method('get')->willReturn(
            new Collection([
                $databaseObject
            ])
        );

        $dbMock->method('table')->willReturn(
            $builderMock
        );

        $adapter = new GetNfeAdapter(
            db: $dbMock
        );

        $this->assertEquals(new NfeEntity(
            key: $nfKey,
            totalValue: (float) $nftotal_value,
        ), $adapter->getOneByKey($nfKey));
    }
}
