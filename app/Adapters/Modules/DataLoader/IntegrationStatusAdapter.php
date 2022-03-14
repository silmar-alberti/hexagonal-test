<?php

declare(strict_types=1);

namespace App\Adapters\Modules\DataLoader;

use Core\Modules\DataLoader\Exception\DataOperationException;
use Core\Modules\DataLoader\Gateway\IntegrationStatusGateway;
use Illuminate\Database\Connection;

class IntegrationStatusAdapter implements IntegrationStatusGateway
{
    public function __construct(
        private Connection $db,
    ) {
    }

    public function getNextCursor(): int
    {
        $data = $this->db->table('integration')
            ->select(['next_cursor'])
            ->orderBy('id', direction: 'desc')
            ->limit(1)
            ->get();

        if (count($data) > 0) {
            return (int) $data->shift()->next_cursor;
        }

        return 0;
    }

    public function updateNextCursor(int $nextCursor): void
    {
        $success = $this->db->table('integration')
            ->insert([
                'next_cursor' => $nextCursor
            ]);

        if ($success === false) {
            throw new DataOperationException('Error on save next cursor');
        }
    }
}
