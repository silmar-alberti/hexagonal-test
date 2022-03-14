<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Gateway;

use Core\Modules\DataLoader\Exception\DataOperationException;

interface IntegrationStatusGateway
{
    public function getNextCursor(): int;

    /**
     * @throws DataOperationException
     */
    public function updateNextCursor(int $nextCursor): void;
}
