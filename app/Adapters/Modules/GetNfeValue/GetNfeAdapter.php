<?php

declare(strict_types=1);

namespace App\Adapters\Modules\GetNfeValue;

use Core\Modules\GetNfeValue\Entity\NfeEntity;
use Core\Modules\GetNfeValue\Gateway\GetNfeGateway;
use Illuminate\Database\Connection;

class GetNfeAdapter implements GetNfeGateway
{
    public function __construct(
        private Connection $db,
    ) {
    }

    public function getOneByKey(string $nfeKey): ?NfeEntity
    {
        $nfs = $this->db->table('nfe')
            ->select(['key', 'total_value'])
            ->where('key', '=', $nfeKey)
            ->limit(1)
            ->get();

        if (count($nfs) === 0) {
            return null;
        }

        $nfData = $nfs->shift();

        return new NfeEntity(
            key: $nfData->key,
            totalValue: (float) $nfData->total_value,
        );
    }
}
