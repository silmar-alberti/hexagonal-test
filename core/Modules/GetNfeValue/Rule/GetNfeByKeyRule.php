<?php

declare(strict_types=1);

namespace Core\Modules\GetNfeValue\Rule;

use Core\Modules\GetNfeValue\Gateway\GetNfeGateway;

class GetNfeByKeyRule
{
    private string $key;

    public function __construct(
        private GetNfeGateway $getNfeGateway,
    ) {
    }

    public function __invoke(
        string $key
    ) {
        $this->key = $key;
    }

    public function apply(): ?float
    {

        $nfe = $this->getNfeGateway->getOneByKey($this->key);

        if (null === $nfe) {
            return null;
        }

        return $nfe->totalValue;
    }
}
