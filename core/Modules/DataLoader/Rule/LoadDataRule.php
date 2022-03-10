<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Rule;

use Core\Modules\DataLoader\Entity\GetNfeFilterEntity;
use Core\Modules\DataLoader\Entity\NfeEntity;
use Core\Modules\DataLoader\Gateway\FindExternalNfeGateway;
use Core\Modules\DataLoader\Gateway\IntegrationStatusGateway;

class LoadDataRule implements RuleInterface
{
    const STEP_AMOUNT = 50;

    public function __construct(
        private FindExternalNfeGateway $findNfe,
        private IntegrationStatusGateway $integrationStatus,
    ) {
    }

    /**
     * @return NfeEntity[]
     */
    public function apply(): array
    {
        $cursor = $this->integrationStatus->getNextCursor();

        $nfes = $this->findNfe->get(
            new GetNfeFilterEntity(
                limit: self::STEP_AMOUNT,
                cursor: $cursor
            )
        );

        $this->integrationStatus->updateNextCursor($cursor + count($nfes));

        return $nfes;
    }
}
