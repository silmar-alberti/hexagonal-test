<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Rule;

use Core\Modules\DataLoader\Entity\NfeEntity;
use Core\Modules\DataLoader\Gateway\NfeExistsGateway;

/**
 * @property NfeEntity[] $nfes
 */
class FilterRule implements RuleInterface
{
    private array $nfes;

    public function __construct(
        private NfeExistsGateway $nfeExistsRepository,
    ) {
    }

    public function __invoke(array $nfes): void
    {
        $this->nfes = $nfes;
    }

    /**
     * @return NfeEntity[]
     */
    public function apply(): array
    {
        $keys = array_map(fn (NfeEntity $nfe) => $nfe->getKey(), $this->nfes);
        $exitentKeys = $this->nfeExistsRepository->getExistentKeys($keys);


        return array_filter($this->nfes, function (NfeEntity $nfe) use ($exitentKeys) {
            return in_array($nfe->getKey(), $exitentKeys) === false;
        });
    }
}
