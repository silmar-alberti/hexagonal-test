<?php

declare(strict_types=1);

namespace Core\Modules\GetNfeValue;

use Core\Modules\GetNfeValue\Rule\GetNfeByKeyRule;

final class UseCase
{
    public function __construct(
        private GetNfeByKeyRule $getNfeByKeyRule,
    ) {
    }

    public function execute(string $nfeKey): ?float
    {
        ($this->getNfeByKeyRule)($nfeKey);

        return $this->getNfeByKeyRule->apply();
    }
}
