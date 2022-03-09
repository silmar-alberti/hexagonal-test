<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader\Entity;

use SimpleXMLElement;

class NfeEntity
{
    public function __construct(
        public readonly string $key,
        public readonly SimpleXMLElement $xml,
    ) {
    }

    public function getTotalValue(): float
    {
        return (float) $this->xml->NFe->infNFe->total->ICMSTot->vNF->__toString();
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
