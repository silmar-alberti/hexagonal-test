<?php

declare(strict_types=1);

namespace Tests\Core\Modules\GetNfeValue;

use PHPUnit\Framework\TestCase;
use Core\Modules\GetNfeValue\UseCase;
use Core\Modules\GetNfeValue\Rule\GetNfeByKeyRule;

class UseCaseTest extends TestCase
{
    public function testApplyRule()
    {
        $nfValue = 2.5;

        $ruleMock = $this->createMock(GetNfeByKeyRule::class);
        $ruleMock->method('apply')->willReturn($nfValue);


        $useCase = new UseCase(
            $ruleMock,
        );

        $this->assertEquals($nfValue, $useCase->execute(''));
    }
}
