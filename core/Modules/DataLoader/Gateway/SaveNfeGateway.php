<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Gateway;

use Core\Modules\DataLoader\Entity\NfeToPersist;
use Core\Modules\DataLoader\Exception\DataOperationException;

interface SaveNfeGateway
{
    /**
     * save entries on database
     * @param NfeToPersist[] $nfes
     * @throws DataOperationException
     */
    public function save(array $nfes): void;
}
