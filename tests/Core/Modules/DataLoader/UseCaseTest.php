<?php

declare(strict_types=1);

namespace Tests\Core\Modules\DataLoader;

use Core\Modules\DataLoader\Rule\FilterRule;
use Core\Modules\DataLoader\Rule\LoadDataRule;
use Core\Modules\DataLoader\Rule\SaveDataRule;
use Core\Modules\DataLoader\UseCase;
use PHPUnit\Framework\TestCase;

class UseCaseTest extends TestCase
{
    public function testShouldCallAllRules()
    {
        $loadDataRuleMock = $this->createRuleMock(LoadDataRule::class, []);
        $filterRuleMock = $this->createRuleMock(FilterRule::class, []);

        $saveDataRuleMock = $this->createMock(SaveDataRule::class);
        $saveDataRuleMock->expects($this->once())->method('apply');

        $useCase = new UseCase(
            loadDataRule: $loadDataRuleMock,
            filterRule: $filterRuleMock,
            saveDataRule: $saveDataRuleMock,
        );

        $useCase->execute();
    }
    private function createRuleMock(string $class, mixed $applyReturn)
    {
        $mock = $this->createMock($class);
        $mock->expects($this->once())->method('apply')->willReturn($applyReturn);

        return $mock;
    }
}
