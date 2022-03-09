<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Rule;

use Core\Modules\DataLoader\Entity\GetNfeFilterEntity;
use Core\Modules\DataLoader\Entity\NfeEntity;
use Core\Modules\DataLoader\Gateway\FindNfeGateway;

class LoadDataRule implements RuleInterface
{
    public function __construct(
        private FindNfeGateway $findNfe
    ) {
    }

    /**
     * @return NfeEntity[]
     */
    public function apply(): array
    {
        return $this->findNfe->get(new GetNfeFilterEntity(limit: 2));
    }
}
