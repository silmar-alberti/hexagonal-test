<?php

declare(strict_types=1);

namespace Tests\InfraEstructure\Modules\DataLoader;

use Exception;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;
use App\Adapters\Modules\DataLoader\SaveNfeAdapter;
use Core\Modules\DataLoader\Entity\NfeToPersistEntity;

class SaveNfeAdapterTest extends TestCase
{
    public function testBulkSaveSuccess()
    {
        $nfeToPersist = new NfeToPersistEntity(
            'nfeKey',
            4587.30,
        );

        $builderMock = $this->createMock(Builder::class);
        $builderMock->expects($this->once())
            ->method('insert')
            ->with([[
                'key' => 'nfeKey',
                'total_value' => 4587.30,
            ]])
            ->willReturn(true);

        $dbMock = $this->createMock(Connection::class);
        $dbMock->expects($this->once())
            ->method('table')
            ->willReturn($builderMock);

        $adapter = new SaveNfeAdapter($dbMock);

        $adapter->save([$nfeToPersist]);
    }

    public function testBulkSaveException()
    {
        $nfeToPersist = new NfeToPersistEntity(
            'nfeKey',
            4587.30,
        );

        $builderMock = $this->createMock(Builder::class);
        $builderMock
            ->method('insert')
            ->willReturn(false);

        $dbMock = $this->createMock(Connection::class);
        $dbMock
            ->method('table')
            ->willReturn($builderMock);

        $adapter = new SaveNfeAdapter($dbMock);

        $this->expectException(Exception::class);

        $adapter->save([$nfeToPersist]);
    }
}
