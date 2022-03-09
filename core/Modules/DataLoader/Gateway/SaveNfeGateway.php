<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Gateway;

use Core\Modules\DataLoader\Entity\NfeToPersist;

interface SaveNfeGateway
{
    /**
     * save entries on database
     * @param NfeToPersist[] $nfes
     */
    public function save(array $nfes): void;
}
