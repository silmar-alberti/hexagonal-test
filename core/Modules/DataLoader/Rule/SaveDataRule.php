<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Rule;

use Core\Modules\DataLoader\Entity\NfeEntity;
use Core\Modules\DataLoader\Entity\NfeToPersist;
use Core\Modules\DataLoader\Gateway\SaveNfeGateway;

/**
 * @property NfeEntity[] $nfes
 */
class SaveDataRule implements RuleInterface
{
    private array $nfes = [];

    public function __construct(
        private SaveNfeGateway $SaveNfeGateway,
    ) {
    }

    /**
     * @param NfeEntity[] $nfes
     */
    public function __invoke(array $nfes): self
    {
        $this->nfes = $nfes;

        return $this;
    }

    public function apply(): void
    {
        $persistNfeEntities = array_map(function (NfeEntity $nfe) {
            return new NfeToPersist(
                key: $nfe->getKey(),
                value: $nfe->getTotalValue(),
            );
        }, $this->nfes);

        $this->SaveNfeGateway->save($persistNfeEntities);
    }
}
