<?php

declare(strict_types=1);

namespace App\Adapters\Modules\DataLoader;

use Core\Modules\DataLoader\Gateway\NfeExistsGateway;
use Illuminate\Database\Connection;

class NfeExistsAdapter implements NfeExistsGateway
{
    public function __construct(
        private Connection $db,
    ) {
    }

    public function getExistentKeys(array $keysToCheck): array
    {
        $results = $this->db->table('nfe')
            ->select(['key'])
            ->whereIn('key', $keysToCheck)
            ->get();

        return (array) $results->pluck('key')->toArray();
    }
}
