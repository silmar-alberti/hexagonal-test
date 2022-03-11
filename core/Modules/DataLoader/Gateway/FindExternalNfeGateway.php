<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Gateway;

use Core\Modules\DataLoader\Entity\GetNfeFilterEntity;
use Core\Modules\DataLoader\Entity\NfeEntity;

interface FindExternalNfeGateway
{
    /**
     * get Nfe by filters, return all if haven't filters
     * @return NfeEntity[]
     */
    public function get(GetNfeFilterEntity $filter): array;
}
