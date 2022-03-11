<?php

declare(strict_types=1);

namespace App\Adapters\Modules\DataLoader;

use Core\Modules\DataLoader\Entity\NfeToPersistEntity;
use Core\Modules\DataLoader\Gateway\SaveNfeGateway;
use Exception;
use Illuminate\Database\Connection;

class SaveNfeAdapter implements SaveNfeGateway
{
    public function __construct(
        private Connection $db
    ) {
    }

    /**
     * @param NfeToPersistEntity[] $nfes
     */
    public function save(array $nfes): void
    {
        $mappedData = array_map(function (NfeToPersistEntity $nfe) {
            return [
                'key' => $nfe->key,
                'total_value' => $nfe->totalValue,
            ];
        }, $nfes);

        $success = $this->db->table('nfe')->insert($mappedData);
        if ($success === false) {
            // TODO create specific exception
            throw new Exception();
        }
    }
}
