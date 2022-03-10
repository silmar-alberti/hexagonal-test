<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Gateway;

interface IntegrationStatusGateway
{
    public function getNextCursor(): int;

    // TODO throw specific Exception
    public function updateNextCursor(int $nextCursor): void;
}
