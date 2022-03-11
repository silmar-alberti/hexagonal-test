<?php

declare(strict_types=1);

namespace Tests\InfraEstructure\Modules\DataLoader;

use App\Adapters\Modules\DataLoader\NfeExistsAdapter;
use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class NfeExistsAdapterTest extends TestCase
{
    public function testFilters()
    {
        $keysToCheck = ['123'];

        $builderMock = $this->createMock(Builder::class);
        $builderMock->expects($this->once())
            ->method('select')
            ->with(['key'])
            ->willReturn($builderMock);
        $builderMock->expects($this->once())
            ->method('whereIn')
            ->with('key', $keysToCheck)
            ->willReturn($builderMock);

        $builderMock->expects($this->once())
            ->method('get')
            ->willReturn(new Collection());

        $dbMock = $this->createMock(Connection::class);
        $dbMock->expects($this->once())
            ->method('table')
            ->with('nfe')
            ->willReturn($builderMock);

        $adapter = new NfeExistsAdapter($dbMock);
        $this->assertEmpty($adapter->getExistentKeys($keysToCheck));
    }

    public function testReturnMapping()
    {
        $builderMock = $this->createMock(Builder::class);
        $builderMock
            ->method('select')
            ->willReturn($builderMock);
        $builderMock
            ->method('whereIn')
            ->willReturn($builderMock);

        $builderMock
            ->method('get')
            ->willReturn(new Collection([
                ['key' => '123'],
                ['key' => '456'],
            ]));

        $dbMock = $this->createMock(Connection::class);
        $dbMock
            ->method('table')
            ->willReturn($builderMock);

        $adapter = new NfeExistsAdapter($dbMock);
        $this->assertEquals(['123', '456'], $adapter->getExistentKeys([]));
    }
}
