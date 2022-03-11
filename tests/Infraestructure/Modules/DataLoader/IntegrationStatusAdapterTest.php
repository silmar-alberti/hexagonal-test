<?php

declare(strict_types=1);

use App\Adapters\Modules\DataLoader\IntegrationStatusAdapter;
use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class IntegrationStatusAdapterTest extends TestCase
{
    public function testGetNextCursorFirstExecution()
    {
        $builderMock = $this->createMock(Builder::class);
        $builderMock->expects($this->once())
            ->method('select')
            ->with(['next_cursor'])
            ->willReturn($builderMock);

        $builderMock->expects($this->once())
            ->method('orderBy')
            ->with('id', 'desc')
            ->willReturn($builderMock);

        $builderMock->expects($this->once())
            ->method('limit')
            ->with(1)
            ->willReturn($builderMock);

        $builderMock->expects($this->once())
            ->method('get')
            ->willReturn(new Collection());

        $adapter = new IntegrationStatusAdapter(
            $this->createDbMock($builderMock)
        );

        $this->assertEquals(0, $adapter->getNextCursor());
    }

    public function testGetCursorLastExecution()
    {
        $builderMock = $this->createMock(Builder::class);
        $builderMock
            ->method('select')
            ->willReturn($builderMock);

        $builderMock
            ->method('orderBy')
            ->willReturn($builderMock);

        $builderMock
            ->method('limit')
            ->willReturn($builderMock);

        $builderMock
            ->method('get')
            ->willReturn(new Collection([
                (object) ['next_cursor' => 56]
            ]));

        $adapter = new IntegrationStatusAdapter(
            $this->createDbMock($builderMock)
        );

        $this->assertEquals(56, $adapter->getNextCursor());
    }

    public function testUpdateNextCursor()
    {
        $builderMock = $this->createMock(Builder::class);
        $builderMock->expects($this->once())
            ->method('insert')
            ->with(['next_cursor' => 12])
            ->willReturn($builderMock);

        $adapter = new IntegrationStatusAdapter(
            $this->createDbMock($builderMock)
        );

        $this->assertEmpty($adapter->updateNextCursor(12));
    }

    private function createDbMock($builderMock)
    {
        $mock = $this->createMock(Connection::class);
        $mock->expects($this->once())
            ->method('table')
            ->with('integration')
            ->willReturn($builderMock);

        return $mock;
    }
}
