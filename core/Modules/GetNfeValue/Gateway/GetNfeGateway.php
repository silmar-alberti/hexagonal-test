<?php

declare(strict_types=1);

namespace Core\Modules\GetNfeValue\Gateway;

use Core\Modules\GetNfeValue\Entity\NfeEntity;

interface GetNfeGateway
{
    public function getOneByKey(string $nfeKey): ?NfeEntity;
}
