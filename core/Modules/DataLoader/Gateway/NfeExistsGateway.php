<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Gateway;


interface NfeExistsGateway
{
    /**
     * return array with not knew Nfe
     *
     * @param string[] $nfesToCheck
     * @return string[]
     */
    public function getExistentKeys(array $keysToCheck): array;
}
